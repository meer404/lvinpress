<?php
/**
 * Admin Pages List
 */
$pageTitle = $t('pages') ?? 'Pages';
ob_start();
?>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><?= $t('all_pages') ?? 'All Pages' ?> (<?= count($pages ?? []) ?>)</h3>
        <a href="<?= url('admin/pages/create') ?>" class="btn btn-gold btn-sm">
            <i class="fas fa-plus"></i> <?= $t('add_new') ?>
        </a>
    </div>
    <div class="admin-card__body" style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><?= $t('title') ?></th>
                    <th><?= $t('slug') ?></th>
                    <th><?= $t('status') ?></th>
                    <th><?= $t('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $pg): ?>
                    <tr>
                        <td><?= htmlspecialchars($pg->{'title_' . $lang} ?? $pg->title_en ?? '') ?></td>
                        <td class="text-sm text-muted"><?= htmlspecialchars($pg->slug ?? '') ?></td>
                        <td>
                            <span class="badge badge-<?= ($pg->status ?? 'draft') === 'published' ? 'success' : 'warning' ?>">
                                <?= $t($pg->status ?? 'draft') ?>
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:0.25rem;">
                                <a href="<?= url('admin/pages/edit/' . $pg->id) ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
                                <a href="<?= lang_url('page/' . $pg->slug) ?>" class="btn btn-sm btn-outline" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="4" class="text-center text-muted" style="padding:2rem;"><?= $t('no_pages') ?? 'No pages found' ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
