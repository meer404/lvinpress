<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $categoryModel = new Category();
        $categories = $categoryModel->getActive();
        
        $this->view('admin.categories.index', [
            'categories' => $categories,
            'pageTitle' => 'Categories'
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/categories');
        }

        $categoryModel = new Category();
        $categoryModel->create([
            'name_ku' => $this->sanitize($this->input('name_ku', '')),
            'name_en' => $this->sanitize($this->input('name_en', '')),
            'name_ar' => $this->sanitize($this->input('name_ar', '')),
            'slug_ku' => slugify($this->input('name_ku', ''), 'ku'),
            'slug_en' => slugify($this->input('name_en', '')),
            'slug_ar' => slugify($this->input('name_ar', ''), 'ar'),
            'description_ku' => $this->input('description_ku', ''),
            'description_en' => $this->input('description_en', ''),
            'description_ar' => $this->input('description_ar', ''),
            'color' => $this->input('color', '#d4af37'),
            'icon' => $this->sanitize($this->input('icon', '')),
            'sort_order' => (int)$this->input('sort_order', 0),
            'show_in_menu' => (int)$this->input('show_in_menu', 1),
        ]);

        flash('success', 'Category created');
        $this->redirect(APP_URL . '/admin/categories');
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/categories');
        }

        $categoryModel = new Category();
        $categoryModel->update((int)$id, [
            'name_ku' => $this->sanitize($this->input('name_ku', '')),
            'name_en' => $this->sanitize($this->input('name_en', '')),
            'name_ar' => $this->sanitize($this->input('name_ar', '')),
            'slug_ku' => slugify($this->input('name_ku', ''), 'ku'),
            'slug_en' => slugify($this->input('name_en', '')),
            'slug_ar' => slugify($this->input('name_ar', ''), 'ar'),
            'description_ku' => $this->input('description_ku', ''),
            'description_en' => $this->input('description_en', ''),
            'description_ar' => $this->input('description_ar', ''),
            'color' => $this->input('color', '#d4af37'),
            'icon' => $this->sanitize($this->input('icon', '')),
            'sort_order' => (int)$this->input('sort_order', 0),
            'show_in_menu' => (int)$this->input('show_in_menu', 1),
        ]);

        flash('success', 'Category updated');
        $this->redirect(APP_URL . '/admin/categories');
    }

    public function delete(string $id): void
    {
        $this->requireAdmin();
        $categoryModel = new Category();
        $categoryModel->delete((int)$id);
        flash('success', 'Category deleted');
        $this->redirect(APP_URL . '/admin/categories');
    }
}
