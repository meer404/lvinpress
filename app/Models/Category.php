<?php
namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    protected string $table = 'lvp_categories';

    public function getActive(string $lang = 'ku'): array
    {
        return $this->db->fetchAll(
            "SELECT c.*, 
                    (SELECT COUNT(*) FROM lvp_articles a WHERE a.category_id = c.id AND a.status = 'published') as article_count
             FROM {$this->table} c
             WHERE c.is_active = 1
             ORDER BY c.sort_order ASC"
        );
    }

    public function getMenu(string $lang = 'ku'): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE is_active = 1 AND show_in_menu = 1 ORDER BY sort_order ASC"
        );
    }

    public function getBySlug(string $slug): ?object
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE slug_en = ? OR slug_ku = ? OR slug_ar = ?",
            [$slug, $slug, $slug]
        );
    }
}
