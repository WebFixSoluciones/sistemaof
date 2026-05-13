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

        // Cargar permisos del rol seleccionado para marcarlos en la vista
        $rol_seleccionado = filter_input(INPUT_GET, 'rol', FILTER_VALIDATE_INT) ?? ($roles[0]['id_rol'] ?? 0);
        $permisos_actuales = [];
        if ($rol_seleccionado) {
            $stmt = $db->prepare("SELECT id_modulo, id_accion FROM sof_role_permissions WHERE id_rol = ? AND permitido = 1");
            $stmt->execute([$rol_seleccionado]);
            foreach ($stmt->fetchAll() as $row) {
                $permisos_actuales[$row['id_modulo']][$row['id_accion']] = true;
            }
        }

        $this->view('admin/seguridad', [
            'title'   => 'Panel de Seguridad — SistemaOF',
            'roles'   => $roles,
            'modulos' => $modulos,
            'acciones'=> $acciones,
            'permisos_actuales' => $permisos_actuales,
        ]);
    }

    /**
     * POST: Guardar permisos del rol
     */
    public function guardarPermisos() {
        $this->requirePermiso('SEGURIDAD');

        $id_rol = filter_input(INPUT_POST, 'id_rol', FILTER_VALIDATE_INT);
        $permisos = $_POST['permisos'] ?? [];

        if (!$id_rol) {
            $this->redirect('/admin/seguridad');
        }

        $db = getDBConnection();
        $creado_por = $_SESSION['user_id'] ?? null;
        
        try {
            $db->beginTransaction();

            $stmt = $db->prepare("DELETE FROM sof_role_permissions WHERE id_rol = :id_rol");
            $stmt->execute([':id_rol' => $id_rol]);

            if (!empty($permisos)) {
                $stmtInsert = $db->prepare("INSERT INTO sof_role_permissions (id_rol, id_modulo, id_accion, permitido, asignado_por) VALUES (:rol, :mod, :acc, 1, :por)");
                foreach ($permisos as $id_modulo => $acciones) {
                    foreach ($acciones as $id_accion => $val) {
                        $stmtInsert->execute([
                            ':rol' => $id_rol,
                            ':mod' => $id_modulo,
                            ':acc' => $id_accion,
                            ':por' => $creado_por
                        ]);
                    }
                }
            }

            $db->commit();
        } catch (\Exception $e) {
            $db->rollBack();
            $_SESSION['swal_error'] = 'Error al guardar permisos: ' . $e->getMessage();
        }

        $_SESSION['swal_success'] = 'Los permisos del rol han sido actualizados.';
        $this->redirect('/admin/seguridad?rol=' . $id_rol);
    }

    /**
     * Formulario crear rol
     */
    public function crearRol() {
        $this->requirePermiso('SEGURIDAD');
        $this->view('admin/rol_form', [
            'title' => 'Crear Rol — SistemaOF',
        ]);
    }

    /**
     * POST: Guardar nuevo rol
     */
    public function guardarRol() {
        $this->requirePermiso('SEGURIDAD');

        $nom_rol = trim($_POST['nom_rol'] ?? '');
        $desc_rol = trim($_POST['desc_rol'] ?? '');
        $es_superadmin = isset($_POST['es_superadmin']) ? 1 : 0;

        if (empty($nom_rol)) {
            $_SESSION['swal_error'] = 'El nombre del rol es obligatorio.';
            return $this->redirect('/admin/roles/crear');
        }

        $db = getDBConnection();
        try {
            $stmt = $db->prepare("INSERT INTO sof_roles (nom_rol, desc_rol, es_superadmin) VALUES (:nom, :desc, :sup)");
            $stmt->execute([
                ':nom'  => $nom_rol,
                ':desc' => $desc_rol,
                ':sup'  => $es_superadmin
            ]);
        } catch (\Exception $e) {
            $_SESSION['swal_error'] = 'Error al guardar el rol: ' . $e->getMessage();
            return $this->redirect('/admin/roles/crear');
        }

        $_SESSION['swal_success'] = 'Rol creado correctamente.';
        $this->redirect('/admin/seguridad');
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
            $_SESSION['swal_error'] = 'Todos los campos marcados son obligatorios.';
            return $this->redirect('/admin/usuarios/crear');
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
            $_SESSION['swal_error'] = 'Error al guardar el usuario: ' . $e->getMessage();
            return $this->redirect('/admin/usuarios/crear');
        }

        $_SESSION['swal_success'] = 'Usuario creado y asignado correctamente.';
        $this->redirect('/admin/usuarios');
    }
}
