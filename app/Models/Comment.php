<?php
namespace App\Models;

use App\Core\Model;

class Comment extends Model
{
    protected string $table = 'lvp_comments';

    public function getByArticle(int $articleId, string $status = 'approved', string $lang = 'en'): array
    {
        return $this->db->fetchAll(
            "SELECT c.*, u.full_name_{$lang} as user_name, u.avatar as user_avatar
             FROM {$this->table} c
             LEFT JOIN lvp_users u ON c.user_id = u.id
             WHERE c.article_id = ? AND c.status = ? AND c.parent_id IS NULL
             ORDER BY c.created_at DESC",
            [$articleId, $status]
        );
    }

    public function getReplies(int $commentId, string $lang = 'en'): array
    {
        return $this->db->fetchAll(
            "SELECT c.*, u.full_name_{$lang} as user_name, u.avatar as user_avatar
             FROM {$this->table} c
             LEFT JOIN lvp_users u ON c.user_id = u.id
             WHERE c.parent_id = ? AND c.status = 'approved'
             ORDER BY c.created_at ASC",
            [$commentId]
        );
    }

    public function getPending(): array
    {
        return $this->db->fetchAll(
            "SELECT c.*, a.title_en as article_title
             FROM {$this->table} c
             LEFT JOIN lvp_articles a ON c.article_id = a.id
             WHERE c.status = 'pending'
             ORDER BY c.created_at DESC"
        );
    }
}
