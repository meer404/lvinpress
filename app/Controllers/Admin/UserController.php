<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class UserController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $users = $this->db->fetchAll("SELECT * FROM lvp_users ORDER BY created_at DESC");
        
        $this->view('admin.users.index', [
            'users' => $users,
            'pageTitle' => 'Users'
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->view('admin.users.form', ['pageTitle' => 'Add User']);
    }

    public function edit(string $id): void
    {
        $this->requireAdmin();
        $user = $this->db->fetch("SELECT * FROM lvp_users WHERE id = ?", [(int)$id]);
        if (!$user) { $this->redirect(APP_URL . '/admin/users'); return; }
        $this->view('admin.users.form', ['user' => $user, 'pageTitle' => 'Edit User']);
    }

    public function store(): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) { flash('error', 'Invalid token'); $this->redirect(APP_URL . '/admin/users'); }

        $this->db->insert('lvp_users', [
            'username' => $this->sanitize($this->input('username')),
            'email' => $this->sanitize($this->input('email')),
            'password' => password_hash($this->input('password'), HASH_ALGO, ['cost' => HASH_COST]),
            'full_name_ku' => $this->sanitize($this->input('full_name_ku', '')),
            'full_name_en' => $this->sanitize($this->input('full_name_en', '')),
            'full_name_ar' => $this->sanitize($this->input('full_name_ar', '')),
            'role' => $this->input('role', 'writer'),
            'status' => 'active'
        ]);

        flash('success', 'User created');
        $this->redirect(APP_URL . '/admin/users');
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) { flash('error', 'Invalid token'); $this->redirect(APP_URL . '/admin/users'); }

        $data = [
            'full_name_ku' => $this->sanitize($this->input('full_name_ku', '')),
            'full_name_en' => $this->sanitize($this->input('full_name_en', '')),
            'full_name_ar' => $this->sanitize($this->input('full_name_ar', '')),
            'email' => $this->sanitize($this->input('email')),
            'role' => $this->input('role'),
            'status' => $this->input('status', 'active')
        ];

        if ($this->input('password')) {
            $data['password'] = password_hash($this->input('password'), HASH_ALGO, ['cost' => HASH_COST]);
        }

        $this->db->update('lvp_users', $data, 'id = ?', [(int)$id]);
        flash('success', 'User updated');
        $this->redirect(APP_URL . '/admin/users');
    }

    public function delete(string $id): void
    {
        $this->requireAdmin();
        $user = $this->getCurrentUser();
        if ((int)$id === $user->id) {
            flash('error', 'Cannot delete yourself');
            $this->redirect(APP_URL . '/admin/users');
        }
        $this->db->delete('lvp_users', 'id = ?', [(int)$id]);
        flash('success', 'User deleted');
        $this->redirect(APP_URL . '/admin/users');
    }
}
