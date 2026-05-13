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
            SELECT oc.*, p.NOM_PROY, p.COD_PROY AS cod_proyecto, prov.nom_prov,
                   i.NOM_INGE, e.nom_empresa
            FROM ord_compras oc
            LEFT JOIN proyectos p ON oc.id_proy = p.ID_PROY
            LEFT JOIN proveedores prov ON oc.id_prov = prov.id_prov
            LEFT JOIN ingenieros i ON oc.id_inge = i.ID_INGE
            LEFT JOIN empresas e ON oc.id_empresa = e.id_empresa
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
            SELECT d.*, p.nom_prod, p.cod_prod 
            FROM det_ocompra d
            LEFT JOIN productos p ON d.id_prod = p.id_prod
            WHERE d.id_ocompra = :id
            ORDER BY d.corre_item ASC
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

    /* ================================================================
     *  CONTROL DE ÓRDENES DE COMPRA — Módulo Completo
     * ================================================================ */

    /**
     * Lista todas las OC con filtros opcionales de proyecto, proveedor y estatus.
     */
    public function listarOrdenes(array $filtros = []) {
        $where = [];
        $params = [];

        if (!empty($filtros['id_proy'])) {
            $where[] = "oc.id_proy = :id_proy";
            $params[':id_proy'] = $filtros['id_proy'];
        }
        if (!empty($filtros['id_prov'])) {
            $where[] = "oc.id_prov = :id_prov";
            $params[':id_prov'] = $filtros['id_prov'];
        }
        if (!empty($filtros['estatus'])) {
            $where[] = "oc.estatus_orden = :estatus";
            $params[':estatus'] = $filtros['estatus'];
        }
        if (!empty($filtros['buscar'])) {
            $where[] = "(oc.cod_ocompra LIKE :buscar OR prov.nom_prov LIKE :buscar2)";
            $params[':buscar'] = '%' . $filtros['buscar'] . '%';
            $params[':buscar2'] = '%' . $filtros['buscar'] . '%';
        }

        $whereClause = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "
            SELECT oc.*, p.NOM_PROY, p.COD_PROY AS cod_proyecto, prov.nom_prov,
                   (SELECT COUNT(*) FROM det_ocompra d WHERE d.id_ocompra = oc.id_ocompra) AS total_items,
                   (SELECT COUNT(*) FROM det_ocompra d WHERE d.id_ocompra = oc.id_ocompra AND d.estatus_item = 'Completo') AS items_completos,
                   (SELECT COUNT(*) FROM det_ocompra d WHERE d.id_ocompra = oc.id_ocompra AND d.estatus_item = 'Pendiente') AS items_pendientes
            FROM ord_compras oc
            LEFT JOIN proyectos p ON oc.id_proy = p.ID_PROY
            LEFT JOIN proveedores prov ON oc.id_prov = prov.id_prov
            {$whereClause}
            ORDER BY oc.fecha_orden DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene KPIs generales del módulo de compras.
     */
    public function getKPIs() {
        $kpis = [];

        // Total OC
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM ord_compras");
        $kpis['total_oc'] = $stmt->fetch()['total'];

        // OC Pendientes de aprobación
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM ord_compras WHERE estatus_aprob = 'No'");
        $kpis['pendientes_aprob'] = $stmt->fetch()['total'];

        // OC Aprobadas
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM ord_compras WHERE estatus_aprob = 'Si'");
        $kpis['aprobadas'] = $stmt->fetch()['total'];

        // Monto total OC
        $stmt = $this->db->query("SELECT COALESCE(SUM(cost_total), 0) AS monto FROM ord_compras");
        $kpis['monto_total'] = $stmt->fetch()['monto'];

        // Items totalmente recibidos vs pendientes
        $stmt = $this->db->query("SELECT 
            COUNT(*) AS total_items,
            SUM(CASE WHEN estatus_item = 'Completo' THEN 1 ELSE 0 END) AS completos,
            SUM(CASE WHEN estatus_item = 'Pendiente' THEN 1 ELSE 0 END) AS pendientes,
            SUM(CASE WHEN estatus_item = 'Anticipo' THEN 1 ELSE 0 END) AS parciales
            FROM det_ocompra");
        $items = $stmt->fetch();
        $kpis['items_total'] = $items['total_items'];
        $kpis['items_completos'] = $items['completos'];
        $kpis['items_pendientes'] = $items['pendientes'];
        $kpis['items_parciales'] = $items['parciales'];

        return $kpis;
    }

    /**
     * Obtiene catálogo de proyectos activos (para filtros).
     */
    public function getProyectos() {
        return $this->db->query("SELECT ID_PROY, COD_PROY, NOM_PROY FROM proyectos WHERE ACTIVO = 'Activo' ORDER BY NOM_PROY")->fetchAll();
    }

    /**
     * Obtiene catálogo de proveedores activos (para filtros).
     */
    public function getProveedores() {
        return $this->db->query("SELECT id_prov, nom_prov FROM proveedores WHERE estatus = 'Activo' ORDER BY nom_prov")->fetchAll();
    }

    /**
     * Consulta el stock por producto — resumen de cantidades pedidas/recibidas/pendientes por producto.
     */
    public function getStockProductos(array $filtros = []) {
        $where = [];
        $params = [];

        if (!empty($filtros['buscar'])) {
            $where[] = "(p.nom_prod LIKE :buscar OR p.cod_prod LIKE :buscar2)";
            $params[':buscar'] = '%' . $filtros['buscar'] . '%';
            $params[':buscar2'] = '%' . $filtros['buscar'] . '%';
        }
        if (!empty($filtros['id_proy'])) {
            $where[] = "d.id_proy = :id_proy";
            $params[':id_proy'] = $filtros['id_proy'];
        }

        $whereClause = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "
            SELECT 
                p.id_prod, p.cod_prod, p.nom_prod, p.unid_med, p.cost_unit,
                SUM(d.cant_item) AS total_pedido,
                SUM(COALESCE(d.cant_recib, 0)) AS total_recibido,
                SUM(d.cant_item) - SUM(COALESCE(d.cant_recib, 0)) AS total_pendiente,
                COUNT(DISTINCT d.id_ocompra) AS en_ordenes
            FROM det_ocompra d
            INNER JOIN productos p ON d.id_prod = p.id_prod
            {$whereClause}
            GROUP BY p.id_prod, p.cod_prod, p.nom_prod, p.unid_med, p.cost_unit
            ORDER BY total_pendiente DESC, p.nom_prod ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Historial de entregas para una OC específica.
     */
    public function getHistorialEntregas($id_ocompra) {
        $sql = "
            SELECT oe.id_oentrega, oe.fecha_oentrega, i.NOM_INGE,
                   de.id_item, de.cant_entrega, de.pend_entrega, de.fecha_hora,
                   dc.descrip_item
            FROM orden_entrega oe
            LEFT JOIN det_oentrega de ON oe.id_oentrega = de.id_oentrega
            LEFT JOIN det_ocompra dc ON de.id_item = dc.corre_item AND oe.id_ocompra = dc.id_ocompra
            LEFT JOIN ingenieros i ON oe.id_inge = i.ID_INGE
            WHERE oe.id_ocompra = :id
            ORDER BY oe.fecha_oentrega DESC, de.id_item ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_ocompra]);
        return $stmt->fetchAll();
    }
}
