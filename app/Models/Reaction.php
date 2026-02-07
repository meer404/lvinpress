<?php
namespace App\Models;

use App\Core\Model;

class Reaction extends Model
{
    protected string $table = 'lvp_article_reactions';

    public function add(int $articleId, string $ipAddress, string $type, ?int $userId = null): bool
    {
        // Check if exists
        $existing = $this->db->fetch(
            "SELECT id FROM {$this->table} WHERE article_id = ? AND ip_address = ? AND (user_id = ? OR user_id IS NULL)",
            [$articleId, $ipAddress, $userId]
        );

        if ($existing) {
            // Update existing
            return $this->db->query(
                "UPDATE {$this->table} SET reaction_type = ? WHERE id = ?",
                [$type, $existing->id]
            );
        } else {
            // Insert new
            return $this->db->query(
                "INSERT INTO {$this->table} (article_id, user_id, ip_address, reaction_type) VALUES (?, ?, ?, ?)",
                [$articleId, $userId, $ipAddress, $type]
            );
        }
    }

    public function remove(int $articleId, string $ipAddress, ?int $userId = null): bool
    {
        return $this->db->query(
            "DELETE FROM {$this->table} WHERE article_id = ? AND ip_address = ? AND (user_id = ? OR user_id IS NULL)",
            [$articleId, $ipAddress, $userId]
        );
    }

    public function getCounts(int $articleId): array
    {
        $rows = $this->db->fetchAll(
            "SELECT reaction_type, COUNT(*) as count FROM {$this->table} WHERE article_id = ? GROUP BY reaction_type",
            [$articleId]
        );

        $counts = [
            'like' => 0,
            'love' => 0,
            'wow' => 0,
            'sad' => 0,
            'angry' => 0
        ];

        foreach ($rows as $row) {
            $counts[$row->reaction_type] = (int)$row->count;
        }

        return $counts;
    }

    public function getUserReaction(int $articleId, string $ipAddress, ?int $userId = null): ?string
    {
        $row = $this->db->fetch(
            "SELECT reaction_type FROM {$this->table} WHERE article_id = ? AND ip_address = ? AND (user_id = ? OR user_id IS NULL)",
            [$articleId, $ipAddress, $userId]
        );

        return $row ? $row->reaction_type : null;
    }
}
