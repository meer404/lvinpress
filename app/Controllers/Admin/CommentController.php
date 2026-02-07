<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class CommentController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $status = $_GET['status'] ?? 'pending';
        
        $comments = $this->db->fetchAll(
            "SELECT c.*, a.title_en as article_title, u.username 
             FROM lvp_comments c 
             LEFT JOIN lvp_articles a ON c.article_id = a.id
             LEFT JOIN lvp_users u ON c.user_id = u.id
             WHERE c.status = ?
             ORDER BY c.created_at DESC LIMIT 50",
            [$status]
        );

        $this->view('admin.comments.index', [
            'comments' => $comments,
            'currentStatus' => $status,
            'pageTitle' => 'Comments'
        ]);
    }

    public function approve(string $id): void
    {
        $this->requireAdmin();
        $this->db->update('lvp_comments', ['status' => 'approved'], 'id = ?', [(int)$id]);
        flash('success', 'Comment approved');
        $this->redirect(APP_URL . '/admin/comments');
    }

    public function delete(string $id): void
    {
        $this->requireAdmin();
        $this->db->delete('lvp_comments', 'id = ?', [(int)$id]);
        flash('success', 'Comment deleted');
        $this->redirect(APP_URL . '/admin/comments');
    }
}
