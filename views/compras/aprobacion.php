<?php ob_start(); ?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Bandeja de Aprobaciones</h2>
    <p class="text-sm text-gray-500">Revisión y autorización de Órdenes de Compra (Exclusivo Gerencia/Finanzas).</p>
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orden</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($ordenes)): ?>
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay órdenes pendientes.</td></tr>
                <?php else: ?>
                    <?php foreach ($ordenes as $oc): ?>
                    <tr class="<?= $oc['estatus_aprob'] === 'No' ? 'bg-yellow-50/30' : '' ?>">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($oc['cod_ocompra']) ?>
                            <br><span class="text-xs text-gray-400"><?= $oc['fecha_orden'] ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($oc['NOM_PROY'] ?? $oc['cod_proy']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($oc['nom_prov'] ?? 'N/A') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                            L. <?= number_format($oc['cost_total'], 2) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($oc['estatus_aprob'] === 'No'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Requiere Aprobación
                                </span>
                            <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aprobada
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <?php if ($oc['estatus_aprob'] === 'No'): ?>
                                <form action="<?= BASE_URL ?>/compras/aprobar" method="POST" class="inline">
                                    <input type="hidden" name="id_ocompra" value="<?= $oc['id_ocompra'] ?>">
                                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded text-xs transition-colors">
                                        ✓ Aprobar
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">Autorizado</span>
                            <?php endif; ?>
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
