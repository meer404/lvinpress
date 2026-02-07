<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm(): void
    {
        if ($this->getCurrentUser()) {
            $this->redirect(APP_URL);
        }
        $this->view('frontend.auth.login', [
            'meta' => ['title' => $this->t('login')]
        ]);
    }

    public function login(): void
    {
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/login');
        }

        $login = $this->sanitize($this->input('login', ''));
        $password = $this->input('password', '');

        $userModel = new User();
        $user = $userModel->authenticate($login, $password);

        if ($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_role'] = $user->role;
            
            if (in_array($user->role, ['admin', 'editor'])) {
                $this->redirect(APP_URL . '/admin');
            } else {
                $this->redirect(APP_URL . '/' . $this->lang);
            }
        } else {
            flash('error', 'Invalid credentials');
            $this->redirect(APP_URL . '/login');
        }
    }

    public function registerForm(): void
    {
        if ($this->getCurrentUser()) {
            $this->redirect(APP_URL);
        }
        $this->view('frontend.auth.register', [
            'meta' => ['title' => $this->t('register')]
        ]);
    }

    public function register(): void
    {
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/register');
        }

        $username = $this->sanitize($this->input('username', ''));
        $email = $this->sanitize($this->input('email', ''));
        $password = $this->input('password', '');
        $confirmPassword = $this->input('confirm_password', '');
        $fullName = $this->sanitize($this->input('full_name', ''));

        // Validation
        $errors = [];
        if (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email';
        if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters';
        if ($password !== $confirmPassword) $errors[] = 'Passwords do not match';

        $userModel = new User();
        if ($userModel->findByUsername($username)) $errors[] = 'Username already exists';
        if ($userModel->findByEmail($email)) $errors[] = 'Email already exists';

        if (!empty($errors)) {
            flash('errors', $errors);
            $this->redirect(APP_URL . '/register');
            return;
        }

        $userId = $userModel->create([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, HASH_ALGO, ['cost' => HASH_COST]),
            'full_name_en' => $fullName,
            'full_name_ku' => $fullName,
            'full_name_ar' => $fullName,
            'role' => 'subscriber',
            'status' => 'active'
        ]);

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_role'] = 'subscriber';
        $this->redirect(APP_URL . '/' . $this->lang);
    }

    public function logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['user_role']);
        session_destroy();
        session_start();
        $this->redirect(APP_URL . '/login');
    }
}
