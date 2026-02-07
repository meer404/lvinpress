<?php
/**
 * LVINPress Homepage
 */
include VIEW_PATH . '/frontend/partials/header.php';

$titleField = 'title_' . $lang;
$excerptField = 'excerpt_' . $lang;
$slugField = 'slug_' . $lang;
$catNameField = 'name_' . $lang;

// Placeholder image
$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='500' viewBox='0 0 800 500'%3E%3Crect width='800' height='500' fill='%231a1a2e'/%3E%3Ctext x='400' y='250' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
?>

<!-- Hero Section -->
<?php if (!empty($featured)): ?>
<section class="hero">
    <div class="container">
        <div class="hero__grid">
            <?php $main = $featured[0]; ?>
            <a href="<?= lang_url('article/' . ($main->$slugField ?: $main->slug_en ?: $main->slug_ku)) ?>" class="hero__main">
                <img src="<?= $main->featured_image ? upload_url($main->featured_image) : $placeholder ?>" 
                     alt="<?= $main->$titleField ?? $main->title_ku ?>" class="hero__main-image" loading="eager">
                <div class="hero__main-overlay">
                    <span class="hero__main-category" style="background:<?= $main->category_color ?? '#d4af37' ?>">
                        <?= $main->category_name ?? '' ?>
                    </span>
                    <h1 class="hero__main-title"><?= $main->$titleField ?? $main->title_ku ?></h1>
                    <p class="hero__main-excerpt"><?= excerpt($main->$excerptField ?? $main->excerpt_ku ?? '', 150) ?></p>
                    <div class="hero__main-meta">
                        <span><i class="far fa-clock"></i> <?= time_ago($main->published_at ?? $main->created_at) ?></span>
                        <span><i class="far fa-eye"></i> <?= number_format($main->views ?? 0) ?> <?= $t('views') ?></span>
                    </div>
                </div>
            </a>
            
            <?php for ($i = 1; $i <= min(2, count($featured) - 1); $i++): 
                $side = $featured[$i];
            ?>
            <a href="<?= lang_url('article/' . ($side->$slugField ?: $side->slug_en ?: $side->slug_ku)) ?>" class="hero__side">
                <img src="<?= $side->featured_image ? upload_url($side->featured_image) : $placeholder ?>" 
                     alt="<?= $side->$titleField ?? $side->title_ku ?>" class="hero__side-image" loading="eager">
                <div class="hero__side-overlay">
                    <span class="hero__side-category" style="background:<?= $side->category_color ?? '#d4af37' ?>">
                        <?= $side->category_name ?? '' ?>
                    </span>
                    <h2 class="hero__side-title"><?= $side->$titleField ?? $side->title_ku ?></h2>
                </div>
            </a>
            <?php endfor; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Main Content + Sidebar -->
<div class="container">
    <div class="content-layout">
        <div class="main-content">
            <!-- Latest News -->
            <section class="fade-in">
                <div class="section-header">
                    <h2 class="section-header__title"><?= $t('latest_news') ?></h2>
                    <a href="#" class="section-header__link"><?= $t('read_more') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i></a>
                </div>
                
                <div class="articles-grid">
                    <?php foreach (($latest['items'] ?? []) as $article): ?>
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
            </section>

            <!-- Category Sections -->
            <?php foreach (($byCategories ?? []) as $catSection):
                $cat = $catSection['category'];
                $catArticles = $catSection['articles'];
                if (empty($catArticles)) continue;
            ?>
            <section class="category-section fade-in">
                <div class="section-header">
                    <h2 class="section-header__title">
                        <span class="category-section__badge" style="background:<?= $cat->color ?>">
                            <?php if ($cat->icon): ?><i class="fas fa-<?= $cat->icon ?>"></i><?php endif; ?>
                        </span>
                        <?= $cat->$catNameField ?? $cat->name_en ?>
                    </h2>
                    <a href="<?= lang_url('category/' . $cat->slug_en) ?>" class="section-header__link">
                        <?= $t('read_more') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                    </a>
                </div>
                
                <div class="articles-grid">
                    <?php foreach ($catArticles as $article): ?>
                    <article class="article-card">
                        <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                            <div class="article-card__image-wrapper">
                                <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                                     alt="<?= $article->$titleField ?? $article->title_ku ?>" 
                                     class="article-card__image" loading="lazy">
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
            </section>
            <?php endforeach; ?>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Weather & Currency Widget -->
            <div class="sidebar__widget">
                <div class="widget-grid">
                    <!-- Weather -->
                    <div class="weather-widget">
                        <div class="weather-icon">
                            <i class="fas fa-<?= $weather['condition'] ?? 'cloud' ?>"></i>
                        </div>
                        <div class="weather-info">
                            <div class="weather-temp"><?= $weather['temp'] ?? 0 ?>°C</div>
                            <div class="weather-city"><?= $weather['city'] ?? 'Erbil' ?></div>
                        </div>
                    </div>
                    <!-- Currency -->
                    <div class="currency-widget">
                        <div class="currency-row">
                            <span>🇺🇸 USD</span>
                            <span class="text-gold"><?= number_format($currency['USD_SELL'] ?? 0) ?></span>
                        </div>
                        <div class="currency-row">
                            <span>⚜️ Gold 21</span>
                            <span class="text-gold"><?= number_format($currency['gold_21'] ?? 0) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trending Widget -->
            <?php if (!empty($trending)): ?>
            <div class="sidebar__widget">
                <h3 class="sidebar__widget-title"><i class="fas fa-fire text-gold"></i> <?= $t('trending') ?></h3>
                <?php foreach (($trending) as $i => $tArticle): ?>
                <a href="<?= lang_url('article/' . ($tArticle->$slugField ?: $tArticle->slug_en ?: $tArticle->slug_ku)) ?>" class="article-card--small">
                    <div class="article-card__content">
                        <div class="article-card__number"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></div>
                        <h4 class="article-card__title"><?= $tArticle->$titleField ?? $tArticle->title_ku ?></h4>
                        <span class="text-xs text-muted"><?= time_ago($tArticle->published_at ?? $tArticle->created_at) ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Poll Widget -->
            <?php if ($poll): ?>
            <div class="sidebar__widget">
                <h3 class="sidebar__widget-title"><i class="fas fa-poll text-gold"></i> <?= $t('polls') ?></h3>
                <?php 
                $pollQuestion = $poll->{'question_' . $lang} ?? $poll->question_ku;
                $pollOptions = json_decode($poll->options, true);
                $pollVotes = json_decode($poll->votes ?? '{}', true);
                $voted = isset($_SESSION['voted_polls'][$poll->id]);
                ?>
                <p class="poll__question"><?= $pollQuestion ?></p>
                <div id="pollWidget" data-poll-id="<?= $poll->id ?>">
                    <?php foreach ($pollOptions as $idx => $option): 
                        $optText = is_array($option) ? ($option[$lang] ?? $option['ku'] ?? '') : $option;
                        $voteCount = $pollVotes[$idx] ?? 0;
                        $percentage = $poll->total_votes > 0 ? round(($voteCount / $poll->total_votes) * 100) : 0;
                    ?>
                    <?php if ($voted): ?>
                        <div class="poll__option" style="cursor:default">
                            <div style="display:flex;justify-content:space-between">
                                <span><?= $optText ?></span>
                                <span class="text-gold"><?= $percentage ?>%</span>
                            </div>
                            <div class="poll__bar">
                                <div class="poll__bar-fill" style="width:<?= $percentage ?>%"></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <button class="poll__option" onclick="votePoll(<?= $poll->id ?>, <?= $idx ?>)">
                            <?= $optText ?>
                        </button>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <p class="text-xs text-muted mt-1"><?= number_format($poll->total_votes) ?> <?= $t('vote') ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Ad Space -->
            <div class="sidebar__widget" style="text-align:center;color:var(--text-muted);">
                <p class="text-xs"><?= $t('advertisement') ?></p>
                <div style="background:var(--bg-secondary);padding:3rem 1rem;border-radius:var(--radius-md);margin-top:0.5rem;">
                    <p class="text-sm">300×250</p>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
