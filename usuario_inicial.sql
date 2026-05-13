-- ============================================================
--  SistemaOF v3.0 — Script de usuario inicial (Superadmin)
--  EJECUTAR UNA SOLA VEZ en phpMyAdmin o consola MySQL
-- ============================================================
-- 
-- Contraseña: Admin2026!
-- La contraseña está hasheada con bcrypt (cost=12)
-- ============================================================

INSERT INTO `sof_users` 
    (`username`, `nombre_usuario`, `email`, `password_hash`, `estatus`, `id_empresa`, `observaciones`)
VALUES 
    (
        'superadmin',
        'Super Administrador',
        'admin@sistemaof.com',
        '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Activo',
        1,
        'Usuario inicial del sistema — Cambiar contraseña después del primer acceso'
    );

-- Asignar rol Superadmin al usuario recién creado
INSERT INTO `sof_user_roles` (`id_user`, `id_rol`, `asignado_por`)
SELECT u.id_user, 1, u.id_user
FROM sof_users u
WHERE u.email = 'admin@sistemaof.com'
LIMIT 1;

-- Verificar:
-- SELECT u.id_user, u.nombre_usuario, u.email, r.nom_rol, r.es_superadmin
-- FROM sof_users u
-- JOIN sof_user_roles ur ON u.id_user = ur.id_user
-- JOIN sof_roles r ON ur.id_rol = r.id_rol
-- WHERE u.email = 'admin@sistemaof.com';
