<?php
namespace App\Controllers\Api;

use App\Core\Controller;

class BookmarkController extends Controller
{
    public function toggle(): void
    {
        $user = $this->getCurrentUser();
        if (!$user) {
            $this->json(['success' => false, 'message' => 'Login required'], 401);
            return;
        }

        $articleId = (int)($_POST['article_id'] ?? 0);
        if (!$articleId) {
            $this->json(['success' => false, 'message' => 'Article ID required'], 400);
            return;
        }

        $existing = $this->db->fetch(
            "SELECT id FROM lvp_bookmarks WHERE user_id = ? AND article_id = ?",
            [$user->id, $articleId]
        );

        if ($existing) {
            $this->db->delete('lvp_bookmarks', 'id = ?', [$existing->id]);
            $this->json(['success' => true, 'bookmarked' => false, 'message' => 'Bookmark removed']);
        } else {
            $this->db->insert('lvp_bookmarks', [
                'user_id' => $user->id,
                'article_id' => $articleId
            ]);
            $this->json(['success' => true, 'bookmarked' => true, 'message' => 'Article bookmarked']);
        }
    }
}
