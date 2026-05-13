<?php ob_start(); ?>

<!-- ═══ Breadcrumb ═══ -->
<div class="flex items-center gap-2 mb-5 text-xs text-gray-400">
    <a href="<?= BASE_URL ?>/compras" class="hover:text-gray-600">← Control de OC</a>
    <span>/</span>
    <span class="font-semibold text-gray-700"><?= htmlspecialchars($orden['cod_ocompra']) ?></span>
</div>

<!-- ═══ Cabecera OC ═══ -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-5">
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-1">
                <?= htmlspecialchars($orden['cod_ocompra']) ?>
                <?php
                    $badgeColor = match($orden['estatus_orden']) {
                        'Aprobada' => 'bg-green-50 text-green-700 border-green-200',
                        'Anticipo' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'Cancelada' => 'bg-red-50 text-red-700 border-red-200',
                        default => 'bg-gray-100 text-gray-600 border-gray-200',
                    };
                ?>
                <span class="ml-2 inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full border <?= $badgeColor ?>"><?= $orden['estatus_orden'] ?></span>
                <?php if ($orden['estatus_aprob'] === 'Si'): ?>
                    <span class="ml-1 inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">Aprobada</span>
                <?php else: ?>
                    <span class="ml-1 inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">Sin Aprobar</span>
                <?php endif; ?>
            </h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($orden['nom_prov'] ?? '—') ?></p>
        </div>
        <div class="flex gap-2">
            <?php if ($orden['estatus_aprob'] === 'Si'): ?>
            <a href="<?= BASE_URL ?>/compras/recibir?id=<?= $orden['id_ocompra'] ?>" 
               class="text-xs font-medium px-3 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                📦 Registrar Recepción
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-5 pt-4 border-t border-gray-100">
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Proyecto</span>
            <span class="text-sm font-medium text-gray-800"><?= htmlspecialchars($orden['cod_proyecto'] ?? $orden['cod_proy']) ?></span>
            <p class="text-[10px] text-gray-500"><?= htmlspecialchars($orden['NOM_PROY'] ?? '') ?></p>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Fecha Orden</span>
            <span class="text-sm font-medium text-gray-800"><?= $orden['fecha_orden'] ?></span>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Ingeniero</span>
            <span class="text-sm font-medium text-gray-800"><?= htmlspecialchars($orden['NOM_INGE'] ?? '—') ?></span>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Total OC</span>
            <span class="text-lg font-bold text-gray-900">L. <?= number_format($orden['cost_total'], 2) ?></span>
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Forma de Pago</span>
            <span class="text-sm text-gray-700"><?= $orden['forma_pago'] ?? '—' ?></span>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Empresa</span>
            <span class="text-sm text-gray-700"><?= htmlspecialchars($orden['nom_empresa'] ?? '—') ?></span>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Aprobado Por</span>
            <span class="text-sm text-gray-700"><?= htmlspecialchars($orden['nom_aprob'] ?? '—') ?></span>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Fecha Aprobación</span>
            <span class="text-sm text-gray-700"><?= $orden['fecha_aprob'] ?? '—' ?></span>
        </div>
    </div>
</div>

<!-- ═══ Tabla de Ítems / Productos ═══ -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-5">
    <div class="px-4 py-3 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-800">Detalle de Productos / Materiales</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">#</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">Producto</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px]">U. Med</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Pedido</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Recibido</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Pendiente</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Costo Unit.</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Total</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px]">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $i = 1; foreach ($detalles as $item): ?>
                <?php
                    $recibido = (float)($item['cant_recib'] ?? 0);
                    $pedido   = (float)$item['cant_item'];
                    $pendiente = $pedido - $recibido;
                    $pct = $pedido > 0 ? round(($recibido / $pedido) * 100) : 0;

                    $estadoColor = match($item['estatus_item']) {
                        'Completo' => 'bg-green-50 text-green-700 border-green-200',
                        'Anticipo' => 'bg-amber-50 text-amber-700 border-amber-200',
                        default => 'bg-gray-100 text-gray-600 border-gray-200',
                    };
                ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-2 text-gray-400 font-mono"><?= $i++ ?></td>
                    <td class="px-3 py-2">
                        <div class="font-medium text-gray-800 max-w-[250px] truncate" title="<?= htmlspecialchars($item['descrip_item']) ?>">
                            <?= htmlspecialchars($item['descrip_item']) ?>
                        </div>
                        <?php if (!empty($item['cod_prod'])): ?>
                        <div class="text-[10px] text-gray-400"><?= htmlspecialchars($item['cod_prod']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-3 py-2 text-center text-gray-500"><?= htmlspecialchars($item['umed_item']) ?></td>
                    <td class="px-3 py-2 text-right font-semibold text-gray-800"><?= number_format($pedido, 2) ?></td>
                    <td class="px-3 py-2 text-right">
                        <span class="font-semibold <?= $recibido > 0 ? 'text-green-600' : 'text-gray-400' ?>"><?= number_format($recibido, 2) ?></span>
                    </td>
                    <td class="px-3 py-2 text-right">
                        <span class="font-semibold <?= $pendiente > 0 ? 'text-red-500' : 'text-green-600' ?>"><?= number_format($pendiente, 2) ?></span>
                    </td>
                    <td class="px-3 py-2 text-right text-gray-600">L. <?= number_format($item['cost_unit'], 2) ?></td>
                    <td class="px-3 py-2 text-right font-semibold text-gray-800">L. <?= number_format($item['cost_total'], 2) ?></td>
                    <td class="px-3 py-2 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <span class="inline-flex text-[9px] font-semibold px-1.5 py-0.5 rounded-full border <?= $estadoColor ?>">
                                <?= $item['estatus_item'] ?>
                            </span>
                            <div class="w-12 bg-gray-100 rounded-full h-1 overflow-hidden">
                                <div class="h-full rounded-full <?= $pct === 100 ? 'bg-green-500' : ($pct > 0 ? 'bg-amber-400' : 'bg-gray-200') ?>" style="width: <?= $pct ?>%"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="bg-gray-50 border-t border-gray-200">
                <tr>
                    <td colspan="7" class="px-3 py-2 text-right font-bold text-gray-600 text-[11px] uppercase">Total OC:</td>
                    <td class="px-3 py-2 text-right font-bold text-gray-900 text-sm">L. <?= number_format($orden['cost_total'], 2) ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- ═══ Historial de Entregas ═══ -->
<?php if (!empty($historial)): ?>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-800">Historial de Entregas / Recepciones</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">Entrega #</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">Fecha</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">Recibió</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">Producto</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Cant. Entregada</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Quedó Pend.</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($historial as $h): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 font-mono text-gray-600">#<?= $h['id_oentrega'] ?></td>
                    <td class="px-3 py-2 text-gray-700"><?= $h['fecha_oentrega'] ?></td>
                    <td class="px-3 py-2 text-gray-700"><?= htmlspecialchars($h['NOM_INGE'] ?? '—') ?></td>
                    <td class="px-3 py-2 text-gray-700 max-w-[200px] truncate"><?= htmlspecialchars($h['descrip_item'] ?? '—') ?></td>
                    <td class="px-3 py-2 text-right font-semibold text-green-600"><?= number_format($h['cant_entrega'], 2) ?></td>
                    <td class="px-3 py-2 text-right font-semibold <?= $h['pend_entrega'] > 0 ? 'text-red-500' : 'text-green-600' ?>">
                        <?= number_format($h['pend_entrega'], 2) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="bg-gray-50 rounded-xl border border-gray-100 p-6 text-center">
    <p class="text-sm text-gray-400">No se han registrado entregas para esta orden.</p>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
