<?php
/**
 * LVINPress Helper Functions
 */

function asset(string $path): string
{
    return APP_URL . '/public/assets/' . ltrim($path, '/');
}

function upload_url(string $path): string
{
    return APP_URL . '/public/uploads/' . ltrim($path, '/');
}

function url(string $path = ''): string
{
    return APP_URL . '/' . ltrim($path, '/');
}

function lang_url(string $path = '', ?string $lang = null): string
{
    $lang = $lang ?? ($_SESSION['lang'] ?? DEFAULT_LANG);
    return APP_URL . '/' . $lang . '/' . ltrim($path, '/');
}

function current_lang(): string
{
    return $_SESSION['lang'] ?? DEFAULT_LANG;
}

function is_rtl(): bool
{
    $rtlLangs = unserialize(RTL_LANGS);
    return in_array(current_lang(), $rtlLangs);
}

function csrf_field(): string
{
    $token = $_SESSION['csrf_token'] ?? '';
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . $token . '">';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function old(string $key, string $default = ''): string
{
    return htmlspecialchars($_SESSION['old_input'][$key] ?? $default, ENT_QUOTES, 'UTF-8');
}

function flash(string $key, $value = null)
{
    if ($value !== null) {
        $_SESSION['flash'][$key] = $value;
        return;
    }
    $val = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $val;
}

function format_date(string $date, ?string $lang = null): string
{
    $lang = $lang ?? current_lang();
    $timestamp = strtotime($date);
    
    switch ($lang) {
        case 'ku':
            $months = ['کانونی دووەم', 'شوبات', 'ئازار', 'نیسان', 'ئایار', 'حوزەیران', 'تەمموز', 'ئاب', 'ئەیلوول', 'تشرینی یەکەم', 'تشرینی دووەم', 'کانونی یەکەم'];
            $month = $months[date('n', $timestamp) - 1];
            return date('j', $timestamp) . ' ' . $month . ' ' . date('Y', $timestamp);
        case 'ar':
            $months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
            $month = $months[date('n', $timestamp) - 1];
            return date('j', $timestamp) . ' ' . $month . ' ' . date('Y', $timestamp);
        default:
            return date('F j, Y', $timestamp);
    }
}

function time_ago(string $datetime, ?string $lang = null): string
{
    $lang = $lang ?? current_lang();
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    $intervals = [
        ['ku' => 'ساڵ', 'en' => 'year', 'ar' => 'سنة', 'seconds' => 31536000],
        ['ku' => 'مانگ', 'en' => 'month', 'ar' => 'شهر', 'seconds' => 2592000],
        ['ku' => 'هەفتە', 'en' => 'week', 'ar' => 'أسبوع', 'seconds' => 604800],
        ['ku' => 'ڕۆژ', 'en' => 'day', 'ar' => 'يوم', 'seconds' => 86400],
        ['ku' => 'کاتژمێر', 'en' => 'hour', 'ar' => 'ساعة', 'seconds' => 3600],
        ['ku' => 'خولەک', 'en' => 'minute', 'ar' => 'دقيقة', 'seconds' => 60],
    ];
    
    foreach ($intervals as $interval) {
        $count = floor($diff / $interval['seconds']);
        if ($count >= 1) {
            $unit = $interval[$lang] ?? $interval['en'];
            if ($lang === 'ku') return "پێش {$count} {$unit}";
            if ($lang === 'ar') return "منذ {$count} {$unit}";
            return "{$count} {$unit}" . ($count > 1 ? 's' : '') . ' ago';
        }
    }
    
    $now = ['ku' => 'ئێستا', 'en' => 'just now', 'ar' => 'الآن'];
    return $now[$lang] ?? $now['en'];
}

function reading_time(string $content, ?string $lang = null): string
{
    $lang = $lang ?? current_lang();
    $wordCount = str_word_count(strip_tags($content));
    $minutes = max(1, ceil($wordCount / 200));
    
    switch ($lang) {
        case 'ku': return $minutes . ' خولەک خوێندنەوە';
        case 'ar': return $minutes . ' دقائق للقراءة';
        default: return $minutes . ' min read';
    }
}

function excerpt(string $text, int $length = 160): string
{
    $text = strip_tags($text);
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '...';
}

function slugify(string $text, string $lang = 'en'): string
{
    if ($lang === 'en') {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }
    // For Kurdish/Arabic - use URL encoding for non-latin
    $text = preg_replace('/\s+/', '-', trim($text));
    $text = preg_replace('/-+/', '-', $text);
    return urlencode($text);
}

function upload_image($file, string $folder = 'articles'): ?string
{
    if (!isset($file['tmp_name']) || !$file['tmp_name']) return null;
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = unserialize(ALLOWED_IMAGE_TYPES);
    
    if (!in_array($ext, $allowed)) return null;
    if ($file['size'] > MAX_UPLOAD_SIZE) return null;
    
    $dir = UPLOAD_PATH . '/' . $folder . '/' . date('Y/m');
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    
    $filename = uniqid() . '_' . time() . '.' . $ext;
    $path = $dir . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $path)) {
        // Create WebP version
        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
            create_webp($path, $dir . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp');
        }
        return $folder . '/' . date('Y/m') . '/' . $filename;
    }
    
    return null;
}

function create_webp(string $source, string $dest, int $quality = 80): bool
{
    if (!function_exists('imagewebp')) return false;
    
    $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
    
    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $img = imagecreatefromjpeg($source);
            break;
        case 'png':
            $img = imagecreatefrompng($source);
            break;
        default:
            return false;
    }
    
    if (!$img) return false;
    
    $result = imagewebp($img, $dest, $quality);
    imagedestroy($img);
    return $result;
}

function generate_meta_tags(array $meta): string
{
    $html = '';
    $title = ($meta['title'] ?? APP_NAME) . META_TITLE_SUFFIX;
    $description = $meta['description'] ?? META_DESCRIPTION_DEFAULT;
    $image = $meta['image'] ?? '';
    $url = $meta['url'] ?? (isset($_SERVER['REQUEST_URI']) ? APP_URL . $_SERVER['REQUEST_URI'] : APP_URL);
    
    $html .= "<title>{$title}</title>\n";
    $html .= "<meta name=\"description\" content=\"{$description}\">\n";
    $html .= "<link rel=\"canonical\" href=\"{$url}\">\n";
    
    // Open Graph
    $html .= "<meta property=\"og:title\" content=\"{$title}\">\n";
    $html .= "<meta property=\"og:description\" content=\"{$description}\">\n";
    $html .= "<meta property=\"og:url\" content=\"{$url}\">\n";
    $html .= "<meta property=\"og:type\" content=\"" . ($meta['type'] ?? 'website') . "\">\n";
    if ($image) $html .= "<meta property=\"og:image\" content=\"{$image}\">\n";
    
    // Twitter Card
    $html .= "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    $html .= "<meta name=\"twitter:title\" content=\"{$title}\">\n";
    $html .= "<meta name=\"twitter:description\" content=\"{$description}\">\n";
    if ($image) $html .= "<meta name=\"twitter:image\" content=\"{$image}\">\n";
    
    // Article schema
    if (isset($meta['article'])) {
        $html .= "<meta property=\"article:published_time\" content=\"" . ($meta['article']['published'] ?? '') . "\">\n";
        $html .= "<meta property=\"article:author\" content=\"" . ($meta['article']['author'] ?? '') . "\">\n";
    }
    
    return $html;
}
