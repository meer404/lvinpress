<?php
namespace App\Controllers\Api;

use App\Core\Controller;

class CommentController extends Controller
{
    public function store(): void
    {
        $articleId = (int)($_POST['article_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        $parentId = (int)($_POST['parent_id'] ?? 0) ?: null;
        
        if (!$articleId || !$content) {
            $this->json(['success' => false, 'message' => 'Missing required fields'], 400);
            return;
        }

        $data = [
            'article_id' => $articleId,
            'content' => $this->sanitize($content),
            'parent_id' => $parentId,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'status' => 'pending'
        ];

        $user = $this->getCurrentUser();
        if ($user) {
            $data['user_id'] = $user->id;
            $data['author_name'] = $user->{'full_name_' . $this->lang};
            $data['author_email'] = $user->email;
        } else {
            $data['author_name'] = $this->sanitize($_POST['name'] ?? 'Anonymous');
            $data['author_email'] = $this->sanitize($_POST['email'] ?? '');
        }

        $this->db->insert('lvp_comments', $data);
        $this->json(['success' => true, 'message' => 'Comment submitted for moderation']);
    }
}
