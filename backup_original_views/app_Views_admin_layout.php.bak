<?php
/**
 * Admin Layout - Sidebar + Header + Content Area
 */
$lang = $_SESSION['lang'] ?? 'ku';
$dir = in_array($lang, ['ku', 'ar']) ? 'rtl' : 'ltr';
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
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="admin-body" data-theme="light">

<!-- Admin Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar__header">
        <a href="<?= url('admin') ?>" class="admin-sidebar__logo">
            <span style="color:var(--gold);font-family:var(--font-display);font-size:1.5rem;font-weight:700;">LVIN</span>
            <span style="font-size:0.75rem;color:var(--text-muted);display:block;">Press Admin</span>
        </a>
        <button class="admin-sidebar__close" onclick="document.getElementById('adminSidebar').classList.remove('open')">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <nav class="admin-sidebar__nav">
        <a href="<?= url('admin') ?>" class="admin-nav__item <?= adminActive('/admin') && !adminActive('/admin/') ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i> <span><?= $t('dashboard') ?></span>
        </a>
        
        <div class="admin-nav__group-title"><?= $t('content') ?></div>
        <a href="<?= url('admin/articles') ?>" class="admin-nav__item <?= adminActive('admin/articles') ?>">
            <i class="fas fa-newspaper"></i> <span><?= $t('articles') ?></span>
        </a>
        <a href="<?= url('admin/categories') ?>" class="admin-nav__item <?= adminActive('admin/categories') ?>">
            <i class="fas fa-folder"></i> <span><?= $t('categories') ?></span>
        </a>
        <a href="<?= url('admin/media') ?>" class="admin-nav__item <?= adminActive('admin/media') ?>">
            <i class="fas fa-images"></i> <span><?= $t('media') ?></span>
        </a>
        
        <div class="admin-nav__group-title"><?= $t('community') ?></div>
        <a href="<?= url('admin/comments') ?>" class="admin-nav__item <?= adminActive('admin/comments') ?>">
            <i class="fas fa-comments"></i> <span><?= $t('comments') ?></span>
            <?php if (($pendingComments ?? 0) > 0): ?>
            <span class="admin-nav__badge"><?= $pendingComments ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= url('admin/users') ?>" class="admin-nav__item <?= adminActive('admin/users') ?>">
            <i class="fas fa-users"></i> <span><?= $t('users') ?></span>
        </a>
        
        <div class="admin-nav__group-title"><?= $t('system') ?></div>
        <a href="<?= url('admin/settings') ?>" class="admin-nav__item <?= adminActive('admin/settings') ?>">
            <i class="fas fa-cog"></i> <span><?= $t('settings') ?></span>
        </a>
        <a href="<?= lang_url('') ?>" class="admin-nav__item" target="_blank">
            <i class="fas fa-external-link-alt"></i> <span><?= $t('view_site') ?></span>
        </a>
        <a href="<?= url('logout') ?>" class="admin-nav__item" style="color:#e74c3c;">
            <i class="fas fa-sign-out-alt"></i> <span><?= $t('logout') ?></span>
        </a>
    </nav>
</aside>

<!-- Admin Main -->
<div class="admin-main">
    <!-- Admin Header -->
    <header class="admin-header">
        <div style="display:flex;align-items:center;gap:1rem;">
            <button class="admin-menu-toggle" onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                <i class="fas fa-bars"></i>
            </button>
            <h2 class="admin-header__title"><?= $pageTitle ?? 'Dashboard' ?></h2>
        </div>
        <div style="display:flex;align-items:center;gap:1rem;">
            <!-- Language Switcher -->
            <select onchange="changeLang(this.value)" style="padding:0.4rem;border:1px solid var(--border-color);border-radius:var(--radius-sm);background:var(--bg-primary);color:var(--text-primary);">
                <option value="ku" <?= $lang === 'ku' ? 'selected' : '' ?>>کوردی</option>
                <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
                <option value="ar" <?= $lang === 'ar' ? 'selected' : '' ?>>العربية</option>
            </select>
            <!-- User -->
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <div style="width:32px;height:32px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#1a1a2e;font-weight:600;font-size:0.875rem;">
                    <?= strtoupper(substr($currentUser->{'full_name_' . $lang} ?? $currentUser->username ?? 'A', 0, 1)) ?>
                </div>
                <span class="text-sm"><?= $currentUser->{'full_name_' . $lang} ?? $currentUser->username ?? 'Admin' ?></span>
            </div>
        </div>
    </header>
    
    <!-- Flash Messages -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <?php foreach ($_SESSION['flash'] as $ftype => $fmsg): ?>
            <div class="flash-message flash-<?= $ftype ?>" style="margin:1rem 1.5rem 0;">
                <?php if (is_array($fmsg)): ?>
                    <ul style="margin:0;padding-left:1rem;"><?php foreach($fmsg as $m): ?><li><?= $m ?></li><?php endforeach; ?></ul>
                <?php else: ?>
                    <?= $fmsg ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    
    <!-- Content -->
    <div class="admin-content">
        <?= $content ?? '' ?>
    </div>
</div>

<script>
// Close sidebar on mobile when clicking outside
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('adminSidebar');
    if (window.innerWidth <= 768 && sidebar.classList.contains('open') && 
        !sidebar.contains(e.target) && !e.target.classList.contains('admin-menu-toggle')) {
        sidebar.classList.remove('open');
    }
});

// Change language via session
function changeLang(newLang) {
    fetch('<?= url('api/lang') ?>?lang=' + newLang).then(() => location.reload()).catch(() => location.reload());
}
</script>
</body>
</html>
