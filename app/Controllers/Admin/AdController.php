<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class AdController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $ads = $this->db->fetchAll("SELECT * FROM lvp_ads ORDER BY position, created_at DESC");
        $this->view('admin.ads.index', [
            'pageTitle' => 'Ads Management',
            'ads' => $ads
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/ads');
        }

        $this->db->insert('lvp_ads', [
            'title' => $this->sanitize($this->input('title', '')),
            'code' => $this->input('code', ''),
            'position' => $this->sanitize($this->input('position', 'sidebar')),
            'is_active' => $this->input('is_active', 0)
        ]);

        flash('success', 'Ad created successfully');
        $this->redirect(APP_URL . '/admin/ads');
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/ads');
        }

        $this->db->update('lvp_ads', [
            'title' => $this->sanitize($this->input('title', '')),
            'code' => $this->input('code', ''),
            'position' => $this->sanitize($this->input('position', 'sidebar')),
            'is_active' => $this->input('is_active', 0)
        ], 'id = ?', [(int)$id]);

        flash('success', 'Ad updated successfully');
        $this->redirect(APP_URL . '/admin/ads');
    }

    public function delete(string $id): void
    {
        $this->requireAdmin();
        $this->db->delete('lvp_ads', 'id = ?', [(int)$id]);
        flash('success', 'Ad deleted');
        $this->redirect(APP_URL . '/admin/ads');
    }
}
