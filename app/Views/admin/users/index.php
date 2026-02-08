<?php
/**
 * Admin Users List - Tailwind CSS Redesign
 */
$pageTitle = $t('users');
ob_start();
?>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('all_users') ?> <span class="text-stone-400 font-normal">(<?= count($users ?? []) ?>)</span></h3>
        <a href="<?= url('admin/users/create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-gold text-white text-sm font-medium rounded-lg hover:bg-brand-gold-dark transition shadow-sm">
            <i class="fas fa-plus text-xs"></i> <?= $t('add_new') ?>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('avatar') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('name') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('email') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('role') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('status') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('joined') ?></th>
                    <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('actions') ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-stone-50/50 transition group">
                        <td class="px-5 py-3">
                            <div class="w-9 h-9 bg-gradient-to-br from-brand-gold to-brand-gold-dark rounded-full flex items-center justify-center text-sidebar-bg font-bold text-sm">
                                <?= strtoupper(substr($user->{'full_name_' . $lang} ?? $user->username ?? 'U', 0, 1)) ?>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <div class="font-medium text-stone-700"><?= $user->{'full_name_' . $lang} ?: $user->full_name_en ?: $user->username ?></div>
                            <div class="text-xs text-stone-400">@<?= $user->username ?></div>
                        </td>
                        <td class="px-5 py-3 text-stone-500"><?= $user->email ?></td>
                        <td class="px-5 py-3">
                            <?php
                            $roleColor = match($user->role) {
                                'admin' => 'bg-emerald-50 text-emerald-700',
                                'editor' => 'bg-blue-50 text-blue-700',
                                default => 'bg-amber-50 text-amber-700'
                            };
                            ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium <?= $roleColor ?>"><?= ucfirst($user->role) ?></span>
                        </td>
                        <td class="px-5 py-3">
                            <?php $sColor = $user->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'; ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium <?= $sColor ?>">
                                <?= $user->status === 'active' ? $t('active') : $t('inactive') ?>
                            </span>
                        </td>
                        <td class="px-5 py-3 text-stone-400 text-xs"><?= date('Y-m-d', strtotime($user->created_at)) ?></td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                <a href="<?= url('admin/users/edit/' . $user->id) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-brand-gold hover:text-brand-gold transition">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <?php if ($user->id != ($currentUser->id ?? 0)): ?>
                                <a href="<?= url('admin/users/delete/' . $user->id) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:border-red-400 hover:text-red-500 hover:bg-red-50 transition"
                                   onclick="return confirm('<?= $t('confirm_delete') ?>')">
                                    <i class="fas fa-trash text-xs"></i>
                                </a>
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
