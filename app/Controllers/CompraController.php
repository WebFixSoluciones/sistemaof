<?php

namespace App\Controllers;

use App\Models\CompraModel;
use App\Models\EntregaModel;

class CompraController extends BaseController {

    /**
     * ══════════════════════════════════════════════════════════════
     *  PANEL PRINCIPAL — Control de Órdenes de Compra
     * ══════════════════════════════════════════════════════════════
     */
    public function index() {
        $this->requirePermiso('COMPRAS');

        $model = new CompraModel();

        // Filtros desde GET
        $filtros = [
            'id_proy' => filter_input(INPUT_GET, 'proyecto', FILTER_VALIDATE_INT),
            'id_prov' => filter_input(INPUT_GET, 'proveedor', FILTER_VALIDATE_INT),
            'estatus' => filter_input(INPUT_GET, 'estatus', FILTER_SANITIZE_SPECIAL_CHARS),
            'buscar'  => filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_SPECIAL_CHARS),
        ];

        $ordenes    = $model->listarOrdenes($filtros);
        $kpis       = $model->getKPIs();
        $proyectos  = $model->getProyectos();
        $proveedores = $model->getProveedores();

        $this->view('compras/index', [
            'title'       => 'Control de Órdenes de Compra — SistemaOF',
            'ordenes'     => $ordenes,
            'kpis'        => $kpis,
            'proyectos'   => $proyectos,
            'proveedores' => $proveedores,
            'filtros'     => $filtros,
        ]);
    }

    /**
     * ══════════════════════════════════════════════════════════════
     *  DETALLE — Ver OC completa con ítems y tracking
     * ══════════════════════════════════════════════════════════════
     */
    public function detalle() {
        $this->requirePermiso('COMPRAS');

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) $this->redirect('/compras');

        $model   = new CompraModel();
        $orden   = $model->getOrden($id);
        if (!$orden) $this->redirect('/compras');

        $detalles  = $model->getDetalles($id);
        $historial = $model->getHistorialEntregas($id);

        $this->view('compras/detalle', [
            'title'     => 'Detalle OC: ' . $orden['cod_ocompra'],
            'orden'     => $orden,
            'detalles'  => $detalles,
            'historial' => $historial,
        ]);
    }

    /**
     * ══════════════════════════════════════════════════════════════
     *  STOCK — Consulta de productos por stock
     * ══════════════════════════════════════════════════════════════
     */
    public function stock() {
        $this->requirePermiso('COMPRAS');

        $model = new CompraModel();

        $filtros = [
            'buscar'  => filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_SPECIAL_CHARS),
            'id_proy' => filter_input(INPUT_GET, 'proyecto', FILTER_VALIDATE_INT),
        ];

        $productos  = $model->getStockProductos($filtros);
        $proyectos  = $model->getProyectos();

        $this->view('compras/stock', [
            'title'      => 'Consulta de Stock por Producto — SistemaOF',
            'productos'  => $productos,
            'proyectos'  => $proyectos,
            'filtros'    => $filtros,
        ]);
    }

    /**
     * ══════════════════════════════════════════════════════════════
     *  BANDEJA DE APROBACIÓN
     * ══════════════════════════════════════════════════════════════
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
            $model     = new CompraModel();
            $aprobador = $_SESSION['user_name'] ?? 'Sistema Web';
            $model->aprobarOrden($id, $aprobador);
            $_SESSION['swal_success'] = 'Orden de compra aprobada correctamente.';
        }

        $this->redirect('/compras/aprobacion');
    }

    /**
     * ══════════════════════════════════════════════════════════════
     *  RECEPCIÓN EN CAMPO
     * ══════════════════════════════════════════════════════════════
     */
    public function recepcion() {
        $this->requirePermiso('ENTREGAS');

        $model   = new EntregaModel();
        $ordenes = $model->getOrdenesEnTransito();

        $this->view('compras/recepcion_lista', [
            'title'  => 'Recepción de Material en Campo',
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
            $_SESSION['swal_error'] = 'No se enviaron cantidades para procesar.';
            $this->redirect('/compras/recepcion');
        }

        $model     = new EntregaModel();
        $resultado = $model->registrarRecepcion(
            $id_ocompra,
            $cantidades,
            (int)($_SESSION['user_id'] ?? 1)
        );

        if ($resultado !== true) {
            $_SESSION['swal_error'] = $resultado;
            $this->redirect('/compras/recibir?id=' . $id_ocompra);
            return;
        }

        $_SESSION['swal_success'] = 'Recepción registrada correctamente. Los ítems han sido actualizados.';
        $this->redirect('/compras/recepcion');
    }
}
