<?php
/**
 * Admin Newsletter Management
 */
$pageTitle = $t('newsletter') ?? 'Newsletter';
ob_start();
?>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><?= $t('subscribers') ?? 'Subscribers' ?> (<?= count($subscribers ?? []) ?>)</h3>
    </div>
    <div class="admin-card__body" style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><?= $t('email') ?></th>
                    <th><?= $t('status') ?></th>
                    <th><?= $t('subscribed_at') ?? 'Subscribed' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($subscribers)): ?>
                    <?php foreach ($subscribers as $sub): ?>
                    <tr>
                        <td><?= htmlspecialchars($sub->email ?? '') ?></td>
                        <td>
                            <span class="badge badge-<?= ($sub->is_active ?? 1) ? 'success' : 'warning' ?>">
                                <?= ($sub->is_active ?? 1) ? $t('active') : $t('unsubscribed') ?>
                            </span>
                        </td>
                        <td class="text-sm text-muted"><?= date('Y-m-d H:i', strtotime($sub->created_at ?? 'now')) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="3" class="text-center text-muted" style="padding:2rem;"><?= $t('no_subscribers') ?? 'No subscribers yet' ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
