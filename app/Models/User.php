<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'lvp_users';

    public function findByEmail(string $email): ?object
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE email = ?", [$email]);
    }

    public function findByUsername(string $username): ?object
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE username = ?", [$username]);
    }

    public function authenticate(string $login, string $password): ?object
    {
        $user = $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE (username = ? OR email = ?) AND status = 'active'",
            [$login, $login]
        );
        
        if ($user && password_verify($password, $user->password)) {
            $this->db->update($this->table, ['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$user->id]);
            return $user;
        }
        
        return null;
    }

    public function getByRole(string $role): array
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} WHERE role = ? ORDER BY created_at DESC", [$role]);
    }
}
