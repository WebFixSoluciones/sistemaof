<?php ob_start(); ?>

<div class="flex items-center gap-2 mb-5 text-xs text-gray-400">
    <a href="<?= BASE_URL ?>/compras" class="hover:text-gray-600">← Control de OC</a>
    <span>/</span>
    <a href="<?= BASE_URL ?>/compras/recepcion" class="hover:text-gray-600">Recepción</a>
    <span>/</span>
    <span class="font-semibold text-gray-700"><?= htmlspecialchars($orden['cod_ocompra']) ?></span>
</div>

<div class="mb-5">
    <h2 class="text-xl font-bold text-gray-900">Recepción de Materiales</h2>
    <p class="text-xs text-gray-500">Validación física contra OC: <span class="font-bold text-primary"><?= htmlspecialchars($orden['cod_ocompra']) ?></span> — <?= htmlspecialchars($orden['nom_prov'] ?? '') ?></p>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-5">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Proyecto</span>
            <span class="text-sm font-medium text-gray-800"><?= htmlspecialchars($orden['NOM_PROY'] ?? $orden['cod_proy']) ?></span>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Proveedor</span>
            <span class="text-sm font-medium text-gray-800"><?= htmlspecialchars($orden['nom_prov'] ?? 'N/A') ?></span>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Fecha Orden</span>
            <span class="text-sm font-medium text-gray-800"><?= $orden['fecha_orden'] ?></span>
        </div>
        <div>
            <span class="block text-[10px] font-bold uppercase text-gray-400">Estado</span>
            <span class="text-sm font-bold text-amber-600"><?= strtoupper($orden['estatus_orden']) ?></span>
        </div>
    </div>
</div>

<form action="<?= BASE_URL ?>/compras/procesar-recepcion" method="POST" id="formRecepcion">
    <input type="hidden" name="id_ocompra" value="<?= $orden['id_ocompra'] ?>">

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-5">
        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-sm font-semibold text-gray-800">Ítems a Validar</h3>
            <span class="text-[10px] text-gray-400">Solo ingrese cantidad en lo que recibió hoy.</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-xs">
                <thead class="bg-white">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px]">Material</th>
                        <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px]">U.Med</th>
                        <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Pedido</th>
                        <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px]">Recibido</th>
                        <th class="px-3 py-2 text-right font-semibold text-red-500 uppercase text-[10px]">Pendiente</th>
                        <th class="px-3 py-2 text-center font-semibold text-primary uppercase text-[10px] bg-indigo-50">Recibido HOY</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php 
                    $todosCompletos = true;
                    foreach ($detalles as $item): 
                        $pend_recib = $item['pend_recib'] !== null ? (float)$item['pend_recib'] : (float)$item['cant_item'];
                        $cant_recib = $item['cant_recib'] !== null ? (float)$item['cant_recib'] : 0;
                        if ($pend_recib > 0) $todosCompletos = false;
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors <?= $pend_recib <= 0 ? 'bg-green-50/30 opacity-60' : '' ?>">
                        <td class="px-3 py-2">
                            <div class="font-medium text-gray-800 max-w-[220px] truncate" title="<?= htmlspecialchars($item['descrip_item']) ?>">
                                <?= htmlspecialchars($item['descrip_item']) ?>
                            </div>
                            <?php if ($pend_recib <= 0): ?>
                                <span class="inline-flex text-[9px] font-semibold px-1.5 py-0.5 rounded-full bg-green-50 text-green-700 border border-green-200 mt-0.5">Completo</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2 text-center text-gray-500"><?= htmlspecialchars($item['umed_item']) ?></td>
                        <td class="px-3 py-2 text-right font-semibold text-gray-800"><?= (float)$item['cant_item'] ?></td>
                        <td class="px-3 py-2 text-right <?= $cant_recib > 0 ? 'text-green-600 font-semibold' : 'text-gray-400' ?>"><?= $cant_recib ?></td>
                        <td class="px-3 py-2 text-right font-bold <?= $pend_recib > 0 ? 'text-red-500' : 'text-green-600' ?>"><?= $pend_recib ?></td>
                        <td class="px-3 py-2 text-center bg-indigo-50/30">
                            <?php if ($pend_recib > 0): ?>
                                <input type="number" 
                                       name="cant_entrega[<?= $item['corre_item'] ?>]" 
                                       min="0" 
                                       max="<?= $pend_recib ?>" 
                                       step="0.01"
                                       class="w-20 px-2 py-1.5 border border-gray-200 rounded-lg text-center text-xs focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="0">
                            <?php else: ?>
                                <span class="text-gray-300">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (!$todosCompletos): ?>
    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="w-full sm:flex-1">
            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Observaciones (opcional)</label>
            <input type="text" name="observaciones" placeholder="Ej. Material llegó húmedo, caja 2 rota..." 
                   class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <button type="button" onclick="confirmarRecepcion()" 
                class="btn-primary px-6 py-2.5 bg-primary text-white font-semibold rounded-lg hover:bg-primaryHover text-xs whitespace-nowrap">
            Confirmar Recepción
        </button>
    </div>
    <?php else: ?>
    <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center">
        <h3 class="text-base font-bold text-green-800">¡Orden Completada!</h3>
        <p class="text-xs text-green-600 mt-1">Todos los ítems de esta OC han sido recibidos satisfactoriamente.</p>
    </div>
    <?php endif; ?>
</form>

<script>
function confirmarRecepcion() {
    Swal.fire({
        title: '¿Confirmar recepción?',
        text: 'Se registrarán las cantidades ingresadas. Esta operación actualiza el inventario de la OC.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6366f1',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formRecepcion').submit();
        }
    });
}
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
