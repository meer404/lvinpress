<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

class PageController extends Controller
{
    public function show(string $lang, string $slug): void
    {
        $supported = unserialize(SUPPORTED_LANGS);
        if (in_array($lang, $supported)) {
            $_SESSION['lang'] = $lang;
            $this->lang = $lang;
            $this->loadLanguage();
        }

        $page = $this->db->fetch(
            "SELECT * FROM lvp_pages WHERE slug = ? AND status = 'published'",
            [$slug]
        );
        
        if (!$page) {
            http_response_code(404);
            require VIEW_PATH . '/errors/404.php';
            return;
        }

        $titleField = 'title_' . $this->lang;
        $contentField = 'content_' . $this->lang;
        
        $categoryModel = new Category();
        $categories = $categoryModel->getMenu($this->lang);

        $this->view('frontend.page', [
            'page' => $page,
            'categories' => $categories,
            'meta' => [
                'title' => $page->$titleField ?: $page->title_en,
                'description' => excerpt(strip_tags($page->$contentField ?: $page->content_en), 160)
            ]
        ]);
    }
}
