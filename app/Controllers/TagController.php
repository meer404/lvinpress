<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

class TagController extends Controller
{
    public function show(string $lang, string $slug): void
    {
        $supported = unserialize(SUPPORTED_LANGS);
        if (in_array($lang, $supported)) {
            $_SESSION['lang'] = $lang;
            $this->lang = $lang;
            $this->loadLanguage();
        }

        $tag = $this->db->fetch(
            "SELECT * FROM lvp_tags WHERE slug = ?",
            [$slug]
        );
        
        if (!$tag) {
            http_response_code(404);
            require VIEW_PATH . '/errors/404.php';
            return;
        }

        $page = (int)($_GET['page'] ?? 1);
        $offset = ($page - 1) * ARTICLES_PER_PAGE;
        
        $nameField = 'name_' . $this->lang;
        
        // Count total articles with this tag
        $total = $this->db->fetch(
            "SELECT COUNT(*) as total FROM lvp_articles a
             JOIN lvp_article_tags at ON a.id = at.article_id
             WHERE at.tag_id = ? AND a.status = 'published'",
            [$tag->id]
        )->total;
        
        // Get articles with this tag
        $articles = $this->db->fetchAll(
            "SELECT a.*, c.name_{$this->lang} as category_name, c.slug_en as category_slug, c.color as category_color,
                    u.full_name_{$this->lang} as author_name
             FROM lvp_articles a
             JOIN lvp_article_tags at ON a.id = at.article_id
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             LEFT JOIN lvp_users u ON a.user_id = u.id
             WHERE at.tag_id = ? AND a.status = 'published'
             ORDER BY a.published_at DESC
             LIMIT ? OFFSET ?",
            [$tag->id, ARTICLES_PER_PAGE, $offset]
        );
        
        $totalPages = max(1, ceil($total / ARTICLES_PER_PAGE));
        
        $categoryModel = new Category();
        $categories = $categoryModel->getMenu($this->lang);

        $this->view('frontend.tag', [
            'tag' => $tag,
            'articles' => $articles,
            'totalArticles' => $total,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'categories' => $categories,
            'meta' => [
                'title' => $tag->$nameField ?: $tag->name_en ?: $tag->slug,
                'description' => $this->t('tag_description', ['tag' => $tag->$nameField ?: $tag->slug])
            ]
        ]);
    }
}
