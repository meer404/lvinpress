<?php
/**
 * Admin Dashboard
 */
$pageTitle = $t('dashboard');
ob_start();
?>

<!-- Stats Cards -->
<div class="admin-stats">
    <div class="stat-card">
        <div class="stat-card__icon" style="background:#d4af3720;color:#d4af37;">
            <i class="fas fa-newspaper"></i>
        </div>
        <div>
            <div class="stat-card__value"><?= number_format($stats['articles'] ?? 0) ?></div>
            <div class="stat-card__label"><?= $t('articles') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon" style="background:#3498db20;color:#3498db;">
            <i class="fas fa-eye"></i>
        </div>
        <div>
            <div class="stat-card__value"><?= number_format($stats['total_views'] ?? 0) ?></div>
            <div class="stat-card__label"><?= $t('total_views') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon" style="background:#2ecc7120;color:#2ecc71;">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="stat-card__value"><?= number_format($stats['users'] ?? 0) ?></div>
            <div class="stat-card__label"><?= $t('users') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon" style="background:#e74c3c20;color:#e74c3c;">
            <i class="fas fa-comments"></i>
        </div>
        <div>
            <div class="stat-card__value"><?= number_format($stats['comments'] ?? 0) ?></div>
            <div class="stat-card__label"><?= $t('comments') ?></div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:1.5rem;">
    <!-- Recent Articles -->
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><?= $t('recent_articles') ?></h3>
            <a href="<?= url('admin/articles/create') ?>" class="btn btn-gold btn-sm">
                <i class="fas fa-plus"></i> <?= $t('add_new') ?>
            </a>
        </div>
        <div class="admin-card__body">
            <?php if (!empty($recentArticles)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th><?= $t('title') ?></th>
                        <th><?= $t('status') ?></th>
                        <th><?= $t('views') ?></th>
                        <th><?= $t('date') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentArticles as $article): ?>
                    <tr>
                        <td>
                            <a href="<?= url('admin/articles/edit/' . $article->id) ?>" class="text-primary">
                                <?= excerpt($article->{'title_' . $lang} ?? $article->title_ku, 40) ?>
                            </a>
                        </td>
                        <td>
                            <span class="badge badge-<?= $article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'info') ?>">
                                <?= $t($article->status) ?>
                            </span>
                        </td>
                        <td><?= number_format($article->views ?? 0) ?></td>
                        <td class="text-sm text-muted"><?= date('Y-m-d', strtotime($article->created_at)) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="text-muted"><?= $t('no_articles') ?></p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Comments -->
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><?= $t('recent_comments') ?></h3>
            <a href="<?= url('admin/comments') ?>" class="btn btn-outline btn-sm"><?= $t('view_all') ?></a>
        </div>
        <div class="admin-card__body">
            <?php if (!empty($recentComments)): ?>
                <?php foreach ($recentComments as $comment): ?>
                <div style="padding:0.75rem 0;border-bottom:1px solid var(--border-color);">
                    <div style="display:flex;justify-content:space-between;align-items:start;">
                        <div>
                            <strong class="text-sm"><?= $comment->author_name ?? $comment->user_name ?? 'Anonymous' ?></strong>
                            <span class="badge badge-<?= $comment->status === 'approved' ? 'success' : 'warning' ?>" style="margin-left:0.5rem;">
                                <?= $t($comment->status) ?>
                            </span>
                        </div>
                        <span class="text-xs text-muted"><?= time_ago($comment->created_at) ?></span>
                    </div>
                    <p class="text-sm text-muted" style="margin-top:0.25rem;"><?= excerpt($comment->content, 100) ?></p>
                    <?php if ($comment->status === 'pending'): ?>
                    <div style="display:flex;gap:0.5rem;margin-top:0.5rem;">
                        <a href="<?= url('admin/comments/approve/' . $comment->id) ?>" class="btn btn-sm" style="background:#2ecc71;color:#fff;font-size:0.75rem;">
                            <i class="fas fa-check"></i>
                        </a>
                        <a href="<?= url('admin/comments/delete/' . $comment->id) ?>" class="btn btn-sm" style="background:#e74c3c;color:#fff;font-size:0.75rem;" 
                           onclick="return confirm('<?= $t('confirm_delete') ?>')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <p class="text-muted"><?= $t('no_comments') ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Stats / Monthly Chart placeholder -->
<div class="admin-card" style="margin-top:1.5rem;">
    <div class="admin-card__header">
        <h3><?= $t('monthly_views') ?></h3>
    </div>
    <div class="admin-card__body">
        <?php if (!empty($monthlyViews)): ?>
        <div style="display:flex;align-items:flex-end;gap:4px;height:200px;padding:1rem 0;">
            <?php 
            $maxViews = max(array_map(function($mv) { return $mv->visits ?? 0; }, $monthlyViews) ?: [1]);
            foreach ($monthlyViews as $mv): 
                $height = ($mv->visits / max($maxViews, 1)) * 100;
            ?>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;">
                <span class="text-xs text-muted" style="margin-bottom:4px;"><?= number_format($mv->visits) ?></span>
                <div style="width:100%;background:linear-gradient(to top,var(--gold),#f0d060);border-radius:4px 4px 0 0;height:<?= max($height, 5) ?>%;min-height:4px;transition:height 0.5s ease;"></div>
                <span class="text-xs text-muted" style="margin-top:4px;"><?= date('M', strtotime($mv->month . '-01')) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-muted text-center" style="padding:2rem;"><?= $t('no_data') ?></p>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
