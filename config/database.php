<?php
/**
 * Configuración de Base de Datos — SistemaOF v3.0
 */

define('DB_HOST',    '127.0.0.1');
define('DB_PORT',    '3306');
define('DB_NAME',    'sistemaof');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

/**
 * Retorna una conexión PDO singleton.
 * Se llama desde cualquier Model o Controller.
 */
function getDBConnection(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST
             . ";port="    . DB_PORT
             . ";dbname="  . DB_NAME
             . ";charset=" . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            http_response_code(500);
            die("<b>Error de conexión a la base de datos.</b> Verifica la configuración en <code>config/database.php</code>.<br><small>" . $e->getMessage() . "</small>");
        }
    }

    return $pdo;
}

/**
 * Verifica si la conexión a la BD está activa sin detener el script.
 */
function checkDBConnection(): bool {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return true;
    } catch (\PDOException $e) {
        return false;
    }
}
