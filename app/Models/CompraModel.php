<?php

namespace App\Models;

class CompraModel {
    private $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    /**
     * Obtiene la lista de órdenes de compra con datos básicos del proyecto y proveedor.
     */
    public function getOrdenesPendientes() {
        $sql = "
            SELECT oc.*, p.NOM_PROY, prov.nom_prov 
            FROM ord_compras oc
            LEFT JOIN proyectos p ON oc.id_proy = p.ID_PROY
            LEFT JOIN proveedores prov ON oc.id_prov = prov.id_prov
            ORDER BY oc.fecha_orden DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtiene una orden de compra específica.
     */
    public function getOrden($id_ocompra) {
        $sql = "
            SELECT oc.*, p.NOM_PROY, prov.nom_prov 
            FROM ord_compras oc
            LEFT JOIN proyectos p ON oc.id_proy = p.ID_PROY
            LEFT JOIN proveedores prov ON oc.id_prov = prov.id_prov
            WHERE oc.id_ocompra = :id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_ocompra]);
        return $stmt->fetch();
    }

    /**
     * Obtiene los detalles (ítems) de una orden de compra.
     */
    public function getDetalles($id_ocompra) {
        $sql = "
            SELECT * FROM det_ocompra 
            WHERE id_ocompra = :id
            ORDER BY corre_item ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_ocompra]);
        return $stmt->fetchAll();
    }

    /**
     * Aprueba una orden de compra (Actualización segura).
     */
    public function aprobarOrden($id_ocompra, $nombre_aprobador) {
        $sql = "
            UPDATE ord_compras 
            SET estatus_aprob = 'Si', 
                estatus_orden = 'Aprobada',
                fecha_aprob = CURDATE(), 
                nom_aprob = :aprobador
            WHERE id_ocompra = :id AND estatus_aprob = 'No'
        ";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id_ocompra,
            ':aprobador' => $nombre_aprobador
        ]);
    }
}
