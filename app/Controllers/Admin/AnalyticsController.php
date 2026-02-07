<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class AnalyticsController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        
        // Basic analytics data
        $totalArticles = $this->db->fetch("SELECT COUNT(*) as total FROM lvp_articles")->total ?? 0;
        $totalViews = $this->db->fetch("SELECT SUM(views) as total FROM lvp_articles")->total ?? 0;
        $totalUsers = $this->db->fetch("SELECT COUNT(*) as total FROM lvp_users")->total ?? 0;
        $totalComments = $this->db->fetch("SELECT COUNT(*) as total FROM lvp_comments")->total ?? 0;
        
        $this->view('admin.analytics.index', [
            'pageTitle' => 'Analytics',
            'totalArticles' => $totalArticles,
            'totalViews' => $totalViews,
            'totalUsers' => $totalUsers,
            'totalComments' => $totalComments
        ]);
    }
}
