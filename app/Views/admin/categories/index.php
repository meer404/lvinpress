<?php
/**
 * Admin Categories - Tailwind CSS Redesign
 */
$pageTitle = $t('categories');
ob_start();
?>

<div class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-6">
    <!-- Categories List -->
    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-stone-100">
            <h3 class="font-semibold text-stone-800"><?= $t('all_categories') ?></h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-stone-100">
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('color') ?></th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('name') ?> (KU)</th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('name') ?> (EN)</th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('name') ?> (AR)</th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('articles') ?></th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('order') ?></th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('actions') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                        <tr class="hover:bg-stone-50/50 transition group">
                            <td class="px-5 py-3"><span class="w-5 h-5 rounded-full inline-block shadow-sm" style="background:<?= $cat->color ?? '#d4af37' ?>"></span></td>
                            <td class="px-5 py-3 font-medium text-stone-700"><?= $cat->name_ku ?></td>
                            <td class="px-5 py-3 text-stone-500"><?= $cat->name_en ?></td>
                            <td class="px-5 py-3 text-stone-500"><?= $cat->name_ar ?></td>
                            <td class="px-5 py-3 text-stone-500"><?= $cat->article_count ?? 0 ?></td>
                            <td class="px-5 py-3 text-stone-400"><?= $cat->sort_order ?? 0 ?></td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                    <button onclick='editCategory(<?= htmlspecialchars(json_encode($cat)) ?>)' class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-brand-gold hover:text-brand-gold transition">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <a href="<?= url('admin/categories/delete/' . $cat->id) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-red-400 hover:text-red-500 hover:bg-red-50 transition"
                                       onclick="return confirm('<?= $t('confirm_delete') ?>')">
                                        <i class="fas fa-trash text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr><td colspan="7" class="text-center text-stone-400 py-12"><?= $t('no_categories') ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Form -->
    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden h-fit">
        <div class="px-5 py-4 border-b border-stone-100">
            <h3 class="font-semibold text-stone-800" id="catFormTitle"><?= $t('add_category') ?></h3>
        </div>
        <div class="p-5">
            <form method="POST" id="categoryForm" action="<?= url('admin/categories/store') ?>" class="space-y-4">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="catId" value="">
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('name') ?> (کوردی) <span class="text-red-500">*</span></label>
                    <input type="text" name="name_ku" id="catNameKu" required dir="rtl" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('name') ?> (English)</label>
                    <input type="text" name="name_en" id="catNameEn" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('name') ?> (العربية)</label>
                    <input type="text" name="name_ar" id="catNameAr" dir="rtl" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('slug') ?></label>
                    <input type="text" name="slug" id="catSlug" dir="ltr" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('description') ?> (کوردی)</label>
                    <textarea name="description_ku" id="catDescKu" rows="2" dir="rtl" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold resize-y"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('color') ?></label>
                        <input type="color" name="color" id="catColor" value="#d4af37" class="w-full h-10 rounded-xl border border-stone-200 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('order') ?></label>
                        <input type="number" name="sort_order" id="catOrder" value="0" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    </div>
                </div>
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" id="catActive" value="1" checked class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30">
                    <span class="text-sm text-stone-700"><?= $t('active') ?></span>
                </label>
                <button type="submit" class="w-full px-4 py-2.5 bg-brand-gold text-white font-semibold rounded-xl hover:bg-brand-gold-dark transition shadow-sm flex items-center justify-center gap-2">
                    <i class="fas fa-save text-sm"></i> <?= $t('save') ?>
                </button>
                <button type="button" id="cancelBtn" onclick="resetForm()" class="w-full px-4 py-2 border border-stone-200 text-stone-600 font-medium rounded-xl hover:bg-stone-50 transition hidden">
                    <?= $t('cancel') ?>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function editCategory(cat) {
    document.getElementById('catFormTitle').textContent = '<?= $t('edit_category') ?>';
    document.getElementById('categoryForm').action = '<?= url('admin/categories/update/') ?>' + cat.id;
    document.getElementById('catId').value = cat.id;
    document.getElementById('catNameKu').value = cat.name_ku || '';
    document.getElementById('catNameEn').value = cat.name_en || '';
    document.getElementById('catNameAr').value = cat.name_ar || '';
    document.getElementById('catSlug').value = cat.slug || '';
    document.getElementById('catDescKu').value = cat.description_ku || '';
    document.getElementById('catColor').value = cat.color || '#d4af37';
    document.getElementById('catOrder').value = cat.sort_order || 0;
    document.getElementById('catActive').checked = cat.is_active == 1;
    document.getElementById('cancelBtn').classList.remove('hidden');
}
function resetForm() {
    document.getElementById('catFormTitle').textContent = '<?= $t('add_category') ?>';
    document.getElementById('categoryForm').action = '<?= url('admin/categories/store') ?>';
    document.getElementById('categoryForm').reset();
    document.getElementById('catId').value = '';
    document.getElementById('cancelBtn').classList.add('hidden');
}
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
