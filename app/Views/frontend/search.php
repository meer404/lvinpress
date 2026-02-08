<?php
/**
 * Search Results Page - Advanced Tailwind CSS
 */
include VIEW_PATH . '/frontend/partials/header.php';

$titleField = 'title_' . $lang;
$slugField = 'slug_' . $lang;
$excerptField = 'excerpt_' . $lang;

$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='450' viewBox='0 0 800 450'%3E%3Crect width='800' height='450' fill='%231a1a2e'/%3E%3Ctext x='400' y='225' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
?>

<section class="max-w-container mx-auto px-4 lg:px-6 py-10 lg:py-14">
    <div class="max-w-2xl mx-auto mb-10" data-animate>
        <h1 class="font-display text-2xl lg:text-3xl font-bold text-stone-900 dark:text-white text-center mb-6"><?= $t('search_results') ?></h1>
        <form action="<?= lang_url('search') ?>" method="GET" class="flex gap-2">
            <input type="text" name="q" value="<?= htmlspecialchars($query ?? '') ?>" 
                   class="flex-1 px-5 py-3 bg-stone-50 dark:bg-dark-tertiary border border-stone-200 dark:border-white/10 rounded-full text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/10 transition-all" 
                   placeholder="<?= $t('search_placeholder') ?>">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 rounded-full font-semibold hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <?php if (isset($query)): ?>
        <p class="text-stone-400 dark:text-stone-500 text-center text-sm mt-4">
            <?= $totalArticles ?> <?= $t('results_for') ?> "<strong class="text-stone-600 dark:text-stone-300"><?= htmlspecialchars($query) ?></strong>"
        </p>
        <?php endif; ?>
    </div>
    
    <?php if (!empty($articles)): ?>
    <div class="max-w-3xl mx-auto space-y-6">
        <?php foreach ($articles as $article): ?>
        <article class="spotlight-card group flex flex-col sm:flex-row bg-white dark:bg-dark-card rounded-xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-black/20 transition-all duration-300 border border-stone-100 dark:border-white/5" data-animate>
            <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>" class="shrink-0">
                <div class="sm:w-56 aspect-[16/10] sm:aspect-auto sm:h-full overflow-hidden">
                    <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                         alt="<?= $article->$titleField ?? $article->title_ku ?>" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                </div>
            </a>
            <div class="p-5 flex flex-col justify-center flex-1 min-w-0">
                <?php if ($article->category_name): ?>
                <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit mb-2" style="background:<?= $article->category_color ?? '#d4af37' ?>15; color:<?= $article->category_color ?? '#d4af37' ?>;">
                    <?= $article->category_name ?>
                </span>
                <?php endif; ?>
                <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                    <h2 class="font-display text-lg font-bold text-stone-900 dark:text-stone-100 leading-snug mb-2 group-hover:text-brand-red transition-colors line-clamp-2"><?= $article->$titleField ?? $article->title_ku ?></h2>
                </a>
                <p class="text-stone-500 dark:text-stone-400 text-sm line-clamp-2 mb-3"><?= excerpt($article->$excerptField ?? $article->excerpt_ku ?? '', 160) ?></p>
                <div class="flex items-center gap-2 text-xs text-stone-400 dark:text-stone-500">
                    <span><?= $article->author_name ?? '' ?></span>
                    <span class="opacity-40">•</span>
                    <span><?= time_ago($article->published_at ?? $article->created_at) ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="flex items-center justify-center gap-2 pt-6">
            <?php if ($currentPage > 1): ?>
            <a href="<?= lang_url('search?q=' . urlencode($query) . '&page=' . ($currentPage - 1)) ?>" class="w-10 h-10 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-500 hover:border-brand-gold hover:text-brand-gold transition-all">
                <i class="fas fa-chevron-<?= is_rtl() ? 'right' : 'left' ?> text-xs"></i>
            </a>
            <?php endif; ?>
            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
            <a href="<?= lang_url('search?q=' . urlencode($query) . '&page=' . $i) ?>" 
               class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium transition-all <?= $i == $currentPage ? 'bg-brand-red text-white shadow-md' : 'border border-stone-200 dark:border-white/10 text-stone-500 hover:border-brand-gold hover:text-brand-gold' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
            <a href="<?= lang_url('search?q=' . urlencode($query) . '&page=' . ($currentPage + 1)) ?>" class="w-10 h-10 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-500 hover:border-brand-gold hover:text-brand-gold transition-all">
                <i class="fas fa-chevron-<?= is_rtl() ? 'left' : 'right' ?> text-xs"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <?php elseif (isset($query)): ?>
    <div class="text-center py-16">
        <i class="fas fa-search text-5xl text-stone-200 dark:text-stone-700 mb-4 block"></i>
        <p class="text-stone-400 dark:text-stone-500"><?= $t('no_results') ?></p>
    </div>
    <?php endif; ?>
</section>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
