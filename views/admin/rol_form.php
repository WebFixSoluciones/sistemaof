<?php ob_start(); ?>

<div class="mb-6 flex items-center gap-3">
    <a href="<?= BASE_URL ?>/admin/seguridad" class="text-sm text-gray-400 hover:text-gray-700">← Seguridad</a>
    <span class="text-gray-300">/</span>
    <h2 class="text-xl font-bold text-gray-900">Nuevo Rol</h2>
</div>

<div class="max-w-xl">
    <form action="<?= BASE_URL ?>/admin/roles/guardar" method="POST" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Rol <span class="text-red-500">*</span></label>
            <input type="text" name="nom_rol" required placeholder="Ej. Auditor, Almacén, etc."
                   class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea name="desc_rol" rows="3" placeholder="Breve descripción de las responsabilidades..."
                      class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary"></textarea>
        </div>

        <div class="flex items-start gap-3 bg-indigo-50 p-4 rounded-lg border border-indigo-100">
            <div class="flex items-center h-5">
                <input type="checkbox" name="es_superadmin" value="1" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
            </div>
            <div class="text-sm">
                <label class="font-medium text-indigo-900">Privilegios de Superadmin</label>
                <p class="text-indigo-700 mt-0.5 text-xs">Si marcas esta opción, el rol tendrá acceso ilimitado a todos los módulos y acciones del sistema, ignorando la tabla de permisos específica.</p>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="btn-primary flex-1 py-2.5 bg-primary text-white font-semibold rounded-lg hover:bg-primaryHover text-sm">
                Crear Rol
            </button>
            <a href="<?= BASE_URL ?>/admin/seguridad"
               class="flex-1 text-center py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-sm">
                Cancelar
            </a>
        </div>

    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
