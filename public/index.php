<?php
/**
 * SistemaOF v3.0 - Front Controller
 * Archivo principal que recibe todas las peticiones.
 */

// Iniciar sesión de forma segura
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'use_strict_mode' => true,
]);

// Definir BASE_URL dinámicamente para los links y redirecciones
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim($scriptName, '/'));

// Cargar configuración
require_once __DIR__ . '/../config/database.php';

// Autoload simple (PSR-4 básico)
spl_autoload_register(function ($class) {
    // Convertir App\ a app/
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Inicializar el Router
require_once __DIR__ . '/../routes/web.php';