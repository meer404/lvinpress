<?php
/**
 * Admin Analytics - Tailwind CSS Redesign
 */
$pageTitle = $t('analytics') ?? 'Analytics';
ob_start();
?>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl p-5 border border-stone-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-brand-gold/10 flex items-center justify-center">
                <i class="fas fa-newspaper text-brand-gold"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-stone-800"><?= number_format($totalArticles ?? 0) ?></div>
                <div class="text-xs text-stone-500 font-medium"><?= $t('total_articles') ?? 'Total Articles' ?></div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-stone-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                <i class="fas fa-eye text-emerald-500"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-stone-800"><?= number_format($totalViews ?? 0) ?></div>
                <div class="text-xs text-stone-500 font-medium"><?= $t('total_views') ?? 'Total Views' ?></div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-stone-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                <i class="fas fa-users text-blue-500"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-stone-800"><?= number_format($totalUsers ?? 0) ?></div>
                <div class="text-xs text-stone-500 font-medium"><?= $t('total_users') ?? 'Total Users' ?></div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-stone-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center">
                <i class="fas fa-comments text-purple-500"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-stone-800"><?= number_format($totalComments ?? 0) ?></div>
                <div class="text-xs text-stone-500 font-medium"><?= $t('total_comments') ?? 'Total Comments' ?></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden mt-6">
    <div class="px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('analytics_overview') ?? 'Analytics Overview' ?></h3>
    </div>
    <div class="p-5">
        <p class="text-stone-400 text-center py-8"><?= $t('analytics_info') ?? 'Detailed analytics charts coming soon.' ?></p>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
