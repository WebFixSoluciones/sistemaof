<?php

namespace App\Models;

class AuthModel {
    private $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    /**
     * Busca usuario por email y valida la contraseña.
     * Retorna el usuario completo o false.
     */
    public function findByEmail(string $email): array|false {
        $stmt = $this->db->prepare("
            SELECT u.*, r.id_rol, r.nom_rol, r.es_superadmin
            FROM sof_users u
            LEFT JOIN sof_user_roles ur ON u.id_user = ur.id_user
            LEFT JOIN sof_roles r ON ur.id_rol = r.id_rol
            WHERE u.email = :email AND u.estatus = 'Activo'
            LIMIT 1
        ");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() ?: false;
    }

    /**
     * Retorna el array de módulos a los que el rol tiene permiso de VER.
     * Superadmin ve TODOS los módulos activos.
     */
    public function getModulosPermitidos(int $id_rol, bool $es_superadmin): array {
        if ($es_superadmin) {
            $stmt = $this->db->prepare("
                SELECT cod_modulo, nom_modulo, ruta_modulo, icono, orden
                FROM sof_modulos WHERE estatus = 'Activo'
                ORDER BY orden ASC
            ");
            $stmt->execute();
        } else {
            // Solo módulos donde el rol tenga permiso VER (id_accion=1)
            $stmt = $this->db->prepare("
                SELECT m.cod_modulo, m.nom_modulo, m.ruta_modulo, m.icono, m.orden
                FROM sof_role_permissions rp
                INNER JOIN sof_modulos m ON rp.id_modulo = m.id_modulo
                WHERE rp.id_rol = :id_rol 
                  AND rp.id_accion = 1
                  AND rp.permitido = 1
                  AND m.estatus = 'Activo'
                ORDER BY m.orden ASC
            ");
            $stmt->execute([':id_rol' => $id_rol]);
        }
        $rows = $stmt->fetchAll();
        // Indexar por cod_modulo para acceso O(1)
        $perms = [];
        foreach ($rows as $r) {
            $perms[$r['cod_modulo']] = $r;
        }
        return $perms;
    }

    /**
     * Retorna array de acciones que el rol tiene sobre un módulo específico.
     * Superadmin siempre tiene todo.
     */
    public function getAccionesPermitidas(int $id_rol, string $cod_modulo, bool $es_superadmin): array {
        if ($es_superadmin) {
            $stmt = $this->db->prepare("SELECT cod_accion FROM sof_acciones");
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("
                SELECT a.cod_accion
                FROM sof_role_permissions rp
                INNER JOIN sof_acciones a ON rp.id_accion = a.id_accion
                INNER JOIN sof_modulos m ON rp.id_modulo = m.id_modulo
                WHERE rp.id_rol = :id_rol
                  AND m.cod_modulo = :cod_modulo
                  AND rp.permitido = 1
            ");
            $stmt->execute([':id_rol' => $id_rol, ':cod_modulo' => $cod_modulo]);
        }
        return array_column($stmt->fetchAll(), 'cod_accion');
    }

    /**
     * Registra el último acceso del usuario.
     */
    public function registrarAcceso(int $id_user): void {
        $stmt = $this->db->prepare("UPDATE sof_users SET ultimo_acceso = NOW() WHERE id_user = :id");
        $stmt->execute([':id' => $id_user]);
    }
}
