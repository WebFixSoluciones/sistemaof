<?php
    require_once __DIR__ . '/../../config/database.php';
    $db_connected = checkDBConnection();
    ob_start();
?>

<div class="w-full max-w-md">
    <!-- DB Indicator -->
    <div class="flex justify-center mb-6">
        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full shadow-sm text-xs font-semibold
            <?= $db_connected ? 'bg-white text-green-700 border border-green-200' : 'bg-red-50 text-red-600 border border-red-200' ?>">
            <span class="w-2 h-2 rounded-full <?= $db_connected ? 'bg-green-500 animate-pulse' : 'bg-red-500' ?>"></span>
            <?= $db_connected ? 'BD Sincronizada' : 'Sin conexión a BD' ?>
        </div>
    </div>

    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900">Sistema<span class="text-primary">OF</span> v3.0</h2>
        <p class="mt-2 text-sm text-gray-500">Gestión Integral de Proyectos</p>
    </div>

    <div class="glass-card rounded-2xl p-8">
        <form action="<?= BASE_URL ?>/login" method="POST" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" id="email" required placeholder="tu@correo.com" 
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary sm:text-sm transition duration-150 ease-in-out">
            </div>
            
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <a href="<?= BASE_URL ?>/recover" class="text-xs text-primary hover:text-primaryHover font-medium">¿Olvidaste tu contraseña?</a>
                </div>
                <input type="password" name="password" id="password" required placeholder="••••••••" 
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary sm:text-sm transition duration-150 ease-in-out">
            </div>

            <button type="submit" <?= !$db_connected ? 'disabled' : '' ?> class="btn-primary w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-primaryHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary mt-6 <?= !$db_connected ? 'opacity-50 cursor-not-allowed' : '' ?>">
                <?= $db_connected ? 'Ingresar al Sistema' : 'Base de datos desconectada' ?>
            </button>
        </form>
    </div>
    
    <div class="mt-8 text-center">
        <p class="text-xs text-gray-400">&copy; 2026 Servicios de Construcción O&F S. de R.L.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if(isset($error)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error de autenticación',
            text: '<?= htmlspecialchars($error) ?>',
            confirmButtonColor: '#0f172a'
        });
    <?php endif; ?>
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
