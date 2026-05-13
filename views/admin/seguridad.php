<?php ob_start(); ?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Seguridad (RBAC)</h2>
    <p class="text-sm text-gray-500">Gestión de Usuarios, Roles y Permisos del Sistema.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Columna 1: Roles -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Roles del Sistema</h3>
            <button class="text-sm bg-primary text-white px-3 py-1 rounded hover:bg-primaryHover">+ Nuevo</button>
        </div>
        <ul class="divide-y divide-gray-100">
            <li class="py-3 flex justify-between items-center">
                <div>
                    <span class="font-medium text-gray-800">Superadmin</span>
                    <p class="text-xs text-gray-500">Acceso total</p>
                </div>
                <button class="text-gray-400 hover:text-primary"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
            </li>
            <li class="py-3 flex justify-between items-center bg-gray-50 -mx-6 px-6 border-l-4 border-primary">
                <div>
                    <span class="font-medium text-gray-800">Gerencia</span>
                    <p class="text-xs text-gray-500">Acceso gerencial</p>
                </div>
                <button class="text-primary"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
            </li>
            <li class="py-3 flex justify-between items-center">
                <div>
                    <span class="font-medium text-gray-800">Administrador</span>
                    <p class="text-xs text-gray-500">Operación completa</p>
                </div>
                <button class="text-gray-400 hover:text-primary"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
            </li>
        </ul>
    </div>

    <!-- Columna 2 y 3: Permisos -->
    <div class="lg:col-span-2 bg-white shadow-sm rounded-xl border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">Permisos para: <span class="text-primary">Gerencia</span></h3>
            <button class="text-sm bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">Guardar Cambios</button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Módulo</th>
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ver</th>
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase">Crear</th>
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase">Editar</th>
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase">Eliminar</th>
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aprobar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-3 py-3 whitespace-nowrap font-medium text-gray-900">Proyectos</td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" checked class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" checked class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" checked class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="px-3 py-3 whitespace-nowrap font-medium text-gray-900">Compras</td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" checked class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" checked class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                    </tr>
                    <tr>
                        <td class="px-3 py-3 whitespace-nowrap font-medium text-gray-900">Planillas</td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" checked class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                        <td class="px-3 py-3 text-center"><input type="checkbox" checked class="text-primary rounded border-gray-300 focus:ring-primary"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-8 bg-white shadow-sm rounded-xl border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-medium text-gray-900">Usuarios del Sistema</h3>
        <button class="text-sm bg-primary text-white px-4 py-2 rounded hover:bg-primaryHover">+ Nuevo Usuario</button>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Correo</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">A</div>
                            <div class="ml-3 font-medium text-gray-900">Admin General</div>
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">admin@sistemaof.com</td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Superadmin</span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-primary hover:text-primaryHover">Editar</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">C</div>
                            <div class="ml-3 font-medium text-gray-900">Carlos Ortiz</div>
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">cortiz@sistemaof.com</td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Gerencia</span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-primary hover:text-primaryHover">Editar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
