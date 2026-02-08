<?php
/**
 * Static Page View - Tailwind CSS Redesign
 */
include VIEW_PATH . '/frontend/partials/header.php';

$titleField = 'title_' . $lang;
$contentField = 'content_' . $lang;

$pageTitle = $page->$titleField ?: $page->title_en;
$pageContent = $page->$contentField ?: $page->content_en;
?>

<div class="max-w-container mx-auto px-4 lg:px-6 py-10 lg:py-14">
    <article class="max-w-3xl mx-auto">
        <h1 class="font-display text-3xl lg:text-4xl font-bold text-stone-900 dark:text-white text-center mb-8"><?= $pageTitle ?></h1>
        <div class="article-body text-stone-700 dark:text-stone-300 text-base lg:text-lg leading-relaxed">
            <?= $pageContent ?>
        </div>
    </article>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
