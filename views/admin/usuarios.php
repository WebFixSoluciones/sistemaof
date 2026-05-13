<?php ob_start(); ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Usuarios del Sistema</h2>
        <p class="text-sm text-gray-400">Gestión de accesos y roles para SistemaOF.</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/usuarios/crear"
       class="btn-primary inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primaryHover">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Usuario
    </a>
</div>

<?php if (!empty($error)): ?>
<div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Correo</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Empresa</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Último Acceso</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if (empty($usuarios)): ?>
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                        No hay usuarios registrados. <a href="<?= BASE_URL ?>/admin/usuarios/crear" class="text-primary hover:underline">Crear el primero</a>.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($usuarios as $u): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 text-primary font-bold flex items-center justify-center text-sm flex-shrink-0">
                                <?= strtoupper(substr($u['nombre_usuario'], 0, 1)) ?>
                            </div>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($u['nombre_usuario']) ?></span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-500"><?= htmlspecialchars($u['email']) ?></td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                            <?= htmlspecialchars($u['nom_rol'] ?? 'Sin rol') ?>
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs"><?= htmlspecialchars($u['nom_empresa'] ?? '—') ?></td>
                    <td class="px-5 py-3 text-gray-400 text-xs">
                        <?= $u['ultimo_acceso'] ? date('d/m/Y H:i', strtotime($u['ultimo_acceso'])) : 'Nunca' ?>
                    </td>
                    <td class="px-5 py-3">
                        <?php
                            $colores = [
                                'Activo'    => 'bg-green-100 text-green-800',
                                'Inactivo'  => 'bg-gray-100 text-gray-600',
                                'Suspendido'=> 'bg-yellow-100 text-yellow-700',
                                'Bloqueado' => 'bg-red-100 text-red-700',
                            ];
                            $cls = $colores[$u['estatus']] ?? 'bg-gray-100 text-gray-600';
                        ?>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold <?= $cls ?>">
                            <?= $u['estatus'] ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
