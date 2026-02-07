<?php
namespace App\Core;

abstract class Controller
{
    protected Database $db;
    protected string $lang;
    protected bool $isRtl;
    protected array $langData = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->lang = $_SESSION['lang'] ?? DEFAULT_LANG;
        $rtlLangs = unserialize(RTL_LANGS);
        $this->isRtl = in_array($this->lang, $rtlLangs);
        $this->loadLanguage();
    }

    protected function loadLanguage(): void
    {
        $langFile = ROOT_PATH . '/config/lang/' . $this->lang . '.php';
        if (file_exists($langFile)) {
            $this->langData = require $langFile;
        }
    }

    protected function t(string $key, array $replace = []): string
    {
        $text = $this->langData[$key] ?? $key;
        foreach ($replace as $k => $v) {
            $text = str_replace(':' . $k, $v, $text);
        }
        return $text;
    }

    protected function view(string $view, array $data = []): void
    {
        $data['lang'] = $this->lang;
        $data['isRtl'] = $this->isRtl;
        $data['dir'] = $this->isRtl ? 'rtl' : 'ltr';
        $data['langNames'] = unserialize(LANG_NAMES);
        $data['t'] = fn($key, $replace = []) => $this->t($key, $replace);
        $data['currentUser'] = $this->getCurrentUser();
        $data['settings'] = $this->getSettings();
        
        extract($data);
        
        $viewFile = VIEW_PATH . '/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewFile)) {
            throw new \Exception("View {$view} not found at {$viewFile}");
        }
        
        ob_start();
        require $viewFile;
        echo ob_get_clean();
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function getCurrentUser(): ?object
    {
        if (!isset($_SESSION['user_id'])) return null;
        
        return $this->db->fetch(
            "SELECT * FROM " . DB_PREFIX . "users WHERE id = ? AND status = 'active'",
            [$_SESSION['user_id']]
        );
    }

    protected function requireAuth(): void
    {
        if (!$this->getCurrentUser()) {
            $this->redirect(APP_URL . '/login');
        }
    }

    protected function requireAdmin(): void
    {
        $user = $this->getCurrentUser();
        if (!$user || !in_array($user->role, ['admin', 'editor'])) {
            http_response_code(403);
            require VIEW_PATH . '/errors/403.php';
            exit;
        }
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(): bool
    {
        $token = $_POST[CSRF_TOKEN_NAME] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    protected function getSettings(): object
    {
        static $settings = null;
        if ($settings === null) {
            try {
                $rows = $this->db->fetchAll("SELECT setting_key, setting_value FROM " . DB_PREFIX . "settings");
                $s = new \stdClass();
                foreach ($rows as $row) {
                    $s->{$row->setting_key} = $row->setting_value;
                }
                $settings = $s;
            } catch (\Exception $e) {
                $settings = new \stdClass();
            }
        }
        return $settings;
    }

    protected function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
