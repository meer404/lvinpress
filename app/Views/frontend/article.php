<?php
/**
 * Article Page - Advanced Tailwind CSS
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

<div class="max-w-7xl mx-auto px-4 lg:px-6 py-8 lg:py-12">
<div class="grid grid-cols-1 lg:grid-cols-[1fr_260px] gap-10">
<article class="min-w-0" data-animate>
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav flex items-center gap-2 text-sm text-stone-400 dark:text-stone-500 mb-6 flex-wrap" data-animate>
        <a href="<?= lang_url() ?>" class="hover:text-brand-gold transition-colors"><i class="fas fa-home text-xs"></i> <?= $t('home') ?></a>
        <i class="fas fa-chevron-right text-[8px] opacity-40 rtl:rotate-180"></i>
        <a href="<?= lang_url('category/' . $article->category_slug) ?>" class="hover:text-brand-gold transition-colors"><?= $article->category_name ?? '' ?></a>
        <i class="fas fa-chevron-right text-[8px] opacity-40 rtl:rotate-180"></i>
        <span class="text-stone-300 dark:text-stone-600 truncate max-w-[200px]"><?= excerpt($articleTitle, 50) ?></span>
    </nav>

    <!-- Category Badge -->
    <a href="<?= lang_url('category/' . $article->category_slug) ?>" 
       class="inline-flex items-center gap-1.5 px-4 py-1 rounded-full text-xs font-bold text-white mb-4 hover:opacity-90 transition-opacity backdrop-blur-sm" style="background:<?= $article->category_color ?? '#B80000' ?>CC">
        <span class="w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse"></span>
        <?= $article->category_name ?? '' ?>
    </a>
    
    <!-- Title -->
    <h1 class="font-display text-3xl lg:text-4xl xl:text-5xl font-bold text-stone-900 dark:text-white leading-tight mb-4"><?= $articleTitle ?></h1>
    
    <!-- Excerpt -->
    <?php if ($articleExcerpt): ?>
    <p class="text-lg text-stone-500 dark:text-stone-400 leading-relaxed mb-6 max-w-3xl"><?= $articleExcerpt ?></p>
    <?php endif; ?>
    
    <!-- Meta Bar -->
    <div class="article-meta-bar flex flex-wrap items-center gap-4 py-4 border-y border-stone-100 dark:border-white/5 mb-8">
        <div class="flex items-center gap-3">
            <img src="<?= $article->author_avatar ? upload_url($article->author_avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($article->author_name ?? 'A') . '&background=d4af37&color=1a1a2e' ?>" 
                 alt="<?= $article->author_name ?? '' ?>" class="w-10 h-10 rounded-full object-cover ring-2 ring-brand-gold/20">
            <div>
                <div class="text-sm font-semibold text-stone-800 dark:text-stone-200"><?= $article->author_name ?? '' ?></div>
                <div class="text-xs text-stone-400 dark:text-stone-500"><?= $t('published_on') ?> <?= format_date($article->published_at ?? $article->created_at) ?></div>
            </div>
        </div>
        <div class="flex items-center gap-4 ml-auto text-sm text-stone-400 dark:text-stone-500">
            <span class="flex items-center gap-1"><i class="far fa-clock"></i> <?= $article->reading_time ?? 3 ?> <?= $t('min_read') ?></span>
            <span class="flex items-center gap-1"><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
            <span class="flex items-center gap-1"><i class="far fa-comment"></i> <?= count($comments ?? []) ?></span>
        </div>
        <div class="flex items-center gap-2">
            <button class="px-3 py-1.5 text-xs font-medium border border-stone-200 dark:border-white/10 rounded-full hover:border-brand-gold hover:text-brand-gold transition-all" onclick="document.body.classList.toggle('focus-mode')">
                <i class="fas fa-expand"></i> <?= $t('focus_mode') ?>
            </button>
            <?php if ($currentUser): ?>
            <button class="px-3 py-1.5 text-xs font-medium border border-stone-200 dark:border-white/10 rounded-full hover:border-brand-gold hover:text-brand-gold transition-all" id="bookmarkBtn" onclick="toggleBookmark(<?= $article->id ?>)">
                <i class="fa<?= $isBookmarked ? 's' : 'r' ?> fa-bookmark"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Featured Image -->
    <?php if ($article->featured_image): ?>
    <figure class="mb-8">
        <img src="<?= upload_url($article->featured_image) ?>" alt="<?= $articleTitle ?>" class="w-full rounded-2xl shadow-lg max-h-[500px] object-cover cursor-zoom-in img-reveal" onclick="openLightbox(this.src)">
        <?php if ($article->featured_image_caption): ?>
        <figcaption class="text-sm text-stone-400 dark:text-stone-500 text-center mt-2"><?= $article->featured_image_caption ?></figcaption>
        <?php endif; ?>
    </figure>
    <?php endif; ?>
    
    <!-- Video Embed -->
    <?php if ($article->video_url): ?>
    <div class="relative pb-[56.25%] h-0 overflow-hidden rounded-2xl mb-8 shadow-lg">
        <iframe src="<?= str_replace('watch?v=', 'embed/', $article->video_url) ?>" 
                class="absolute top-0 left-0 w-full h-full" frameborder="0" allowfullscreen loading="lazy"></iframe>
    </div>
    <?php endif; ?>
    
    <!-- Audio Player -->
    <?php if ($article->audio_url): ?>
    <div class="mb-8 p-5 bg-gradient-to-r from-stone-50 to-stone-100 dark:from-dark-tertiary dark:to-dark-card rounded-xl border border-stone-100 dark:border-white/5">
        <p class="text-sm text-stone-400 dark:text-stone-500 mb-3 flex items-center gap-2"><i class="fas fa-headphones text-brand-gold"></i> <?= $t('audio') ?></p>
        <audio controls class="w-full">
            <source src="<?= $article->audio_url ?>" type="audio/mpeg">
        </audio>
    </div>
    <?php endif; ?>
    
    <!-- Content -->
    <div class="article-body text-stone-700 dark:text-stone-300 text-base lg:text-lg leading-relaxed mb-10">
        <?= $articleContent ?>
    </div>
    
    <!-- Tags -->
    <?php if (!empty($tags)): ?>
    <div class="flex flex-wrap gap-2 mb-10" data-animate>
        <span class="text-sm text-stone-400 dark:text-stone-500 flex items-center gap-1 mr-1"><i class="fas fa-tags text-brand-gold text-xs"></i></span>
        <?php foreach ($tags as $tag): ?>
        <a href="<?= lang_url('tag/' . $tag->slug) ?>" class="px-4 py-1.5 text-sm font-medium border border-stone-200 dark:border-white/10 rounded-full text-stone-600 dark:text-stone-400 hover:border-brand-gold hover:text-brand-gold hover:bg-brand-gold/5 transition-all">
            #<?= $tag->{'name_' . $lang} ?? $tag->name_en ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <!-- Reactions -->
    <div class="py-8 border-y border-stone-100 dark:border-white/5 mb-8" data-animate>
        <h3 class="font-display text-lg font-bold text-center text-stone-900 dark:text-white mb-5"><?= $t('what_do_you_think') ?></h3>
        <div class="flex items-center justify-center gap-3 flex-wrap">
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
            <button class="flex flex-col items-center gap-1 p-3 rounded-xl hover:bg-stone-50 dark:hover:bg-dark-tertiary transition-all group cursor-pointer <?= ($userReaction === $type) ? 'bg-brand-gold/5 ring-2 ring-brand-gold/20' : '' ?>" 
                    onclick="reactToArticle(<?= $article->id ?>, '<?= $type ?>')" data-type="<?= $type ?>">
                <span class="text-2xl group-hover:scale-125 group-active:scale-90 transition-transform"><?= $data['icon'] ?></span>
                <span class="text-xs font-bold text-stone-800 dark:text-stone-200" id="count-<?= $type ?>"><?= $reactions[$type] ?? 0 ?></span>
                <span class="text-[10px] text-stone-400"><?= $data['label'] ?></span>
            </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Share Buttons -->
    <div class="share-section share-btn-group flex items-center gap-3 flex-wrap mb-10" data-animate>
        <span class="text-sm text-stone-400 dark:text-stone-500 flex items-center gap-1.5"><i class="fas fa-share-alt text-brand-gold"></i> <?= $t('share_article') ?>:</span>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" class="w-10 h-10 rounded-xl bg-[#1877f2]/10 text-[#1877f2] flex items-center justify-center hover:bg-[#1877f2] hover:text-white hover:shadow-lg hover:shadow-[#1877f2]/30 hover:-translate-y-0.5 transition-all" target="_blank"><i class="fab fa-facebook-f text-sm"></i></a>
        <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>" class="w-10 h-10 rounded-xl bg-stone-900/10 text-stone-700 dark:bg-white/5 dark:text-stone-300 flex items-center justify-center hover:bg-stone-900 hover:text-white hover:shadow-lg hover:-translate-y-0.5 transition-all" target="_blank"><i class="fab fa-x-twitter text-sm"></i></a>
        <a href="https://wa.me/?text=<?= $shareTitle ?>%20<?= $shareUrl ?>" class="w-10 h-10 rounded-xl bg-[#25d366]/10 text-[#25d366] flex items-center justify-center hover:bg-[#25d366] hover:text-white hover:shadow-lg hover:shadow-[#25d366]/30 hover:-translate-y-0.5 transition-all" target="_blank"><i class="fab fa-whatsapp text-sm"></i></a>
        <a href="https://t.me/share/url?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>" class="w-10 h-10 rounded-xl bg-[#0088cc]/10 text-[#0088cc] flex items-center justify-center hover:bg-[#0088cc] hover:text-white hover:shadow-lg hover:shadow-[#0088cc]/30 hover:-translate-y-0.5 transition-all" target="_blank"><i class="fab fa-telegram text-sm"></i></a>
        <button class="w-10 h-10 rounded-xl bg-stone-100 dark:bg-dark-tertiary text-stone-500 dark:text-stone-400 flex items-center justify-center hover:bg-brand-gold hover:text-stone-900 hover:-translate-y-0.5 transition-all" onclick="copyArticleLink()"><i class="fas fa-link text-sm"></i></button>
        <button class="w-10 h-10 rounded-xl bg-stone-100 dark:bg-dark-tertiary text-stone-500 dark:text-stone-400 flex items-center justify-center hover:bg-brand-gold hover:text-stone-900 hover:-translate-y-0.5 transition-all" onclick="window.print()"><i class="fas fa-print text-sm"></i></button>
    </div>
    
    <!-- Author Bio -->
    <?php if ($article->author_name): ?>
    <div class="author-bio-section flex items-start gap-5 p-6 bg-gradient-to-br from-stone-50 to-stone-100 dark:from-dark-card dark:to-dark-tertiary rounded-2xl border border-stone-100 dark:border-white/5 mb-10" data-animate>
        <img src="<?= $article->author_avatar ? upload_url($article->author_avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($article->author_name) . '&background=d4af37&color=1a1a2e&size=80' ?>" 
             alt="<?= $article->author_name ?>" class="w-16 h-16 rounded-full object-cover ring-2 ring-brand-gold/20 shrink-0">
        <div>
            <h3 class="font-display text-lg font-bold text-stone-900 dark:text-white mb-1"><?= $article->author_name ?></h3>
            <p class="text-sm text-stone-500 dark:text-stone-400 leading-relaxed"><?= $article->author_bio ?? '' ?></p>
            <div class="flex gap-3 mt-3">
                <?php if ($article->social_facebook): ?><a href="<?= $article->social_facebook ?>" class="text-stone-400 hover:text-[#1877f2] transition-colors"><i class="fab fa-facebook"></i></a><?php endif; ?>
                <?php if ($article->social_twitter): ?><a href="<?= $article->social_twitter ?>" class="text-stone-400 hover:text-stone-800 dark:hover:text-white transition-colors"><i class="fab fa-x-twitter"></i></a><?php endif; ?>
                <?php if ($article->social_instagram): ?><a href="<?= $article->social_instagram ?>" class="text-stone-400 hover:text-pink-500 transition-colors"><i class="fab fa-instagram"></i></a><?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Related Articles -->
    <?php if (!empty($related)): ?>
    <section class="mb-10" data-animate>
        <h2 class="font-display text-xl font-bold text-stone-900 dark:text-white flex items-center gap-2 mb-6">
            <span class="w-1 h-6 bg-gradient-to-b from-brand-red to-brand-red/40 rounded-full"></span>
            <?= $t('related_articles') ?>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($related as $rIdx => $rel): ?>
            <article class="spotlight-card group bg-white dark:bg-dark-card rounded-xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-black/20 transition-all duration-300 hover:-translate-y-1 border border-stone-100 dark:border-white/5" style="--delay:<?= $rIdx * 80 ?>ms">
                <a href="<?= lang_url('article/' . ($rel->$slugField ?: $rel->slug_en ?: $rel->slug_ku)) ?>">
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img src="<?= $rel->featured_image ? upload_url($rel->featured_image) : $placeholder ?>" 
                             alt="<?= $rel->$titleField ?? $rel->title_ku ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                </a>
                <div class="p-4">
                    <a href="<?= lang_url('article/' . ($rel->$slugField ?: $rel->slug_en ?: $rel->slug_ku)) ?>">
                        <h3 class="font-display text-base font-bold text-stone-900 dark:text-stone-100 leading-snug mb-2 group-hover:text-brand-red transition-colors line-clamp-2"><?= $rel->$titleField ?? $rel->title_ku ?></h3>
                    </a>
                    <span class="text-xs text-stone-400 dark:text-stone-500 flex items-center gap-1"><i class="far fa-clock text-[10px]"></i> <?= time_ago($rel->published_at ?? $rel->created_at) ?></span>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Comments Section -->
    <?php if ($article->allow_comments): ?>
    <section class="comments-section" id="comments" data-animate>
        <h2 class="font-display text-xl font-bold text-stone-900 dark:text-white flex items-center gap-2 mb-6">
            <span class="w-1 h-6 bg-gradient-to-b from-brand-red to-brand-red/40 rounded-full"></span>
            <?= $t('comments') ?> <span class="text-sm font-normal text-stone-400">(<?= count($comments ?? []) ?>)</span>
        </h2>
        
        <!-- Comment Form -->
        <form id="commentForm" onsubmit="return submitComment(event)" class="mb-8 space-y-4 p-6 bg-stone-50 dark:bg-dark-card rounded-2xl border border-stone-100 dark:border-white/5">
            <input type="hidden" name="article_id" value="<?= $article->id ?>">
            <?php if (!$currentUser): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="relative">
                    <input type="text" name="name" placeholder=" " required id="commentName"
                           class="peer w-full px-4 py-3 pt-5 bg-white dark:bg-dark-tertiary border border-stone-200 dark:border-white/10 rounded-xl text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/10 transition-all">
                    <label for="commentName" class="floating-label"><?= $t('your_name') ?></label>
                </div>
                <div class="relative">
                    <input type="email" name="email" placeholder=" " id="commentEmail"
                           class="peer w-full px-4 py-3 pt-5 bg-white dark:bg-dark-tertiary border border-stone-200 dark:border-white/10 rounded-xl text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/10 transition-all">
                    <label for="commentEmail" class="floating-label"><?= $t('your_email') ?></label>
                </div>
            </div>
            <?php endif; ?>
            <textarea name="content" placeholder="<?= $t('your_comment') ?>" required rows="4"
                      class="w-full px-4 py-3 bg-white dark:bg-dark-tertiary border border-stone-200 dark:border-white/10 rounded-xl text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/10 transition-all resize-y"></textarea>
            <button type="submit" class="magnetic-btn px-6 py-2.5 bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 font-bold rounded-full text-sm shadow-md shadow-brand-gold/20 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <?= $t('submit_comment') ?> <i class="fas fa-paper-plane text-xs ml-1"></i>
            </button>
        </form>
        <div id="commentMessage" class="hidden p-4 rounded-xl text-sm mb-6"></div>
        
        <!-- Comments List -->
        <div class="space-y-5">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                <div class="flex gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-gold to-brand-gold-dark text-stone-900 flex items-center justify-center font-bold text-sm shrink-0 shadow-md shadow-brand-gold/20">
                        <?= strtoupper(substr($comment->author_name ?? $comment->user_name ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="flex-1 min-w-0 p-4 rounded-xl bg-stone-50 dark:bg-dark-card border border-stone-100 dark:border-white/5 group-hover:border-brand-gold/20 transition-colors">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm font-semibold text-stone-800 dark:text-stone-200"><?= $comment->author_name ?? $comment->user_name ?? 'Anonymous' ?></span>
                            <span class="text-xs text-stone-400 dark:text-stone-500"><?= time_ago($comment->created_at) ?></span>
                        </div>
                        <p class="text-sm text-stone-600 dark:text-stone-400 leading-relaxed"><?= htmlspecialchars($comment->content) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <i class="far fa-comment-dots text-4xl text-stone-200 dark:text-stone-700 mb-3"></i>
                    <p class="text-stone-400 dark:text-stone-500 text-sm"><?= $t('no_comments') ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>
</article>

<!-- Sidebar: Table of Contents -->
<aside class="article-toc hidden lg:block">
    <div class="sticky top-24" id="tableOfContents">
        <h4 class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-stone-500 mb-3 flex items-center gap-2">
            <i class="fas fa-list-ul text-brand-gold"></i> <?= $lang === 'ku' ? 'ناوەڕۆک' : 'Contents' ?>
        </h4>
        <nav id="tocNav" class="space-y-1 text-sm max-h-[60vh] overflow-y-auto"></nav>
    </div>
</aside>
</div><!-- /grid -->
</div><!-- /container -->

<!-- Image Lightbox -->
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox()">
    <button class="absolute top-6 right-6 w-10 h-10 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white hover:bg-white/20 transition-all z-10" onclick="closeLightbox()">
        <i class="fas fa-times"></i>
    </button>
    <img id="lightboxImg" src="" class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg shadow-2xl" onclick="event.stopPropagation()">
</div>

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
// Reactions
function reactToArticle(articleId, type) {
    fetch('<?= APP_URL ?>/article/react', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ article_id: articleId, type: type })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            for (const [rType, count] of Object.entries(data.counts)) {
                const el = document.getElementById('count-' + rType);
                if (el) el.textContent = count;
            }
            document.querySelectorAll('[data-type]').forEach(btn => {
                btn.classList.remove('bg-brand-gold/5', 'ring-2', 'ring-brand-gold/20');
                if (data.action === 'added' && btn.dataset.type === type) {
                    btn.classList.add('bg-brand-gold/5', 'ring-2', 'ring-brand-gold/20');
                    btn.querySelector('span:first-child').style.animation = 'scale-in 0.3s ease';
                }
            });
        }
    })
    .catch(error => console.error('Error:', error));
}

// Lightbox
function openLightbox(src) {
    const lb = document.getElementById('lightbox');
    document.getElementById('lightboxImg').src = src;
    lb.classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

// TOC Generation
(function() {
    const body = document.querySelector('.article-body');
    const tocNav = document.getElementById('tocNav');
    if (!body || !tocNav) return;
    
    const headings = body.querySelectorAll('h2, h3');
    if (headings.length < 2) {
        const tocContainer = document.getElementById('tableOfContents');
        if (tocContainer) tocContainer.style.display = 'none';
        return;
    }
    
    headings.forEach((h, i) => {
        const id = 'heading-' + i;
        h.id = id;
        const link = document.createElement('a');
        link.href = '#' + id;
        link.className = 'toc-link' + (h.tagName === 'H3' ? ' toc-link-depth-2' : '');
        link.textContent = h.textContent;
        tocNav.appendChild(link);
    });
    
    // Scroll spy
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                tocNav.querySelectorAll('.toc-link').forEach(l => l.classList.remove('active'));
                const link = tocNav.querySelector('a[href="#' + entry.target.id + '"]');
                if (link) link.classList.add('active');
            }
        });
    }, { rootMargin: '-80px 0px -70% 0px' });
    
    headings.forEach(h => observer.observe(h));
})();
</script>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
