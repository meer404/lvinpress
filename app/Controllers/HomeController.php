<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Category;

use App\Helpers\WidgetHelper;

class HomeController extends Controller
{
    public function index(string $lang = ''): void
    {
        if ($lang && in_array($lang, unserialize(SUPPORTED_LANGS))) {
            $_SESSION['lang'] = $lang;
            $this->lang = $lang;
            $this->loadLanguage();
            $rtlLangs = unserialize(RTL_LANGS);
            $this->isRtl = in_array($this->lang, $rtlLangs);
        }

        $articleModel = new Article();
        $categoryModel = new Category();
        $widgetHelper = new WidgetHelper();

        $featured = $articleModel->getFeatured($this->lang, 5);
        $latest = $articleModel->getPublished($this->lang, 1, 8);
        $trending = $articleModel->getTrending($this->lang, 5);
        $breaking = $articleModel->getBreaking($this->lang, 3);
        $byCategories = $articleModel->getLatestByCategories($this->lang, 4);
        $categories = $categoryModel->getMenu($this->lang);

        // Breaking news ticker
        $breakingNews = $this->db->fetchAll(
            "SELECT * FROM lvp_breaking_news WHERE is_active = 1 AND (expires_at IS NULL OR expires_at > NOW()) ORDER BY priority DESC"
        );

        // Active poll
        $poll = $this->db->fetch(
            "SELECT * FROM lvp_polls WHERE is_active = 1 AND (expires_at IS NULL OR expires_at > NOW()) ORDER BY created_at DESC LIMIT 1"
        );

        // Widgets
        $weather = $widgetHelper->getWeather($this->getSettings()->weather_city ?? 'Erbil');
        $currency = $widgetHelper->getCurrency();

        $this->view('frontend.home', [
            'featured' => $featured,
            'latest' => $latest,
            'trending' => $trending,
            'breaking' => $breaking,
            'byCategories' => $byCategories,
            'categories' => $categories,
            'breakingNews' => $breakingNews,
            'poll' => $poll,
            'weather' => $weather,
            'currency' => $currency,
            'meta' => [
                'title' => $this->t('home') . ' - ' . ($this->getSettings()->{'site_name_' . $this->lang} ?? 'LVINPress'),
                'description' => $this->getSettings()->{'site_description_' . $this->lang} ?? ''
            ]
        ]);
    }
}
