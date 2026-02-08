<?php
/**
 * Admin Comments - Tailwind CSS Redesign
 */
$pageTitle = $t('comments');
ob_start();
?>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('comments') ?></h3>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-2 px-5 py-3 border-b border-stone-100 bg-stone-50/50">
        <a href="<?= url('admin/comments') ?>" class="px-3 py-1.5 rounded-lg text-xs font-medium transition <?= empty($statusFilter) ? 'bg-brand-gold text-white shadow-sm' : 'bg-white text-stone-600 border border-stone-200 hover:border-brand-gold hover:text-brand-gold' ?>">
            <?= $t('all') ?>
        </a>
        <a href="<?= url('admin/comments?status=pending') ?>" class="px-3 py-1.5 rounded-lg text-xs font-medium transition inline-flex items-center gap-1.5 <?= ($statusFilter ?? '') === 'pending' ? 'bg-brand-gold text-white shadow-sm' : 'bg-white text-stone-600 border border-stone-200 hover:border-brand-gold hover:text-brand-gold' ?>">
            <?= $t('pending') ?>
            <?php if (($pendingCount ?? 0) > 0): ?>
            <span class="bg-red-500 text-white text-[0.6rem] font-bold px-1.5 py-0.5 rounded-full"><?= $pendingCount ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= url('admin/comments?status=approved') ?>" class="px-3 py-1.5 rounded-lg text-xs font-medium transition <?= ($statusFilter ?? '') === 'approved' ? 'bg-brand-gold text-white shadow-sm' : 'bg-white text-stone-600 border border-stone-200 hover:border-brand-gold hover:text-brand-gold' ?>">
            <?= $t('approved') ?>
        </a>
    </div>

    <!-- Comments List -->
    <div class="divide-y divide-stone-50">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
            <div class="flex gap-3 p-5 hover:bg-stone-50/50 transition">
                <div class="w-10 h-10 bg-gradient-to-br from-brand-gold to-brand-gold-dark rounded-full flex items-center justify-center text-sidebar-bg font-bold text-sm shrink-0">
                    <?= strtoupper(substr($comment->author_name ?? $comment->user_name ?? 'A', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <div class="flex items-center gap-2">
                            <strong class="text-sm text-stone-700"><?= $comment->author_name ?? $comment->user_name ?? 'Anonymous' ?></strong>
                            <?php $cColor = $comment->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'; ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-[0.65rem] font-medium <?= $cColor ?>"><?= $t($comment->status) ?></span>
                        </div>
                        <span class="text-[0.65rem] text-stone-400"><?= time_ago($comment->created_at) ?></span>
                    </div>
                    <?php if ($comment->article_title): ?>
                    <p class="text-xs text-stone-400 mt-1">
                        <?= $t('on') ?>: <a href="<?= url('admin/articles/edit/' . $comment->article_id) ?>" class="text-brand-gold hover:underline"><?= excerpt($comment->article_title, 50) ?></a>
                    </p>
                    <?php endif; ?>
                    <p class="text-sm text-stone-600 mt-2 leading-relaxed"><?= htmlspecialchars($comment->content) ?></p>
                    <div class="flex items-center gap-2 mt-3">
                        <?php if ($comment->status !== 'approved'): ?>
                        <a href="<?= url('admin/comments/approve/' . $comment->id) ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 text-white text-xs font-medium rounded-lg hover:bg-emerald-600 transition">
                            <i class="fas fa-check text-[0.6rem]"></i> <?= $t('approve') ?>
                        </a>
                        <?php endif; ?>
                        <a href="<?= url('admin/comments/delete/' . $comment->id) ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition"
                           onclick="return confirm('<?= $t('confirm_delete') ?>')">
                            <i class="fas fa-trash text-[0.6rem]"></i> <?= $t('delete') ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
        <div class="text-center text-stone-400 py-12">
            <i class="fas fa-comments text-3xl mb-2 block opacity-30"></i>
            <?= $t('no_comments') ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
