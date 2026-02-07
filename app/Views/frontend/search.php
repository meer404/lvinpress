<?php
/**
 * Search Results Page
 */
include VIEW_PATH . '/frontend/partials/header.php';

$titleField = 'title_' . $lang;
$slugField = 'slug_' . $lang;
$excerptField = 'excerpt_' . $lang;

$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='450' viewBox='0 0 800 450'%3E%3Crect width='800' height='450' fill='%231a1a2e'/%3E%3Ctext x='400' y='225' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
?>

<section class="container" style="padding-top:var(--spacing-2xl);">
    <div style="max-width:700px;margin:0 auto var(--spacing-2xl);">
        <h1 style="font-family:var(--font-display);font-size:2rem;margin-bottom:var(--spacing-lg);text-align:center;">
            <?= $t('search_results') ?>
        </h1>
        <form action="<?= lang_url('search') ?>" method="GET" style="display:flex;gap:0.5rem;">
            <input type="text" name="q" value="<?= htmlspecialchars($query ?? '') ?>" 
                   class="form-control" placeholder="<?= $t('search_placeholder') ?>" style="flex:1;">
            <button type="submit" class="btn btn-gold"><i class="fas fa-search"></i></button>
        </form>
        <?php if (isset($query)): ?>
        <p class="text-muted text-center" style="margin-top:var(--spacing-md);">
            <?= $totalArticles ?> <?= $t('results_for') ?> "<strong><?= htmlspecialchars($query) ?></strong>"
        </p>
        <?php endif; ?>
    </div>
    
    <?php if (!empty($articles)): ?>
    <div style="max-width:900px;margin:0 auto;">
        <?php foreach ($articles as $article): ?>
        <article class="article-card article-card--horizontal" style="margin-bottom:var(--spacing-lg);">
            <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                <div class="article-card__image-wrapper" style="min-width:220px;max-width:220px;">
                    <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                         alt="<?= $article->$titleField ?? $article->title_ku ?>" class="article-card__image" loading="lazy">
                </div>
            </a>
            <div class="article-card__content" style="padding:var(--spacing-lg);">
                <?php if ($article->category_name): ?>
                <span class="article-card__category" style="background:<?= $article->category_color ?? '#d4af37' ?>20;color:<?= $article->category_color ?? '#d4af37' ?>;">
                    <?= $article->category_name ?>
                </span>
                <?php endif; ?>
                <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                    <h2 class="article-card__title"><?= $article->$titleField ?? $article->title_ku ?></h2>
                </a>
                <p class="article-card__excerpt"><?= excerpt($article->$excerptField ?? $article->excerpt_ku ?? '', 160) ?></p>
                <div class="article-card__meta">
                    <span><?= $article->author_name ?? '' ?></span>
                    <span>•</span>
                    <span><?= time_ago($article->published_at ?? $article->created_at) ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
            <a href="<?= lang_url('search?q=' . urlencode($query) . '&page=' . ($currentPage - 1)) ?>" class="pagination__btn">
                <i class="fas fa-chevron-<?= is_rtl() ? 'right' : 'left' ?>"></i>
            </a>
            <?php endif; ?>
            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
            <a href="<?= lang_url('search?q=' . urlencode($query) . '&page=' . $i) ?>" 
               class="pagination__btn <?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
            <a href="<?= lang_url('search?q=' . urlencode($query) . '&page=' . ($currentPage + 1)) ?>" class="pagination__btn">
                <i class="fas fa-chevron-<?= is_rtl() ? 'left' : 'right' ?>"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <?php elseif (isset($query)): ?>
    <div style="text-align:center;padding:var(--spacing-2xl);">
        <i class="fas fa-search" style="font-size:3rem;color:var(--text-muted);margin-bottom:1rem;display:block;"></i>
        <p class="text-muted"><?= $t('no_results') ?></p>
    </div>
    <?php endif; ?>
</section>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
