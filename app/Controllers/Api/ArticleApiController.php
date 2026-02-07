<?php
namespace App\Controllers\Api;

use App\Core\Controller;
use App\Models\Article;

class ArticleApiController extends Controller
{
    public function trending(): void
    {
        $lang = $_GET['lang'] ?? $this->lang;
        $limit = min((int)($_GET['limit'] ?? 5), 20);
        
        $articleModel = new Article();
        $articles = $articleModel->getTrending($lang, $limit);
        
        $this->json(['success' => true, 'data' => $articles]);
    }

    public function search(): void
    {
        $query = trim($_GET['q'] ?? '');
        $lang = $_GET['lang'] ?? $this->lang;
        $page = (int)($_GET['page'] ?? 1);
        
        if (!$query) {
            $this->json(['success' => false, 'message' => 'Query required'], 400);
            return;
        }

        $articleModel = new Article();
        $results = $articleModel->search($query, $lang, $page, 10);
        
        $this->json(['success' => true, 'data' => $results]);
    }
}
