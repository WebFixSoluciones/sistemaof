<?php ob_start(); ?>

<!-- KPI Cards -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-8">

    <!-- Proyectos Activos -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Proyectos</p>
            <div class="h-8 w-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                <svg class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?= (int)($kpiProyectos['activos'] ?? 0) ?></p>
        <p class="text-xs text-gray-400 mt-1">de <?= (int)($kpiProyectos['total'] ?? 0) ?> en total</p>
    </div>

    <!-- OC Pendientes de Aprobación -->
    <?php if (!empty($_SESSION['es_superadmin']) || isset($_SESSION['modulos_permitidos']['COMPRAS'])): ?>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">OC por Aprobar</p>
            <div class="h-8 w-8 rounded-lg bg-yellow-50 flex items-center justify-center">
                <svg class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold <?= ($kpiComprasPendientes['total'] ?? 0) > 0 ? 'text-yellow-600' : 'text-gray-900' ?>">
            <?= (int)($kpiComprasPendientes['total'] ?? 0) ?>
        </p>
        <a href="<?= BASE_URL ?>/compras/aprobacion" class="text-xs text-primary hover:underline mt-1 inline-block">Ir a bandeja →</a>
    </div>
    <?php endif; ?>

    <!-- Material en Tránsito -->
    <?php if (!empty($_SESSION['es_superadmin']) || isset($_SESSION['modulos_permitidos']['ENTREGAS'])): ?>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Material en Tránsito</p>
            <div class="h-8 w-8 rounded-lg bg-orange-50 flex items-center justify-center">
                <svg class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-orange-500"><?= (int)($kpiMaterialEnTransito['total'] ?? 0) ?></p>
        <a href="<?= BASE_URL ?>/compras/recepcion" class="text-xs text-primary hover:underline mt-1 inline-block">Ir a recepción →</a>
    </div>
    <?php endif; ?>

</div>

<!-- Widgets de actividad reciente -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- OC Pendientes de Aprobación -->
    <?php if ((!empty($_SESSION['es_superadmin']) || isset($_SESSION['modulos_permitidos']['COMPRAS'])) && !empty($ocPendientes)): ?>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-800">🕐 OC Pendientes de Aprobación</h3>
            <a href="<?= BASE_URL ?>/compras/aprobacion" class="text-xs text-primary hover:underline">Ver todas</a>
        </div>
        <ul class="divide-y divide-gray-100">
            <?php foreach ($ocPendientes as $oc): ?>
            <li class="px-5 py-3 flex items-center justify-between hover:bg-gray-50">
                <div>
                    <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($oc['cod_ocompra']) ?></p>
                    <p class="text-xs text-gray-400"><?= htmlspecialchars($oc['NOM_PROY'] ?? $oc['cod_proy'] ?? '') ?> — <?= htmlspecialchars($oc['nom_prov'] ?? '') ?></p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-900">L. <?= number_format($oc['cost_total'], 0) ?></p>
                    <p class="text-xs text-yellow-600">Pendiente</p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Material en Tránsito -->
    <?php if ((!empty($_SESSION['es_superadmin']) || isset($_SESSION['modulos_permitidos']['ENTREGAS'])) && !empty($materialTransito)): ?>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-800">🚚 OCs Aprobadas en Ruta</h3>
            <a href="<?= BASE_URL ?>/compras/recepcion" class="text-xs text-primary hover:underline">Ver todas</a>
        </div>
        <ul class="divide-y divide-gray-100">
            <?php foreach ($materialTransito as $oc): ?>
            <li class="px-5 py-3 flex items-center justify-between hover:bg-gray-50">
                <div>
                    <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($oc['cod_ocompra']) ?></p>
                    <p class="text-xs text-gray-400"><?= htmlspecialchars($oc['NOM_PROY'] ?? '') ?> — <?= htmlspecialchars($oc['nom_prov'] ?? '') ?></p>
                </div>
                <span class="text-xs font-semibold px-2 py-1 rounded-full
                    <?= $oc['estatus_orden'] === 'Anticipo' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' ?>">
                    <?= $oc['estatus_orden'] ?>
                </span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Mensaje si no hay datos relevantes según el rol -->
    <?php if (empty($ocPendientes) && empty($materialTransito)): ?>
    <div class="lg:col-span-2 bg-gray-50 rounded-xl border border-dashed border-gray-200 p-10 text-center text-gray-400">
        <p class="text-3xl mb-2">✓</p>
        <p class="font-medium">Todo al día</p>
        <p class="text-sm mt-1">No hay órdenes pendientes ni material en tránsito en este momento.</p>
    </div>
    <?php endif; ?>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
