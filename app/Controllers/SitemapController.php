<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Category;

use App\Core\Cache;

class SitemapController extends Controller
{
    public function index(): void
    {
        $cache = new Cache();
        $cacheKey = 'sitemap_index';
        
        if ($cachedContent = $cache->get($cacheKey)) {
            header('Content-Type: application/xml; charset=utf-8');
            echo $cachedContent;
            exit;
        }

        header('Content-Type: application/xml; charset=utf-8');
        
        $supported = unserialize(SUPPORTED_LANGS);
        
        ob_start();
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        foreach ($supported as $lang) {
            echo '<sitemap>' . "\n";
            echo '<loc>' . APP_URL . '/sitemap-' . $lang . '.xml</loc>' . "\n";
            echo '<lastmod>' . date('c') . '</lastmod>' . "\n";
            echo '</sitemap>' . "\n";
        }
        
        echo '</sitemapindex>';
        
        $content = ob_get_clean();
        $cache->set($cacheKey, $content, 86400); // 1 day cache
        
        echo $content;
        exit;
    }

    public function language(string $lang): void
    {
        $supported = unserialize(SUPPORTED_LANGS);
        if (!in_array($lang, $supported)) {
            http_response_code(404);
            return;
        }

        header('Content-Type: application/xml; charset=utf-8');
        
        $articleModel = new Article();
        $categoryModel = new Category();
        
        $articles = $articleModel->getPublished($lang, 1, 1000);
        $categories = $categoryModel->getActive();
        
        $slugField = 'slug_' . $lang;
        
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Homepage
        echo '<url>' . "\n";
        echo '<loc>' . APP_URL . '/' . $lang . '</loc>' . "\n";
        echo '<changefreq>daily</changefreq>' . "\n";
        echo '<priority>1.0</priority>' . "\n";
        echo '</url>' . "\n";
        
        // Categories
        foreach ($categories as $category) {
            echo '<url>' . "\n";
            echo '<loc>' . APP_URL . '/' . $lang . '/category/' . $category->slug_en . '</loc>' . "\n";
            echo '<changefreq>daily</changefreq>' . "\n";
            echo '<priority>0.8</priority>' . "\n";
            echo '</url>' . "\n";
        }
        
        // Articles
        foreach ($articles['items'] ?? [] as $article) {
            $slug = $article->$slugField ?: $article->slug_en ?: $article->slug_ku;
            echo '<url>' . "\n";
            echo '<loc>' . APP_URL . '/' . $lang . '/article/' . $slug . '</loc>' . "\n";
            echo '<lastmod>' . date('c', strtotime($article->updated_at ?? $article->created_at)) . '</lastmod>' . "\n";
            echo '<changefreq>weekly</changefreq>' . "\n";
            echo '<priority>0.6</priority>' . "\n";
            echo '</url>' . "\n";
        }
        
        echo '</urlset>';
        exit;
    }
}
