<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(string $lang, string $slug): void
    {
        $categoryModel = new Category();
        $articleModel = new Article();

        $category = $categoryModel->getBySlug($slug);
        
        if (!$category) {
            http_response_code(404);
            require VIEW_PATH . '/errors/404.php';
            return;
        }

        $page = (int)($_GET['page'] ?? 1);
        $result = $articleModel->getByCategory($slug, $this->lang, $page, ARTICLES_PER_PAGE);
        $categories = $categoryModel->getMenu($this->lang);

        $nameField = 'name_' . $this->lang;
        $this->view('frontend.category', [
            'category' => $category,
            'articles' => $result['items'] ?? [],
            'totalArticles' => $result['total'] ?? 0,
            'totalPages' => $result['totalPages'] ?? 1,
            'currentPage' => $result['page'] ?? 1,
            'categories' => $categories,
            'meta' => [
                'title' => $category->$nameField ?? $category->name_en,
                'description' => $category->{'description_' . $this->lang} ?? ''
            ]
        ]);
    }
}
