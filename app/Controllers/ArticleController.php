<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Comment;

use App\Models\Reaction;

class ArticleController extends Controller
{
    public function show(string $lang, string $slug): void
    {
        $articleModel = new Article();
        $commentModel = new Comment();
        $reactionModel = new Reaction();

        $article = $articleModel->getBySlug($slug, $this->lang);
        
        if (!$article) {
            http_response_code(404);
            require VIEW_PATH . '/errors/404.php';
            return;
        }

        // Increment views
        $articleModel->incrementViews($article->id);

        $related = $articleModel->getRelated($article->id, $article->category_id, $this->lang, 4);
        $comments = $commentModel->getByArticle($article->id, 'approved', $this->lang);
        $reactions = $reactionModel->getCounts($article->id);

        // Check bookmark status & reaction
        $isBookmarked = false;
        $userReaction = null;
        
        // Get IP address for reaction checking (even for guests)
        $ip = $_SERVER['REMOTE_ADDR'];
        $userId = null;

        if ($user = $this->getCurrentUser()) {
            $userId = $user->id;
            $bookmark = $this->db->fetch(
                "SELECT id FROM lvp_bookmarks WHERE user_id = ? AND article_id = ?",
                [$user->id, $article->id]
            );
            $isBookmarked = (bool) $bookmark;
        }

        $userReaction = $reactionModel->getUserReaction($article->id, $ip, $userId);

        // Get tags
        $tags = $this->db->fetchAll(
            "SELECT t.* FROM lvp_tags t JOIN lvp_article_tags at ON t.id = at.tag_id WHERE at.article_id = ?",
            [$article->id]
        );

        $titleField = 'title_' . $this->lang;
        $this->view('frontend.article', [
            'article' => $article,
            'related' => $related,
            'comments' => $comments,
            'tags' => $tags,
            'isBookmarked' => $isBookmarked,
            'reactions' => $reactions,
            'userReaction' => $userReaction,
            'meta' => [
                'title' => $article->$titleField ?? $article->title_ku,
                'description' => excerpt($article->{'excerpt_' . $this->lang} ?? $article->excerpt_ku ?? '', 160),
                'image' => $article->featured_image ? upload_url($article->featured_image) : '',
                'type' => 'article',
                'article' => [
                    'published' => $article->published_at,
                    'author' => $article->author_name ?? ''
                ]
            ]
        ]);
    }

    public function react(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $articleId = (int) ($input['article_id'] ?? 0);
        $type = $input['type'] ?? '';

        if (!$articleId || !in_array($type, ['like', 'love', 'wow', 'sad', 'angry'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }

        $reactionModel = new Reaction();
        $ip = $_SERVER['REMOTE_ADDR'];
        $userId = $this->getCurrentUser() ? $this->getCurrentUser()->id : null;

        // Check if removing (clicking same reaction)
        $current = $reactionModel->getUserReaction($articleId, $ip, $userId);
        
        if ($current === $type) {
            $reactionModel->remove($articleId, $ip, $userId);
            $action = 'removed';
        } else {
            $reactionModel->add($articleId, $ip, $type, $userId);
            $action = 'added';
        }

        $counts = $reactionModel->getCounts($articleId);
        
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'action' => $action, 'counts' => $counts]);
    }
}
