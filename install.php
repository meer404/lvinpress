<?php
/**
 * LVINPress Database Setup
 * Run this file once to create the database and tables
 * Access: http://localhost/vinnew/install.php
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'lvinpress';
$prefix = 'lvp_';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host={$host};charset={$charset}", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `{$dbName}`");

    echo "<h2 style='font-family:sans-serif;color:#d4af37;'>LVINPress Installation</h2>";

    // ============ USERS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}users` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `email` VARCHAR(100) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `full_name_ku` VARCHAR(100) DEFAULT NULL,
        `full_name_en` VARCHAR(100) DEFAULT NULL,
        `full_name_ar` VARCHAR(100) DEFAULT NULL,
        `bio_ku` TEXT DEFAULT NULL,
        `bio_en` TEXT DEFAULT NULL,
        `bio_ar` TEXT DEFAULT NULL,
        `avatar` VARCHAR(255) DEFAULT NULL,
        `role` ENUM('admin','editor','writer','subscriber') DEFAULT 'subscriber',
        `status` ENUM('active','inactive','banned') DEFAULT 'active',
        `social_facebook` VARCHAR(255) DEFAULT NULL,
        `social_twitter` VARCHAR(255) DEFAULT NULL,
        `social_instagram` VARCHAR(255) DEFAULT NULL,
        `last_login` DATETIME DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX `idx_role` (`role`),
        INDEX `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Users table created</p>";

    // ============ CATEGORIES TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}categories` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `parent_id` INT UNSIGNED DEFAULT NULL,
        `name_ku` VARCHAR(100) NOT NULL,
        `name_en` VARCHAR(100) NOT NULL,
        `name_ar` VARCHAR(100) NOT NULL,
        `slug_ku` VARCHAR(120) NOT NULL,
        `slug_en` VARCHAR(120) NOT NULL UNIQUE,
        `slug_ar` VARCHAR(120) NOT NULL,
        `description_ku` TEXT DEFAULT NULL,
        `description_en` TEXT DEFAULT NULL,
        `description_ar` TEXT DEFAULT NULL,
        `image` VARCHAR(255) DEFAULT NULL,
        `color` VARCHAR(7) DEFAULT '#d4af37',
        `icon` VARCHAR(50) DEFAULT NULL,
        `sort_order` INT DEFAULT 0,
        `is_active` TINYINT(1) DEFAULT 1,
        `show_in_menu` TINYINT(1) DEFAULT 1,
        `meta_title_ku` VARCHAR(255) DEFAULT NULL,
        `meta_title_en` VARCHAR(255) DEFAULT NULL,
        `meta_title_ar` VARCHAR(255) DEFAULT NULL,
        `meta_desc_ku` VARCHAR(300) DEFAULT NULL,
        `meta_desc_en` VARCHAR(300) DEFAULT NULL,
        `meta_desc_ar` VARCHAR(300) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX `idx_parent` (`parent_id`),
        INDEX `idx_active` (`is_active`),
        INDEX `idx_sort` (`sort_order`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Categories table created</p>";

    // ============ ARTICLES TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}articles` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `category_id` INT UNSIGNED NOT NULL,
        `title_ku` VARCHAR(500) NOT NULL,
        `title_en` VARCHAR(500) DEFAULT NULL,
        `title_ar` VARCHAR(500) DEFAULT NULL,
        `slug_ku` VARCHAR(550) NOT NULL,
        `slug_en` VARCHAR(550) DEFAULT NULL,
        `slug_ar` VARCHAR(550) DEFAULT NULL,
        `excerpt_ku` TEXT DEFAULT NULL,
        `excerpt_en` TEXT DEFAULT NULL,
        `excerpt_ar` TEXT DEFAULT NULL,
        `content_ku` LONGTEXT DEFAULT NULL,
        `content_en` LONGTEXT DEFAULT NULL,
        `content_ar` LONGTEXT DEFAULT NULL,
        `featured_image` VARCHAR(255) DEFAULT NULL,
        `featured_image_caption` VARCHAR(255) DEFAULT NULL,
        `gallery` JSON DEFAULT NULL,
        `video_url` VARCHAR(500) DEFAULT NULL,
        `audio_url` VARCHAR(500) DEFAULT NULL,
        `type` ENUM('standard','video','gallery','audio','live') DEFAULT 'standard',
        `status` ENUM('draft','published','scheduled','archived') DEFAULT 'draft',
        `is_featured` TINYINT(1) DEFAULT 0,
        `is_breaking` TINYINT(1) DEFAULT 0,
        `is_editors_pick` TINYINT(1) DEFAULT 0,
        `allow_comments` TINYINT(1) DEFAULT 1,
        `views` INT UNSIGNED DEFAULT 0,
        `shares` INT UNSIGNED DEFAULT 0,
        `reading_time` INT DEFAULT NULL,
        `meta_title_ku` VARCHAR(255) DEFAULT NULL,
        `meta_title_en` VARCHAR(255) DEFAULT NULL,
        `meta_title_ar` VARCHAR(255) DEFAULT NULL,
        `meta_desc_ku` VARCHAR(300) DEFAULT NULL,
        `meta_desc_en` VARCHAR(300) DEFAULT NULL,
        `meta_desc_ar` VARCHAR(300) DEFAULT NULL,
        `meta_keywords` VARCHAR(500) DEFAULT NULL,
        `schema_markup` JSON DEFAULT NULL,
        `published_at` DATETIME DEFAULT NULL,
        `scheduled_at` DATETIME DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX `idx_user` (`user_id`),
        INDEX `idx_category` (`category_id`),
        INDEX `idx_status` (`status`),
        INDEX `idx_featured` (`is_featured`),
        INDEX `idx_breaking` (`is_breaking`),
        INDEX `idx_published` (`published_at`),
        INDEX `idx_views` (`views`),
        INDEX `idx_type` (`type`),
        FULLTEXT INDEX `ft_search_ku` (`title_ku`, `content_ku`),
        FULLTEXT INDEX `ft_search_en` (`title_en`, `content_en`),
        FULLTEXT INDEX `ft_search_ar` (`title_ar`, `content_ar`),
        FOREIGN KEY (`user_id`) REFERENCES `{$prefix}users`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`category_id`) REFERENCES `{$prefix}categories`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Articles table created</p>";

    // ============ TAGS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}tags` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name_ku` VARCHAR(50) NOT NULL,
        `name_en` VARCHAR(50) NOT NULL,
        `name_ar` VARCHAR(50) NOT NULL,
        `slug` VARCHAR(60) NOT NULL UNIQUE,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Tags table created</p>";

    // ============ ARTICLE_TAGS PIVOT ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}article_tags` (
        `article_id` INT UNSIGNED NOT NULL,
        `tag_id` INT UNSIGNED NOT NULL,
        PRIMARY KEY (`article_id`, `tag_id`),
        FOREIGN KEY (`article_id`) REFERENCES `{$prefix}articles`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`tag_id`) REFERENCES `{$prefix}tags`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Article_Tags pivot table created</p>";

    // ============ COMMENTS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}comments` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `article_id` INT UNSIGNED NOT NULL,
        `user_id` INT UNSIGNED DEFAULT NULL,
        `parent_id` INT UNSIGNED DEFAULT NULL,
        `author_name` VARCHAR(100) DEFAULT NULL,
        `author_email` VARCHAR(100) DEFAULT NULL,
        `content` TEXT NOT NULL,
        `status` ENUM('pending','approved','rejected','spam') DEFAULT 'pending',
        `ip_address` VARCHAR(45) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_article` (`article_id`),
        INDEX `idx_status` (`status`),
        INDEX `idx_parent` (`parent_id`),
        FOREIGN KEY (`article_id`) REFERENCES `{$prefix}articles`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`user_id`) REFERENCES `{$prefix}users`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Comments table created</p>";

    // ============ NEWSLETTER TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}newsletter` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(100) NOT NULL UNIQUE,
        `name` VARCHAR(100) DEFAULT NULL,
        `language` VARCHAR(2) DEFAULT 'ku',
        `is_active` TINYINT(1) DEFAULT 1,
        `token` VARCHAR(64) DEFAULT NULL,
        `subscribed_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `unsubscribed_at` DATETIME DEFAULT NULL,
        INDEX `idx_active` (`is_active`),
        INDEX `idx_lang` (`language`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Newsletter table created</p>";

    // ============ MEDIA TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}media` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED DEFAULT NULL,
        `filename` VARCHAR(255) NOT NULL,
        `original_name` VARCHAR(255) NOT NULL,
        `path` VARCHAR(500) NOT NULL,
        `mime_type` VARCHAR(100) NOT NULL,
        `size` INT UNSIGNED DEFAULT 0,
        `width` INT UNSIGNED DEFAULT NULL,
        `height` INT UNSIGNED DEFAULT NULL,
        `alt_text` VARCHAR(255) DEFAULT NULL,
        `caption` VARCHAR(500) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_user` (`user_id`),
        FOREIGN KEY (`user_id`) REFERENCES `{$prefix}users`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Media table created</p>";

    // ============ PAGES TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}pages` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title_ku` VARCHAR(300) NOT NULL,
        `title_en` VARCHAR(300) DEFAULT NULL,
        `title_ar` VARCHAR(300) DEFAULT NULL,
        `slug` VARCHAR(320) NOT NULL UNIQUE,
        `content_ku` LONGTEXT DEFAULT NULL,
        `content_en` LONGTEXT DEFAULT NULL,
        `content_ar` LONGTEXT DEFAULT NULL,
        `featured_image` VARCHAR(255) DEFAULT NULL,
        `status` ENUM('draft','published') DEFAULT 'draft',
        `sort_order` INT DEFAULT 0,
        `show_in_footer` TINYINT(1) DEFAULT 0,
        `meta_title` VARCHAR(255) DEFAULT NULL,
        `meta_desc` VARCHAR(300) DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Pages table created</p>";

    // ============ SETTINGS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}settings` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `setting_key` VARCHAR(100) NOT NULL UNIQUE,
        `setting_value` TEXT DEFAULT NULL,
        `setting_group` VARCHAR(50) DEFAULT 'general',
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Settings table created</p>";

    // ============ ADS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}ads` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `position` VARCHAR(50) NOT NULL,
        `code` TEXT DEFAULT NULL,
        `image` VARCHAR(255) DEFAULT NULL,
        `link` VARCHAR(500) DEFAULT NULL,
        `is_active` TINYINT(1) DEFAULT 1,
        `impressions` INT UNSIGNED DEFAULT 0,
        `clicks` INT UNSIGNED DEFAULT 0,
        `start_date` DATE DEFAULT NULL,
        `end_date` DATE DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_position` (`position`),
        INDEX `idx_active` (`is_active`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Ads table created</p>";

    // ============ POLLS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}polls` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `question_ku` VARCHAR(500) NOT NULL,
        `question_en` VARCHAR(500) DEFAULT NULL,
        `question_ar` VARCHAR(500) DEFAULT NULL,
        `options` JSON NOT NULL,
        `votes` JSON DEFAULT NULL,
        `total_votes` INT UNSIGNED DEFAULT 0,
        `is_active` TINYINT(1) DEFAULT 1,
        `expires_at` DATETIME DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Polls table created</p>";

    // ============ BOOKMARKS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}bookmarks` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `article_id` INT UNSIGNED NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY `unique_bookmark` (`user_id`, `article_id`),
        FOREIGN KEY (`user_id`) REFERENCES `{$prefix}users`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`article_id`) REFERENCES `{$prefix}articles`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Bookmarks table created</p>";

    // ============ ANALYTICS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}analytics` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `article_id` INT UNSIGNED DEFAULT NULL,
        `page_url` VARCHAR(500) NOT NULL,
        `referrer` VARCHAR(500) DEFAULT NULL,
        `user_agent` VARCHAR(500) DEFAULT NULL,
        `ip_address` VARCHAR(45) DEFAULT NULL,
        `country` VARCHAR(2) DEFAULT NULL,
        `device` VARCHAR(20) DEFAULT NULL,
        `language` VARCHAR(2) DEFAULT NULL,
        `visited_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_article` (`article_id`),
        INDEX `idx_visited` (`visited_at`),
        INDEX `idx_country` (`country`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Analytics table created</p>";

    // ============ BREAKING NEWS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$prefix}breaking_news` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `text_ku` VARCHAR(500) NOT NULL,
        `text_en` VARCHAR(500) DEFAULT NULL,
        `text_ar` VARCHAR(500) DEFAULT NULL,
        `link` VARCHAR(500) DEFAULT NULL,
        `is_active` TINYINT(1) DEFAULT 1,
        `priority` INT DEFAULT 0,
        `expires_at` DATETIME DEFAULT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Breaking News table created</p>";

    // ============ INSERT DEFAULT DATA ============
    
    // Default admin user (password: admin123)
    $adminPass = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12]);
    $pdo->exec("INSERT IGNORE INTO `{$prefix}users` (`username`, `email`, `password`, `full_name_ku`, `full_name_en`, `full_name_ar`, `role`, `status`) VALUES
    ('admin', 'admin@lvinpress.com', '{$adminPass}', 'بەڕێوەبەر', 'Administrator', 'المدير', 'admin', 'active')");
    echo "<p>✅ Default admin user created (admin / admin123)</p>";

    // Default categories
    $pdo->exec("INSERT IGNORE INTO `{$prefix}categories` (`name_ku`, `name_en`, `name_ar`, `slug_ku`, `slug_en`, `slug_ar`, `color`, `icon`, `sort_order`, `show_in_menu`) VALUES
    ('هەواڵ', 'News', 'أخبار', 'hewal', 'news', 'اخبار', '#d4af37', 'newspaper', 1, 1),
    ('سیاسەت', 'Politics', 'سياسة', 'siyaset', 'politics', 'سياسة', '#1a1a2e', 'landmark', 2, 1),
    ('ئابووری', 'Economy', 'اقتصاد', 'abwwri', 'economy', 'اقتصاد', '#16213e', 'chart-line', 3, 1),
    ('وەرزش', 'Sports', 'رياضة', 'werzish', 'sports', 'رياضة', '#e94560', 'futbol', 4, 1),
    ('تەندروستی', 'Health', 'صحة', 'tendrusti', 'health', 'صحة', '#0f3460', 'heartbeat', 5, 1),
    ('تەکنەلۆژیا', 'Technology', 'تكنولوجيا', 'teknolojya', 'technology', 'تكنولوجيا', '#533483', 'microchip', 6, 1),
    ('کولتوور', 'Culture', 'ثقافة', 'kultwwr', 'culture', 'ثقافة', '#2b2d42', 'palette', 7, 1),
    ('جیهان', 'World', 'عالم', 'jihan', 'world', 'عالم', '#8d99ae', 'globe', 8, 1)");
    echo "<p>✅ Default categories created</p>";

    // Default settings
    $pdo->exec("INSERT IGNORE INTO `{$prefix}settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
    ('site_name_ku', 'ئێل ڤی ئای ئێن پرێس', 'general'),
    ('site_name_en', 'LVINPress', 'general'),
    ('site_name_ar', 'إل في آي إن بريس', 'general'),
    ('site_description_ku', 'پلاتفۆرمی هەواڵی لوکس', 'general'),
    ('site_description_en', 'Premium Luxury News Platform', 'general'),
    ('site_description_ar', 'منصة أخبار فاخرة', 'general'),
    ('site_logo', '', 'general'),
    ('site_favicon', '', 'general'),
    ('primary_color', '#d4af37', 'design'),
    ('secondary_color', '#1a1a2e', 'design'),
    ('dark_mode_default', '0', 'design'),
    ('articles_per_page', '12', 'content'),
    ('comments_enabled', '1', 'content'),
    ('comments_moderation', '1', 'content'),
    ('social_facebook', '', 'social'),
    ('social_twitter', '', 'social'),
    ('social_instagram', '', 'social'),
    ('social_youtube', '', 'social'),
    ('social_telegram', '', 'social'),
    ('analytics_code', '', 'analytics'),
    ('header_scripts', '', 'scripts'),
    ('footer_scripts', '', 'scripts'),
    ('weather_api_key', '', 'widgets'),
    ('weather_city', 'Erbil', 'widgets'),
    ('ticker_enabled', '1', 'widgets'),
    ('breaking_news_enabled', '1', 'widgets')");
    echo "<p>✅ Default settings inserted</p>";

    // Sample article
    $pdo->exec("INSERT IGNORE INTO `{$prefix}articles` (`user_id`, `category_id`, `title_ku`, `title_en`, `title_ar`, `slug_ku`, `slug_en`, `slug_ar`, `excerpt_ku`, `excerpt_en`, `excerpt_ar`, `content_ku`, `content_en`, `content_ar`, `status`, `is_featured`, `is_breaking`, `views`, `published_at`) VALUES
    (1, 1, 'بەخێربێن بۆ ئێل ڤی ئای ئێن پرێس', 'Welcome to LVINPress', 'مرحباً بكم في إل في آي إن بريس', 'bexerbin-bo-lvinpress', 'welcome-to-lvinpress', 'مرحبا-بكم-في-lvinpress', 'ئێل ڤی ئای ئێن پرێس پلاتفۆرمێکی هەواڵی لوکسە بۆ خوێنەرانی کوردی و عەرەبی و ئینگلیزی', 'LVINPress is a premium luxury news platform for Kurdish, Arabic and English readers', 'إل في آي إن بريس هي منصة أخبار فاخرة للقراء الأكراد والعرب والإنجليز', '<p>بەخێربێن بۆ ئێل ڤی ئای ئێن پرێس. ئەم پلاتفۆرمە بۆ پێشکەشکردنی هەواڵ بە شێوازێکی لوکس و پیشەیی دروستکراوە.</p>', '<p>Welcome to LVINPress. This platform is built for providing news in a luxury and professional manner.</p>', '<p>مرحباً بكم في إل في آي إن بريس. تم إنشاء هذه المنصة لتقديم الأخبار بطريقة فاخرة ومهنية.</p>', 'published', 1, 1, 150, NOW()),
    (1, 2, 'دوایین هەواڵەکانی سیاسی', 'Latest Political News', 'آخر الأخبار السياسية', 'dwayin-hewalekani-siyasi', 'latest-political-news', 'اخر-الاخبار-السياسية', 'دوایین هەواڵ و ڕووداوەکانی سیاسی لە کوردستان و جیهان', 'Latest political news and events from Kurdistan and the world', 'آخر الأخبار والأحداث السياسية من كردستان والعالم', '<p>دوایین هەواڵ و ڕووداوەکانی سیاسی لە کوردستان و جیهان. ئەم بابەتە نوێترین پێشهاتەکان دەخاتە ڕوو.</p>', '<p>Latest political news and events from Kurdistan and the world. This article covers the newest developments.</p>', '<p>آخر الأخبار والأحداث السياسية من كردستان والعالم. يغطي هذا المقال أحدث التطورات.</p>', 'published', 0, 0, 89, NOW()),
    (1, 4, 'هەواڵی وەرزشی', 'Sports News Update', 'تحديث الأخبار الرياضية', 'hewali-werzshi', 'sports-news-update', 'تحديث-الاخبار-الرياضية', 'دوایین هەواڵی وەرزشی و ئەنجامەکانی یاریەکان', 'Latest sports news and match results', 'آخر الأخبار الرياضية ونتائج المباريات', '<p>دوایین هەواڵی وەرزشی و ئەنجامەکانی یاریەکان لە کوردستان و جیهان.</p>', '<p>Latest sports news and match results from Kurdistan and the world.</p>', '<p>آخر الأخبار الرياضية ونتائج المباريات من كردستان والعالم.</p>', 'published', 1, 0, 234, NOW()),
    (1, 6, 'تەکنەلۆژیای نوێ', 'New Technology Trends', 'اتجاهات التكنولوجيا الجديدة', 'teknolojyay-nwe', 'new-technology-trends', 'اتجاهات-التكنولوجيا', 'دوایین گەشەسەندنەکانی تەکنەلۆژیا لە جیهان', 'Latest technology developments in the world', 'أحدث التطورات التكنولوجية في العالم', '<p>دوایین گەشەسەندنەکانی تەکنەلۆژیا لە جیهاندا و کاریگەریان لەسەر ژیانی ڕۆژانە.</p>', '<p>Latest technology developments in the world and their impact on daily life.</p>', '<p>أحدث التطورات التكنولوجية في العالم وتأثيرها على الحياة اليومية.</p>', 'published', 0, 0, 178, NOW())");
    echo "<p>✅ Sample articles created</p>";

    // Breaking news
    $pdo->exec("INSERT IGNORE INTO `{$prefix}breaking_news` (`text_ku`, `text_en`, `text_ar`, `is_active`, `priority`) VALUES
    ('بەخێربێن بۆ ئێل ڤی ئای ئێن پرێس - پلاتفۆرمی هەواڵی لوکس', 'Welcome to LVINPress - Premium Luxury News Platform', 'مرحباً بكم في إل في آي إن بريس - منصة أخبار فاخرة', 1, 1)");
    echo "<p>✅ Breaking news sample created</p>";

    echo "<br><h3 style='color:#d4af37;font-family:sans-serif;'>✅ Installation Complete!</h3>";
    echo "<p style='font-family:sans-serif;'>Admin Login: <b>admin</b> / <b>admin123</b></p>";
    echo "<p style='font-family:sans-serif;'><a href='index.php' style='color:#d4af37;'>Go to Homepage →</a> | <a href='admin' style='color:#d4af37;'>Admin Panel →</a></p>";
    echo "<p style='font-family:sans-serif;color:red;'><b>⚠️ Delete this install.php file after installation!</b></p>";

} catch (PDOException $e) {
    echo "<h2 style='color:red;font-family:sans-serif;'>Installation Error</h2>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
