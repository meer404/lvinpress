<?php
/**
 * Admin Comments List
 */
$pageTitle = $t('comments');
ob_start();
?>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><?= $t('comments') ?></h3>
    </div>
    
    <!-- Filters -->
    <div style="padding:1rem 1.5rem;border-bottom:1px solid var(--border-color);display:flex;gap:1rem;">
        <a href="<?= url('admin/comments') ?>" class="btn btn-sm <?= empty($statusFilter) ? 'btn-gold' : 'btn-outline' ?>"><?= $t('all') ?></a>
        <a href="<?= url('admin/comments?status=pending') ?>" class="btn btn-sm <?= ($statusFilter ?? '') === 'pending' ? 'btn-gold' : 'btn-outline' ?>">
            <?= $t('pending') ?> <?php if (($pendingCount ?? 0) > 0): ?><span class="admin-nav__badge"><?= $pendingCount ?></span><?php endif; ?>
        </a>
        <a href="<?= url('admin/comments?status=approved') ?>" class="btn btn-sm <?= ($statusFilter ?? '') === 'approved' ? 'btn-gold' : 'btn-outline' ?>"><?= $t('approved') ?></a>
    </div>
    
    <div class="admin-card__body">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
            <div style="padding:1rem;border-bottom:1px solid var(--border-color);display:flex;gap:1rem;">
                <div style="width:40px;height:40px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#1a1a2e;font-weight:600;flex-shrink:0;">
                    <?= strtoupper(substr($comment->author_name ?? $comment->user_name ?? 'A', 0, 1)) ?>
                </div>
                <div style="flex:1;">
                    <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
                        <div>
                            <strong><?= $comment->author_name ?? $comment->user_name ?? 'Anonymous' ?></strong>
                            <span class="badge badge-<?= $comment->status === 'approved' ? 'success' : 'warning' ?>"><?= $t($comment->status) ?></span>
                        </div>
                        <span class="text-xs text-muted"><?= time_ago($comment->created_at) ?></span>
                    </div>
                    <?php if ($comment->article_title): ?>
                    <p class="text-xs text-muted" style="margin-top:0.25rem;">
                        <?= $t('on') ?>: <a href="<?= url('admin/articles/edit/' . $comment->article_id) ?>"><?= excerpt($comment->article_title, 50) ?></a>
                    </p>
                    <?php endif; ?>
                    <p style="margin-top:0.5rem;"><?= htmlspecialchars($comment->content) ?></p>
                    <div style="display:flex;gap:0.5rem;margin-top:0.5rem;">
                        <?php if ($comment->status !== 'approved'): ?>
                        <a href="<?= url('admin/comments/approve/' . $comment->id) ?>" class="btn btn-sm" style="background:#2ecc71;color:#fff;">
                            <i class="fas fa-check"></i> <?= $t('approve') ?>
                        </a>
                        <?php endif; ?>
                        <a href="<?= url('admin/comments/delete/' . $comment->id) ?>" class="btn btn-sm" style="background:#e74c3c;color:#fff;" 
                           onclick="return confirm('<?= $t('confirm_delete') ?>')">
                            <i class="fas fa-trash"></i> <?= $t('delete') ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
        <div class="text-center text-muted" style="padding:2rem;">
            <i class="fas fa-comments" style="font-size:2rem;margin-bottom:0.5rem;display:block;"></i>
            <?= $t('no_comments') ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
