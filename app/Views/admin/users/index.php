<?php
/**
 * Admin Users List
 */
$pageTitle = $t('users');
ob_start();
?>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><?= $t('all_users') ?> (<?= count($users ?? []) ?>)</h3>
        <a href="<?= url('admin/users/create') ?>" class="btn btn-gold btn-sm">
            <i class="fas fa-plus"></i> <?= $t('add_new') ?>
        </a>
    </div>
    <div class="admin-card__body" style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><?= $t('avatar') ?></th>
                    <th><?= $t('name') ?></th>
                    <th><?= $t('email') ?></th>
                    <th><?= $t('role') ?></th>
                    <th><?= $t('status') ?></th>
                    <th><?= $t('joined') ?></th>
                    <th><?= $t('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div style="width:36px;height:36px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#1a1a2e;font-weight:600;">
                                <?= strtoupper(substr($user->{'full_name_' . $lang} ?? $user->username ?? 'U', 0, 1)) ?>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:500;"><?= $user->{'full_name_' . $lang} ?: $user->full_name_en ?: $user->username ?></div>
                            <div class="text-xs text-muted">@<?= $user->username ?></div>
                        </td>
                        <td class="text-sm"><?= $user->email ?></td>
                        <td>
                            <span class="badge badge-<?= $user->role === 'admin' ? 'success' : ($user->role === 'editor' ? 'info' : 'warning') ?>">
                                <?= ucfirst($user->role) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?= $user->status === 'active' ? 'success' : 'error' ?>">
                                <?= $user->status === 'active' ? $t('active') : $t('inactive') ?>
                            </span>
                        </td>
                        <td class="text-sm text-muted"><?= date('Y-m-d', strtotime($user->created_at)) ?></td>
                        <td>
                            <div style="display:flex;gap:0.25rem;">
                                <a href="<?= url('admin/users/edit/' . $user->id) ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
                                <?php if ($user->id != ($currentUser->id ?? 0)): ?>
                                <a href="<?= url('admin/users/delete/' . $user->id) ?>" class="btn btn-sm" style="background:#e74c3c;color:#fff;" 
                                   onclick="return confirm('<?= $t('confirm_delete') ?>')"><i class="fas fa-trash"></i></a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
