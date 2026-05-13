<?php ob_start(); ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Inventario y Stock en Proyectos</h2>
    <p class="text-sm text-gray-500">Consulta de materiales recibidos y disponibles en cada frente de obra.</p>
</div>

<!-- Filtros de búsqueda rápida -->
<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="flex-1 w-full">
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Buscar Material</label>
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Ej. Cemento, Canaleta, Pintura..."
                   class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>
    <div class="w-full md:w-64">
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Proyecto</label>
        <select id="projectFilter" class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
            <option value="">Todos los Proyectos</option>
            <?php 
                $proyectos = [];
                foreach ($stock as $item) {
                    $proyectos[$item['COD_PROY']] = $item['NOM_PROY'];
                }
                foreach ($proyectos as $cod => $nom): 
            ?>
                <option value="<?= htmlspecialchars($cod) ?>"><?= htmlspecialchars($nom) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto / Material</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Recibido</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-primary uppercase tracking-wider">Stock Actual</th>
                </tr>
            </thead>
            <tbody id="stockTable" class="bg-white divide-y divide-gray-100">
                <?php if (empty($stock)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">No hay registros de inventario.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($stock as $item): ?>
                    <tr class="stock-row hover:bg-gray-50 transition-colors" data-proyecto="<?= htmlspecialchars($item['COD_PROY']) ?>">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs font-bold text-gray-800 block"><?= htmlspecialchars($item['COD_PROY']) ?></span>
                            <span class="text-[10px] text-gray-500 truncate max-w-[150px] block" title="<?= htmlspecialchars($item['NOM_PROY']) ?>">
                                <?= htmlspecialchars($item['NOM_PROY']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium product-name">
                            <?= htmlspecialchars($item['descrip_item']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            <?= htmlspecialchars($item['umed_item']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                            <?= number_format((float)$item['total_recibido'], 2) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <?php 
                                $stock_act = (float)$item['stock_actual'];
                                $colorClass = $stock_act > 0 ? 'text-green-700 bg-green-50 border-green-200' : 'text-orange-700 bg-orange-50 border-orange-200';
                            ?>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-bold border <?= $colorClass ?>">
                                <?= number_format($stock_act, 2) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Filtros JS simples para el inventario
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const projectFilter = document.getElementById('projectFilter');
        const rows = document.querySelectorAll('.stock-row');

        function filterTable() {
            const term = searchInput.value.toLowerCase();
            const project = projectFilter.value;

            rows.forEach(row => {
                const productName = row.querySelector('.product-name').textContent.toLowerCase();
                const rowProject = row.getAttribute('data-proyecto');
                
                const matchesSearch = productName.includes(term);
                const matchesProject = project === '' || rowProject === project;

                if (matchesSearch && matchesProject) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);
        projectFilter.addEventListener('change', filterTable);
    });
</script>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>
