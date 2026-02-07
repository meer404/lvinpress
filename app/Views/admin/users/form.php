<?php
/**
 * Admin User Create/Edit Form
 */
$isEdit = isset($user) && is_object($user);
$pageTitle = $isEdit ? $t('edit') . ' ' . ($user->username ?? '') : $t('add_new');
ob_start();
?>

<div style="max-width:700px;">
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><?= $pageTitle ?></h3>
            <a href="<?= url('admin/users') ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> <?= $t('back') ?? 'Back' ?></a>
        </div>
        <div class="admin-card__body">
            <form method="POST" action="<?= $isEdit ? url('admin/users/update/' . $user->id) : url('admin/users/store') ?>">
                <?= csrf_field() ?>
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label class="form-label"><?= $t('username') ?> *</label>
                        <input type="text" name="username" class="form-control" 
                               value="<?= htmlspecialchars($user->username ?? '') ?>" 
                               required pattern="[a-zA-Z0-9_]+" <?= $isEdit ? 'readonly' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('email') ?> *</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?= htmlspecialchars($user->email ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= $t('password') ?> <?= $isEdit ? '' : '*' ?></label>
                    <input type="password" name="password" class="form-control" 
                           minlength="6" <?= $isEdit ? '' : 'required' ?>>
                    <?php if ($isEdit): ?>
                    <small class="text-muted">Leave blank to keep current password</small>
                    <?php endif; ?>
                </div>

                <!-- Multilingual Names -->
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label class="form-label"><?= $t('full_name') ?> (کوردی)</label>
                        <input type="text" name="full_name_ku" class="form-control" dir="rtl"
                               value="<?= htmlspecialchars($user->full_name_ku ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('full_name') ?> (English)</label>
                        <input type="text" name="full_name_en" class="form-control" dir="ltr"
                               value="<?= htmlspecialchars($user->full_name_en ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= $t('full_name') ?> (العربية)</label>
                        <input type="text" name="full_name_ar" class="form-control" dir="rtl"
                               value="<?= htmlspecialchars($user->full_name_ar ?? '') ?>">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label class="form-label"><?= $t('role') ?></label>
                        <select name="role" class="form-control">
                            <option value="subscriber" <?= ($user->role ?? '') === 'subscriber' ? 'selected' : '' ?>>Subscriber</option>
                            <option value="writer" <?= ($user->role ?? '') === 'writer' ? 'selected' : '' ?>>Writer</option>
                            <option value="editor" <?= ($user->role ?? '') === 'editor' ? 'selected' : '' ?>>Editor</option>
                            <option value="admin" <?= ($user->role ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <?php if ($isEdit): ?>
                    <div class="form-group">
                        <label class="form-label"><?= $t('status') ?></label>
                        <select name="status" class="form-control">
                            <option value="active" <?= ($user->status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="suspended" <?= ($user->status ?? '') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                            <option value="banned" <?= ($user->status ?? '') === 'banned' ? 'selected' : '' ?>>Banned</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div style="display:flex;gap:0.5rem;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> <?= $t('save') ?></button>
                    <a href="<?= url('admin/users') ?>" class="btn btn-outline"><?= $t('cancel') ?? 'Cancel' ?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
