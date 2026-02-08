<?php
/**
 * Category Page - Advanced Tailwind CSS
 */
include VIEW_PATH . '/frontend/partials/header.php';

$titleField = 'title_' . $lang;
$slugField = 'slug_' . $lang;
$excerptField = 'excerpt_' . $lang;
$catNameField = 'name_' . $lang;
$catDescField = 'description_' . $lang;

$categoryName = $category->$catNameField ?: $category->name_ku;
$categoryDesc = $category->$catDescField ?: $category->description_ku ?? '';

$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='450' viewBox='0 0 800 450'%3E%3Crect width='800' height='450' fill='%231a1a2e'/%3E%3Ctext x='400' y='225' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
?>

<!-- Category Hero -->
<section class="border-b-[3px] py-10 lg:py-14 relative overflow-hidden" style="background:<?= $category->color ?? '#d4af37' ?>10; border-color:<?= $category->color ?? '#d4af37' ?>;">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,<?= $category->color ?? '#d4af37' ?>15,transparent_70%)]"></div>
    <div class="max-w-container mx-auto px-4 lg:px-6 relative z-10">
        <nav class="flex items-center gap-2 text-sm text-stone-400 dark:text-stone-500 mb-4" data-animate>
            <a href="<?= lang_url('') ?>" class="hover:text-brand-gold transition-colors"><?= $t('home') ?></a>
            <span class="opacity-40">/</span>
            <span class="text-stone-600 dark:text-stone-300"><?= $categoryName ?></span>
        </nav>
        <h1 class="font-display text-3xl lg:text-4xl font-bold text-stone-900 dark:text-white mb-2" data-animate><?= $categoryName ?></h1>
        <?php if ($categoryDesc): ?>
        <p class="text-stone-500 dark:text-stone-400 max-w-xl text-sm lg:text-base"><?= $categoryDesc ?></p>
        <?php endif; ?>
        <p class="text-sm text-stone-400 dark:text-stone-500 mt-2"><?= $totalArticles ?> <?= $t('articles') ?></p>
    </div>
</section>

<div class="max-w-container mx-auto px-4 lg:px-6 py-8 lg:py-12">
    <div class="content-grid grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
        <main class="lg:col-span-2">
            <?php if (!empty($articles)): ?>
            <div class="space-y-6">
                <?php foreach ($articles as $article): ?>
                <article class="spotlight-card group flex flex-col sm:flex-row bg-white dark:bg-dark-card rounded-xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-black/20 transition-all duration-300 border border-stone-100 dark:border-white/5" data-animate>
                    <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>" class="shrink-0">
                        <div class="sm:w-72 aspect-[16/10] sm:aspect-auto sm:h-full overflow-hidden">
                            <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                                 alt="<?= $article->$titleField ?? $article->title_ku ?>" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                        </div>
                    </a>
                    <div class="p-5 flex flex-col justify-center flex-1 min-w-0">
                        <div class="flex items-center gap-2 text-xs text-stone-400 dark:text-stone-500 mb-2 flex-wrap">
                            <span><?= format_date($article->published_at ?? $article->created_at) ?></span>
                            <span class="opacity-40">•</span>
                            <span><i class="far fa-clock"></i> <?= $article->reading_time ?? 3 ?> <?= $t('min_read') ?></span>
                            <span class="opacity-40">•</span>
                            <span><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
                        </div>
                        <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                            <h2 class="font-display text-lg font-bold text-stone-900 dark:text-stone-100 leading-snug mb-2 group-hover:text-brand-red transition-colors line-clamp-2"><?= $article->$titleField ?? $article->title_ku ?></h2>
                        </a>
                        <p class="text-stone-500 dark:text-stone-400 text-sm line-clamp-2 mb-3"><?= excerpt($article->$excerptField ?? $article->excerpt_ku ?? '', 180) ?></p>
                        <span class="text-xs text-stone-400 dark:text-stone-500"><?= $article->author_name ?? '' ?></span>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="flex items-center justify-center gap-2 mt-10">
                <?php if ($currentPage > 1): ?>
                <a href="<?= lang_url('category/' . $category->slug . '?page=' . ($currentPage - 1)) ?>" class="w-10 h-10 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-500 hover:border-brand-gold hover:text-brand-gold transition-all">
                    <i class="fas fa-chevron-<?= is_rtl() ? 'right' : 'left' ?> text-xs"></i>
                </a>
                <?php endif; ?>
                <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                <a href="<?= lang_url('category/' . $category->slug . '?page=' . $i) ?>" 
                   class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium transition-all <?= $i == $currentPage ? 'bg-brand-red text-white shadow-md' : 'border border-stone-200 dark:border-white/10 text-stone-500 hover:border-brand-gold hover:text-brand-gold' ?>"><?= $i ?></a>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                <a href="<?= lang_url('category/' . $category->slug . '?page=' . ($currentPage + 1)) ?>" class="w-10 h-10 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-500 hover:border-brand-gold hover:text-brand-gold transition-all">
                    <i class="fas fa-chevron-<?= is_rtl() ? 'left' : 'right' ?> text-xs"></i>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php else: ?>
            <div class="text-center py-16">
                <i class="fas fa-newspaper text-5xl text-stone-200 dark:text-stone-700 mb-4 block"></i>
                <p class="text-stone-400 dark:text-stone-500"><?= $t('no_articles') ?></p>
            </div>
            <?php endif; ?>
        </main>
        
        <!-- Sidebar -->
        <aside class="sidebar-col space-y-6">
            <div class="bg-white dark:bg-dark-card rounded-xl border border-stone-100 dark:border-white/5 p-5 shadow-sm">
                <h3 class="font-display text-lg font-bold text-stone-900 dark:text-white mb-4"><?= $t('categories') ?></h3>
                <?php if (!empty($categories)): ?>
                <div class="space-y-1">
                    <?php foreach ($categories as $cat): ?>
                    <a href="<?= lang_url('category/' . $cat->slug) ?>" 
                       class="flex items-center justify-between py-2.5 px-3 rounded-lg text-sm transition-all <?= $cat->id == $category->id ? 'bg-brand-gold/10 text-brand-gold font-semibold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-dark-tertiary' ?>">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full shrink-0" style="background:<?= $cat->color ?? '#d4af37' ?>"></span>
                            <?= $cat->$catNameField ?? $cat->name_ku ?>
                        </span>
                        <span class="text-xs text-stone-400 dark:text-stone-500"><?= $cat->article_count ?? 0 ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Newsletter -->
            <div class="p-6 bg-gradient-to-br from-brand-gold to-brand-gold-dark rounded-xl text-stone-900">
                <h3 class="font-display text-lg font-bold mb-2"><?= $t('newsletter_title') ?></h3>
                <p class="text-sm text-stone-900/70 mb-4"><?= $t('newsletter_desc') ?></p>
                <form onsubmit="return subscribeNewsletter(event)">
                    <input type="email" name="email" placeholder="<?= $t('your_email') ?>" required
                           class="w-full px-4 py-2.5 rounded-lg border-none text-sm outline-none mb-2 bg-white/90 placeholder-stone-400">
                    <button type="submit" class="w-full px-4 py-2.5 bg-dark-card text-brand-gold font-semibold rounded-lg text-sm hover:bg-stone-900 transition-colors">
                        <?= $t('subscribe') ?>
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
