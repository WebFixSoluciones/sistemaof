<?php

namespace App\Controllers;

use App\Models\CompraModel;
use App\Models\EntregaModel;

class CompraController extends BaseController {

    /**
     * Bandeja de Aprobación — requiere permiso COMPRAS
     */
    public function aprobacion() {
        $this->requirePermiso('COMPRAS');

        $model   = new CompraModel();
        $ordenes = $model->getOrdenesPendientes();

        $puedeAprobar = $this->tieneAccion('COMPRAS', 'APROBAR');

        $this->view('compras/aprobacion', [
            'title'        => 'Bandeja de Aprobación de Órdenes',
            'ordenes'      => $ordenes,
            'puedeAprobar' => $puedeAprobar,
        ]);
    }

    /**
     * POST: Aprobar una OC
     */
    public function aprobarOc() {
        $this->requirePermiso('COMPRAS');

        if (!$this->tieneAccion('COMPRAS', 'APROBAR')) {
            http_response_code(403);
            die('Sin permiso para aprobar.');
        }

        $id = filter_input(INPUT_POST, 'id_ocompra', FILTER_VALIDATE_INT);
        if ($id) {
            $model       = new CompraModel();
            $aprobador   = $_SESSION['user_name'] ?? 'Sistema Web';
            $model->aprobarOrden($id, $aprobador);
        }

        $this->redirect('/compras/aprobacion');
    }

    /**
     * Bandeja de Recepción — requiere permiso ENTREGAS
     */
    public function recepcion() {
        $this->requirePermiso('ENTREGAS');

        $model   = new EntregaModel();
        $ordenes = $model->getOrdenesEnTransito();

        $this->view('compras/recepcion_lista', [
            'title'  => 'Material en Tránsito — Bandeja de Recepción',
            'ordenes' => $ordenes,
        ]);
    }

    /**
     * Detalle de una OC para registrar recepción
     */
    public function recibirOc() {
        $this->requirePermiso('ENTREGAS');

        $id_ocompra = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id_ocompra) $this->redirect('/compras/recepcion');

        $compraModel = new CompraModel();
        $orden       = $compraModel->getOrden($id_ocompra);
        if (!$orden) $this->redirect('/compras/recepcion');

        $detalles = $compraModel->getDetalles($id_ocompra);

        $this->view('compras/recepcion_detalle', [
            'title'    => 'Recepción OC: ' . $orden['cod_ocompra'],
            'orden'    => $orden,
            'detalles' => $detalles,
        ]);
    }

    /**
     * POST: Guardar cantidades recibidas
     */
    public function procesarRecepcion() {
        $this->requirePermiso('ENTREGAS');

        $id_ocompra   = filter_input(INPUT_POST, 'id_ocompra', FILTER_VALIDATE_INT);
        $cantidades   = $_POST['cant_entrega'] ?? [];

        if (!$id_ocompra || empty($cantidades)) {
            $this->redirect('/compras/recepcion');
        }

        $model     = new EntregaModel();
        $resultado = $model->registrarRecepcion(
            $id_ocompra,
            $cantidades,
            (int)($_SESSION['user_id'] ?? 1)
        );

        if ($resultado !== true) {
            // Mostrar error amigable de vuelta en el formulario
            $compraModel = new CompraModel();
            $orden       = $compraModel->getOrden($id_ocompra);
            $detalles    = $compraModel->getDetalles($id_ocompra);
            $this->view('compras/recepcion_detalle', [
                'title'    => 'Recepción OC: ' . $orden['cod_ocompra'],
                'orden'    => $orden,
                'detalles' => $detalles,
                'error'    => $resultado,
            ]);
            return;
        }

        $this->redirect('/compras/recepcion');
    }

    /**
     * Consulta de Stock e Inventario en Proyecto
     */
    public function inventario() {
        $this->requirePermiso('ENTREGAS'); // O crear un permiso específico de INVENTARIO

        $model = new EntregaModel();
        $stock = $model->getInventarioProyectos();

        $this->view('compras/inventario', [
            'title' => 'Control de Stock y Materiales',
            'stock' => $stock
        ]);
    }
}
