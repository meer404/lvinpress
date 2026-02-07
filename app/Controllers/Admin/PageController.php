<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class PageController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $pages = $this->db->fetchAll("SELECT * FROM lvp_pages ORDER BY created_at DESC");
        $this->view('admin.pages.index', [
            'pageTitle' => 'Pages',
            'pages' => $pages
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->view('admin.pages.form', [
            'pageTitle' => 'Create Page',
            'page' => null
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/pages');
        }

        $this->db->insert('lvp_pages', [
            'slug' => $this->sanitize($this->input('slug', '')),
            'title_ku' => $this->sanitize($this->input('title_ku', '')),
            'title_en' => $this->sanitize($this->input('title_en', '')),
            'title_ar' => $this->sanitize($this->input('title_ar', '')),
            'content_ku' => $this->input('content_ku', ''),
            'content_en' => $this->input('content_en', ''),
            'content_ar' => $this->input('content_ar', ''),
            'status' => $this->input('status', 'draft')
        ]);

        flash('success', 'Page created successfully');
        $this->redirect(APP_URL . '/admin/pages');
    }

    public function edit(string $id): void
    {
        $this->requireAdmin();
        $page = $this->db->fetch("SELECT * FROM lvp_pages WHERE id = ?", [(int)$id]);
        if (!$page) {
            $this->redirect(APP_URL . '/admin/pages');
        }
        $this->view('admin.pages.form', [
            'pageTitle' => 'Edit Page',
            'page' => $page
        ]);
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/pages');
        }

        $this->db->update('lvp_pages', [
            'slug' => $this->sanitize($this->input('slug', '')),
            'title_ku' => $this->sanitize($this->input('title_ku', '')),
            'title_en' => $this->sanitize($this->input('title_en', '')),
            'title_ar' => $this->sanitize($this->input('title_ar', '')),
            'content_ku' => $this->input('content_ku', ''),
            'content_en' => $this->input('content_en', ''),
            'content_ar' => $this->input('content_ar', ''),
            'status' => $this->input('status', 'draft')
        ], 'id = ?', [(int)$id]);

        flash('success', 'Page updated successfully');
        $this->redirect(APP_URL . '/admin/pages');
    }
}
