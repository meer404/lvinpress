<?php
/**
 * Tag Archive Page - Advanced Tailwind CSS
 */
include VIEW_PATH . '/frontend/partials/header.php';

$nameField = 'name_' . $lang;
$titleField = 'title_' . $lang;
$slugField = 'slug_' . $lang;
$excerptField = 'excerpt_' . $lang;

$tagName = $tag->$nameField ?: $tag->name_en ?: $tag->slug;

$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='500' viewBox='0 0 800 500'%3E%3Crect width='800' height='500' fill='%231a1a2e'/%3E%3Ctext x='400' y='250' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
?>

<div class="max-w-container mx-auto px-4 lg:px-6 py-10 lg:py-14">
    <!-- Tag Header -->
    <div class="text-center mb-10" data-animate>
        <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 px-4 py-1.5 rounded-full text-sm font-semibold mb-4">
            <i class="fas fa-tag text-xs"></i> <?= $t('tag') ?? 'Tag' ?>
        </span>
        <h1 class="font-display text-3xl lg:text-4xl font-bold text-stone-900 dark:text-white mb-2"><?= $tagName ?></h1>
        <p class="text-stone-400 dark:text-stone-500"><?= number_format($totalArticles) ?> <?= $t('articles') ?></p>
    </div>

    <?php if (!empty($articles)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
        <?php foreach ($articles as $article): ?>
        <article class="spotlight-card group bg-white dark:bg-dark-card rounded-xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-black/20 transition-all duration-300 hover:-translate-y-1 border border-stone-100 dark:border-white/5" data-animate>
            <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                <div class="relative aspect-[16/10] overflow-hidden">
                    <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                         alt="<?= $article->$titleField ?? $article->title_ku ?>" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                    <span class="absolute top-3 left-3 rtl:left-auto rtl:right-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold text-white" style="background:<?= $article->category_color ?? '#d4af37' ?>">
                        <?= $article->category_name ?? '' ?>
                    </span>
                </div>
            </a>
            <div class="p-4">
                <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                    <h3 class="font-display text-base font-bold text-stone-900 dark:text-stone-100 leading-snug mb-2 group-hover:text-brand-red transition-colors line-clamp-2"><?= $article->$titleField ?? $article->title_ku ?></h3>
                </a>
                <p class="text-stone-500 dark:text-stone-400 text-sm line-clamp-2 mb-3"><?= excerpt($article->$excerptField ?? $article->excerpt_ku ?? '', 100) ?></p>
                <div class="flex items-center justify-between text-xs text-stone-400 dark:text-stone-500">
                    <span><?= $article->author_name ?? '' ?></span>
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1"><i class="far fa-clock"></i> <?= time_ago($article->published_at ?? $article->created_at) ?></span>
                        <span class="flex items-center gap-1"><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="flex items-center justify-center gap-2 mt-10">
        <?php if ($currentPage > 1): ?>
        <a href="<?= lang_url('tag/' . $tag->slug . '?page=' . ($currentPage - 1)) ?>" class="w-10 h-10 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-500 hover:border-brand-gold hover:text-brand-gold transition-all">
            <i class="fas fa-chevron-<?= $isRtl ? 'right' : 'left' ?> text-xs"></i>
        </a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= lang_url('tag/' . $tag->slug . '?page=' . $i) ?>" 
           class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium transition-all <?= $i === $currentPage ? 'bg-brand-red text-white shadow-md' : 'border border-stone-200 dark:border-white/10 text-stone-500 hover:border-brand-gold hover:text-brand-gold' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
        <a href="<?= lang_url('tag/' . $tag->slug . '?page=' . ($currentPage + 1)) ?>" class="w-10 h-10 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-500 hover:border-brand-gold hover:text-brand-gold transition-all">
            <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?> text-xs"></i>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <div class="text-center py-16">
        <i class="fas fa-newspaper text-5xl text-stone-200 dark:text-stone-700 mb-4 block"></i>
        <p class="text-stone-400 dark:text-stone-500"><?= $t('no_articles') ?? 'No articles found' ?></p>
    </div>
    <?php endif; ?>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
