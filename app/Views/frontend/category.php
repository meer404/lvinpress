<?php
/**
 * Category Page - Article Listing
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
<section class="category-hero" style="background:<?= $category->color ?? '#d4af37' ?>15; border-bottom:3px solid <?= $category->color ?? '#d4af37' ?>;">
    <div class="container" style="padding:var(--spacing-2xl) 0;">
        <nav class="breadcrumb" style="margin-bottom:var(--spacing-md);">
            <a href="<?= lang_url('') ?>"><?= $t('home') ?></a>
            <span class="breadcrumb__sep">/</span>
            <span><?= $categoryName ?></span>
        </nav>
        <h1 style="font-family:var(--font-display);font-size:2.5rem;margin-bottom:0.5rem;"><?= $categoryName ?></h1>
        <?php if ($categoryDesc): ?>
        <p class="text-muted" style="max-width:600px;"><?= $categoryDesc ?></p>
        <?php endif; ?>
        <p class="text-sm text-muted"><?= $totalArticles ?> <?= $t('articles') ?></p>
    </div>
</section>

<div class="container content-layout" style="margin-top:var(--spacing-2xl);">
    <main class="main-content">
        <?php if (!empty($articles)): ?>
        <div class="articles-grid" style="grid-template-columns:1fr;">
            <?php foreach ($articles as $i => $article): ?>
            <article class="article-card article-card--horizontal">
                <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                    <div class="article-card__image-wrapper" style="min-width:280px;">
                        <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                             alt="<?= $article->$titleField ?? $article->title_ku ?>" class="article-card__image" loading="lazy">
                    </div>
                </a>
                <div class="article-card__content" style="padding:var(--spacing-lg);">
                    <div class="article-card__meta">
                        <span class="article-card__date"><?= format_date($article->published_at ?? $article->created_at) ?></span>
                        <span style="color:var(--text-muted);">•</span>
                        <span><i class="far fa-clock"></i> <?= $article->reading_time ?? 3 ?> <?= $t('min_read') ?></span>
                        <span style="color:var(--text-muted);">•</span>
                        <span><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
                    </div>
                    <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                        <h2 class="article-card__title" style="font-size:1.3rem;"><?= $article->$titleField ?? $article->title_ku ?></h2>
                    </a>
                    <p class="article-card__excerpt"><?= excerpt($article->$excerptField ?? $article->excerpt_ku ?? '', 180) ?></p>
                    <div class="article-card__author">
                        <span class="text-sm"><?= $article->author_name ?? '' ?></span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
            <a href="<?= lang_url('category/' . $category->slug . '?page=' . ($currentPage - 1)) ?>" class="pagination__btn">
                <i class="fas fa-chevron-<?= is_rtl() ? 'right' : 'left' ?>"></i>
            </a>
            <?php endif; ?>
            
            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
            <a href="<?= lang_url('category/' . $category->slug . '?page=' . $i) ?>" 
               class="pagination__btn <?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            
            <?php if ($currentPage < $totalPages): ?>
            <a href="<?= lang_url('category/' . $category->slug . '?page=' . ($currentPage + 1)) ?>" class="pagination__btn">
                <i class="fas fa-chevron-<?= is_rtl() ? 'left' : 'right' ?>"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div style="text-align:center;padding:var(--spacing-2xl);">
            <i class="fas fa-newspaper" style="font-size:3rem;color:var(--text-muted);margin-bottom:1rem;"></i>
            <p class="text-muted"><?= $t('no_articles') ?></p>
        </div>
        <?php endif; ?>
    </main>
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Categories -->
        <div class="sidebar__widget">
            <h3 class="sidebar__title"><?= $t('categories') ?></h3>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                <a href="<?= lang_url('category/' . $cat->slug) ?>" 
                   class="sidebar__cat-link <?= $cat->id == $category->id ? 'active' : '' ?>"
                   style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid var(--border-color);">
                    <span><span style="color:<?= $cat->color ?? '#d4af37' ?>;margin-right:0.5rem;">●</span> <?= $cat->$catNameField ?? $cat->name_ku ?></span>
                    <span class="text-muted text-sm"><?= $cat->article_count ?? 0 ?></span>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Newsletter -->
        <div class="sidebar__widget" style="background:var(--gold);color:#1a1a2e;padding:var(--spacing-xl);border-radius:var(--radius-lg);">
            <h3 style="font-family:var(--font-display);margin-bottom:0.5rem;"><?= $t('newsletter_title') ?></h3>
            <p style="font-size:0.875rem;margin-bottom:1rem;"><?= $t('newsletter_desc') ?></p>
            <form onsubmit="return subscribeNewsletter(event)">
                <input type="email" name="email" placeholder="<?= $t('your_email') ?>" required
                       style="width:100%;padding:0.75rem;border:none;border-radius:var(--radius-md);margin-bottom:0.5rem;">
                <button type="submit" class="btn" style="width:100%;background:#1a1a2e;color:#d4af37;"><?= $t('subscribe') ?></button>
            </form>
        </div>
    </aside>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
