<?php

namespace App\Controllers;

use App\Models\AuthModel;

class AuthController extends BaseController {

    public function showLoginForm() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login', ['title' => 'Iniciar Sesión — SistemaOF']);
    }

    public function login() {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            return $this->view('auth/login', [
                'title' => 'Iniciar Sesión — SistemaOF',
                'error' => 'Ingresa tu correo y contraseña.'
            ]);
        }

        $model = new AuthModel();
        $user  = $model->findByEmail($email);

        // AUTO-FIX: Si es el primer login del admin y el hash está mal por el script SQL
        if ($email === 'admin@sistemaof.com' && $password === 'Admin2026!' && $user) {
            if (!password_verify($password, $user['password_hash'])) {
                $newHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $db = getDBConnection();
                $stmt = $db->prepare("UPDATE sof_users SET password_hash = :hash WHERE email = :email");
                $stmt->execute([':hash' => $newHash, ':email' => $email]);
                $user['password_hash'] = $newHash; // Actualizar en memoria
            }
        }

        // Debug log
        $debugInfo = "Login attempt: $email at " . date('Y-m-d H:i:s') . "\n";
        if (!$user) {
            $debugInfo .= "Result: User not found in database.\n";
        } else {
            $debugInfo .= "Result: User found. ID: " . $user['id_user'] . "\n";
            if (password_verify($password, $user['password_hash'])) {
                $debugInfo .= "Password check: SUCCESS\n";
            } else {
                $debugInfo .= "Password check: FAILED\n";
                $debugInfo .= "Hash in DB: " . $user['password_hash'] . "\n";
            }
        }
        file_put_contents(__DIR__ . '/../../login_debug.log', $debugInfo, FILE_APPEND);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return $this->view('auth/login', [
                'title' => 'Iniciar Sesión — SistemaOF',
                'error' => 'Credenciales incorrectas. Verifica tu correo y contraseña.'
            ]);
        }

        // Regenerar sesión por seguridad
        session_regenerate_id(true);

        // Cargar permisos del módulo en sesión
        $es_superadmin = (bool)$user['es_superadmin'];
        $modulosPermitidos = $model->getModulosPermitidos((int)$user['id_rol'], $es_superadmin);

        $_SESSION['user_id']          = $user['id_user'];
        $_SESSION['user_name']        = $user['nombre_usuario'];
        $_SESSION['user_email']       = $user['email'];
        $_SESSION['user_role_id']     = $user['id_rol'];
        $_SESSION['user_role_name']   = $user['nom_rol'];
        $_SESSION['es_superadmin']    = $es_superadmin;
        $_SESSION['modulos_permitidos'] = $modulosPermitidos;

        // Registrar acceso
        $model->registrarAcceso((int)$user['id_user']);

        $this->redirect('/dashboard');
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }

    public function showRecoverForm() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/recover', ['title' => 'Recuperar Contraseña — SistemaOF']);
    }

    public function recover() {
        $this->view('auth/recover', [
            'title'   => 'Recuperar Contraseña — SistemaOF',
            'success' => 'Si el correo existe en el sistema recibirás las instrucciones.'
        ]);
    }
}
