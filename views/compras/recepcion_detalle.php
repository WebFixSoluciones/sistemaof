<?php ob_start(); ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Recepción de Materiales</h2>
        <p class="text-sm text-gray-500">Inspección física contra Orden de Compra: <span class="font-bold text-primary"><?= htmlspecialchars($orden['cod_ocompra']) ?></span></p>
    </div>
    <a href="<?= BASE_URL ?>/compras/recepcion" class="text-sm text-gray-600 hover:text-gray-900 bg-gray-100 px-4 py-2 rounded-lg transition-colors">
        &larr; Volver
    </a>
</div>

<div class="bg-surface shadow-sm rounded-xl border border-gray-100 mb-8 p-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Proyecto</p>
            <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($orden['NOM_PROY'] ?? $orden['cod_proy']) ?></p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Proveedor</p>
            <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($orden['nom_prov'] ?? 'N/A') ?></p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Fecha Emisión</p>
            <p class="text-sm font-medium text-gray-800"><?= $orden['fecha_orden'] ?></p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Estatus Actual</p>
            <p class="text-sm font-bold text-orange-600"><?= strtoupper($orden['estatus_orden']) ?></p>
        </div>
    </div>
</div>

<form action="<?= BASE_URL ?>/compras/procesar-recepcion" method="POST">
    <input type="hidden" name="id_ocompra" value="<?= $orden['id_ocompra'] ?>">

    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Ítems a Validar</h3>
            <span class="text-xs text-gray-500">Solo ingrese cantidad en lo que recibió hoy.</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción del Material</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Unidad</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Solicitado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ya Recibido</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase text-red-600">Falta</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-primary uppercase bg-indigo-50/50">Recibido HOY</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php 
                    $todosCompletos = true;
                    foreach ($detalles as $item): 
                        $pend_recib = $item['pend_recib'] !== null ? (float)$item['pend_recib'] : (float)$item['cant_item'];
                        $cant_recib = $item['cant_recib'] !== null ? (float)$item['cant_recib'] : 0;
                        if ($pend_recib > 0) $todosCompletos = false;
                    ?>
                    <tr class="<?= $pend_recib <= 0 ? 'bg-green-50/30 opacity-60' : '' ?>">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($item['descrip_item']) ?>
                            <?php if ($pend_recib <= 0): ?>
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    Completo
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            <?= htmlspecialchars($item['umed_item']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">
                            <?= (float)$item['cant_item'] ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            <?= $cant_recib ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 text-center">
                            <?= $pend_recib ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center bg-indigo-50/20">
                            <?php if ($pend_recib > 0): ?>
                                <input type="number" 
                                       name="cant_entrega[<?= $item['corre_item'] ?>]" 
                                       min="0" 
                                       max="<?= $pend_recib ?>" 
                                       step="0.01"
                                       class="w-24 px-3 py-1.5 border border-gray-300 rounded text-center focus:ring-primary focus:border-primary sm:text-sm"
                                       placeholder="0">
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (!$todosCompletos): ?>
    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between bg-surface shadow-sm rounded-xl border border-gray-100 p-6">
        <div class="w-full sm:w-1/2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Notas / Observaciones de Entrega</label>
            <input type="text" name="observaciones" placeholder="Ej. El material llegó húmedo, la caja 2 rota..." 
                   class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
        </div>
        <div class="w-full sm:w-auto mt-4 sm:mt-0">
            <button type="submit" class="w-full btn-primary flex justify-center py-3 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary hover:bg-primaryHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Confirmar Recepción Seleccionada
            </button>
        </div>
    </div>
    <?php else: ?>
    <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
        <h3 class="text-lg font-bold text-green-800">¡Orden Completada!</h3>
        <p class="text-sm text-green-600 mt-1">Todos los ítems de esta Orden de Compra han sido recibidos satisfactoriamente en el proyecto.</p>
    </div>
    <?php endif; ?>
</form>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
