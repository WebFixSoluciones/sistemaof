<?php ob_start(); ?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Material en Tránsito</h2>
    <p class="text-sm text-gray-500">Bandeja de Recepción de Entregas en Sitio (Exclusivo Ingenieros Residentes).</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($ordenes)): ?>
        <div class="col-span-full bg-gray-50 rounded-lg p-8 text-center text-gray-500 border border-dashed border-gray-300">
            No hay camiones en ruta ni entregas pendientes para su proyecto actual.
        </div>
    <?php else: ?>
        <?php foreach ($ordenes as $oc): ?>
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow flex flex-col">
            <div class="p-5 flex-1">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-primary"><?= htmlspecialchars($oc['cod_ocompra']) ?></h3>
                        <p class="text-xs text-gray-500">Emitida: <?= $oc['fecha_orden'] ?></p>
                    </div>
                    <?php if ($oc['estatus_orden'] === 'Anticipo'): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 border border-blue-200">
                            Recepción Parcial
                        </span>
                    <?php else: ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-md bg-orange-50 text-orange-700 border border-orange-200">
                            En Tránsito
                        </span>
                    <?php endif; ?>
                </div>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-800 font-medium line-clamp-1">Proyecto: <?= htmlspecialchars($oc['NOM_PROY'] ?? $oc['cod_proy']) ?></p>
                    <p class="text-sm text-gray-500 line-clamp-1">Prov: <?= htmlspecialchars($oc['nom_prov'] ?? 'N/A') ?></p>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Progreso Estimado</p>
                    <!-- Barra visual de ejemplo -->
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-primary h-2.5 rounded-full" style="width: <?= $oc['estatus_orden'] === 'Anticipo' ? '50%' : '5%' ?>"></div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-4 border-t border-gray-100 rounded-b-xl">
                <a href="<?= BASE_URL ?>/compras/recibir?id=<?= $oc['id_ocompra'] ?>" class="block w-full text-center text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 rounded-lg py-2 transition-colors">
                    Realizar Inspección y Recepción
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
