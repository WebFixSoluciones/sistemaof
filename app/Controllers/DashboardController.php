<?php

namespace App\Controllers;

use App\Models\CompraModel;

class DashboardController extends BaseController {

    public function index() {
        $this->requireAuth();

        $db = getDBConnection();

        // KPIs — consultas de solo lectura, agrupadas y rápidas
        $kpiProyectos = $db->query("
            SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN ACTIVO='Activo' THEN 1 ELSE 0 END) AS activos
            FROM proyectos
        ")->fetch();

        $kpiComprasPendientes = $db->query("
            SELECT COUNT(*) AS total
            FROM ord_compras 
            WHERE estatus_aprob = 'No'
        ")->fetch();

        $kpiMaterialEnTransito = $db->query("
            SELECT COUNT(*) AS total
            FROM ord_compras
            WHERE estatus_aprob = 'Si' 
              AND estatus_orden NOT IN ('Cancelada', 'Completa')
        ")->fetch();

        // Últimas 5 OC pendientes de aprobación (para el widget del dashboard)
        $ocPendientes = $db->query("
            SELECT oc.cod_ocompra, oc.fecha_orden, oc.cost_total, p.NOM_PROY, prov.nom_prov
            FROM ord_compras oc
            LEFT JOIN proyectos p ON oc.id_proy = p.ID_PROY
            LEFT JOIN proveedores prov ON oc.id_prov = prov.id_prov
            WHERE oc.estatus_aprob = 'No'
            ORDER BY oc.fecha_orden DESC
            LIMIT 5
        ")->fetchAll();

        // Material en tránsito por proyecto
        $materialTransito = $db->query("
            SELECT oc.cod_ocompra, p.NOM_PROY, prov.nom_prov, oc.estatus_orden
            FROM ord_compras oc
            LEFT JOIN proyectos p ON oc.id_proy = p.ID_PROY
            LEFT JOIN proveedores prov ON oc.id_prov = prov.id_prov
            WHERE oc.estatus_aprob = 'Si' 
              AND oc.estatus_orden NOT IN ('Cancelada', 'Completa')
            ORDER BY oc.fecha_orden DESC
            LIMIT 5
        ")->fetchAll();

        $this->view('dashboard/index', [
            'title'                => 'Dashboard — SistemaOF',
            'kpiProyectos'         => $kpiProyectos,
            'kpiComprasPendientes' => $kpiComprasPendientes,
            'kpiMaterialEnTransito'=> $kpiMaterialEnTransito,
            'ocPendientes'         => $ocPendientes,
            'materialTransito'     => $materialTransito,
        ]);
    }
}
