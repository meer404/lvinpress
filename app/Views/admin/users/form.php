<?php
/**
 * Admin User Form - Tailwind CSS Redesign
 */
$isEdit = isset($user) && is_object($user);
$pageTitle = $isEdit ? $t('edit') . ' ' . ($user->username ?? '') : $t('add_new');
ob_start();
?>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
            <h3 class="font-semibold text-stone-800"><?= $pageTitle ?></h3>
            <a href="<?= url('admin/users') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-stone-200 text-stone-600 text-xs font-medium rounded-lg hover:border-brand-gold hover:text-brand-gold transition">
                <i class="fas fa-arrow-left text-[0.6rem]"></i> <?= $t('back') ?? 'Back' ?>
            </a>
        </div>
        <div class="p-5">
            <form method="POST" action="<?= $isEdit ? url('admin/users/update/' . $user->id) : url('admin/users/store') ?>" class="space-y-4">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('username') ?> *</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($user->username ?? '') ?>"
                               required pattern="[a-zA-Z0-9_]+" <?= $isEdit ? 'readonly' : '' ?>
                               class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold <?= $isEdit ? 'bg-stone-50 text-stone-400' : '' ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('email') ?> *</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user->email ?? '') ?>" required
                               class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('password') ?> <?= $isEdit ? '' : '*' ?></label>
                    <input type="password" name="password" minlength="6" <?= $isEdit ? '' : 'required' ?>
                           class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    <?php if ($isEdit): ?>
                    <p class="text-xs text-stone-400 mt-1">Leave blank to keep current password</p>
                    <?php endif; ?>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('full_name') ?> (کوردی)</label>
                        <input type="text" name="full_name_ku" dir="rtl" value="<?= htmlspecialchars($user->full_name_ku ?? '') ?>"
                               class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('full_name') ?> (English)</label>
                        <input type="text" name="full_name_en" dir="ltr" value="<?= htmlspecialchars($user->full_name_en ?? '') ?>"
                               class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('full_name') ?> (العربية)</label>
                        <input type="text" name="full_name_ar" dir="rtl" value="<?= htmlspecialchars($user->full_name_ar ?? '') ?>"
                               class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('role') ?></label>
                        <select name="role" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                            <option value="subscriber" <?= ($user->role ?? '') === 'subscriber' ? 'selected' : '' ?>>Subscriber</option>
                            <option value="writer" <?= ($user->role ?? '') === 'writer' ? 'selected' : '' ?>>Writer</option>
                            <option value="editor" <?= ($user->role ?? '') === 'editor' ? 'selected' : '' ?>>Editor</option>
                            <option value="admin" <?= ($user->role ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <?php if ($isEdit): ?>
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5"><?= $t('status') ?></label>
                        <select name="status" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold">
                            <option value="active" <?= ($user->status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="suspended" <?= ($user->status ?? '') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                            <option value="banned" <?= ($user->status ?? '') === 'banned' ? 'selected' : '' ?>>Banned</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-brand-gold text-white font-semibold rounded-xl hover:bg-brand-gold-dark transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-save text-sm"></i> <?= $t('save') ?>
                    </button>
                    <a href="<?= url('admin/users') ?>" class="px-6 py-2.5 border border-stone-200 text-stone-600 font-medium rounded-xl hover:bg-stone-50 transition"><?= $t('cancel') ?? 'Cancel' ?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
