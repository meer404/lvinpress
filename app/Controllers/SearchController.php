<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;

class SearchController extends Controller
{
    public function index(string $lang): void
    {
        $query = trim($_GET['q'] ?? '');
        $page = (int)($_GET['page'] ?? 1);
        
        $results = ['items' => [], 'total' => 0, 'page' => 1, 'totalPages' => 1, 'query' => $query];
        
        if ($query) {
            $articleModel = new Article();
            $results = $articleModel->search($query, $this->lang, $page, ARTICLES_PER_PAGE);
        }

        $this->view('frontend.search', [
            'articles' => $results['items'] ?? [],
            'totalArticles' => $results['total'] ?? 0,
            'totalPages' => $results['totalPages'] ?? 1,
            'currentPage' => $results['page'] ?? 1,
            'query' => $query,
            'meta' => [
                'title' => $this->t('search_results') . ': ' . $query,
                'description' => $this->t('search_for') . ' ' . $query
            ]
        ]);
    }
}
