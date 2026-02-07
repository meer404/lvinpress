<?php
namespace App\Models;

use App\Core\Model;

class Article extends Model
{
    protected string $table = 'lvp_articles';

    public function getPublished(string $lang = 'ku', int $page = 1, int $perPage = 12, ?int $categoryId = null): array
    {
        $where = "status = 'published' AND published_at <= NOW()";
        $params = [];
        
        if ($categoryId) {
            $where .= " AND category_id = ?";
            $params[] = $categoryId;
        }
        
        $offset = ($page - 1) * $perPage;
        $total = $this->db->count($this->table, $where, $params);
        $totalPages = max(1, ceil($total / $perPage));
        
        $items = $this->db->fetchAll(
            "SELECT a.*, 
                    c.name_{$lang} as category_name, c.slug_en as category_slug, c.color as category_color,
                    u.full_name_{$lang} as author_name, u.avatar as author_avatar, u.username
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             LEFT JOIN lvp_users u ON a.user_id = u.id
             WHERE a.{$where}
             ORDER BY a.published_at DESC
             LIMIT {$perPage} OFFSET {$offset}",
            $params
        );
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'hasNext' => $page < $totalPages,
            'hasPrev' => $page > 1
        ];
    }

    public function getFeatured(string $lang = 'ku', int $limit = 5): array
    {
        return $this->db->fetchAll(
            "SELECT a.*, 
                    c.name_{$lang} as category_name, c.slug_en as category_slug, c.color as category_color,
                    u.full_name_{$lang} as author_name, u.avatar as author_avatar
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             LEFT JOIN lvp_users u ON a.user_id = u.id
             WHERE a.status = 'published' AND a.is_featured = 1 AND a.published_at <= NOW()
             ORDER BY a.published_at DESC
             LIMIT ?",
            [$limit]
        );
    }

    public function getBreaking(string $lang = 'ku', int $limit = 3): array
    {
        return $this->db->fetchAll(
            "SELECT a.*, c.name_{$lang} as category_name, c.slug_en as category_slug, c.color as category_color
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             WHERE a.status = 'published' AND a.is_breaking = 1 AND a.published_at <= NOW()
             ORDER BY a.published_at DESC
             LIMIT ?",
            [$limit]
        );
    }

    public function getTrending(string $lang = 'ku', int $limit = 5): array
    {
        return $this->db->fetchAll(
            "SELECT a.*, c.name_{$lang} as category_name, c.slug_en as category_slug, c.color as category_color
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             WHERE a.status = 'published' AND a.published_at <= NOW()
             AND a.published_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
             ORDER BY a.views DESC
             LIMIT ?",
            [$limit]
        );
    }

    public function getByCategory(string $categorySlug, string $lang = 'ku', int $page = 1, int $perPage = 12): array
    {
        $offset = ($page - 1) * $perPage;
        
        $total = $this->db->fetch(
            "SELECT COUNT(*) as total FROM {$this->table} a 
             JOIN lvp_categories c ON a.category_id = c.id 
             WHERE c.slug_en = ? AND a.status = 'published'",
            [$categorySlug]
        )->total;
        
        $totalPages = max(1, ceil($total / $perPage));
        
        $items = $this->db->fetchAll(
            "SELECT a.*, 
                    c.name_{$lang} as category_name, c.slug_en as category_slug, c.color as category_color,
                    u.full_name_{$lang} as author_name, u.avatar as author_avatar
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             LEFT JOIN lvp_users u ON a.user_id = u.id
             WHERE c.slug_en = ? AND a.status = 'published' AND a.published_at <= NOW()
             ORDER BY a.published_at DESC
             LIMIT {$perPage} OFFSET {$offset}",
            [$categorySlug]
        );
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'hasNext' => $page < $totalPages,
            'hasPrev' => $page > 1
        ];
    }

    public function getBySlug(string $slug, string $lang = 'ku'): ?object
    {
        return $this->db->fetch(
            "SELECT a.*, 
                    c.name_{$lang} as category_name, c.slug_en as category_slug, c.color as category_color,
                    u.full_name_{$lang} as author_name, u.avatar as author_avatar, u.username,
                    u.bio_{$lang} as author_bio, u.social_facebook, u.social_twitter, u.social_instagram
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             LEFT JOIN lvp_users u ON a.user_id = u.id
             WHERE (a.slug_ku = ? OR a.slug_en = ? OR a.slug_ar = ?) AND a.status = 'published'",
            [$slug, $slug, $slug]
        );
    }

    public function getRelated(int $articleId, int $categoryId, string $lang = 'ku', int $limit = 4): array
    {
        return $this->db->fetchAll(
            "SELECT a.*, c.name_{$lang} as category_name, c.slug_en as category_slug, c.color as category_color
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             WHERE a.id != ? AND a.category_id = ? AND a.status = 'published'
             ORDER BY a.published_at DESC
             LIMIT ?",
            [$articleId, $categoryId, $limit]
        );
    }

    public function incrementViews(int $id): void
    {
        $this->db->query("UPDATE {$this->table} SET views = views + 1 WHERE id = ?", [$id]);
    }

    public function search(string $query, string $lang = 'ku', int $page = 1, int $perPage = 12): array
    {
        $offset = ($page - 1) * $perPage;
        $searchField = "title_{$lang}";
        $contentField = "content_{$lang}";
        $searchTerm = "%{$query}%";
        
        $total = $this->db->fetch(
            "SELECT COUNT(*) as total FROM {$this->table} 
             WHERE status = 'published' AND ({$searchField} LIKE ? OR {$contentField} LIKE ?)",
            [$searchTerm, $searchTerm]
        )->total;
        
        $totalPages = max(1, ceil($total / $perPage));
        
        $items = $this->db->fetchAll(
            "SELECT a.*, 
                    c.name_{$lang} as category_name, c.slug_en as category_slug, c.color as category_color,
                    u.full_name_{$lang} as author_name
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             LEFT JOIN lvp_users u ON a.user_id = u.id
             WHERE a.status = 'published' AND (a.{$searchField} LIKE ? OR a.{$contentField} LIKE ?)
             ORDER BY a.published_at DESC
             LIMIT {$perPage} OFFSET {$offset}",
            [$searchTerm, $searchTerm]
        );
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'query' => $query
        ];
    }

    public function getLatestByCategories(string $lang = 'ku', int $perCategory = 4): array
    {
        $categories = $this->db->fetchAll(
            "SELECT * FROM lvp_categories WHERE is_active = 1 AND show_in_menu = 1 ORDER BY sort_order"
        );
        
        $result = [];
        foreach ($categories as $cat) {
            $articles = $this->db->fetchAll(
                "SELECT a.*, 
                        u.full_name_{$lang} as author_name, u.avatar as author_avatar
                 FROM {$this->table} a
                 LEFT JOIN lvp_users u ON a.user_id = u.id
                 WHERE a.category_id = ? AND a.status = 'published' AND a.published_at <= NOW()
                 ORDER BY a.published_at DESC
                 LIMIT ?",
                [$cat->id, $perCategory]
            );
            
            if (!empty($articles)) {
                $result[] = [
                    'category' => $cat,
                    'articles' => $articles
                ];
            }
        }
        
        return $result;
    }

    public function getForAdmin(int $page = 1, int $perPage = 20, ?string $status = null): array
    {
        $where = '1=1';
        $params = [];
        
        if ($status) {
            $where .= " AND a.status = ?";
            $params[] = $status;
        }
        
        $offset = ($page - 1) * $perPage;
        $total = $this->db->fetch(
            "SELECT COUNT(*) as total FROM {$this->table} a WHERE {$where}",
            $params
        )->total;
        
        $totalPages = max(1, ceil($total / $perPage));
        
        $items = $this->db->fetchAll(
            "SELECT a.*, c.name_en as category_name, u.username as author_username
             FROM {$this->table} a
             LEFT JOIN lvp_categories c ON a.category_id = c.id
             LEFT JOIN lvp_users u ON a.user_id = u.id
             WHERE {$where}
             ORDER BY a.created_at DESC
             LIMIT {$perPage} OFFSET {$offset}",
            $params
        );
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages
        ];
    }
}
