<?php
/**
 * Admin Analytics Dashboard
 */
$pageTitle = $t('analytics') ?? 'Analytics';
ob_start();
?>

<div class="admin-stats">
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon" style="background:rgba(212,175,55,0.1);color:#d4af37;">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="admin-stat-card__content">
            <span class="admin-stat-card__value"><?= number_format($totalArticles ?? 0) ?></span>
            <span class="admin-stat-card__label"><?= $t('total_articles') ?? 'Total Articles' ?></span>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon" style="background:rgba(46,204,113,0.1);color:#2ecc71;">
            <i class="fas fa-eye"></i>
        </div>
        <div class="admin-stat-card__content">
            <span class="admin-stat-card__value"><?= number_format($totalViews ?? 0) ?></span>
            <span class="admin-stat-card__label"><?= $t('total_views') ?? 'Total Views' ?></span>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon" style="background:rgba(52,152,219,0.1);color:#3498db;">
            <i class="fas fa-users"></i>
        </div>
        <div class="admin-stat-card__content">
            <span class="admin-stat-card__value"><?= number_format($totalUsers ?? 0) ?></span>
            <span class="admin-stat-card__label"><?= $t('total_users') ?? 'Total Users' ?></span>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-card__icon" style="background:rgba(155,89,182,0.1);color:#9b59b6;">
            <i class="fas fa-comments"></i>
        </div>
        <div class="admin-stat-card__content">
            <span class="admin-stat-card__value"><?= number_format($totalComments ?? 0) ?></span>
            <span class="admin-stat-card__label"><?= $t('total_comments') ?? 'Total Comments' ?></span>
        </div>
    </div>
</div>

<div class="admin-card mt-4">
    <div class="admin-card__header">
        <h3><?= $t('analytics_overview') ?? 'Analytics Overview' ?></h3>
    </div>
    <div class="admin-card__body">
        <p class="text-muted"><?= $t('analytics_info') ?? 'Detailed analytics charts coming soon.' ?></p>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
