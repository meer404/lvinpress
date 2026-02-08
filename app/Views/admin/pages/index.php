<?php
/**
 * Admin Pages List - Tailwind CSS Redesign
 */
$pageTitle = $t('pages') ?? 'Pages';
ob_start();
?>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('all_pages') ?? 'All Pages' ?> <span class="text-stone-400 font-normal">(<?= count($pages ?? []) ?>)</span></h3>
        <a href="<?= url('admin/pages/create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-gold text-white text-sm font-medium rounded-lg hover:bg-brand-gold-dark transition shadow-sm">
            <i class="fas fa-plus text-xs"></i> <?= $t('add_new') ?>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('title') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('slug') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('status') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('actions') ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $pg): ?>
                    <tr class="hover:bg-stone-50/50 transition group">
                        <td class="px-5 py-3 font-medium text-stone-700"><?= htmlspecialchars($pg->{'title_' . $lang} ?? $pg->title_en ?? '') ?></td>
                        <td class="px-5 py-3 text-stone-400 font-mono text-xs"><?= htmlspecialchars($pg->slug ?? '') ?></td>
                        <td class="px-5 py-3">
                            <?php $sColor = ($pg->status ?? 'draft') === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'; ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium <?= $sColor ?>"><?= $t($pg->status ?? 'draft') ?></span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                <a href="<?= url('admin/pages/edit/' . $pg->id) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-brand-gold hover:text-brand-gold transition">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="<?= lang_url('page/' . $pg->slug) ?>" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-blue-400 hover:text-blue-500 transition">
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="4" class="text-center text-stone-400 py-12"><?= $t('no_pages') ?? 'No pages found' ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
