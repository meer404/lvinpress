<?php
/**
 * Author Profile Page - Advanced Tailwind CSS
 */
include VIEW_PATH . '/frontend/partials/header.php';

$nameField = 'full_name_' . $lang;
$bioField = 'bio_' . $lang;
$titleField = 'title_' . $lang;
$slugField = 'slug_' . $lang;

$authorName = $author->$nameField ?: $author->full_name_en ?: $author->username;
$authorBio = $author->$bioField ?? '';

$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='500' viewBox='0 0 800 500'%3E%3Crect width='800' height='500' fill='%231a1a2e'/%3E%3Ctext x='400' y='250' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
?>

<div class="max-w-container mx-auto px-4 lg:px-6 py-10 lg:py-14">
    <!-- Author Header -->
    <div class="text-center mb-12" data-animate>
        <img src="<?= $author->avatar ? upload_url($author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($authorName) . '&background=d4af37&color=1a1a2e&size=120' ?>" 
             alt="<?= $authorName ?>" 
             class="w-28 h-28 rounded-full object-cover ring-4 ring-brand-gold/20 shadow-lg mx-auto mb-5">
        <h1 class="font-display text-2xl lg:text-3xl font-bold text-stone-900 dark:text-white mb-2"><?= $authorName ?></h1>
        <p class="text-stone-500 dark:text-stone-400 max-w-lg mx-auto text-sm lg:text-base leading-relaxed"><?= $authorBio ?></p>
        
        <?php if ($author->social_facebook || $author->social_twitter || $author->social_instagram): ?>
        <div class="flex items-center justify-center gap-2 mt-5">
            <?php if ($author->social_facebook): ?>
            <a href="<?= $author->social_facebook ?>" target="_blank" class="w-9 h-9 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-400 hover:border-brand-gold hover:text-brand-gold transition-all"><i class="fab fa-facebook-f text-sm"></i></a>
            <?php endif; ?>
            <?php if ($author->social_twitter): ?>
            <a href="<?= $author->social_twitter ?>" target="_blank" class="w-9 h-9 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-400 hover:border-brand-gold hover:text-brand-gold transition-all"><i class="fab fa-x-twitter text-sm"></i></a>
            <?php endif; ?>
            <?php if ($author->social_instagram): ?>
            <a href="<?= $author->social_instagram ?>" target="_blank" class="w-9 h-9 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-400 hover:border-brand-gold hover:text-brand-gold transition-all"><i class="fab fa-instagram text-sm"></i></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <p class="text-sm text-stone-400 dark:text-stone-500 mt-4">
            <?= number_format($totalArticles) ?> <?= $t('articles') ?>
        </p>
    </div>

    <!-- Section Header -->
    <div class="flex items-center gap-2 mb-6">
        <h2 class="font-display text-xl font-bold text-stone-900 dark:text-white flex items-center gap-2">
            <span class="w-1 h-6 bg-brand-red rounded-full"></span>
            <?= $t('articles_by') ?? 'Articles by' ?> <?= $authorName ?>
        </h2>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($articles as $article): ?>
        <article class="spotlight-card group bg-white dark:bg-dark-card rounded-xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-black/20 transition-all duration-300 hover:-translate-y-1 border border-stone-100 dark:border-white/5" data-animate>
            <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                <div class="relative aspect-[16/10] overflow-hidden">
                    <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                         alt="<?= $article->$titleField ?? $article->title_ku ?>" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                    <span class="absolute top-3 left-3 rtl:left-auto rtl:right-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold text-white backdrop-blur-sm" style="background:<?= $article->category_color ?? '#d4af37' ?>CC">
                        <?= $article->category_name ?? '' ?>
                    </span>
                </div>
            </a>
            <div class="p-4">
                <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                    <h3 class="font-display text-base font-bold text-stone-900 dark:text-stone-100 leading-snug mb-2 group-hover:text-brand-red transition-colors line-clamp-2"><?= $article->$titleField ?? $article->title_ku ?></h3>
                </a>
                <div class="flex items-center gap-3 text-xs text-stone-400 dark:text-stone-500">
                    <span><?= time_ago($article->published_at ?? $article->created_at) ?></span>
                    <span class="flex items-center gap-1"><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="flex items-center justify-center gap-2 mt-10">
        <?php if ($currentPage > 1): ?>
        <a href="<?= lang_url('author/' . $author->id . '?page=' . ($currentPage - 1)) ?>" class="w-10 h-10 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-500 hover:border-brand-gold hover:text-brand-gold transition-all">
            <i class="fas fa-chevron-<?= $isRtl ? 'right' : 'left' ?> text-xs"></i>
        </a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= lang_url('author/' . $author->id . '?page=' . $i) ?>" 
           class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium transition-all <?= $i === $currentPage ? 'bg-brand-red text-white shadow-md' : 'border border-stone-200 dark:border-white/10 text-stone-500 hover:border-brand-gold hover:text-brand-gold' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
        <a href="<?= lang_url('author/' . $author->id . '?page=' . ($currentPage + 1)) ?>" class="w-10 h-10 rounded-full border border-stone-200 dark:border-white/10 flex items-center justify-center text-stone-500 hover:border-brand-gold hover:text-brand-gold transition-all">
            <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?> text-xs"></i>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
