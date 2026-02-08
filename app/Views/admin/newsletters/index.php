<?php
/**
 * Admin Newsletter - Tailwind CSS Redesign
 */
$pageTitle = $t('newsletter') ?? 'Newsletter';
ob_start();
?>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('subscribers') ?? 'Subscribers' ?> <span class="text-stone-400 font-normal">(<?= count($subscribers ?? []) ?>)</span></h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('email') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('status') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('subscribed_at') ?? 'Subscribed' ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                <?php if (!empty($subscribers)): ?>
                    <?php foreach ($subscribers as $sub): ?>
                    <tr class="hover:bg-stone-50/50 transition">
                        <td class="px-5 py-3 text-stone-700"><?= htmlspecialchars($sub->email ?? '') ?></td>
                        <td class="px-5 py-3">
                            <?php $sColor = ($sub->is_active ?? 1) ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'; ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium <?= $sColor ?>">
                                <?= ($sub->is_active ?? 1) ? $t('active') : $t('unsubscribed') ?>
                            </span>
                        </td>
                        <td class="px-5 py-3 text-stone-400 text-xs"><?= date('Y-m-d H:i', strtotime($sub->created_at ?? 'now')) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="3" class="text-center text-stone-400 py-12"><?= $t('no_subscribers') ?? 'No subscribers yet' ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
