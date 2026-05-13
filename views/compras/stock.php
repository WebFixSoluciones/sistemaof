<?php ob_start(); ?>

<!-- ═══ Breadcrumb ═══ -->
<div class="flex items-center gap-2 mb-5 text-xs text-gray-400">
    <a href="<?= BASE_URL ?>/compras" class="hover:text-gray-600">← Control de OC</a>
    <span>/</span>
    <span class="font-semibold text-gray-700">Consulta de Stock</span>
</div>

<!-- ═══ Filtros ═══ -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-5">
    <form method="GET" action="<?= BASE_URL ?>/compras/stock" class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Buscar Producto</label>
            <input type="text" name="buscar" value="<?= htmlspecialchars($filtros['buscar'] ?? '') ?>" placeholder="Nombre o código del producto..."
                   class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="min-w-[180px]">
            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Filtrar por Proyecto</label>
            <select name="proyecto" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Todos los Proyectos</option>
                <?php foreach ($proyectos as $proy): ?>
                    <option value="<?= $proy['ID_PROY'] ?>" <?= ($filtros['id_proy'] ?? '') == $proy['ID_PROY'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($proy['COD_PROY'] . ' — ' . $proy['NOM_PROY']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-xs font-medium hover:bg-gray-700">Consultar</button>
            <a href="<?= BASE_URL ?>/compras/stock" class="px-3 py-2 border border-gray-200 text-gray-500 rounded-lg text-xs hover:bg-gray-50">Limpiar</a>
        </div>
    </form>
</div>

<!-- ═══ Resumen Rápido ═══ -->
<?php
    $totalPedido = 0; $totalRecibido = 0; $totalPendiente = 0;
    foreach ($productos as $p) {
        $totalPedido += (float)$p['total_pedido'];
        $totalRecibido += (float)$p['total_recibido'];
        $totalPendiente += (float)$p['total_pendiente'];
    }
    $pctGlobal = $totalPedido > 0 ? round(($totalRecibido / $totalPedido) * 100) : 0;
?>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <span class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Productos Distintos</span>
        <p class="text-2xl font-bold text-gray-900"><?= count($productos) ?></p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <span class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Total Pedido</span>
        <p class="text-2xl font-bold text-indigo-600"><?= number_format($totalPedido, 0) ?> <span class="text-xs font-normal text-gray-400">uds</span></p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <span class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Total Recibido</span>
        <p class="text-2xl font-bold text-green-600"><?= number_format($totalRecibido, 0) ?> <span class="text-xs font-normal text-gray-400">uds</span></p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <span class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Pendiente Global</span>
        <div class="flex items-center gap-2">
            <p class="text-2xl font-bold <?= $totalPendiente > 0 ? 'text-red-500' : 'text-green-600' ?>"><?= number_format($totalPendiente, 0) ?></p>
            <div class="flex-1">
                <div class="bg-gray-100 rounded-full h-2 overflow-hidden">
                    <div class="h-full rounded-full <?= $pctGlobal === 100 ? 'bg-green-500' : ($pctGlobal > 0 ? 'bg-amber-400' : 'bg-gray-300') ?>" style="width: <?= $pctGlobal ?>%"></div>
                </div>
                <span class="text-[9px] text-gray-400"><?= $pctGlobal ?>% completado</span>
            </div>
        </div>
    </div>
</div>

<!-- ═══ Tabla de Stock ═══ -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-sm font-semibold text-gray-800">Stock de Productos en Órdenes de Compra</h3>
        <span class="text-[10px] text-gray-400 font-medium"><?= count($productos) ?> productos</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">Código</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">Producto</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px]">U. Med</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Pedido</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Recibido</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Pendiente</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px]">Avance</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Costo Unit.</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px]">En # OC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (empty($productos)): ?>
                <tr><td colspan="9" class="px-4 py-8 text-center text-gray-400">No se encontraron productos con los filtros aplicados.</td></tr>
                <?php else: ?>
                <?php foreach ($productos as $prod): ?>
                <?php
                    $pedido = (float)$prod['total_pedido'];
                    $recib  = (float)$prod['total_recibido'];
                    $pend   = (float)$prod['total_pendiente'];
                    $pct    = $pedido > 0 ? round(($recib / $pedido) * 100) : 0;
                    $barColor = $pct === 100 ? 'bg-green-500' : ($pct > 0 ? 'bg-amber-400' : 'bg-gray-200');
                ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-2 font-mono text-gray-500"><?= htmlspecialchars($prod['cod_prod']) ?></td>
                    <td class="px-3 py-2">
                        <span class="font-medium text-gray-800 max-w-[200px] truncate block" title="<?= htmlspecialchars($prod['nom_prod']) ?>">
                            <?= htmlspecialchars($prod['nom_prod']) ?>
                        </span>
                    </td>
                    <td class="px-3 py-2 text-center text-gray-500"><?= htmlspecialchars($prod['unid_med']) ?></td>
                    <td class="px-3 py-2 text-right font-semibold text-gray-800"><?= number_format($pedido, 2) ?></td>
                    <td class="px-3 py-2 text-right font-semibold <?= $recib > 0 ? 'text-green-600' : 'text-gray-400' ?>"><?= number_format($recib, 2) ?></td>
                    <td class="px-3 py-2 text-right font-semibold <?= $pend > 0 ? 'text-red-500' : 'text-green-600' ?>"><?= number_format($pend, 2) ?></td>
                    <td class="px-3 py-2">
                        <div class="flex items-center gap-1.5">
                            <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="h-full rounded-full <?= $barColor ?>" style="width: <?= $pct ?>%"></div>
                            </div>
                            <span class="text-[10px] font-semibold text-gray-500 w-8 text-right"><?= $pct ?>%</span>
                        </div>
                    </td>
                    <td class="px-3 py-2 text-right text-gray-600">L. <?= number_format($prod['cost_unit'], 2) ?></td>
                    <td class="px-3 py-2 text-center">
                        <span class="inline-flex text-[10px] font-semibold px-1.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700"><?= $prod['en_ordenes'] ?></span>
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
