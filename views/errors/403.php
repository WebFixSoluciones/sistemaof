<?php ob_start(); ?>
<div class="flex flex-col items-center justify-center h-full text-center py-20">
    <p class="text-6xl font-black text-red-200 mb-4">403</p>
    <h2 class="text-2xl font-bold text-gray-700 mb-2">Acceso denegado</h2>
    <p class="text-gray-400 mb-8">No tienes permiso para acceder a este módulo con tu rol actual.</p>
    <a href="<?= BASE_URL ?>/dashboard" class="btn-primary px-6 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primaryHover">
        Volver al Dashboard
    </a>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>
