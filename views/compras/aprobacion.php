<?php ob_start(); ?>

<div class="flex items-center gap-2 mb-5 text-xs text-gray-400">
    <a href="<?= BASE_URL ?>/compras" class="hover:text-gray-600">← Control de OC</a>
    <span>/</span>
    <span class="font-semibold text-gray-700">Aprobaciones</span>
</div>

<div class="mb-5">
    <h2 class="text-xl font-bold text-gray-900">Bandeja de Aprobaciones</h2>
    <p class="text-xs text-gray-500">Revisión y autorización de Órdenes de Compra.</p>
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Orden</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Proyecto</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Proveedor</th>
                    <th class="px-3 py-2 text-right font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Total</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Estatus</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <?php if (empty($ordenes)): ?>
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No hay órdenes registradas.</td></tr>
                <?php else: ?>
                    <?php foreach ($ordenes as $oc): ?>
                    <tr class="hover:bg-gray-50 transition-colors <?= $oc['estatus_aprob'] === 'No' ? 'bg-amber-50/30' : '' ?>">
                        <td class="px-3 py-2.5">
                            <div class="font-semibold text-gray-800"><?= htmlspecialchars($oc['cod_ocompra']) ?></div>
                            <div class="text-[10px] text-gray-400"><?= $oc['fecha_orden'] ?></div>
                        </td>
                        <td class="px-3 py-2.5 text-gray-700">
                            <?= htmlspecialchars($oc['cod_proy']) ?>
                        </td>
                        <td class="px-3 py-2.5 text-gray-700 max-w-[180px] truncate">
                            <?= htmlspecialchars($oc['nom_prov'] ?? 'N/A') ?>
                        </td>
                        <td class="px-3 py-2.5 text-right font-bold text-gray-800">
                            L. <?= number_format($oc['cost_total'], 2) ?>
                        </td>
                        <td class="px-3 py-2.5 text-center">
                            <?php if ($oc['estatus_aprob'] === 'No'): ?>
                                <span class="inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                    Requiere Aprobación
                                </span>
                            <?php else: ?>
                                <span class="inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full bg-green-50 text-green-700 border border-green-200">
                                    Aprobada
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2.5 text-center">
                            <?php if ($oc['estatus_aprob'] === 'No' && !empty($puedeAprobar)): ?>
                                <form action="<?= BASE_URL ?>/compras/aprobar" method="POST" class="inline form-aprobar">
                                    <input type="hidden" name="id_ocompra" value="<?= $oc['id_ocompra'] ?>">
                                    <input type="hidden" name="cod_oc" value="<?= htmlspecialchars($oc['cod_ocompra']) ?>">
                                    <button type="button" onclick="confirmarAprobacion(this)"
                                            class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-[11px] font-medium transition-colors shadow-sm shadow-green-200">
                                        ✓ Aprobar
                                    </button>
                                </form>
                            <?php elseif ($oc['estatus_aprob'] === 'Si'): ?>
                                <a href="<?= BASE_URL ?>/compras/detalle?id=<?= $oc['id_ocompra'] ?>" class="text-[10px] font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg hover:bg-indigo-100">Ver</a>
                            <?php else: ?>
                                <span class="text-gray-400 text-[10px]">Sin permiso</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmarAprobacion(btn) {
    const form = btn.closest('form');
    const cod = form.querySelector('[name="cod_oc"]').value;
    
    Swal.fire({
        title: '¿Aprobar esta orden?',
        html: `Estás a punto de aprobar la orden <strong>${cod}</strong>.<br>Esta acción no se puede deshacer.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
