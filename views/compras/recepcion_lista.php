<?php ob_start(); ?>

<div class="flex items-center gap-2 mb-5 text-xs text-gray-400">
    <a href="<?= BASE_URL ?>/compras" class="hover:text-gray-600">← Control de OC</a>
    <span>/</span>
    <span class="font-semibold text-gray-700">Recepción en Campo</span>
</div>

<div class="mb-5">
    <h2 class="text-xl font-bold text-gray-900">Recepción de Material en Campo</h2>
    <p class="text-xs text-gray-500">OC aprobadas con entregas pendientes. Seleccione una para registrar recepción.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if (empty($ordenes)): ?>
        <div class="col-span-full bg-gray-50 rounded-xl p-8 text-center text-gray-400 border border-dashed border-gray-200">
            No hay entregas pendientes.
        </div>
    <?php else: ?>
        <?php foreach ($ordenes as $oc): ?>
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow flex flex-col">
            <div class="p-4 flex-1">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-base font-bold text-primary"><?= htmlspecialchars($oc['cod_ocompra']) ?></h3>
                        <p class="text-[10px] text-gray-400"><?= $oc['fecha_orden'] ?></p>
                    </div>
                    <?php if ($oc['estatus_orden'] === 'Anticipo'): ?>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">Parcial</span>
                    <?php else: ?>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">En Tránsito</span>
                    <?php endif; ?>
                </div>
                
                <div class="space-y-1 text-xs mb-3">
                    <p class="text-gray-700"><span class="font-semibold">Proyecto:</span> <?= htmlspecialchars($oc['cod_proy']) ?></p>
                    <p class="text-gray-500 truncate" title="<?= htmlspecialchars($oc['nom_prov'] ?? '') ?>"><?= htmlspecialchars($oc['nom_prov'] ?? 'N/A') ?></p>
                </div>

                <div class="pt-3 border-t border-gray-100">
                    <p class="text-[10px] font-bold uppercase text-gray-400 mb-1.5">Progreso</p>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-primary h-1.5 rounded-full" style="width: <?= $oc['estatus_orden'] === 'Anticipo' ? '50%' : '5%' ?>"></div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-3 border-t border-gray-100 rounded-b-xl">
                <a href="<?= BASE_URL ?>/compras/recibir?id=<?= $oc['id_ocompra'] ?>" 
                   class="block w-full text-center text-xs font-semibold text-white bg-gray-800 hover:bg-gray-700 rounded-lg py-2 transition-colors">
                    📦 Inspección y Recepción
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
