<?php ob_start(); ?>

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900">Sistema<span class="text-primary">OF</span> v3.0</h2>
        <p class="mt-2 text-sm text-gray-500">Gestión Integral de Proyectos</p>
    </div>

    <div class="glass-card rounded-2xl p-8">
        <?php if(isset($error)): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

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

            <button type="submit" class="btn-primary w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-primaryHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary mt-6">
                Ingresar al Sistema
            </button>
        </form>
    </div>
    
    <div class="mt-8 text-center">
        <p class="text-xs text-gray-400">&copy; 2026 Servicios de Construcción O&F S. de R.L.</p>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
