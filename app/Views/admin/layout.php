<?php
/**
 * Admin Layout - Advanced Tailwind CSS
 * Sidebar + Header + Content Area
 */
$lang = $_SESSION['lang'] ?? 'ku';
$dir = in_array($lang, ['ku', 'ar']) ? 'rtl' : 'ltr';
$isRtl = $dir === 'rtl';
$currentRoute = $_SERVER['REQUEST_URI'] ?? '';

function adminActive($path) {
    global $currentRoute;
    return strpos($currentRoute, $path) !== false ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin' ?> | LVINPress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: ['selector', '[data-theme="dark"]'],
        theme: {
            extend: {
                colors: {
                    brand: {
                        red: '#B80000', 'red-light': '#FF4D4D', 'red-dark': '#8A0000',
                        gold: '#d4af37', 'gold-light': '#e8cc6e', 'gold-dark': '#b8962e'
                    },
                    dark: {
                        primary: '#0c0c14', secondary: '#161625',
                        tertiary: '#1e1e32', card: '#1a1a2e'
                    },
                    sidebar: { bg: '#0f0f1a', hover: '#1a1a30', active: '#242445' }
                },
                fontFamily: {
                    display: ['Playfair Display', 'Georgia', 'serif'],
                    body: ['Inter', 'system-ui', 'sans-serif'],
                },
                maxWidth: { container: '1400px' },
                animation: {
                    'slide-in': 'slideIn 0.3s ease-out forwards',
                    'fade-in': 'fadeIn 0.4s ease-out forwards',
                },
                keyframes: {
                    slideIn: { '0%': { opacity: '0', transform: 'translateY(-8px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                    fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                }
            }
        }
    }
    </script>
    <link rel="stylesheet" href="<?= asset('css/tailwind-custom.css') ?>">
    <style>
    /* Admin-specific utilities */
    .admin-sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .admin-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    .admin-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 999px; }
    .admin-sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
    /* Active nav indicator */
    .nav-item-active { position: relative; }
    .nav-item-active::before { content:''; position:absolute; <?= $isRtl ? 'right' : 'left' ?>:0; top:50%; transform:translateY(-50%); width:3px; height:60%; background:linear-gradient(180deg, #d4af37, #b8962e); border-radius:0 4px 4px 0; }
    /* Sidebar noise texture */
    .sidebar-noise::after { content:''; position:absolute; inset:0; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.02'/%3E%3C/svg%3E"); pointer-events:none; z-index:1; }
    /* Admin card glass effect */
    .admin-glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
    /* Notification dropdown */
    .notif-dropdown { display:none; }
    .notif-dropdown.show { display:block; }
    /* Search command palette */
    .admin-search-overlay { display:none; }
    .admin-search-overlay.show { display:flex; }
    </style>
</head>
<body class="font-body bg-gradient-to-br from-stone-100 via-stone-50 to-stone-100 text-stone-800 min-h-screen">

<!-- Mobile Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

<!-- Admin Sidebar -->
<aside id="adminSidebar" class="fixed top-0 <?= $isRtl ? 'right-0' : 'left-0' ?> z-50 h-screen w-64 bg-sidebar-bg text-white flex flex-col transition-transform duration-300 <?= $isRtl ? 'translate-x-full' : '-translate-x-full' ?> lg:translate-x-0 sidebar-noise">
    <!-- Logo -->
    <div class="flex items-center justify-between px-5 py-5 border-b border-white/10 relative z-10">
        <a href="<?= url('admin') ?>" class="flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-gold to-brand-gold-dark flex items-center justify-center shadow-lg shadow-brand-gold/20 group-hover:shadow-brand-gold/40 transition-shadow">
                <span class="font-display text-sm font-bold text-sidebar-bg">LP</span>
            </div>
            <div class="flex flex-col">
                <span class="font-display text-lg font-bold text-brand-gold leading-tight">LVIN</span>
                <span class="text-[0.6rem] text-stone-500 tracking-widest uppercase">Press Admin</span>
            </div>
        </a>
        <button class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 transition" onclick="toggleSidebar()">
            <i class="fas fa-times text-sm text-stone-400"></i>
        </button>
    </div>

    <!-- Sidebar Search -->
    <div class="px-3 py-3 border-b border-white/5 relative z-10">
        <button onclick="openAdminSearch()" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/5 text-stone-400 text-sm transition group">
            <i class="fas fa-search text-xs opacity-60"></i>
            <span class="flex-1 text-left text-xs"><?= $lang === 'ku' ? 'گەڕان...' : ($lang === 'ar' ? 'بحث...' : 'Search...') ?></span>
            <kbd class="text-[0.6rem] bg-white/10 px-1.5 py-0.5 rounded font-mono opacity-50 group-hover:opacity-80">⌘K</kbd>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto admin-sidebar-scroll py-4 px-3 space-y-1 relative z-10">
        <?php
        $navItems = [
            ['url' => 'admin', 'icon' => 'fa-tachometer-alt', 'label' => $t('dashboard'), 'exact' => true],
        ];
        $contentItems = [
            ['url' => 'admin/articles', 'icon' => 'fa-newspaper', 'label' => $t('articles')],
            ['url' => 'admin/categories', 'icon' => 'fa-folder', 'label' => $t('categories')],
            ['url' => 'admin/pages', 'icon' => 'fa-file-alt', 'label' => $t('pages') ?? 'Pages'],
            ['url' => 'admin/media', 'icon' => 'fa-images', 'label' => $t('media')],
        ];
        $communityItems = [
            ['url' => 'admin/comments', 'icon' => 'fa-comments', 'label' => $t('comments'), 'badge' => $pendingComments ?? 0],
            ['url' => 'admin/users', 'icon' => 'fa-users', 'label' => $t('users')],
            ['url' => 'admin/newsletters', 'icon' => 'fa-envelope', 'label' => $t('newsletter') ?? 'Newsletter'],
            ['url' => 'admin/polls', 'icon' => 'fa-poll', 'label' => $t('polls') ?? 'Polls'],
        ];
        $systemItems = [
            ['url' => 'admin/ads', 'icon' => 'fa-ad', 'label' => $t('ads') ?? 'Ads'],
            ['url' => 'admin/analytics', 'icon' => 'fa-chart-line', 'label' => $t('analytics') ?? 'Analytics'],
            ['url' => 'admin/settings', 'icon' => 'fa-cog', 'label' => $t('settings')],
        ];

        function renderNavItem($item, $currentRoute) {
            $isActive = !empty($item['exact'])
                ? (preg_match('#/admin/?$#', $currentRoute) && !preg_match('#/admin/.#', $currentRoute))
                : strpos($currentRoute, $item['url']) !== false;
            $activeClass = $isActive
                ? 'nav-item-active bg-sidebar-active text-brand-gold'
                : 'text-stone-300 hover:bg-sidebar-hover hover:text-white';
            $badge = ($item['badge'] ?? 0) > 0
                ? '<span class="ml-auto bg-brand-red text-white text-[0.6rem] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center animate-pulse">' . $item['badge'] . '</span>'
                : '';
            echo '<a href="' . url($item['url']) . '" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 ' . $activeClass . '">';
            echo '<i class="fas ' . $item['icon'] . ' w-5 text-center text-xs opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all"></i>';
            echo '<span>' . $item['label'] . '</span>';
            echo $badge;
            echo '</a>';
        }

        function renderNavGroup($title, $items, $currentRoute) {
            echo '<div class="pt-5 first:pt-0">';
            echo '<p class="px-3 mb-2 text-[0.6rem] font-semibold uppercase tracking-[0.15em] text-stone-500">' . $title . '</p>';
            foreach ($items as $item) renderNavItem($item, $currentRoute);
            echo '</div>';
        }
        ?>
        <?php foreach ($navItems as $item) renderNavItem($item, $currentRoute); ?>
        <?php renderNavGroup($t('content'), $contentItems, $currentRoute); ?>
        <?php renderNavGroup($t('community'), $communityItems, $currentRoute); ?>
        <?php renderNavGroup($t('system') ?? 'System', $systemItems, $currentRoute); ?>

        <!-- Separator -->
        <div class="border-t border-white/10 mt-4 pt-4">
            <a href="<?= lang_url('') ?>" target="_blank" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-stone-300 hover:bg-sidebar-hover hover:text-white transition-all duration-200">
                <i class="fas fa-external-link-alt w-5 text-center text-xs opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all"></i>
                <span><?= $t('view_site') ?></span>
            </a>
            <a href="<?= url('logout') ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
                <i class="fas fa-sign-out-alt w-5 text-center text-xs opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all"></i>
                <span><?= $t('logout') ?></span>
            </a>
        </div>
    </nav>
</aside>

<!-- Admin Search Overlay -->
<div id="adminSearchOverlay" class="admin-search-overlay fixed inset-0 z-[60] bg-black/40 backdrop-blur-sm items-start justify-center pt-[15vh]" onclick="if(event.target===this)closeAdminSearch()">
    <div class="w-full max-w-lg mx-4 bg-white rounded-2xl shadow-2xl shadow-black/20 overflow-hidden border border-stone-200/60 animate-slide-in">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-stone-100">
            <i class="fas fa-search text-stone-400"></i>
            <input id="adminSearchInput" type="text" placeholder="<?= $lang === 'ku' ? 'گەڕان لە ئەدمین...' : ($lang === 'ar' ? 'البحث في لوحة التحكم...' : 'Search admin panel...') ?>" class="flex-1 bg-transparent outline-none text-sm placeholder:text-stone-400">
            <kbd class="text-[0.6rem] bg-stone-100 text-stone-500 px-2 py-0.5 rounded font-mono">ESC</kbd>
        </div>
        <div id="adminSearchResults" class="max-h-72 overflow-y-auto">
            <div class="p-4 text-center text-sm text-stone-400">
                <i class="fas fa-keyboard mb-2 text-lg opacity-40"></i>
                <p><?= $lang === 'ku' ? 'دەست بکە بە نووسین بۆ گەڕان' : ($lang === 'ar' ? 'ابدأ الكتابة للبحث' : 'Start typing to search') ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="lg:<?= $isRtl ? 'mr-64' : 'ml-64' ?> min-h-screen flex flex-col transition-all">
    <!-- Admin Header -->
    <header class="sticky top-0 z-30 admin-glass border-b border-stone-200/60">
        <div class="flex items-center justify-between h-16 px-4 lg:px-6">
            <div class="flex items-center gap-4">
                <button class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-stone-100 transition" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-stone-600"></i>
                </button>
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm">
                    <a href="<?= url('admin') ?>" class="text-stone-400 hover:text-brand-gold transition-colors">
                        <i class="fas fa-home text-xs"></i>
                    </a>
                    <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?> text-[0.5rem] text-stone-300"></i>
                    <span class="font-semibold text-stone-800"><?= $pageTitle ?? 'Dashboard' ?></span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <!-- Header search trigger -->
                <button onclick="openAdminSearch()" class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl border border-stone-200/80 bg-white/60 text-stone-400 text-sm hover:border-brand-gold/40 hover:text-brand-gold transition-all">
                    <i class="fas fa-search text-xs"></i>
                    <span class="text-xs"><?= $lang === 'ku' ? 'گەڕان' : ($lang === 'ar' ? 'بحث' : 'Search') ?></span>
                    <kbd class="text-[0.55rem] bg-stone-100 px-1.5 py-0.5 rounded font-mono">⌘K</kbd>
                </button>

                <!-- Notifications -->
                <div class="relative">
                    <button onclick="toggleNotifications()" class="relative w-9 h-9 flex items-center justify-center rounded-xl hover:bg-stone-100 transition text-stone-500 hover:text-stone-700">
                        <i class="fas fa-bell text-sm"></i>
                        <?php if (($pendingComments ?? 0) > 0): ?>
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-brand-red text-white text-[0.55rem] font-bold rounded-full flex items-center justify-center animate-pulse"><?= $pendingComments ?></span>
                        <?php endif; ?>
                    </button>
                    <div id="notifDropdown" class="notif-dropdown absolute <?= $isRtl ? 'left-0' : 'right-0' ?> top-12 w-72 bg-white rounded-2xl shadow-xl shadow-black/10 border border-stone-200/60 overflow-hidden animate-slide-in">
                        <div class="px-4 py-3 border-b border-stone-100 flex items-center justify-between">
                            <span class="text-sm font-semibold"><?= $lang === 'ku' ? 'ئاگادارکردنەوەکان' : ($lang === 'ar' ? 'الإشعارات' : 'Notifications') ?></span>
                            <?php if (($pendingComments ?? 0) > 0): ?>
                            <span class="text-xs bg-brand-red/10 text-brand-red px-2 py-0.5 rounded-full font-medium"><?= $pendingComments ?> <?= $lang === 'ku' ? 'نوێ' : ($lang === 'ar' ? 'جديد' : 'new') ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <?php if (($pendingComments ?? 0) > 0): ?>
                            <a href="<?= url('admin/comments') ?>" class="flex items-start gap-3 px-4 py-3 hover:bg-stone-50 transition">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fas fa-comment text-xs text-blue-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium"><?= $pendingComments ?> <?= $lang === 'ku' ? 'لێدوان چاوەڕوانن' : ($lang === 'ar' ? 'تعليقات بانتظار المراجعة' : 'comments pending review') ?></p>
                                    <p class="text-xs text-stone-400 mt-0.5"><?= $lang === 'ku' ? 'کلیک بکە بۆ بەڕێوەبردن' : ($lang === 'ar' ? 'انقر للإدارة' : 'Click to manage') ?></p>
                                </div>
                            </a>
                            <?php else: ?>
                            <div class="p-6 text-center text-stone-400">
                                <i class="fas fa-check-circle text-2xl mb-2 text-emerald-400"></i>
                                <p class="text-sm"><?= $lang === 'ku' ? 'هیچ ئاگادارکردنەوەیەک نییە' : ($lang === 'ar' ? 'لا إشعارات' : 'All caught up!') ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Language Switcher -->
                <select onchange="changeLang(this.value)" class="text-xs px-2.5 py-1.5 rounded-xl border border-stone-200/80 bg-white/60 text-stone-700 focus:outline-none focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold cursor-pointer transition-all">
                    <option value="ku" <?= $lang === 'ku' ? 'selected' : '' ?>>کوردی</option>
                    <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
                    <option value="ar" <?= $lang === 'ar' ? 'selected' : '' ?>>العربية</option>
                </select>

                <!-- User avatar -->
                <div class="flex items-center gap-2.5 <?= $isRtl ? 'mr-1' : 'ml-1' ?>">
                    <div class="w-9 h-9 bg-gradient-to-br from-brand-gold to-brand-gold-dark rounded-xl flex items-center justify-center text-sidebar-bg font-bold text-sm shadow-sm shadow-brand-gold/20 hover:shadow-brand-gold/40 transition-shadow cursor-pointer">
                        <?= strtoupper(substr($currentUser->{'full_name_' . $lang} ?? $currentUser->username ?? 'A', 0, 1)) ?>
                    </div>
                    <span class="hidden sm:block text-sm font-medium text-stone-700"><?= $currentUser->{'full_name_' . $lang} ?? $currentUser->username ?? 'Admin' ?></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="px-4 lg:px-6 pt-4 space-y-2">
        <?php foreach ($_SESSION['flash'] as $ftype => $fmsg):
            $colors = match($ftype) {
                'success' => 'bg-emerald-50 border-emerald-200/60 text-emerald-800',
                'error'   => 'bg-red-50 border-red-200/60 text-red-800',
                'warning' => 'bg-amber-50 border-amber-200/60 text-amber-800',
                default   => 'bg-blue-50 border-blue-200/60 text-blue-800'
            };
            $icon = match($ftype) {
                'success' => 'fa-check-circle text-emerald-500',
                'error'   => 'fa-exclamation-circle text-red-500',
                'warning' => 'fa-exclamation-triangle text-amber-500',
                default   => 'fa-info-circle text-blue-500'
            };
        ?>
        <div class="flex items-start gap-3 px-4 py-3 rounded-2xl border <?= $colors ?> text-sm animate-slide-in shadow-sm" role="alert">
            <i class="fas <?= $icon ?> mt-0.5"></i>
            <div class="flex-1">
                <?php if (is_array($fmsg)): ?>
                    <ul class="list-disc list-inside space-y-0.5"><?php foreach($fmsg as $m): ?><li><?= $m ?></li><?php endforeach; ?></ul>
                <?php else: ?>
                    <?= $fmsg ?>
                <?php endif; ?>
            </div>
            <button onclick="this.parentElement.remove()" class="text-stone-400 hover:text-stone-600 transition">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    </div>
    <?php endif; ?>

    <!-- Content -->
    <main class="flex-1 p-4 lg:p-6 animate-fade-in">
        <?= $content ?? '' ?>
    </main>

    <!-- Admin Footer -->
    <footer class="px-4 lg:px-6 py-3 border-t border-stone-200/60 text-xs text-stone-400 flex items-center justify-between">
        <span>&copy; <?= date('Y') ?> LVINPress</span>
        <span class="hidden sm:inline"><?= $lang === 'ku' ? 'پانێلی بەڕێوەبەر' : ($lang === 'ar' ? 'لوحة التحكم' : 'Admin Panel') ?> v2.0</span>
    </footer>
</div>

<script>
// Sidebar toggle
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const isRtl = document.documentElement.dir === 'rtl';

    if (isRtl) {
        sidebar.classList.toggle('translate-x-full');
        sidebar.classList.toggle('translate-x-0');
    } else {
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');
    }
    overlay.classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (window.innerWidth < 1024 && !overlay.classList.contains('hidden') &&
        !sidebar.contains(e.target) && !e.target.closest('[onclick*="toggleSidebar"]')) {
        toggleSidebar();
    }
});

// Language change
function changeLang(newLang) {
    fetch('<?= url('api/lang') ?>?lang=' + newLang).then(() => location.reload()).catch(() => location.reload());
}

// Notifications dropdown
function toggleNotifications() {
    const dd = document.getElementById('notifDropdown');
    dd.classList.toggle('show');
}
document.addEventListener('click', function(e) {
    const dd = document.getElementById('notifDropdown');
    if (dd && dd.classList.contains('show') && !e.target.closest('[onclick*="toggleNotifications"]') && !dd.contains(e.target)) {
        dd.classList.remove('show');
    }
});

// Admin search overlay
function openAdminSearch() {
    const overlay = document.getElementById('adminSearchOverlay');
    overlay.classList.add('show');
    setTimeout(() => document.getElementById('adminSearchInput')?.focus(), 100);
}
function closeAdminSearch() {
    document.getElementById('adminSearchOverlay').classList.remove('show');
}
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const overlay = document.getElementById('adminSearchOverlay');
        overlay.classList.contains('show') ? closeAdminSearch() : openAdminSearch();
    }
    if (e.key === 'Escape') closeAdminSearch();
});

// Admin search navigation
const adminSearchInput = document.getElementById('adminSearchInput');
if (adminSearchInput) {
    const adminPages = [
        { title: '<?= $t('dashboard') ?>', url: '<?= url('admin') ?>', icon: 'fa-tachometer-alt' },
        { title: '<?= $t('articles') ?>', url: '<?= url('admin/articles') ?>', icon: 'fa-newspaper' },
        { title: '<?= $t('categories') ?>', url: '<?= url('admin/categories') ?>', icon: 'fa-folder' },
        { title: '<?= $t('pages') ?? 'Pages' ?>', url: '<?= url('admin/pages') ?>', icon: 'fa-file-alt' },
        { title: '<?= $t('media') ?>', url: '<?= url('admin/media') ?>', icon: 'fa-images' },
        { title: '<?= $t('comments') ?>', url: '<?= url('admin/comments') ?>', icon: 'fa-comments' },
        { title: '<?= $t('users') ?>', url: '<?= url('admin/users') ?>', icon: 'fa-users' },
        { title: '<?= $t('newsletter') ?? 'Newsletter' ?>', url: '<?= url('admin/newsletters') ?>', icon: 'fa-envelope' },
        { title: '<?= $t('polls') ?? 'Polls' ?>', url: '<?= url('admin/polls') ?>', icon: 'fa-poll' },
        { title: '<?= $t('ads') ?? 'Ads' ?>', url: '<?= url('admin/ads') ?>', icon: 'fa-ad' },
        { title: '<?= $t('analytics') ?? 'Analytics' ?>', url: '<?= url('admin/analytics') ?>', icon: 'fa-chart-line' },
        { title: '<?= $t('settings') ?>', url: '<?= url('admin/settings') ?>', icon: 'fa-cog' },
    ];
    adminSearchInput.addEventListener('input', function() {
        const q = this.value.trim().toLowerCase();
        const results = document.getElementById('adminSearchResults');
        if (!q) {
            results.innerHTML = '<div class="p-4 text-center text-sm text-stone-400"><i class="fas fa-keyboard mb-2 text-lg opacity-40"></i><p>Start typing to search</p></div>';
            return;
        }
        const filtered = adminPages.filter(p => p.title.toLowerCase().includes(q));
        if (filtered.length) {
            results.innerHTML = filtered.map(p =>
                `<a href="${p.url}" class="flex items-center gap-3 px-4 py-3 hover:bg-stone-50 transition text-sm">
                    <i class="fas ${p.icon} w-5 text-center text-stone-400"></i>
                    <span class="font-medium">${p.title}</span>
                    <i class="fas fa-arrow-right text-[0.6rem] text-stone-300 ml-auto"></i>
                </a>`
            ).join('');
        } else {
            results.innerHTML = '<div class="p-4 text-center text-sm text-stone-400">No results found</div>';
        }
    });
}

// Auto-dismiss flash messages
document.querySelectorAll('[role="alert"]').forEach(el => {
    setTimeout(() => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(-8px)';
        el.style.transition = 'all 0.3s ease';
        setTimeout(() => el.remove(), 300);
    }, 6000);
});
</script>
</body>
</html>
