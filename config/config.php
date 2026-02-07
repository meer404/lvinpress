<?php
/**
 * LVINPress - Luxury News Platform
 * Main Configuration File
 */

// Environment
define('APP_ENV', 'development'); // production, development
define('APP_DEBUG', true);
define('APP_NAME', 'LVINPress');
define('APP_URL', 'http://localhost/vinnew');
define('APP_VERSION', '1.0.0');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'lvinpress');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
define('DB_PREFIX', 'lvp_');

// Path Constants
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');
define('CACHE_PATH', ROOT_PATH . '/storage/cache');
define('LOG_PATH', ROOT_PATH . '/storage/logs');
define('VIEW_PATH', ROOT_PATH . '/app/Views');

// Session Configuration
define('SESSION_NAME', 'lvinpress_session');
define('SESSION_LIFETIME', 7200); // 2 hours

// Security
define('CSRF_TOKEN_NAME', '_token');
define('HASH_ALGO', PASSWORD_BCRYPT);
define('HASH_COST', 12);
define('ENCRYPTION_KEY', 'lvinpress_2026_secret_key_change_this');

// Multilingual Configuration
define('DEFAULT_LANG', 'ku');
define('SUPPORTED_LANGS', serialize(['ku', 'en', 'ar']));
define('LANG_NAMES', serialize([
    'ku' => 'کوردی',
    'en' => 'English',
    'ar' => 'العربية'
]));
define('RTL_LANGS', serialize(['ku', 'ar']));

// Upload Configuration
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_IMAGE_TYPES', serialize(['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']));
define('ALLOWED_FILE_TYPES', serialize(['pdf', 'doc', 'docx', 'mp3', 'mp4']));
define('IMAGE_QUALITY', 85);

// Pagination
define('ARTICLES_PER_PAGE', 12);
define('ADMIN_PER_PAGE', 20);
define('COMMENTS_PER_PAGE', 10);

// Cache
define('CACHE_ENABLED', false); // Enable in production
define('CACHE_TTL', 3600); // 1 hour

// SEO
define('META_TITLE_SUFFIX', ' | LVINPress');
define('META_DESCRIPTION_DEFAULT', 'LVINPress - Premium Luxury News Platform');

// Social Media
define('SOCIAL_FACEBOOK', '');
define('SOCIAL_TWITTER', '');
define('SOCIAL_INSTAGRAM', '');
define('SOCIAL_YOUTUBE', '');
define('SOCIAL_TELEGRAM', '');

// Timezone
date_default_timezone_set('Asia/Baghdad');

// Error Reporting
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
