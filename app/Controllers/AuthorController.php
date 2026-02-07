<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;

class AuthorController extends Controller
{
    public function show(string $lang, string $id): void
    {
        $supported = unserialize(SUPPORTED_LANGS);
        if (in_array($lang, $supported)) {
            $_SESSION['lang'] = $lang;
            $this->lang = $lang;
            $this->loadLanguage();
        }

        $author = $this->db->fetch(
            "SELECT * FROM lvp_users WHERE id = ? AND status = 'active'",
            [(int)$id]
        );
        
        if (!$author) {
            http_response_code(404);
            require VIEW_PATH . '/errors/404.php';
            return;
        }

        $articleModel = new Article();
        $page = (int)($_GET['page'] ?? 1);
        
        $nameField = 'full_name_' . $this->lang;
        $bioField = 'bio_' . $this->lang;
        
        // Get author's articles
        $offset = ($page - 1) * ARTICLES_PER_PAGE;
        $total = $this->db->fetch(
            "SELECT COUNT(*) as total FROM lvp_articles WHERE user_id = ? AND status = 'published'",
            [$author->id]
        )->total;
        
        $articles = $this->db->fetchAll(
            "SELECT a.*, c.name_{$this->lang} as category_name, c.slug_en as category_slug, c.color as category_color
             FROM lvp_articles a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             WHERE a.user_id = ? AND a.status = 'published'
             ORDER BY a.published_at DESC
             LIMIT ? OFFSET ?",
            [$author->id, ARTICLES_PER_PAGE, $offset]
        );
        
        $totalPages = max(1, ceil($total / ARTICLES_PER_PAGE));

        $this->view('frontend.author', [
            'author' => $author,
            'articles' => $articles,
            'totalArticles' => $total,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'meta' => [
                'title' => $author->$nameField ?: $author->full_name_en ?: $author->username,
                'description' => excerpt($author->$bioField ?? '', 160)
            ]
        ]);
    }
}
