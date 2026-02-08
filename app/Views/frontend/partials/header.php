<?php
/**
 * Main Frontend Layout - Advanced Tailwind CSS
 * Mega-menu, Command Palette, Animated Brand, Enhanced Interactions
 */
$theme = $_COOKIE['theme'] ?? 'light';
$langName = ($langNames[$lang] ?? 'کوردی');
$siteName = $settings->{'site_name_' . $lang} ?? 'LVINPress';
$categories = $categories ?? [];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>" data-theme="<?= $theme ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a2e">
    <?= generate_meta_tags($meta ?? []) ?>
    
    <!-- Alternate languages -->
    <link rel="alternate" hreflang="ku" href="<?= url('ku') ?>">
    <link rel="alternate" hreflang="en" href="<?= url('en') ?>">
    <link rel="alternate" hreflang="ar" href="<?= url('ar') ?>">
    
    <!-- RSS -->
    <link rel="alternate" type="application/rss+xml" title="<?= $siteName ?> RSS" href="<?= url("feed/{$lang}/rss") ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Inter:wght@300;400;500;600;700;800&family=Noto+Naskh+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: ['selector', '[data-theme="dark"]'],
        theme: {
            extend: {
                colors: {
                    brand: {
                        red: '#B80000',
                        'red-light': '#FF4D4D',
                        'red-dark': '#8A0000',
                        gold: '#d4af37',
                        'gold-light': '#e8cc6e',
                        'gold-dark': '#b8962e',
                    },
                    dark: {
                        primary: '#0c0c14',
                        secondary: '#161625',
                        tertiary: '#1e1e32',
                        card: '#1a1a2e',
                    }
                },
                fontFamily: {
                    display: ['Playfair Display', 'Noto Naskh Arabic', 'Georgia', 'serif'],
                    body: ['Inter', 'Noto Sans Arabic', 'system-ui', 'sans-serif'],
                },
                maxWidth: {
                    'container': '1400px',
                },
                animation: {
                    'fade-in': 'fadeIn 0.6s ease-out forwards',
                    'slide-up': 'slideUp 0.4s ease-out forwards',
                    'slide-down': 'slideDown 0.3s ease-out forwards',
                    'scale-in': 'scaleIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards',
                    'spin-slow': 'spin 3s linear infinite',
                },
                keyframes: {
                    fadeIn: {
                        '0%': { opacity: '0' },
                        '100%': { opacity: '1' },
                    },
                    slideUp: {
                        '0%': { opacity: '0', transform: 'translateY(20px)' },
                        '100%': { opacity: '1', transform: 'translateY(0)' },
                    },
                    slideDown: {
                        '0%': { opacity: '0', transform: 'translateY(-10px)' },
                        '100%': { opacity: '1', transform: 'translateY(0)' },
                    },
                    scaleIn: {
                        '0%': { opacity: '0', transform: 'scale(0.9)' },
                        '100%': { opacity: '1', transform: 'scale(1)' },
                    },
                }
            }
        }
    }
    </script>
    
    <!-- Custom CSS (animations, article content, etc.) -->
    <link rel="stylesheet" href="<?= asset('css/tailwind-custom.css') ?>">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="<?= url('manifest.json') ?>">
    
    <?= $settings->header_scripts ?? '' ?>
</head>
<body class="font-body bg-white dark:bg-dark-primary text-stone-900 dark:text-stone-100 antialiased overflow-x-hidden leading-relaxed page-transition-enter">
    
    <!-- Breaking News Ticker -->
    <?php if (!empty($breakingNews)): ?>
    <div class="news-ticker bg-gradient-to-r from-stone-950 via-dark-card to-stone-950 text-white h-9 flex items-center overflow-hidden relative z-50 border-b border-brand-red/30 text-sm">
        <div class="bg-gradient-to-r from-brand-red to-brand-red-dark text-white px-4 h-full flex items-center font-bold text-xs uppercase tracking-wider whitespace-nowrap relative z-10 gap-2">
            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
            <?= $t('breaking_news') ?>
            <span class="absolute -right-3 top-0 border-l-[12px] border-l-brand-red-dark border-t-[18px] border-t-transparent border-b-[18px] border-b-transparent rtl:right-auto rtl:-left-3 rtl:border-l-0 rtl:border-r-[12px] rtl:border-r-brand-red-dark"></span>
        </div>
        <div class="flex-1 overflow-hidden px-8">
            <div class="ticker-track flex whitespace-nowrap">
                <?php foreach ($breakingNews as $bn): ?>
                    <?php $bnText = $bn->{'text_' . $lang} ?? $bn->text_ku; ?>
                    <a href="<?= $bn->link ?: '#' ?>" class="px-12 text-sm flex items-center gap-2 hover:text-brand-gold transition-colors before:content-['●'] before:text-brand-gold before:text-[8px]"><?= $bnText ?></a>
                <?php endforeach; ?>
                <?php foreach ($breakingNews as $bn): ?>
                    <?php $bnText = $bn->{'text_' . $lang} ?? $bn->text_ku; ?>
                    <a href="<?= $bn->link ?: '#' ?>" class="px-12 text-sm flex items-center gap-2 hover:text-brand-gold transition-colors before:content-['●'] before:text-brand-gold before:text-[8px]"><?= $bnText ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <header class="header-main glass dark:!bg-dark-primary/90 border-b border-stone-100/80 dark:border-white/5 sticky top-0 z-[1000] transition-all duration-500" id="header">
        <!-- Gradient accent line -->
        <div class="h-[2px] bg-gradient-to-r from-transparent via-brand-gold to-transparent opacity-50"></div>
        
        <div class="max-w-container mx-auto px-4 lg:px-6">
            <!-- Top Bar -->
            <div class="flex items-center justify-between py-3 border-b border-stone-100 dark:border-white/5">
                <a href="<?= lang_url() ?>" class="flex items-center gap-3 group">
                    <div>
                        <div class="font-display text-2xl font-black tracking-wide relative">
                            <span class="text-shimmer">LVINPRESS</span>
                            <span class="absolute -bottom-0.5 left-0 w-0 group-hover:w-full h-0.5 bg-gradient-to-r from-brand-gold to-brand-red rounded transition-all duration-500"></span>
                        </div>
                        <div class="text-[10px] text-stone-400 dark:text-stone-500 uppercase tracking-[0.15em]"><?= $settings->{'site_description_' . $lang} ?? 'Premium News' ?></div>
                    </div>
                </a>
                
                <div class="flex items-center gap-2">
                    <!-- Language Switcher -->
                    <div class="flex items-center gap-0.5 bg-stone-100/80 dark:bg-dark-tertiary rounded-full p-0.5">
                        <a href="<?= url('ku') ?>" class="px-3 py-1.5 rounded-full text-sm font-medium transition-all duration-300 <?= $lang === 'ku' ? 'bg-gradient-to-r from-brand-red to-brand-red-dark text-white shadow-md shadow-brand-red/20' : 'text-stone-500 dark:text-stone-400 hover:text-stone-700 dark:hover:text-stone-200' ?>">کو</a>
                        <a href="<?= url('en') ?>" class="px-3 py-1.5 rounded-full text-sm font-medium transition-all duration-300 <?= $lang === 'en' ? 'bg-gradient-to-r from-brand-red to-brand-red-dark text-white shadow-md shadow-brand-red/20' : 'text-stone-500 dark:text-stone-400 hover:text-stone-700 dark:hover:text-stone-200' ?>">EN</a>
                        <a href="<?= url('ar') ?>" class="px-3 py-1.5 rounded-full text-sm font-medium transition-all duration-300 <?= $lang === 'ar' ? 'bg-gradient-to-r from-brand-red to-brand-red-dark text-white shadow-md shadow-brand-red/20' : 'text-stone-500 dark:text-stone-400 hover:text-stone-700 dark:hover:text-stone-200' ?>">عر</a>
                    </div>
                    
                    <!-- Command Palette Trigger -->
                    <button class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-stone-100/80 dark:bg-dark-tertiary rounded-full text-xs text-stone-400 dark:text-stone-500 hover:text-stone-600 dark:hover:text-stone-300 transition-all group" id="cmdPaletteTrigger">
                        <i class="fas fa-search text-[10px]"></i>
                        <span><?= $t('search') ?>...</span>
                        <kbd class="ml-1 px-1.5 py-0.5 bg-white dark:bg-dark-card rounded text-[10px] font-mono border border-stone-200 dark:border-white/10 group-hover:border-brand-gold/30 transition-colors">⌘K</kbd>
                    </button>

                    <!-- Search (mobile) -->
                    <button class="sm:hidden w-10 h-10 rounded-full flex items-center justify-center text-stone-500 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-dark-tertiary hover:text-brand-red transition-all" id="searchToggle" aria-label="<?= $t('search') ?>">
                        <i class="fas fa-search"></i>
                    </button>
                    
                    <!-- Theme Toggle -->
                    <button class="w-10 h-10 rounded-full flex items-center justify-center text-stone-500 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-dark-tertiary hover:text-brand-gold transition-all relative overflow-hidden" id="themeToggle" aria-label="Toggle theme">
                        <i class="fas fa-moon text-sm transition-all duration-300" id="themeIcon"></i>
                    </button>
                    
                    <!-- Auth -->
                    <?php if ($currentUser): ?>
                        <?php if (in_array($currentUser->role, ['admin', 'editor'])): ?>
                            <a href="<?= url('admin') ?>" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold border border-stone-200 dark:border-white/10 rounded-full hover:border-brand-gold hover:text-brand-gold hover:shadow-md hover:shadow-brand-gold/10 transition-all duration-300">
                                <i class="fas fa-gauge-high text-xs"></i> <?= $t('admin_panel') ?>
                            </a>
                        <?php endif; ?>
                        <a href="<?= url('logout') ?>" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold border border-stone-200 dark:border-white/10 rounded-full hover:border-red-400 hover:text-red-500 transition-all">
                            <i class="fas fa-sign-out-alt text-xs"></i> <?= $t('logout') ?>
                        </a>
                    <?php else: ?>
                        <a href="<?= url('login') ?>" class="hidden sm:inline-flex magnetic-btn items-center gap-1.5 px-5 py-2 text-sm font-semibold bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 rounded-full shadow-md shadow-brand-gold/20 hover:shadow-lg hover:shadow-brand-gold/30 hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-user text-xs"></i> <?= $t('login') ?>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Mobile Menu -->
                    <button class="hamburger lg:hidden w-10 h-10 rounded-full flex flex-col items-center justify-center gap-1.5 hover:bg-stone-100 dark:hover:bg-dark-tertiary transition-colors" id="mobileMenuToggle" aria-label="Menu">
                        <span class="w-5 h-0.5 bg-stone-600 dark:bg-stone-300 rounded-full"></span>
                        <span class="w-5 h-0.5 bg-stone-600 dark:bg-stone-300 rounded-full"></span>
                        <span class="w-5 h-0.5 bg-stone-600 dark:bg-stone-300 rounded-full"></span>
                    </button>
                </div>
            </div>
            
            <!-- Navigation with Mega Menu -->
            <nav class="hidden lg:flex items-center gap-0.5 py-2 overflow-x-auto relative" id="mainNav">
                <a href="<?= lang_url() ?>" class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200
                    <?= ($_SERVER['REQUEST_URI'] === '/' . $lang || $_SERVER['REQUEST_URI'] === '/' . $lang . '/') ? 'bg-brand-red/10 text-brand-red dark:text-brand-red-light font-semibold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-dark-tertiary hover:text-brand-red' ?>">
                    <i class="fas fa-home text-xs opacity-70"></i> <?= $t('home') ?>
                </a>
                <?php
                $catModel = new \App\Models\Category();
                $menuCats = $catModel->getMenu($lang);
                foreach ($menuCats as $cat):
                    $catName = $cat->{'name_' . $lang} ?? $cat->name_en;
                ?>
                <a href="<?= lang_url('category/' . $cat->slug_en) ?>" 
                   class="nav-cat-link group px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-dark-tertiary hover:text-brand-red transition-all duration-200 relative"
                   data-cat-color="<?= $cat->color ?? '#B80000' ?>">
                    <span class="relative z-10"><?= $catName ?></span>
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 group-hover:w-3/4 h-0.5 rounded-full transition-all duration-300" style="background:<?= $cat->color ?? '#B80000' ?>"></span>
                </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-nav fixed inset-0 z-[999] pointer-events-none lg:hidden" id="mobileNavDrawer">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="mobileNavOverlay"></div>
        <nav class="absolute top-0 right-0 rtl:right-auto rtl:left-0 w-80 h-full bg-white dark:bg-dark-card shadow-2xl transform translate-x-full rtl:-translate-x-full transition-transform duration-300 overflow-y-auto" id="mobileNavPanel">
            <!-- Mobile nav header -->
            <div class="sticky top-0 bg-white/90 dark:bg-dark-card/90 backdrop-blur-lg z-10 flex items-center justify-between px-5 py-4 border-b border-stone-100 dark:border-white/5">
                <span class="font-display text-lg font-bold text-shimmer">LVINPRESS</span>
                <button id="mobileNavClose" class="w-9 h-9 rounded-full flex items-center justify-center hover:bg-stone-100 dark:hover:bg-dark-tertiary transition-colors">
                    <i class="fas fa-times text-stone-400"></i>
                </button>
            </div>
            
            <!-- Mobile search -->
            <div class="px-4 pt-4 pb-2">
                <form action="<?= lang_url('search') ?>" method="GET" class="relative">
                    <input type="text" name="q" placeholder="<?= $t('search') ?>..." class="w-full pl-10 rtl:pl-4 rtl:pr-10 pr-4 py-2.5 bg-stone-50 dark:bg-dark-tertiary border border-stone-200 dark:border-white/10 rounded-xl text-sm outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/10 transition-all">
                    <i class="fas fa-search absolute left-3.5 rtl:left-auto rtl:right-3.5 top-1/2 -translate-y-1/2 text-stone-300 dark:text-stone-600 text-sm"></i>
                </form>
            </div>
            
            <div class="px-3 py-2 space-y-0.5">
                <a href="<?= lang_url() ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-stone-700 dark:text-stone-300 hover:bg-stone-50 dark:hover:bg-dark-tertiary transition-colors">
                    <i class="fas fa-home w-5 text-center text-brand-gold text-sm"></i> <?= $t('home') ?>
                </a>
                <?php foreach ($menuCats as $cat): ?>
                <a href="<?= lang_url('category/' . $cat->slug_en) ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-stone-700 dark:text-stone-300 hover:bg-stone-50 dark:hover:bg-dark-tertiary transition-colors">
                    <span class="w-2.5 h-2.5 rounded-md" style="background:<?= $cat->color ?? '#d4af37' ?>"></span>
                    <?= $cat->{'name_' . $lang} ?? $cat->name_en ?>
                </a>
                <?php endforeach; ?>
            </div>
            
            <div class="border-t border-stone-100 dark:border-white/10 mx-4 my-2 pt-3">
                <?php if ($currentUser): ?>
                    <?php if (in_array($currentUser->role, ['admin', 'editor'])): ?>
                    <a href="<?= url('admin') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-stone-700 dark:text-stone-300 hover:bg-stone-50 dark:hover:bg-dark-tertiary">
                        <i class="fas fa-gauge-high w-5 text-center text-brand-gold text-sm"></i> <?= $t('admin_panel') ?>
                    </a>
                    <?php endif; ?>
                    <a href="<?= url('logout') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                        <i class="fas fa-sign-out-alt w-5 text-center text-sm"></i> <?= $t('logout') ?>
                    </a>
                <?php else: ?>
                    <a href="<?= url('login') ?>" class="flex items-center justify-center gap-2 mx-1 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-brand-gold to-brand-gold-dark text-stone-900 shadow-md">
                        <i class="fas fa-user text-xs"></i> <?= $t('login') ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile language switch -->
            <div class="px-4 py-3 border-t border-stone-100 dark:border-white/10 mt-2">
                <div class="flex items-center gap-1 bg-stone-100 dark:bg-dark-tertiary rounded-xl p-1">
                    <a href="<?= url('ku') ?>" class="flex-1 text-center py-2 rounded-lg text-sm font-medium transition-all <?= $lang === 'ku' ? 'bg-white dark:bg-dark-card text-brand-red shadow-sm' : 'text-stone-500' ?>">کوردی</a>
                    <a href="<?= url('en') ?>" class="flex-1 text-center py-2 rounded-lg text-sm font-medium transition-all <?= $lang === 'en' ? 'bg-white dark:bg-dark-card text-brand-red shadow-sm' : 'text-stone-500' ?>">English</a>
                    <a href="<?= url('ar') ?>" class="flex-1 text-center py-2 rounded-lg text-sm font-medium transition-all <?= $lang === 'ar' ? 'bg-white dark:bg-dark-card text-brand-red shadow-sm' : 'text-stone-500' ?>">العربية</a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Command Palette / Search Overlay -->
    <div class="search-overlay fixed inset-0 z-[2000] bg-black/60 backdrop-blur-md flex items-start justify-center pt-[15vh] opacity-0 pointer-events-none transition-all duration-300" id="searchOverlay">
        <div class="command-palette w-full max-w-2xl mx-4 rounded-2xl overflow-hidden animate-scale-in" style="animation-play-state: paused;">
            <!-- Search header -->
            <div class="flex items-center gap-3 px-5 py-4 border-b border-stone-200/50 dark:border-white/5">
                <i class="fas fa-search text-stone-300 dark:text-stone-600"></i>
                <form action="<?= lang_url('search') ?>" method="GET" class="flex-1">
                    <input type="text" name="q" id="searchInput" 
                           class="w-full bg-transparent text-lg text-stone-800 dark:text-stone-200 placeholder-stone-300 dark:placeholder-stone-600 outline-none"
                           placeholder="<?= $t('search_placeholder') ?>" autocomplete="off">
                </form>
                <button id="searchClose" class="flex items-center gap-1 px-2 py-1 rounded-lg bg-stone-100 dark:bg-dark-tertiary text-xs text-stone-400 hover:text-stone-600 dark:hover:text-stone-300 transition-colors">
                    <kbd class="font-mono">ESC</kbd>
                </button>
            </div>
            <!-- Search suggestions -->
            <div id="searchSuggestions" class="max-h-[50vh] overflow-y-auto empty:hidden">
                <div class="px-5 py-3 text-xs text-stone-400 dark:text-stone-500 uppercase tracking-wider"><?= $t('search') ?>...</div>
            </div>
            <!-- Search footer -->
            <div class="flex items-center gap-4 px-5 py-2.5 border-t border-stone-200/50 dark:border-white/5 text-[11px] text-stone-400 dark:text-stone-600">
                <span class="flex items-center gap-1"><kbd class="px-1.5 py-0.5 bg-stone-100 dark:bg-dark-tertiary rounded font-mono">↵</kbd> <?= $lang === 'ku' ? 'گەڕان' : 'Search' ?></span>
                <span class="flex items-center gap-1"><kbd class="px-1.5 py-0.5 bg-stone-100 dark:bg-dark-tertiary rounded font-mono">ESC</kbd> <?= $lang === 'ku' ? 'داخستن' : 'Close' ?></span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="min-h-[50vh]">
