<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class NewsletterController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $subscribers = $this->db->fetchAll("SELECT * FROM lvp_newsletter_subscribers ORDER BY created_at DESC");
        $this->view('admin.newsletters.index', [
            'pageTitle' => 'Newsletter',
            'subscribers' => $subscribers
        ]);
    }

    public function send(): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/newsletters');
        }

        // In production, implement email sending logic
        flash('info', 'Newsletter sending feature coming soon');
        $this->redirect(APP_URL . '/admin/newsletters');
    }
}
