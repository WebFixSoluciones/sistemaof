<?php

namespace App\Models;

class EntregaModel {
    private $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    /**
     * Obtiene las OC aprobadas que aún tienen ítems pendientes de recibir.
     * Ideal para la bandeja del Ingeniero Residente.
     */
    public function getOrdenesEnTransito() {
        // En un caso real, filtraríamos por el id_inge en sesión.
        $sql = "
            SELECT oc.*, p.NOM_PROY, prov.nom_prov 
            FROM ord_compras oc
            LEFT JOIN proyectos p ON oc.id_proy = p.ID_PROY
            LEFT JOIN proveedores prov ON oc.id_prov = prov.id_prov
            WHERE oc.estatus_aprob = 'Si' 
              AND oc.estatus_orden IN ('Pendiente', 'Anticipo', 'Aprobada')
            ORDER BY oc.fecha_orden DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Registra de forma transaccional y segura la recepción de material.
     * Evita que se reciba más de lo pendiente.
     */
    public function registrarRecepcion($id_ocompra, $items_recibidos, $id_inge) {
        try {
            $this->db->beginTransaction();

            // 1. Crear cabecera de la entrega
            $sqlEntrega = "INSERT INTO orden_entrega (id_ocompra, fecha_oentrega, id_inge) VALUES (:id_oc, CURDATE(), :inge)";
            $stmtEntrega = $this->db->prepare($sqlEntrega);
            $stmtEntrega->execute([
                ':id_oc' => $id_ocompra,
                ':inge' => $id_inge
            ]);
            $id_oentrega = $this->db->lastInsertId();

            $todosCompletos = true;
            $alMenosUnoParcial = false;

            // 2. Procesar cada ítem recibido
            foreach ($items_recibidos as $corre_item => $cantidad) {
                if (empty($cantidad) || $cantidad <= 0) continue;

                // Obtener datos actuales del ítem de forma segura
                $stmtItem = $this->db->prepare("SELECT cant_item, cant_recib, pend_recib FROM det_ocompra WHERE corre_item = :corre AND id_ocompra = :id_oc FOR UPDATE");
                $stmtItem->execute([':corre' => $corre_item, ':id_oc' => $id_ocompra]);
                $itemActual = $stmtItem->fetch();

                if (!$itemActual) continue;

                // Calcular pendientes. Si pend_recib es nulo, asumimos cant_item. Si cant_recib es nulo, 0.
                $pend_recib = $itemActual['pend_recib'] !== null ? (float)$itemActual['pend_recib'] : (float)$itemActual['cant_item'];
                $cant_recib = $itemActual['cant_recib'] !== null ? (float)$itemActual['cant_recib'] : 0.00;
                $cant_entrega = (float)$cantidad;

                // REGLA DE VALIDACIÓN: No permitir recibir más de lo pendiente
                if ($cant_entrega > $pend_recib) {
                    throw new \Exception("La cantidad a recibir ({$cant_entrega}) supera lo pendiente ({$pend_recib}) para el ítem.");
                }

                $nuevo_recib = $cant_recib + $cant_entrega;
                $nuevo_pend = $pend_recib - $cant_entrega;
                
                $estatus_item = 'Pendiente';
                if ($nuevo_pend <= 0) {
                    $estatus_item = 'Completo';
                } elseif ($nuevo_recib > 0) {
                    $estatus_item = 'Anticipo'; // Parcial
                }

                // Actualizar detalle de OC
                $stmtUpdate = $this->db->prepare("
                    UPDATE det_ocompra 
                    SET cant_recib = :recib, pend_recib = :pend, estatus_item = :estatus 
                    WHERE corre_item = :corre AND id_ocompra = :id_oc
                ");
                $stmtUpdate->execute([
                    ':recib' => $nuevo_recib,
                    ':pend' => $nuevo_pend,
                    ':estatus' => $estatus_item,
                    ':corre' => $corre_item,
                    ':id_oc' => $id_ocompra
                ]);

                // Guardar historial en det_oentrega
                $stmtDetEntrega = $this->db->prepare("
                    INSERT INTO det_oentrega (id_oentrega, id_item, cod_prod, cant_prod, cant_entrega, pend_entrega) 
                    VALUES (:id_oentrega, :corre_item, 0, :cant_prod, :cant_entrega, :pend_entrega)
                ");
                $stmtDetEntrega->execute([
                    ':id_oentrega' => $id_oentrega,
                    ':corre_item' => $corre_item,
                    ':cant_prod' => $itemActual['cant_item'],
                    ':cant_entrega' => $cant_entrega,
                    ':pend_entrega' => $nuevo_pend
                ]);
            }

            // 3. Revisar estado global de la OC para actualizarlo
            $stmtAll = $this->db->prepare("SELECT estatus_item FROM det_ocompra WHERE id_ocompra = :id_oc");
            $stmtAll->execute([':id_oc' => $id_ocompra]);
            $todosItems = $stmtAll->fetchAll();

            foreach ($todosItems as $it) {
                if ($it['estatus_item'] !== 'Completo') {
                    $todosCompletos = false;
                }
                if ($it['estatus_item'] === 'Anticipo' || $it['estatus_item'] === 'Completo') {
                    $alMenosUnoParcial = true;
                }
            }

            $estatus_orden = 'Aprobada';
            if ($todosCompletos) {
                $estatus_orden = 'Completa'; // Puedes cambiarlo a lo que dicte el negocio
            } elseif ($alMenosUnoParcial) {
                $estatus_orden = 'Anticipo'; // Parcial
            }

            $stmtStatusOc = $this->db->prepare("UPDATE ord_compras SET estatus_orden = :est WHERE id_ocompra = :id_oc");
            $stmtStatusOc->execute([':est' => $estatus_orden, ':id_oc' => $id_ocompra]);

            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }
}
