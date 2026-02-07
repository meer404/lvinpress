<?php
/**
 * Article Page - Immersive Reading Experience
 */
include VIEW_PATH . '/frontend/partials/header.php';

$titleField = 'title_' . $lang;
$contentField = 'content_' . $lang;
$excerptField = 'excerpt_' . $lang;
$slugField = 'slug_' . $lang;

$articleTitle = $article->$titleField ?: $article->title_ku;
$articleContent = $article->$contentField ?: $article->content_ku;
$articleExcerpt = $article->$excerptField ?: $article->excerpt_ku;
$articleSlug = $article->$slugField ?: $article->slug_en ?: $article->slug_ku;

$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='450' viewBox='0 0 800 450'%3E%3Crect width='800' height='450' fill='%231a1a2e'/%3E%3Ctext x='400' y='225' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
$shareUrl = urlencode(APP_URL . '/' . $lang . '/article/' . $articleSlug);
$shareTitle = urlencode($articleTitle);
?>

<article class="article-page">
    <!-- Category Badge -->
    <a href="<?= lang_url('category/' . $article->category_slug) ?>" 
       class="article-page__category" style="background:<?= $article->category_color ?? '#d4af37' ?>">
        <?= $article->category_name ?? '' ?>
    </a>
    
    <!-- Title -->
    <h1 class="article-page__title"><?= $articleTitle ?></h1>
    
    <!-- Excerpt -->
    <?php if ($articleExcerpt): ?>
    <p class="article-page__excerpt"><?= $articleExcerpt ?></p>
    <?php endif; ?>
    
    <!-- Meta -->
    <div class="article-page__meta">
        <div class="article-page__author-info">
            <img src="<?= $article->author_avatar ? upload_url($article->author_avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($article->author_name ?? 'A') . '&background=d4af37&color=1a1a2e' ?>" 
                 alt="<?= $article->author_name ?? '' ?>" class="article-page__author-avatar">
            <div>
                <div class="article-page__author-name"><?= $article->author_name ?? '' ?></div>
                <div class="article-page__author-date">
                    <?= $t('published_on') ?> <?= format_date($article->published_at ?? $article->created_at) ?>
                </div>
            </div>
        </div>
        <div class="article-page__reading-time">
            <i class="far fa-clock"></i> <?= $article->reading_time ?? 3 ?> <?= $t('min_read') ?>
        </div>
        <div style="display:flex;gap:0.5rem;align-items:center;">
            <span class="text-sm text-muted"><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
            <span class="text-sm text-muted"><i class="far fa-comment"></i> <?= count($comments ?? []) ?></span>
        </div>
        <!-- Focus Mode -->
        <button class="btn btn-outline btn-sm" onclick="document.body.classList.toggle('focus-mode')">
            <i class="fas fa-expand"></i> <?= $t('focus_mode') ?>
        </button>
        <!-- Bookmark -->
        <?php if ($currentUser): ?>
        <button class="btn btn-outline btn-sm" id="bookmarkBtn" onclick="toggleBookmark(<?= $article->id ?>)">
            <i class="fa<?= $isBookmarked ? 's' : 'r' ?> fa-bookmark"></i>
        </button>
        <?php endif; ?>
    </div>
    
    <!-- Featured Image -->
    <?php if ($article->featured_image): ?>
    <img src="<?= upload_url($article->featured_image) ?>" alt="<?= $articleTitle ?>" class="article-page__featured-image">
    <?php if ($article->featured_image_caption): ?>
    <p class="text-sm text-muted text-center mb-2"><?= $article->featured_image_caption ?></p>
    <?php endif; ?>
    <?php endif; ?>
    
    <!-- Video Embed -->
    <?php if ($article->video_url): ?>
    <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:var(--radius-lg);margin-bottom:var(--spacing-xl);">
        <iframe src="<?= str_replace('watch?v=', 'embed/', $article->video_url) ?>" 
                style="position:absolute;top:0;left:0;width:100%;height:100%;" 
                frameborder="0" allowfullscreen loading="lazy"></iframe>
    </div>
    <?php endif; ?>
    
    <!-- Audio Player -->
    <?php if ($article->audio_url): ?>
    <div style="margin-bottom:var(--spacing-xl);padding:var(--spacing-lg);background:var(--bg-secondary);border-radius:var(--radius-lg);">
        <p class="text-sm text-muted mb-1"><i class="fas fa-headphones"></i> <?= $t('audio') ?></p>
        <audio controls style="width:100%">
            <source src="<?= $article->audio_url ?>" type="audio/mpeg">
        </audio>
    </div>
    <?php endif; ?>
    
    <!-- Content -->
    <div class="article-page__content">
        <?= $articleContent ?>
    </div>
    
    <!-- Tags -->
    <?php if (!empty($tags)): ?>
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:var(--spacing-xl);">
        <?php foreach ($tags as $tag): ?>
        <a href="<?= lang_url('tag/' . $tag->slug) ?>" class="btn btn-outline btn-sm">
            #<?= $tag->{'name_' . $lang} ?? $tag->name_en ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <!-- Reactions -->
    <div class="reactions-section">
        <h3 class="text-center mb-3"><?= $t('what_do_you_think') ?></h3>
        <div class="reactions-grid">
            <?php 
            $reactionTypes = [
                'like' => ['icon' => '👍', 'label' => 'Like'],
                'love' => ['icon' => '❤️', 'label' => 'Love'],
                'wow' => ['icon' => '😮', 'label' => 'Wow'],
                'sad' => ['icon' => '😢', 'label' => 'Sad'],
                'angry' => ['icon' => '😡', 'label' => 'Angry']
            ];
            ?>
            <?php foreach ($reactionTypes as $type => $data): ?>
            <button class="reaction-btn <?= ($userReaction === $type) ? 'active' : '' ?>" 
                    onclick="reactToArticle(<?= $article->id ?>, '<?= $type ?>')"
                    data-type="<?= $type ?>">
                <span class="reaction-icon"><?= $data['icon'] ?></span>
                <span class="reaction-count" id="count-<?= $type ?>"><?= $reactions[$type] ?? 0 ?></span>
                <span class="reaction-label"><?= $data['label'] ?></span>
            </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Share Buttons -->
    <div class="share-buttons">
        <span class="text-sm text-muted" style="display:flex;align-items:center;margin-right:0.5rem;"><?= $t('share_article') ?>:</span>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" class="share-btn share-btn--facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>" class="share-btn share-btn--twitter" target="_blank"><i class="fab fa-x-twitter"></i></a>
        <a href="https://wa.me/?text=<?= $shareTitle ?>%20<?= $shareUrl ?>" class="share-btn share-btn--whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="https://t.me/share/url?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>" class="share-btn share-btn--telegram" target="_blank"><i class="fab fa-telegram"></i></a>
        <button class="share-btn share-btn--copy" onclick="navigator.clipboard.writeText(window.location.href);alert('Link copied!')"><i class="fas fa-link"></i></button>
        <button class="share-btn share-btn--print" onclick="window.print()"><i class="fas fa-print"></i></button>
    </div>
    
    <!-- Author Bio -->
    <?php if ($article->author_name): ?>
    <div class="author-bio">
        <img src="<?= $article->author_avatar ? upload_url($article->author_avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($article->author_name) . '&background=d4af37&color=1a1a2e&size=80' ?>" 
             alt="<?= $article->author_name ?>" class="author-bio__avatar">
        <div>
            <h3 class="author-bio__name"><?= $article->author_name ?></h3>
            <p class="author-bio__text"><?= $article->author_bio ?? '' ?></p>
            <div style="display:flex;gap:0.5rem;margin-top:0.5rem;">
                <?php if ($article->social_facebook): ?><a href="<?= $article->social_facebook ?>" class="text-muted"><i class="fab fa-facebook"></i></a><?php endif; ?>
                <?php if ($article->social_twitter): ?><a href="<?= $article->social_twitter ?>" class="text-muted"><i class="fab fa-x-twitter"></i></a><?php endif; ?>
                <?php if ($article->social_instagram): ?><a href="<?= $article->social_instagram ?>" class="text-muted"><i class="fab fa-instagram"></i></a><?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Related Articles -->
    <?php if (!empty($related)): ?>
    <section style="margin-top:var(--spacing-2xl);">
        <div class="section-header">
            <h2 class="section-header__title"><?= $t('related_articles') ?></h2>
        </div>
        <div class="articles-grid">
            <?php foreach ($related as $rel): ?>
            <article class="article-card">
                <a href="<?= lang_url('article/' . ($rel->$slugField ?: $rel->slug_en ?: $rel->slug_ku)) ?>">
                    <div class="article-card__image-wrapper">
                        <img src="<?= $rel->featured_image ? upload_url($rel->featured_image) : $placeholder ?>" 
                             alt="<?= $rel->$titleField ?? $rel->title_ku ?>" class="article-card__image" loading="lazy">
                    </div>
                </a>
                <div class="article-card__content">
                    <a href="<?= lang_url('article/' . ($rel->$slugField ?: $rel->slug_en ?: $rel->slug_ku)) ?>">
                        <h3 class="article-card__title"><?= $rel->$titleField ?? $rel->title_ku ?></h3>
                    </a>
                    <span class="text-xs text-muted"><?= time_ago($rel->published_at ?? $rel->created_at) ?></span>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Comments Section -->
    <?php if ($article->allow_comments): ?>
    <section class="comments" id="comments">
        <div class="section-header">
            <h2 class="section-header__title"><?= $t('comments') ?> (<?= count($comments ?? []) ?>)</h2>
        </div>
        
        <!-- Comment Form -->
        <form id="commentForm" onsubmit="return submitComment(event)" style="margin-bottom:var(--spacing-xl);">
            <input type="hidden" name="article_id" value="<?= $article->id ?>">
            <?php if (!$currentUser): ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <input type="text" name="name" class="comment-form__input" placeholder="<?= $t('your_name') ?>" required>
                <input type="email" name="email" class="comment-form__input" placeholder="<?= $t('your_email') ?>">
            </div>
            <?php endif; ?>
            <textarea name="content" class="comment-form__textarea" placeholder="<?= $t('your_comment') ?>" required></textarea>
            <button type="submit" class="btn btn-gold"><?= $t('submit_comment') ?></button>
        </form>
        <div id="commentMessage" class="flash-message flash-success" style="display:none;"></div>
        
        <!-- Comments List -->
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div class="comment__avatar">
                    <?= strtoupper(substr($comment->author_name ?? $comment->user_name ?? 'A', 0, 1)) ?>
                </div>
                <div>
                    <div class="comment__name"><?= $comment->author_name ?? $comment->user_name ?? 'Anonymous' ?></div>
                    <div class="comment__date"><?= time_ago($comment->created_at) ?></div>
                    <div class="comment__text"><?= htmlspecialchars($comment->content) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted"><?= $t('no_comments') ?></p>
        <?php endif; ?>
    </section>
    <?php endif; ?>
</article>

<!-- Schema Markup -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "headline": "<?= addslashes($articleTitle) ?>",
    "datePublished": "<?= $article->published_at ?? $article->created_at ?>",
    "dateModified": "<?= $article->updated_at ?? $article->created_at ?>",
    "author": {"@type": "Person", "name": "<?= addslashes($article->author_name ?? '') ?>"},
    "publisher": {"@type": "Organization", "name": "LVINPress"},
    "description": "<?= addslashes(excerpt($articleExcerpt ?? '', 160)) ?>"
    <?php if ($article->featured_image): ?>
    ,"image": "<?= upload_url($article->featured_image) ?>"
    <?php endif; ?>
}
</script>

<script>
function reactToArticle(articleId, type) {
    fetch('<?= APP_URL ?>/article/react', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            article_id: articleId,
            type: type
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Update counts
            for (const [rType, count] of Object.entries(data.counts)) {
                document.getElementById('count-' + rType).textContent = count;
            }
            
            // Update active state
            document.querySelectorAll('.reaction-btn').forEach(btn => {
                btn.classList.remove('active');
                if (data.action === 'added' && btn.dataset.type === type) {
                    btn.classList.add('active');
                }
            });
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
