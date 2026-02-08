<?php
/**
 * Admin Articles List - Tailwind CSS Redesign
 */
$pageTitle = $t('articles');
ob_start();
?>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('all_articles') ?> <span class="text-stone-400 font-normal">(<?= $total ?? 0 ?>)</span></h3>
        <a href="<?= url('admin/articles/create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-gold text-white text-sm font-medium rounded-lg hover:bg-brand-gold-dark transition shadow-sm">
            <i class="fas fa-plus text-xs"></i> <?= $t('add_new') ?>
        </a>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-2 px-5 py-3 border-b border-stone-100 bg-stone-50/50">
        <?php
        $filters = [
            '' => $t('all'),
            'published' => $t('published'),
            'draft' => $t('draft'),
            'pending' => $t('pending'),
        ];
        foreach ($filters as $val => $label):
            $isActive = ($statusFilter ?? '') === $val;
        ?>
        <a href="<?= url('admin/articles' . ($val ? '?status=' . $val : '')) ?>"
           class="px-3 py-1.5 rounded-lg text-xs font-medium transition <?= $isActive ? 'bg-brand-gold text-white shadow-sm' : 'bg-white text-stone-600 border border-stone-200 hover:border-brand-gold hover:text-brand-gold' ?>">
            <?= $label ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="px-5 py-3 text-start w-10"><input type="checkbox" id="selectAll" class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30"></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('image') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('title') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('category') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('author') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('status') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('views') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('date') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('actions') ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $article): ?>
                    <tr class="hover:bg-stone-50/50 transition group">
                        <td class="px-5 py-3"><input type="checkbox" name="ids[]" value="<?= $article->id ?>" class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30"></td>
                        <td class="px-5 py-3">
                            <?php if ($article->featured_image): ?>
                            <img src="<?= upload_url($article->featured_image) ?>" alt="" class="w-14 h-10 object-cover rounded-lg">
                            <?php else: ?>
                            <div class="w-14 h-10 bg-stone-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-stone-300 text-xs"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3">
                            <a href="<?= url('admin/articles/edit/' . $article->id) ?>" class="font-medium text-stone-700 hover:text-brand-gold transition">
                                <?= excerpt($article->{'title_' . $lang} ?? $article->title_ku, 50) ?>
                            </a>
                            <?php if ($article->is_featured): ?>
                            <i class="fas fa-star text-brand-gold text-[0.6rem] ms-1" title="Featured"></i>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1.5 text-xs">
                                <span class="w-2 h-2 rounded-full" style="background:<?= $article->category_color ?? '#d4af37' ?>"></span>
                                <?= $article->category_name ?? '-' ?>
                            </span>
                        </td>
                        <td class="px-5 py-3 text-stone-500"><?= $article->author_name ?? '-' ?></td>
                        <td class="px-5 py-3">
                            <?php
                            $sColors = match($article->status) {
                                'published' => 'bg-emerald-50 text-emerald-700',
                                'draft' => 'bg-amber-50 text-amber-700',
                                default => 'bg-blue-50 text-blue-700'
                            };
                            ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium <?= $sColors ?>"><?= $t($article->status) ?></span>
                        </td>
                        <td class="px-5 py-3 text-stone-500"><?= number_format($article->views ?? 0) ?></td>
                        <td class="px-5 py-3 text-stone-400 text-xs"><?= date('Y-m-d', strtotime($article->created_at)) ?></td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                <a href="<?= url('admin/articles/edit/' . $article->id) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-brand-gold hover:text-brand-gold transition" title="<?= $t('edit') ?>">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="<?= url('admin/articles/delete/' . $article->id) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-red-400 hover:text-red-500 hover:bg-red-50 transition"
                                   onclick="return confirm('<?= $t('confirm_delete') ?>')" title="<?= $t('delete') ?>">
                                    <i class="fas fa-trash text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="9" class="text-center text-stone-400 py-12"><?= $t('no_articles') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (($totalPages ?? 1) > 1): ?>
    <div class="flex justify-center px-5 py-4 border-t border-stone-100">
        <div class="flex items-center gap-1">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= url('admin/articles?page=' . $i . ($statusFilter ? '&status=' . $statusFilter : '')) ?>"
               class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-medium transition <?= $i == ($currentPage ?? 1) ? 'bg-brand-gold text-white shadow-sm' : 'text-stone-500 hover:bg-stone-100' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('input[name="ids[]"]').forEach(cb => cb.checked = this.checked);
});
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
