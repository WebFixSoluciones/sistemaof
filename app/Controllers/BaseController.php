<?php

namespace App\Controllers;

abstract class BaseController {

    /**
     * Renderiza una vista pasando datos a la scope.
     */
    protected function view(string $viewPath, array $data = []): void {
        // Siempre inyectar datos de sesión disponibles en todas las vistas
        $data['_user_id']        = $_SESSION['user_id']          ?? null;
        $data['user_name']       = $_SESSION['user_name']        ?? ($data['user_name'] ?? 'Usuario');
        $data['_role_name']      = $_SESSION['user_role_name']   ?? 'Sin rol';
        $data['_es_superadmin']  = $_SESSION['es_superadmin']    ?? false;
        $data['_modulos']        = $_SESSION['modulos_permitidos'] ?? [];

        extract($data);

        $file = __DIR__ . '/../../views/' . $viewPath . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            http_response_code(500);
            die("<b>Error 500:</b> La vista <code>{$viewPath}</code> no existe en <code>{$file}</code>.");
        }
    }

    /**
     * Redirige a una URL. Antepone BASE_URL si la ruta es relativa.
     */
    protected function redirect(string $url): void {
        if (strpos($url, '/') === 0) {
            $url = BASE_URL . $url;
        }
        header("Location: {$url}");
        exit();
    }

    /**
     * Verifica que el usuario esté autenticado. Redirige si no.
     */
    protected function requireAuth(): void {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    /**
     * Verifica que el usuario tenga permiso sobre un módulo.
     * Superadmin pasa siempre.
     */
    protected function requirePermiso(string $cod_modulo): void {
        $this->requireAuth();
        if (!empty($_SESSION['es_superadmin'])) return;

        $modulos = $_SESSION['modulos_permitidos'] ?? [];
        if (!isset($modulos[$cod_modulo])) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit();
        }
    }

    /**
     * Verifica si el usuario tiene una acción específica sobre un módulo.
     */
    protected function tieneAccion(string $cod_modulo, string $accion): bool {
        if (!empty($_SESSION['es_superadmin'])) return true;
        $model = new \App\Models\AuthModel();
        $acciones = $model->getAccionesPermitidas(
            (int)$_SESSION['user_role_id'],
            $cod_modulo,
            false
        );
        return in_array($accion, $acciones);
    }
}
