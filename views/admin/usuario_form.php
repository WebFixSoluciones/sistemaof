<?php ob_start(); ?>

<div class="mb-6 flex items-center gap-3">
    <a href="<?= BASE_URL ?>/admin/usuarios" class="text-sm text-gray-400 hover:text-gray-700">← Usuarios</a>
    <span class="text-gray-300">/</span>
    <h2 class="text-xl font-bold text-gray-900">Nuevo Usuario</h2>
</div>

<div class="max-w-xl">
    <?php if (!empty($error)): ?>
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/admin/usuarios/guardar" method="POST" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
            <input type="text" name="nombre_usuario" required placeholder="Ej. Carlos Ortiz"
                   class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
            <input type="email" name="email" required placeholder="correo@empresa.com"
                   class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña Inicial <span class="text-red-500">*</span></label>
            <input type="password" name="password" required placeholder="Mínimo 8 caracteres"
                   class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
            <p class="text-xs text-gray-400 mt-1">Se guardará cifrada con bcrypt. El usuario deberá cambiarla.</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol <span class="text-red-500">*</span></label>
                <select name="id_rol" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                    <option value="">— Seleccionar —</option>
                    <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id_rol'] ?>"><?= htmlspecialchars($r['nom_rol']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                <select name="id_empresa" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                    <option value="">— Sin empresa —</option>
                    <?php foreach ($empresas as $e): ?>
                    <option value="<?= $e['id_empresa'] ?>"><?= htmlspecialchars($e['nom_empresa']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Estado Inicial</label>
            <select name="estatus" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="btn-primary flex-1 py-2.5 bg-primary text-white font-semibold rounded-lg hover:bg-primaryHover text-sm">
                Crear Usuario
            </button>
            <a href="<?= BASE_URL ?>/admin/usuarios"
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
