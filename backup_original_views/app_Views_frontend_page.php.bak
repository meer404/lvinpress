<?php
/**
 * Static Page View
 */
include VIEW_PATH . '/frontend/partials/header.php';

$titleField = 'title_' . $lang;
$contentField = 'content_' . $lang;

$pageTitle = $page->$titleField ?: $page->title_en;
$pageContent = $page->$contentField ?: $page->content_en;
?>

<div class="container" style="padding-top:var(--spacing-2xl);padding-bottom:var(--spacing-2xl);">
    <article class="article-page" style="max-width:800px;margin:0 auto;">
        <h1 class="article-page__title" style="text-align:center;margin-bottom:var(--spacing-xl);"><?= $pageTitle ?></h1>
        
        <div class="article-page__content">
            <?= $pageContent ?>
        </div>
    </article>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
