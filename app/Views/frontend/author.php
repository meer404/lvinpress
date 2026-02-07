<?php
/**
 * Author Profile Page
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

<div class="container" style="padding-top:var(--spacing-2xl);padding-bottom:var(--spacing-2xl);">
    <!-- Author Header -->
    <div style="text-align:center;margin-bottom:var(--spacing-2xl);">
        <img src="<?= $author->avatar ? upload_url($author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($authorName) . '&background=d4af37&color=1a1a2e&size=120' ?>" 
             alt="<?= $authorName ?>" 
             style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid var(--gold);margin-bottom:var(--spacing-lg);">
        <h1 style="font-family:var(--font-display);font-size:2rem;margin-bottom:0.5rem;"><?= $authorName ?></h1>
        <p class="text-muted" style="max-width:600px;margin:0 auto;"><?= $authorBio ?></p>
        
        <?php if ($author->social_facebook || $author->social_twitter || $author->social_instagram): ?>
        <div style="display:flex;justify-content:center;gap:1rem;margin-top:var(--spacing-lg);">
            <?php if ($author->social_facebook): ?>
            <a href="<?= $author->social_facebook ?>" target="_blank" class="btn btn-outline btn-sm"><i class="fab fa-facebook-f"></i></a>
            <?php endif; ?>
            <?php if ($author->social_twitter): ?>
            <a href="<?= $author->social_twitter ?>" target="_blank" class="btn btn-outline btn-sm"><i class="fab fa-x-twitter"></i></a>
            <?php endif; ?>
            <?php if ($author->social_instagram): ?>
            <a href="<?= $author->social_instagram ?>" target="_blank" class="btn btn-outline btn-sm"><i class="fab fa-instagram"></i></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <p class="text-sm text-muted" style="margin-top:var(--spacing-lg);">
            <?= number_format($totalArticles) ?> <?= $t('articles') ?>
        </p>
    </div>

    <!-- Author's Articles -->
    <div class="section-header">
        <h2 class="section-header__title"><?= $t('articles_by') ?? 'Articles by' ?> <?= $authorName ?></h2>
    </div>
    
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
                <div class="article-card__meta">
                    <span class="text-xs text-muted"><?= time_ago($article->published_at ?? $article->created_at) ?></span>
                    <span class="text-xs text-muted"><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination" style="margin-top:var(--spacing-2xl);">
        <?php if ($currentPage > 1): ?>
        <a href="<?= lang_url('author/' . $author->id . '?page=' . ($currentPage - 1)) ?>" class="pagination__item">
            <i class="fas fa-chevron-<?= $isRtl ? 'right' : 'left' ?>"></i>
        </a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= lang_url('author/' . $author->id . '?page=' . $i) ?>" 
           class="pagination__item <?= $i === $currentPage ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        
        <?php if ($currentPage < $totalPages): ?>
        <a href="<?= lang_url('author/' . $author->id . '?page=' . ($currentPage + 1)) ?>" class="pagination__item">
            <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
