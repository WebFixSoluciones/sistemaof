<?php

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\AdminController;
use App\Controllers\CompraController;

// Iniciar el enrutador instanciando la clase Router (si no fuera estático)
// En este caso es estático.

Router::get('/', function() {
    // Redirigir al dashboard si está autenticado, sino al login
    if (isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
    header('Location: ' . BASE_URL . '/login');
    exit;
});

// Rutas de Autenticación
Router::get('/login', [AuthController::class, 'showLoginForm']);
Router::post('/login', [AuthController::class, 'login']);
Router::get('/logout', [AuthController::class, 'logout']);
Router::get('/recover', [AuthController::class, 'showRecoverForm']);
Router::post('/recover', [AuthController::class, 'recover']);

// Rutas de Dashboard
Router::get('/dashboard', [DashboardController::class, 'index']);

// Rutas de Admin/Seguridad
Router::get('/admin/seguridad', [AdminController::class, 'seguridad']);
Router::post('/admin/seguridad/guardar', [AdminController::class, 'guardarPermisos']);
Router::get('/admin/roles/crear', [AdminController::class, 'crearRol']);
Router::post('/admin/roles/guardar', [AdminController::class, 'guardarRol']);
Router::get('/admin/usuarios', [AdminController::class, 'usuarios']);
Router::get('/admin/usuarios/crear', [AdminController::class, 'crearUsuario']);
Router::post('/admin/usuarios/guardar', [AdminController::class, 'guardarUsuario']);

// Rutas de Compras y Entregas (Fase 4)
Router::get('/compras', [CompraController::class, 'index']);
Router::get('/compras/detalle', [CompraController::class, 'detalle']);
Router::get('/compras/stock', [CompraController::class, 'stock']);
Router::get('/compras/aprobacion', [CompraController::class, 'aprobacion']);
Router::post('/compras/aprobar', [CompraController::class, 'aprobarOc']);
Router::get('/compras/recepcion', [CompraController::class, 'recepcion']);
Router::get('/compras/recibir', [CompraController::class, 'recibirOc']);
Router::post('/compras/procesar-recepcion', [CompraController::class, 'procesarRecepcion']);

// Despachar la ruta actual
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Remover el prefijo BASE_URL dinámicamente (funciona en localhost/subdir y en raíz)
$base = rtrim(BASE_URL, '/');
if ($base !== '' && strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}
if ($uri === '' || $uri === false) {
    $uri = '/';
}

Router::dispatch($uri, $method);
