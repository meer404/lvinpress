<?php
/**
 * Admin Ads Management - Tailwind CSS Redesign
 */
$pageTitle = $t('ads') ?? 'Ads Management';
ob_start();
?>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('all_ads') ?? 'All Ads' ?></h3>
        <button onclick="document.getElementById('adModal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-gold text-white text-sm font-medium rounded-lg hover:bg-brand-gold-dark transition shadow-sm">
            <i class="fas fa-plus text-xs"></i> <?= $t('add_new') ?>
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('title') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('position') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('status') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('actions') ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                <?php if (!empty($ads)): ?>
                    <?php foreach ($ads as $ad): ?>
                    <tr class="hover:bg-stone-50/50 transition group">
                        <td class="px-5 py-3 font-medium text-stone-700"><?= htmlspecialchars($ad->title ?? '') ?></td>
                        <td class="px-5 py-3">
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium bg-stone-100 text-stone-600"><?= ucfirst($ad->position ?? 'sidebar') ?></span>
                        </td>
                        <td class="px-5 py-3">
                            <?php $aColor = ($ad->is_active ?? 0) ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'; ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium <?= $aColor ?>"><?= ($ad->is_active ?? 0) ? $t('active') : $t('inactive') ?></span>
                        </td>
                        <td class="px-5 py-3">
                            <a href="<?= url('admin/ads/delete/' . $ad->id) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-red-400 hover:text-red-500 hover:bg-red-50 transition opacity-0 group-hover:opacity-100"
                               onclick="return confirm('<?= $t('confirm_delete') ?>')">
                                <i class="fas fa-trash text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="4" class="text-center text-stone-400 py-12"><?= $t('no_ads') ?? 'No ads found' ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Ad Modal -->
<div id="adModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full">
        <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
            <h3 class="font-semibold text-stone-800"><?= $t('add_ad') ?? 'Add Advertisement' ?></h3>
            <button onclick="document.getElementById('adModal').classList.add('hidden')" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-stone-100 transition">
                <i class="fas fa-times text-stone-400"></i>
            </button>
        </div>
        <form method="POST" action="<?= url('admin/ads/store') ?>" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('title') ?></label>
                <input type="text" name="title" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('position') ?></label>
                <select name="position" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    <option value="header">Header</option>
                    <option value="sidebar">Sidebar</option>
                    <option value="article">In Article</option>
                    <option value="footer">Footer</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('ad_code') ?? 'Ad Code' ?></label>
                <textarea name="code" rows="4" placeholder="HTML/JavaScript code" dir="ltr" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold resize-y"></textarea>
            </div>
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-stone-300 text-brand-gold focus:ring-brand-gold/30">
                <span class="text-sm text-stone-700"><?= $t('active') ?></span>
            </label>
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('adModal').classList.add('hidden')" class="px-4 py-2 border border-stone-200 text-stone-600 font-medium rounded-xl hover:bg-stone-50 transition text-sm"><?= $t('cancel') ?></button>
                <button type="submit" class="px-6 py-2 bg-brand-gold text-white font-semibold rounded-xl hover:bg-brand-gold-dark transition shadow-sm text-sm"><?= $t('save') ?></button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
