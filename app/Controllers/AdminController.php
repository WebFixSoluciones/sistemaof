<?php

namespace App\Controllers;

class AdminController extends BaseController {

    /**
     * Panel principal de seguridad RBAC
     */
    public function seguridad() {
        $this->requirePermiso('SEGURIDAD');

        $db = getDBConnection();
        $roles = $db->query("SELECT * FROM sof_roles ORDER BY id_rol ASC")->fetchAll();
        $modulos = $db->query("SELECT * FROM sof_modulos WHERE estatus='Activo' ORDER BY orden ASC")->fetchAll();
        $acciones = $db->query("SELECT * FROM sof_acciones ORDER BY id_accion ASC")->fetchAll();

        $this->view('admin/seguridad', [
            'title'   => 'Panel de Seguridad — SistemaOF',
            'roles'   => $roles,
            'modulos' => $modulos,
            'acciones'=> $acciones,
        ]);
    }

    /**
     * Lista de usuarios del sistema
     */
    public function usuarios() {
        $this->requirePermiso('SEGURIDAD');

        $db = getDBConnection();
        $usuarios = $db->query("
            SELECT u.id_user, u.nombre_usuario, u.email, u.estatus,
                   u.ultimo_acceso, r.nom_rol, e.nom_empresa
            FROM sof_users u
            LEFT JOIN sof_user_roles ur ON u.id_user = ur.id_user
            LEFT JOIN sof_roles r ON ur.id_rol = r.id_rol
            LEFT JOIN empresas e ON u.id_empresa = e.id_empresa
            ORDER BY u.nombre_usuario ASC
        ")->fetchAll();

        $roles = $db->query("SELECT id_rol, nom_rol FROM sof_roles WHERE estatus='Activo' ORDER BY nom_rol ASC")->fetchAll();
        $empresas = $db->query("SELECT id_empresa, nom_empresa FROM empresas ORDER BY nom_empresa ASC")->fetchAll();

        $this->view('admin/usuarios', [
            'title'    => 'Gestión de Usuarios — SistemaOF',
            'usuarios' => $usuarios,
            'roles'    => $roles,
            'empresas' => $empresas,
        ]);
    }

    /**
     * Formulario crear usuario
     */
    public function crearUsuario() {
        $this->requirePermiso('SEGURIDAD');

        $db = getDBConnection();
        $roles = $db->query("SELECT id_rol, nom_rol FROM sof_roles WHERE estatus='Activo' ORDER BY nom_rol ASC")->fetchAll();
        $empresas = $db->query("SELECT id_empresa, nom_empresa FROM empresas ORDER BY nom_empresa ASC")->fetchAll();

        $this->view('admin/usuario_form', [
            'title'    => 'Crear Usuario — SistemaOF',
            'roles'    => $roles,
            'empresas' => $empresas,
            'usuario'  => null,
        ]);
    }

    /**
     * POST: Guardar nuevo usuario
     */
    public function guardarUsuario() {
        $this->requirePermiso('SEGURIDAD');

        $nombre   = trim($_POST['nombre_usuario'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $id_rol   = filter_input(INPUT_POST, 'id_rol', FILTER_VALIDATE_INT);
        $id_empresa = filter_input(INPUT_POST, 'id_empresa', FILTER_VALIDATE_INT);
        $estatus  = $_POST['estatus'] ?? 'Activo';

        if (empty($nombre) || empty($email) || empty($password) || !$id_rol) {
            // Volver al formulario con error
            $db = getDBConnection();
            $roles = $db->query("SELECT id_rol, nom_rol FROM sof_roles WHERE estatus='Activo'")->fetchAll();
            $empresas = $db->query("SELECT id_empresa, nom_empresa FROM empresas")->fetchAll();
            return $this->view('admin/usuario_form', [
                'title'    => 'Crear Usuario — SistemaOF',
                'roles'    => $roles,
                'empresas' => $empresas,
                'usuario'  => null,
                'error'    => 'Todos los campos marcados son obligatorios.',
            ]);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $username = strtolower(explode('@', $email)[0]);
        $creado_por = $_SESSION['user_id'] ?? null;

        $db = getDBConnection();

        try {
            $db->beginTransaction();

            $stmt = $db->prepare("
                INSERT INTO sof_users (username, nombre_usuario, email, password_hash, estatus, id_empresa, creado_por)
                VALUES (:uname, :nombre, :email, :pass, :estatus, :empresa, :creado)
            ");
            $stmt->execute([
                ':uname'   => $username,
                ':nombre'  => $nombre,
                ':email'   => $email,
                ':pass'    => $hash,
                ':estatus' => $estatus,
                ':empresa' => $id_empresa ?: null,
                ':creado'  => $creado_por,
            ]);
            $new_id = $db->lastInsertId();

            // Asignar rol
            $db->prepare("INSERT INTO sof_user_roles (id_user, id_rol, asignado_por) VALUES (:u, :r, :by)")
               ->execute([':u' => $new_id, ':r' => $id_rol, ':by' => $creado_por]);

            $db->commit();
        } catch (\Exception $e) {
            $db->rollBack();
            // volver con error
            $roles = $db->query("SELECT id_rol, nom_rol FROM sof_roles WHERE estatus='Activo'")->fetchAll();
            $empresas = $db->query("SELECT id_empresa, nom_empresa FROM empresas")->fetchAll();
            return $this->view('admin/usuario_form', [
                'title'    => 'Crear Usuario — SistemaOF',
                'roles'    => $roles,
                'empresas' => $empresas,
                'usuario'  => null,
                'error'    => 'Error al guardar: ' . $e->getMessage(),
            ]);
        }

        $this->redirect('/admin/usuarios');
    }
}
