<?php
/**
 * Tag Archive Page
 */
include VIEW_PATH . '/frontend/partials/header.php';

$nameField = 'name_' . $lang;
$titleField = 'title_' . $lang;
$slugField = 'slug_' . $lang;
$excerptField = 'excerpt_' . $lang;

$tagName = $tag->$nameField ?: $tag->name_en ?: $tag->slug;

$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='500' viewBox='0 0 800 500'%3E%3Crect width='800' height='500' fill='%231a1a2e'/%3E%3Ctext x='400' y='250' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
?>

<div class="container" style="padding-top:var(--spacing-2xl);padding-bottom:var(--spacing-2xl);">
    <!-- Tag Header -->
    <div style="text-align:center;margin-bottom:var(--spacing-2xl);">
        <span style="background:var(--gold);color:#1a1a2e;padding:0.5rem 1rem;border-radius:var(--radius-full);font-size:0.875rem;display:inline-block;margin-bottom:var(--spacing-md);">
            <i class="fas fa-tag"></i> <?= $t('tag') ?? 'Tag' ?>
        </span>
        <h1 style="font-family:var(--font-display);font-size:2.5rem;margin-bottom:0.5rem;"><?= $tagName ?></h1>
        <p class="text-muted"><?= number_format($totalArticles) ?> <?= $t('articles') ?></p>
    </div>

    <!-- Articles Grid -->
    <?php if (!empty($articles)): ?>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
        <article class="article-card">
            <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                <div class="article-card__image-wrapper">
                    <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                         alt="<?= $article->$titleField ?? $article->title_ku ?>" 
                         class="article-card__image" loading="lazy">
                    <span class="article-card__category" style="background:<?= $article->category_color ?? '#d4af37' ?>">
                        <?= $article->category_name ?? '' ?>
                    </span>
                </div>
            </a>
            <div class="article-card__content">
                <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                    <h3 class="article-card__title"><?= $article->$titleField ?? $article->title_ku ?></h3>
                </a>
                <p class="article-card__excerpt"><?= excerpt($article->$excerptField ?? $article->excerpt_ku ?? '', 100) ?></p>
                <div class="article-card__meta">
                    <div class="article-card__author">
                        <span><?= $article->author_name ?? '' ?></span>
                    </div>
                    <div class="article-card__stats">
                        <span><i class="far fa-clock"></i> <?= time_ago($article->published_at ?? $article->created_at) ?></span>
                        <span><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination" style="margin-top:var(--spacing-2xl);">
        <?php if ($currentPage > 1): ?>
        <a href="<?= lang_url('tag/' . $tag->slug . '?page=' . ($currentPage - 1)) ?>" class="pagination__item">
            <i class="fas fa-chevron-<?= $isRtl ? 'right' : 'left' ?>"></i>
        </a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= lang_url('tag/' . $tag->slug . '?page=' . $i) ?>" 
           class="pagination__item <?= $i === $currentPage ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        
        <?php if ($currentPage < $totalPages): ?>
        <a href="<?= lang_url('tag/' . $tag->slug . '?page=' . ($currentPage + 1)) ?>" class="pagination__item">
            <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div style="text-align:center;padding:var(--spacing-2xl) 0;">
        <i class="fas fa-newspaper" style="font-size:3rem;color:var(--text-muted);margin-bottom:var(--spacing-lg);display:block;"></i>
        <p class="text-muted"><?= $t('no_articles') ?? 'No articles found' ?></p>
    </div>
    <?php endif; ?>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
