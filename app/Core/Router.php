<?php
namespace App\Core;

class Router
{
    protected array $routes = [];
    protected array $params = [];

    public function get(string $path, string $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, string $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    protected function addRoute(string $method, string $path, string $action): void
    {
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'action' => $action,
            'path' => $path
        ];
    }

    /**
     * Add route with constrained language prefix.
     * $path should start with the lang alternatives, e.g. "ku|en|ar" or "ku|en|ar/category/{slug}"
     */
    public function addConstrained(string $method, string $path, string $action): void
    {
        // Replace {param} with regex, but keep the lang constraint as-is
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', $path);
        // Wrap the lang alternatives in a named group
        // Expected: "ku|en|ar" at start, possibly followed by "/..."
        $pattern = preg_replace('/^((?:[a-z]{2}\|)*[a-z]{2})/', '(?P<lang>$1)', $pattern);
        $pattern = '#^/' . $pattern . '$#';
        
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'action' => $action,
            'path' => '/{lang}/' . preg_replace('/^(?:[a-z]{2}\|)*[a-z]{2}\/?/', '', $path)
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getUri();
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;
            
            if (preg_match($route['pattern'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->params = $params;
                
                // Set language from URL
                if (isset($params['lang'])) {
                    $supported = unserialize(SUPPORTED_LANGS);
                    if (in_array($params['lang'], $supported)) {
                        $_SESSION['lang'] = $params['lang'];
                    }
                }
                
                $this->callAction($route['action'], $params);
                return;
            }
        }
        
        // 404 Not Found
        http_response_code(404);
        $lang = $_SESSION['lang'] ?? DEFAULT_LANG;
        require VIEW_PATH . '/errors/404.php';
    }

    protected function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Remove query string
        $uri = strtok($uri, '?');
        
        // Remove base path for subfolder installations
        // Use APP_URL constant to determine base path
        $basePath = parse_url(APP_URL, PHP_URL_PATH) ?: '';
        $basePath = rtrim($basePath, '/');
        
        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        $uri = '/' . trim($uri, '/');
        
        return $uri;
    }

    protected function callAction(string $action, array $params): void
    {
        [$controllerName, $method] = explode('@', $action);
        
        $controllerClass = 'App\\Controllers\\' . $controllerName;
        
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controllerClass} not found");
        }
        
        $controller = new $controllerClass();
        
        if (!method_exists($controller, $method)) {
            throw new \Exception("Method {$method} not found in {$controllerClass}");
        }
        
        call_user_func_array([$controller, $method], $params);
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
