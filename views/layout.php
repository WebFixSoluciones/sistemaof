<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'SistemaOF') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary:     '#6366f1',
                        primaryHover:'#4f46e5',
                        background:  '#f4f6f9',
                        surface:     '#ffffff',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .glass-card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.25);
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        .btn-primary { transition: all .2s ease-in-out; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(99,102,241,.35); }
        .nav-item { transition: all .15s ease; }
        .nav-item.active { background: #eef2ff; color: #6366f1; font-weight: 600; }
        .nav-item:not(.active):hover { background: #f9fafb; color: #111; }
    </style>
</head>
<body class="text-gray-800 antialiased h-screen flex overflow-hidden bg-background">

<?php
    // ──────────────────────────────────────────────────────────────────────────
    // Variables de sesión disponibles en el layout
    // ──────────────────────────────────────────────────────────────────────────
    $sess_user_name     = $_SESSION['user_name']          ?? 'Usuario';
    $sess_role_name     = $_SESSION['user_role_name']     ?? '';
    $sess_superadmin    = !empty($_SESSION['es_superadmin']);
    $sess_modulos       = $_SESSION['modulos_permitidos'] ?? [];
    $current_uri        = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Helper para marcar link activo
    function isActive(string $ruta): string {
        global $current_uri;
        return (strpos($current_uri, $ruta) !== false) ? 'active' : '';
    }

    // Helper para verificar si el usuario puede ver un módulo
    function puedeVer(string $cod): bool {
        global $sess_superadmin, $sess_modulos;
        return $sess_superadmin || isset($sess_modulos[$cod]);
    }
?>

<?php if (!empty($_SESSION['user_id'])): ?>
<!-- ===== SIDEBAR ===== -->
<aside class="w-60 bg-surface border-r border-gray-200 flex flex-col h-full flex-shrink-0 shadow-sm">
    <div class="h-16 flex items-center px-5 border-b border-gray-100">
        <span class="text-base font-bold text-gray-900 tracking-tight">
            Sistema<span class="text-primary">OF</span>
            <span class="ml-1 text-xs font-normal text-gray-400">v3.0</span>
        </span>
    </div>

    <nav class="flex-1 py-3 px-2 space-y-0.5 overflow-y-auto text-sm">

        <!-- Dashboard — todos lo ven -->
        <a href="<?= BASE_URL ?>/dashboard"
           class="nav-item <?= isActive('/dashboard') ?> flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <!-- ── COMPRAS & CAMPO ────────────────── -->
        <?php if (puedeVer('COMPRAS') || puedeVer('ENTREGAS')): ?>
        <p class="px-3 pt-5 pb-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Compras & Campo</p>

        <?php if (puedeVer('COMPRAS')): ?>
        <a href="<?= BASE_URL ?>/compras/aprobacion"
           class="nav-item <?= isActive('/compras/aprobacion') ?> flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Aprobar Órdenes
        </a>
        <?php endif; ?>

        <?php if (puedeVer('ENTREGAS')): ?>
        <a href="<?= BASE_URL ?>/compras/recepcion"
           class="nav-item <?= isActive('/compras/recepcion') || isActive('/compras/recibir') ? 'active' : '' ?> flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
            </svg>
            Recepción en Campo
        </a>
        <?php endif; ?>
        <?php endif; ?>

        <!-- ── INVENTARIO & PRODUCTOS ────────────────── -->
        <?php if (puedeVer('PRODUCTOS') || puedeVer('ENTREGAS')): ?>
        <p class="px-3 pt-5 pb-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Almacén y Stock</p>
        <a href="<?= BASE_URL ?>/compras/inventario"
           class="nav-item <?= isActive('/compras/inventario') ? 'active' : '' ?> flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Inventario en Proyecto
        </a>
        <?php endif; ?>

        <!-- ── ADMINISTRACIÓN (solo Superadmin) ── -->
        <?php if ($sess_superadmin || puedeVer('SEGURIDAD')): ?>
        <p class="px-3 pt-5 pb-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Administración</p>
        <a href="<?= BASE_URL ?>/admin/seguridad"
           class="nav-item <?= isActive('/admin/seguridad') ?> flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Seguridad / RBAC
        </a>
        <a href="<?= BASE_URL ?>/admin/usuarios"
           class="nav-item <?= isActive('/admin/usuarios') ?> flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
            </svg>
            Usuarios
        </a>
        <?php endif; ?>

    </nav>

    <!-- User Card + Logout -->
    <div class="p-3 border-t border-gray-200">
        <div class="flex items-center gap-3 px-2 py-2 mb-1">
            <div class="h-8 w-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                <?= strtoupper(substr($sess_user_name, 0, 1)) ?>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-gray-800 truncate"><?= htmlspecialchars($sess_user_name) ?></p>
                <p class="text-[10px] text-gray-400 truncate"><?= htmlspecialchars($sess_role_name) ?></p>
            </div>
        </div>
        <a href="<?= BASE_URL ?>/logout"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-red-500 hover:bg-red-50 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Cerrar Sesión
        </a>
    </div>
</aside>
<?php endif; ?>

<!-- ===== MAIN CONTENT ===== -->
<main class="flex-1 overflow-y-auto flex flex-col">
    <?php if (!empty($_SESSION['user_id'])): ?>
    <header class="h-14 bg-surface border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-20 shadow-sm">
        <h1 class="text-base font-semibold text-gray-800"><?= htmlspecialchars($title ?? 'Página') ?></h1>
        <div class="flex items-center gap-4 text-xs">
            <div class="flex items-center gap-1.5 px-2 py-1 bg-green-50 text-green-700 rounded-md font-medium border border-green-100">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                BD Sincronizada
            </div>
            <span class="text-gray-500"><?= date('d/m/Y') ?></span>
            <span class="text-gray-300">|</span>
            <span class="font-medium text-gray-700"><?= htmlspecialchars($sess_user_name) ?></span>
        </div>
    </header>
    <?php endif; ?>

    <div class="<?= !empty($_SESSION['user_id']) ? 'p-6' : 'h-full flex items-center justify-center' ?>">
        <?= $content ?>
    </div>
</main>

<script>
    // Sistema global de alertas SweetAlert2
    <?php if (isset($_SESSION['swal_success'])): ?>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '<?= htmlspecialchars($_SESSION['swal_success']) ?>',
            timer: 3000,
            showConfirmButton: false
        });
        <?php unset($_SESSION['swal_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['swal_error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= htmlspecialchars($_SESSION['swal_error']) ?>',
            confirmButtonColor: '#6366f1'
        });
        <?php unset($_SESSION['swal_error']); ?>
    <?php endif; ?>
</script>

</body>
</html>
