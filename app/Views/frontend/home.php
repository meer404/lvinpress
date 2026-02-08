<?php
/**
 * LVINPress Homepage - Advanced Tailwind CSS
 */
include VIEW_PATH . '/frontend/partials/header.php';

$titleField = 'title_' . $lang;
$excerptField = 'excerpt_' . $lang;
$slugField = 'slug_' . $lang;
$catNameField = 'name_' . $lang;

$placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='500' viewBox='0 0 800 500'%3E%3Crect width='800' height='500' fill='%231a1a2e'/%3E%3Ctext x='400' y='250' font-family='sans-serif' font-size='24' fill='%23d4af37' text-anchor='middle' dy='.3em'%3ELVINPRESS%3C/text%3E%3C/svg%3E";
?>

<!-- Hero Section -->
<?php if (!empty($featured)): ?>
<section class="py-6 lg:py-8" data-animate>
    <div class="max-w-container mx-auto px-4 lg:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
            <!-- Main Story -->
            <?php $main = $featured[0]; ?>
            <a href="<?= lang_url('article/' . ($main->$slugField ?: $main->slug_en ?: $main->slug_ku)) ?>" 
               class="spotlight-card lg:col-span-3 group relative rounded-2xl overflow-hidden aspect-[16/10] lg:aspect-auto lg:min-h-[480px] block">
                <img src="<?= $main->featured_image ? upload_url($main->featured_image) : $placeholder ?>" 
                     alt="<?= $main->$titleField ?? $main->title_ku ?>" 
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="eager">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-5 lg:p-8">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold text-white mb-3 backdrop-blur-sm" style="background:<?= $main->category_color ?? '#B80000' ?>CC">
                        <span class="w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse"></span>
                        <?= $main->category_name ?? '' ?>
                    </span>
                    <h1 class="font-display text-xl lg:text-3xl font-bold text-white leading-tight mb-3 group-hover:text-brand-gold transition-colors duration-300"><?= $main->$titleField ?? $main->title_ku ?></h1>
                    <p class="text-white/70 text-sm lg:text-base line-clamp-2 max-w-xl mb-3"><?= excerpt($main->$excerptField ?? $main->excerpt_ku ?? '', 150) ?></p>
                    <div class="flex items-center gap-4 text-white/50 text-xs">
                        <span class="flex items-center gap-1.5"><i class="far fa-clock"></i> <?= time_ago($main->published_at ?? $main->created_at) ?></span>
                        <span class="flex items-center gap-1.5"><i class="far fa-eye"></i> <?= number_format($main->views ?? 0) ?> <?= $t('views') ?></span>
                        <?php if (!empty($main->author_name)): ?>
                        <span class="flex items-center gap-1.5"><i class="far fa-user"></i> <?= $main->author_name ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>

            <!-- Side Stories 2x2 Grid -->
            <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                <?php for ($i = 1; $i <= min(4, count($featured) - 1); $i++): 
                    $side = $featured[$i];
                ?>
                <a href="<?= lang_url('article/' . ($side->$slugField ?: $side->slug_en ?: $side->slug_ku)) ?>" 
                   class="spotlight-card group relative rounded-xl overflow-hidden aspect-square block" data-animate data-animate-type="scale" style="--delay:<?= $i * 100 ?>ms">
                    <img src="<?= $side->featured_image ? upload_url($side->featured_image) : $placeholder ?>" 
                         alt="<?= $side->$titleField ?? $side->title_ku ?>" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold text-white mb-1.5 backdrop-blur-sm" style="background:<?= $side->category_color ?? '#B80000' ?>CC">
                            <?= $side->category_name ?? '' ?>
                        </span>
                        <h3 class="font-display text-sm font-bold text-white leading-snug group-hover:text-brand-gold transition-colors line-clamp-2"><?= excerpt($side->$titleField ?? $side->title_ku, 60) ?></h3>
                    </div>
                </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Main Content + Sidebar -->
<div class="max-w-container mx-auto px-4 lg:px-6 pb-12">
    <div class="content-grid grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Latest News -->
            <section data-animate>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display text-xl lg:text-2xl font-bold text-stone-900 dark:text-white flex items-center gap-2">
                        <span class="w-1 h-6 bg-gradient-to-b from-brand-red to-brand-red/40 rounded-full"></span>
                        <?= $t('latest_news') ?>
                    </h2>
                    <a href="#" class="text-sm font-medium text-brand-red hover:text-brand-gold transition-colors flex items-center gap-1 group">
                        <?= $t('read_more') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?> text-xs transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach (($latest['items'] ?? []) as $lIdx => $article): ?>
                    <article class="spotlight-card group bg-white dark:bg-dark-card rounded-xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-black/20 transition-all duration-300 hover:-translate-y-1 border border-stone-100 dark:border-white/5" data-animate data-animate-type="slide-up" style="--delay:<?= $lIdx * 80 ?>ms">
                        <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                            <div class="relative aspect-[16/10] overflow-hidden">
                                <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                                     alt="<?= $article->$titleField ?? $article->title_ku ?>" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                                <span class="absolute top-3 left-3 rtl:left-auto rtl:right-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold text-white backdrop-blur-sm" style="background:<?= $article->category_color ?? '#B80000' ?>CC">
                                    <?= $article->category_name ?? '' ?>
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </a>
                        <div class="p-4">
                            <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                                <h3 class="font-display text-base font-bold text-stone-900 dark:text-stone-100 leading-snug mb-2 group-hover:text-brand-red transition-colors line-clamp-2"><?= $article->$titleField ?? $article->title_ku ?></h3>
                            </a>
                            <p class="text-stone-500 dark:text-stone-400 text-sm line-clamp-2 mb-3"><?= excerpt($article->$excerptField ?? $article->excerpt_ku ?? '', 100) ?></p>
                            <div class="flex items-center justify-between text-xs text-stone-400 dark:text-stone-500">
                                <div class="flex items-center gap-1.5">
                                    <i class="far fa-user text-[10px]"></i>
                                    <span><?= $article->author_name ?? '' ?></span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center gap-1"><i class="far fa-clock"></i> <?= time_ago($article->published_at ?? $article->created_at) ?></span>
                                    <span class="flex items-center gap-1"><i class="far fa-eye"></i> <?= number_format($article->views ?? 0) ?></span>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Category Sections -->
            <?php foreach (($byCategories ?? []) as $catIdx => $catSection):
                $cat = $catSection['category'];
                $catArticles = $catSection['articles'];
                if (empty($catArticles)) continue;
            ?>
            <section data-animate data-animate-type="slide-<?= $catIdx % 2 === 0 ? 'left' : 'right' ?>">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display text-xl lg:text-2xl font-bold text-stone-900 dark:text-white flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs shadow-lg" style="background:<?= $cat->color ?>;box-shadow: 0 4px 14px <?= $cat->color ?>44">
                            <?php if ($cat->icon): ?><i class="fas fa-<?= $cat->icon ?>"></i><?php endif; ?>
                        </span>
                        <?= $cat->$catNameField ?? $cat->name_en ?>
                    </h2>
                    <a href="<?= lang_url('category/' . $cat->slug_en) ?>" class="text-sm font-medium hover:text-brand-gold transition-colors flex items-center gap-1 group" style="color:<?= $cat->color ?>">
                        <?= $t('read_more') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?> text-xs transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($catArticles as $cIdx => $article): ?>
                    <article class="spotlight-card group bg-white dark:bg-dark-card rounded-xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-black/20 transition-all duration-300 hover:-translate-y-1 border border-stone-100 dark:border-white/5" style="--delay:<?= $cIdx * 80 ?>ms">
                        <a href="<?= lang_url('article/' . ($article->$slugField ?: $article->slug_en ?: $article->slug_ku)) ?>">
                            <div class="relative aspect-[16/10] overflow-hidden">
                                <img src="<?= $article->featured_image ? upload_url($article->featured_image) : $placeholder ?>" 
                                     alt="<?= $article->$titleField ?? $article->title_ku ?>" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
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
            </section>
            <?php endforeach; ?>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar-col space-y-6">
            <!-- Weather & Currency Widget -->
            <div class="glass-card bg-white dark:bg-dark-card rounded-xl border border-stone-100 dark:border-white/5 overflow-hidden shadow-sm" data-animate data-animate-type="slide-right">
                <div class="grid grid-cols-2 divide-x dark:divide-white/5 rtl:divide-x-reverse">
                    <!-- Weather -->
                    <div class="p-4 flex items-center gap-3">
                        <div class="text-3xl text-brand-gold" style="animation: float-animation 3s ease-in-out infinite">
                            <i class="fas fa-<?= $weather['condition'] ?? 'cloud' ?>"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-stone-900 dark:text-white"><?= $weather['temp'] ?? 0 ?>°C</div>
                            <div class="text-xs text-stone-400"><?= $weather['city'] ?? 'Erbil' ?></div>
                        </div>
                    </div>
                    <!-- Currency -->
                    <div class="p-4 space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-stone-500 dark:text-stone-400">🇺🇸 USD</span>
                            <span class="font-semibold text-brand-gold"><?= number_format($currency['USD_SELL'] ?? 0) ?></span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-stone-500 dark:text-stone-400">⚜️ Gold</span>
                            <span class="font-semibold text-brand-gold"><?= number_format($currency['gold_21'] ?? 0) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trending Widget -->
            <?php if (!empty($trending)): ?>
            <div class="sidebar-widget glass-card bg-white dark:bg-dark-card rounded-xl border border-stone-100 dark:border-white/5 p-5 shadow-sm" data-animate data-animate-type="slide-right" style="--delay:100ms">
                <h3 class="font-display text-lg font-bold text-stone-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-fire text-brand-gold"></i> <?= $t('trending') ?>
                    <span class="text-[10px] font-normal text-brand-red bg-brand-red/10 px-2 py-0.5 rounded-full animate-pulse">LIVE</span>
                </h3>
                <div class="space-y-4">
                    <?php foreach (($trending) as $i => $tArticle): ?>
                    <a href="<?= lang_url('article/' . ($tArticle->$slugField ?: $tArticle->slug_en ?: $tArticle->slug_ku)) ?>" 
                       class="flex items-start gap-3 group" style="--delay:<?= ($i + 1) * 60 ?>ms">
                        <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-b from-stone-300 to-stone-100 dark:from-stone-600 dark:to-stone-800 font-display leading-none min-w-[2rem]"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-stone-800 dark:text-stone-200 leading-snug group-hover:text-brand-red transition-colors line-clamp-2"><?= $tArticle->$titleField ?? $tArticle->title_ku ?></h4>
                            <span class="text-xs text-stone-400 dark:text-stone-500 flex items-center gap-1.5 mt-1"><i class="far fa-clock text-[10px]"></i> <?= time_ago($tArticle->published_at ?? $tArticle->created_at) ?></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Poll Widget -->
            <?php if ($poll): ?>
            <div class="sidebar-widget glass-card bg-white dark:bg-dark-card rounded-xl border border-stone-100 dark:border-white/5 p-5 shadow-sm" data-animate data-animate-type="slide-right" style="--delay:200ms">
                <h3 class="font-display text-lg font-bold text-stone-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-poll text-brand-gold"></i> <?= $t('polls') ?>
                </h3>
                <?php 
                $pollQuestion = $poll->{'question_' . $lang} ?? $poll->question_ku;
                $pollOptions = json_decode($poll->options, true);
                $pollVotes = json_decode($poll->votes ?? '{}', true);
                $voted = isset($_SESSION['voted_polls'][$poll->id]);
                ?>
                <p class="text-sm font-medium text-stone-700 dark:text-stone-300 mb-4"><?= $pollQuestion ?></p>
                <div id="pollWidget" data-poll-id="<?= $poll->id ?>" class="space-y-2">
                    <?php foreach ($pollOptions as $idx => $option): 
                        $optText = is_array($option) ? ($option[$lang] ?? $option['ku'] ?? '') : $option;
                        $voteCount = $pollVotes[$idx] ?? 0;
                        $percentage = $poll->total_votes > 0 ? round(($voteCount / $poll->total_votes) * 100) : 0;
                    ?>
                    <?php if ($voted): ?>
                        <div class="p-3 bg-stone-50 dark:bg-dark-tertiary rounded-lg">
                            <div class="flex justify-between text-sm mb-1.5">
                                <span class="text-stone-700 dark:text-stone-300"><?= $optText ?></span>
                                <span class="font-bold text-brand-gold"><?= $percentage ?>%</span>
                            </div>
                            <div class="h-2 bg-stone-200 dark:bg-dark-primary rounded-full overflow-hidden">
                                <div class="poll-bar-fill h-full bg-gradient-to-r from-brand-gold to-brand-gold-dark rounded-full transition-all duration-1000" style="width:<?= $percentage ?>%"></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <button class="w-full text-left rtl:text-right p-3 bg-stone-50 dark:bg-dark-tertiary rounded-lg text-sm text-stone-700 dark:text-stone-300 hover:bg-brand-gold/10 hover:text-brand-gold border border-transparent hover:border-brand-gold/20 transition-all cursor-pointer group" 
                                onclick="votePoll(<?= $poll->id ?>, <?= $idx ?>)">
                            <span class="group-hover:translate-x-1 rtl:group-hover:-translate-x-1 inline-block transition-transform"><?= $optText ?></span>
                        </button>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <p class="text-xs text-stone-400 dark:text-stone-500 mt-2 flex items-center gap-1"><i class="fas fa-users text-[10px]"></i> <?= number_format($poll->total_votes) ?> <?= $t('vote') ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Ad Space -->
            <div class="text-center text-stone-400 dark:text-stone-600" data-animate>
                <p class="text-xs mb-2"><?= $t('advertisement') ?></p>
                <div class="bg-stone-50 dark:bg-dark-tertiary p-12 rounded-xl border border-stone-100 dark:border-white/5">
                    <p class="text-sm text-stone-400">300×250</p>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include VIEW_PATH . '/frontend/partials/footer.php'; ?>
