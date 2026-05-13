<?php ob_start(); ?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Seguridad (RBAC)</h2>
    <p class="text-sm text-gray-500">Gestión de Usuarios, Roles y Permisos del Sistema.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Columna 1: Roles -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-4">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-base font-semibold text-gray-900">Roles</h3>
            <a href="<?= BASE_URL ?>/admin/roles/crear" class="text-[10px] uppercase font-bold tracking-wider bg-primary text-white px-2 py-1 rounded hover:bg-primaryHover">+ Nuevo</a>
        </div>
        <ul class="divide-y divide-gray-100 text-sm">
            <?php foreach ($roles as $rol): ?>
            <li class="py-2 flex justify-between items-center hover:bg-gray-50 px-2 rounded -mx-2">
                <div class="leading-tight">
                    <span class="font-medium text-gray-800 text-sm"><?= htmlspecialchars($rol['nom_rol']) ?></span>
                    <p class="text-[10px] text-gray-400 mt-0.5"><?= $rol['es_superadmin'] ? 'Acceso total' : 'Personalizado' ?></p>
                </div>
                <div class="flex items-center gap-1.5">
                    <a href="?rol=<?= $rol['id_rol'] ?>" class="text-[10px] font-medium text-primary bg-indigo-50 px-2 py-1 rounded hover:bg-indigo-100">Permisos</a>
                    <a href="<?= BASE_URL ?>/admin/roles/editar?id=<?= $rol['id_rol'] ?>" class="text-gray-400 hover:text-primary">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Columna 2, 3 y 4: Permisos -->
    <div class="lg:col-span-3 bg-white shadow-sm rounded-xl border border-gray-100 p-4">
        <?php 
            $rol_seleccionado = filter_input(INPUT_GET, 'rol', FILTER_VALIDATE_INT) ?? ($roles[0]['id_rol'] ?? 0);
            $nombre_rol_sel = '';
            foreach ($roles as $r) {
                if ($r['id_rol'] == $rol_seleccionado) $nombre_rol_sel = $r['nom_rol'];
            }
        ?>
        <form action="<?= BASE_URL ?>/admin/seguridad/guardar" method="POST">
            <input type="hidden" name="id_rol" value="<?= $rol_seleccionado ?>">
            
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-gray-900">Permisos: <span class="text-primary"><?= htmlspecialchars($nombre_rol_sel) ?></span></h3>
                <button type="submit" class="text-xs bg-gray-800 text-white px-3 py-1.5 rounded hover:bg-gray-700 font-medium">Guardar Cambios</button>
            </div>

            <div class="overflow-x-auto border border-gray-100 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 py-2 text-left font-semibold text-gray-600 uppercase tracking-wider text-[10px]">Módulo</th>
                            <?php foreach ($acciones as $acc): ?>
                                <th class="px-1 py-2 text-center font-semibold text-gray-600 uppercase tracking-wider text-[10px]"><?= htmlspecialchars(substr($acc['nom_accion'], 0, 3)) ?>.</th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <?php foreach ($modulos as $mod): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 py-1.5 whitespace-nowrap font-medium text-gray-800">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-gray-400 text-sm"><?= htmlspecialchars($mod['icono']) ?></span>
                                    <span class="truncate max-w-[120px]" title="<?= htmlspecialchars($mod['nom_modulo']) ?>"><?= htmlspecialchars($mod['nom_modulo']) ?></span>
                                </div>
                            </td>
                            <?php foreach ($acciones as $acc): ?>
                                <?php 
                                    $checkboxName = "permisos[{$mod['id_modulo']}][{$acc['id_accion']}]";
                                    $isChecked = isset($permisos_actuales[$mod['id_modulo']][$acc['id_accion']]) ? 'checked' : '';
                                ?>
                                <td class="px-1 py-1.5 text-center">
                                    <input type="checkbox" name="<?= $checkboxName ?>" value="1" <?= $isChecked ?>
                                           class="text-primary rounded border-gray-300 focus:ring-primary h-3.5 w-3.5 cursor-pointer">
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p class="text-[10px] text-gray-400 mt-2 text-right">* Ver, Cre, Edi, Eli, Apr...</p>
        </form>
    </div>
</div>

<div class="mt-8 bg-white shadow-sm rounded-xl border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Gestión de Usuarios</h3>
        <p class="text-sm text-gray-500">Administra las cuentas de usuario, asigna roles y empresas.</p>
    </div>
    <div class="flex gap-3">
        <a href="<?= BASE_URL ?>/admin/usuarios" class="text-sm bg-indigo-50 text-primary px-4 py-2 rounded hover:bg-indigo-100 font-medium">Ver todos los usuarios</a>
        <a href="<?= BASE_URL ?>/admin/usuarios/crear" class="text-sm bg-primary text-white px-4 py-2 rounded hover:bg-primaryHover font-medium">+ Nuevo Usuario</a>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
