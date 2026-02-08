<?php
/**
 * Admin Dashboard - Tailwind CSS Redesign
 */
$pageTitle = $t('dashboard');
ob_start();
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl p-5 border border-stone-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-brand-gold/10 flex items-center justify-center">
                <i class="fas fa-newspaper text-brand-gold"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-stone-800"><?= number_format($stats['articles'] ?? 0) ?></div>
                <div class="text-xs text-stone-500 font-medium"><?= $t('articles') ?></div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-stone-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                <i class="fas fa-eye text-blue-500"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-stone-800"><?= number_format($stats['total_views'] ?? 0) ?></div>
                <div class="text-xs text-stone-500 font-medium"><?= $t('total_views') ?></div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-stone-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                <i class="fas fa-users text-emerald-500"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-stone-800"><?= number_format($stats['users'] ?? 0) ?></div>
                <div class="text-xs text-stone-500 font-medium"><?= $t('users') ?></div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-stone-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-500/10 flex items-center justify-center">
                <i class="fas fa-comments text-red-500"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-stone-800"><?= number_format($stats['comments'] ?? 0) ?></div>
                <div class="text-xs text-stone-500 font-medium"><?= $t('comments') ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Articles & Comments -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Recent Articles -->
    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
            <h3 class="font-semibold text-stone-800"><?= $t('recent_articles') ?></h3>
            <a href="<?= url('admin/articles/create') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-gold text-white text-xs font-medium rounded-lg hover:bg-brand-gold-dark transition">
                <i class="fas fa-plus"></i> <?= $t('add_new') ?>
            </a>
        </div>
        <div class="overflow-x-auto">
            <?php if (!empty($recentArticles)): ?>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-stone-100">
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('title') ?></th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('status') ?></th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('views') ?></th>
                        <th class="px-5 py-3 text-start text-xs font-semibold text-stone-500 uppercase tracking-wider"><?= $t('date') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    <?php foreach ($recentArticles as $article): ?>
                    <tr class="hover:bg-stone-50/50 transition">
                        <td class="px-5 py-3">
                            <a href="<?= url('admin/articles/edit/' . $article->id) ?>" class="font-medium text-stone-700 hover:text-brand-gold transition">
                                <?= excerpt($article->{'title_' . $lang} ?? $article->title_ku, 40) ?>
                            </a>
                        </td>
                        <td class="px-5 py-3">
                            <?php
                            $statusColors = match($article->status) {
                                'published' => 'bg-emerald-50 text-emerald-700',
                                'draft' => 'bg-amber-50 text-amber-700',
                                default => 'bg-blue-50 text-blue-700'
                            };
                            ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium <?= $statusColors ?>"><?= $t($article->status) ?></span>
                        </td>
                        <td class="px-5 py-3 text-stone-500"><?= number_format($article->views ?? 0) ?></td>
                        <td class="px-5 py-3 text-stone-400 text-xs"><?= date('Y-m-d', strtotime($article->created_at)) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="text-stone-400 text-center py-8"><?= $t('no_articles') ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Comments -->
    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
            <h3 class="font-semibold text-stone-800"><?= $t('recent_comments') ?></h3>
            <a href="<?= url('admin/comments') ?>" class="text-xs font-medium text-brand-gold hover:text-brand-gold-dark transition"><?= $t('view_all') ?></a>
        </div>
        <div class="divide-y divide-stone-50">
            <?php if (!empty($recentComments)): ?>
                <?php foreach ($recentComments as $comment): ?>
                <div class="px-5 py-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <strong class="text-sm text-stone-700"><?= $comment->author_name ?? $comment->user_name ?? 'Anonymous' ?></strong>
                            <?php
                            $cStatusColor = $comment->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700';
                            ?>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-[0.65rem] font-medium <?= $cStatusColor ?>"><?= $t($comment->status) ?></span>
                        </div>
                        <span class="text-[0.65rem] text-stone-400 shrink-0"><?= time_ago($comment->created_at) ?></span>
                    </div>
                    <p class="text-sm text-stone-500 mt-1.5 line-clamp-2"><?= excerpt($comment->content, 100) ?></p>
                    <?php if ($comment->status === 'pending'): ?>
                    <div class="flex items-center gap-2 mt-2.5">
                        <a href="<?= url('admin/comments/approve/' . $comment->id) ?>" class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500 text-white text-xs font-medium rounded-md hover:bg-emerald-600 transition">
                            <i class="fas fa-check text-[0.6rem]"></i> <?= $t('approve') ?? 'Approve' ?>
                        </a>
                        <a href="<?= url('admin/comments/delete/' . $comment->id) ?>" class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-500 text-white text-xs font-medium rounded-md hover:bg-red-600 transition"
                           onclick="return confirm('<?= $t('confirm_delete') ?>')">
                            <i class="fas fa-trash text-[0.6rem]"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <p class="text-stone-400 text-center py-8"><?= $t('no_comments') ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Monthly Views Chart -->
<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden mt-6">
    <div class="px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('monthly_views') ?></h3>
    </div>
    <div class="p-5">
        <?php if (!empty($monthlyViews)): ?>
        <div class="flex items-end gap-1 h-52">
            <?php
            $maxViews = max(array_map(function($mv) { return $mv->visits ?? 0; }, $monthlyViews) ?: [1]);
            foreach ($monthlyViews as $mv):
                $height = ($mv->visits / max($maxViews, 1)) * 100;
            ?>
            <div class="flex-1 flex flex-col items-center group">
                <span class="text-[0.6rem] text-stone-400 mb-1 opacity-0 group-hover:opacity-100 transition"><?= number_format($mv->visits) ?></span>
                <div class="w-full bg-gradient-to-t from-brand-gold to-brand-gold-light rounded-t-md transition-all duration-500 hover:opacity-80"
                     style="height: <?= max($height, 3) ?>%; min-height: 4px;"></div>
                <span class="text-[0.6rem] text-stone-400 mt-1.5"><?= date('M', strtotime($mv->month . '-01')) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-stone-400 text-center py-8"><?= $t('no_data') ?></p>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
