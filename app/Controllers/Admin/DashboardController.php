<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();

        $stats = [
            'articles' => $this->db->count('lvp_articles'),
            'published' => $this->db->count('lvp_articles', "status = 'published'"),
            'drafts' => $this->db->count('lvp_articles', "status = 'draft'"),
            'categories' => $this->db->count('lvp_categories'),
            'users' => $this->db->count('lvp_users'),
            'comments' => $this->db->count('lvp_comments'),
            'pending_comments' => $this->db->count('lvp_comments', "status = 'pending'"),
            'newsletter' => $this->db->count('lvp_newsletter', 'is_active = 1'),
            'total_views' => $this->db->fetch("SELECT COALESCE(SUM(views),0) as total FROM lvp_articles")->total,
        ];

        $recentArticles = $this->db->fetchAll(
            "SELECT a.*, u.username FROM lvp_articles a LEFT JOIN lvp_users u ON a.user_id = u.id ORDER BY a.created_at DESC LIMIT 10"
        );

        $recentComments = $this->db->fetchAll(
            "SELECT c.*, a.title_en as article_title FROM lvp_comments c LEFT JOIN lvp_articles a ON c.article_id = a.id ORDER BY c.created_at DESC LIMIT 10"
        );

        // Monthly views chart data
        $monthlyViews = $this->db->fetchAll(
            "SELECT DATE_FORMAT(visited_at, '%Y-%m') as month, COUNT(*) as visits 
             FROM lvp_analytics 
             WHERE visited_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
             GROUP BY month ORDER BY month"
        );

        // Top articles
        $topArticles = $this->db->fetchAll(
            "SELECT title_en, title_ku, views, slug_en FROM lvp_articles WHERE status = 'published' ORDER BY views DESC LIMIT 5"
        );

        $this->view('admin.dashboard', [
            'stats' => $stats,
            'recentArticles' => $recentArticles,
            'recentComments' => $recentComments,
            'monthlyViews' => $monthlyViews,
            'topArticles' => $topArticles,
            'pageTitle' => 'Dashboard'
        ]);
    }
}
