<?php ob_start(); ?>

<!-- ═══ KPI Cards ═══ -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total OC</span>
            <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-gray-900"><?= $kpis['total_oc'] ?></p>
        <p class="text-[10px] text-gray-400 mt-0.5">Órdenes registradas</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Pendientes</span>
            <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-amber-600"><?= $kpis['pendientes_aprob'] ?></p>
        <p class="text-[10px] text-gray-400 mt-0.5">Requieren aprobación</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Ítems Entregados</span>
            <span class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-green-600"><?= $kpis['items_completos'] ?> <span class="text-sm font-normal text-gray-400">/ <?= $kpis['items_total'] ?></span></p>
        <p class="text-[10px] text-gray-400 mt-0.5">Completos de <?= $kpis['items_total'] ?> totales</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Monto Total</span>
            <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-gray-900">L. <?= number_format($kpis['monto_total'], 2) ?></p>
        <p class="text-[10px] text-gray-400 mt-0.5">Valor acumulado OC</p>
    </div>
</div>

<!-- ═══ Accesos Rápidos ═══ -->
<div class="flex flex-wrap gap-2 mb-5">
    <a href="<?= BASE_URL ?>/compras" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-indigo-600 text-white">Todas las OC</a>
    <a href="<?= BASE_URL ?>/compras/aprobacion" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100">Aprobar Órdenes</a>
    <a href="<?= BASE_URL ?>/compras/recepcion" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-green-50 text-green-700 border border-green-200 hover:bg-green-100">Recepción en Campo</a>
    <a href="<?= BASE_URL ?>/compras/stock" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100">Consulta de Stock</a>
</div>

<!-- ═══ Filtros ═══ -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-5">
    <form method="GET" action="<?= BASE_URL ?>/compras" class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[180px]">
            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Buscar OC / Proveedor</label>
            <input type="text" name="buscar" value="<?= htmlspecialchars($filtros['buscar'] ?? '') ?>" placeholder="Ej. OC-00001, Proveedores..."
                   class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="min-w-[150px]">
            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Proyecto</label>
            <select name="proyecto" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Todos</option>
                <?php foreach ($proyectos as $proy): ?>
                    <option value="<?= $proy['ID_PROY'] ?>" <?= ($filtros['id_proy'] ?? '') == $proy['ID_PROY'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($proy['COD_PROY'] . ' — ' . $proy['NOM_PROY']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="min-w-[140px]">
            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Proveedor</label>
            <select name="proveedor" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Todos</option>
                <?php foreach ($proveedores as $prov): ?>
                    <option value="<?= $prov['id_prov'] ?>" <?= ($filtros['id_prov'] ?? '') == $prov['id_prov'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prov['nom_prov']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="min-w-[120px]">
            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Estado</label>
            <select name="estatus" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Todos</option>
                <option value="Pendiente" <?= ($filtros['estatus'] ?? '') === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="Aprobada" <?= ($filtros['estatus'] ?? '') === 'Aprobada' ? 'selected' : '' ?>>Aprobada</option>
                <option value="Anticipo" <?= ($filtros['estatus'] ?? '') === 'Anticipo' ? 'selected' : '' ?>>Anticipo</option>
                <option value="Cancelada" <?= ($filtros['estatus'] ?? '') === 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-xs font-medium hover:bg-gray-700">Filtrar</button>
            <a href="<?= BASE_URL ?>/compras" class="px-3 py-2 border border-gray-200 text-gray-500 rounded-lg text-xs hover:bg-gray-50">Limpiar</a>
        </div>
    </form>
</div>

<!-- ═══ Tabla de Órdenes ═══ -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-sm font-semibold text-gray-800">Listado de Órdenes de Compra</h3>
        <span class="text-[10px] text-gray-400 font-medium"><?= count($ordenes) ?> registros</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Orden</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Proyecto</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Proveedor</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Total</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Aprobación</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Entregas</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <?php if (empty($ordenes)): ?>
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">No se encontraron órdenes con los filtros aplicados.</td></tr>
                <?php else: ?>
                <?php foreach ($ordenes as $oc): ?>
                <?php
                    // Colores por estado
                    $colorAprob = $oc['estatus_aprob'] === 'Si'
                        ? 'bg-green-50 text-green-700 border-green-200'
                        : 'bg-amber-50 text-amber-700 border-amber-200';
                    $labelAprob = $oc['estatus_aprob'] === 'Si' ? 'Aprobada' : 'Pendiente';

                    // Progress de entregas
                    $totalItems = (int)$oc['total_items'];
                    $completos  = (int)$oc['items_completos'];
                    $pct = $totalItems > 0 ? round(($completos / $totalItems) * 100) : 0;
                    $pctColor = $pct === 100 ? 'bg-green-500' : ($pct > 0 ? 'bg-amber-400' : 'bg-gray-200');
                ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-2.5">
                        <div class="font-semibold text-gray-800"><?= htmlspecialchars($oc['cod_ocompra']) ?></div>
                        <div class="text-[10px] text-gray-400"><?= $oc['fecha_orden'] ?></div>
                    </td>
                    <td class="px-3 py-2.5">
                        <span class="font-medium text-gray-700"><?= htmlspecialchars($oc['cod_proy']) ?></span>
                    </td>
                    <td class="px-3 py-2.5 max-w-[200px]">
                        <span class="text-gray-700 truncate block" title="<?= htmlspecialchars($oc['nom_prov']) ?>"><?= htmlspecialchars($oc['nom_prov']) ?></span>
                    </td>
                    <td class="px-3 py-2.5 text-right font-semibold text-gray-800">
                        L. <?= number_format($oc['cost_total'], 2) ?>
                    </td>
                    <td class="px-3 py-2.5 text-center">
                        <span class="inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full border <?= $colorAprob ?>">
                            <?= $labelAprob ?>
                        </span>
                    </td>
                    <td class="px-3 py-2.5">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="h-full rounded-full <?= $pctColor ?>" style="width: <?= $pct ?>%"></div>
                            </div>
                            <span class="text-[10px] font-semibold text-gray-500 w-10 text-right"><?= $completos ?>/<?= $totalItems ?></span>
                        </div>
                    </td>
                    <td class="px-3 py-2.5 text-center">
                        <a href="<?= BASE_URL ?>/compras/detalle?id=<?= $oc['id_ocompra'] ?>"
                           class="inline-flex items-center gap-1 text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg hover:bg-indigo-100 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Ver
                        </a>
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
