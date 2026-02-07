<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;

use App\Core\Cache;

class FeedController extends Controller
{
    public function rss(string $lang): void
    {
        $cache = new Cache();
        $cacheKey = 'rss_feed_' . $lang;
        
        if ($cachedContent = $cache->get($cacheKey)) {
            header('Content-Type: application/rss+xml; charset=utf-8');
            echo $cachedContent;
            exit;
        }

        $supported = unserialize(SUPPORTED_LANGS);
        if (!in_array($lang, $supported)) {
            $lang = DEFAULT_LANG;
        }

        $articleModel = new Article();
        $articles = $articleModel->getPublished($lang, 1, 20);
        
        $titleField = 'title_' . $lang;
        $excerptField = 'excerpt_' . $lang;
        $slugField = 'slug_' . $lang;
        
        ob_start();
        
        $siteName = $this->getSettings()->{'site_name_' . $lang} ?? 'LVINPress';
        $siteDesc = $this->getSettings()->{'site_description_' . $lang} ?? '';
        
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        echo '<channel>' . "\n";
        echo '<title>' . htmlspecialchars($siteName) . '</title>' . "\n";
        echo '<link>' . APP_URL . '/' . $lang . '</link>' . "\n";
        echo '<description>' . htmlspecialchars($siteDesc) . '</description>' . "\n";
        echo '<language>' . $lang . '</language>' . "\n";
        echo '<atom:link href="' . APP_URL . '/feed/' . $lang . '/rss" rel="self" type="application/rss+xml"/>' . "\n";
        
        foreach ($articles['items'] ?? [] as $article) {
            $title = $article->$titleField ?: $article->title_ku;
            $excerpt = $article->$excerptField ?: $article->excerpt_ku ?: '';
            $slug = $article->$slugField ?: $article->slug_en ?: $article->slug_ku;
            $url = APP_URL . '/' . $lang . '/article/' . $slug;
            
            echo '<item>' . "\n";
            echo '<title>' . htmlspecialchars($title) . '</title>' . "\n";
            echo '<link>' . $url . '</link>' . "\n";
            echo '<guid>' . $url . '</guid>' . "\n";
            echo '<description>' . htmlspecialchars($excerpt) . '</description>' . "\n";
            echo '<pubDate>' . date('r', strtotime($article->published_at ?? $article->created_at)) . '</pubDate>' . "\n";
            if ($article->featured_image) {
                echo '<enclosure url="' . upload_url($article->featured_image) . '" type="image/jpeg"/>' . "\n";
            }
            echo '</item>' . "\n";
        }
        
        echo '</channel>' . "\n";
        echo '</rss>';
        
        $content = ob_get_clean();
        $cache->set($cacheKey, $content, 3600); // 1 hour cache
        
        header('Content-Type: application/rss+xml; charset=utf-8');
        echo $content;
        exit;
    }
}
