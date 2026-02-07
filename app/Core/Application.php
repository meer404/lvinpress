<?php
namespace App\Core;

class Application
{
    protected Router $router;
    protected Database $db;
    protected static ?Application $instance = null;

    public function __construct()
    {
        self::$instance = $this;
        $this->router = new Router();
        $this->db = Database::getInstance();
        $this->registerRoutes();
    }

    public static function getInstance(): ?Application
    {
        return self::$instance;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function getDb(): Database
    {
        return $this->db;
    }

    protected function registerRoutes(): void
    {
        // Language prefix middleware
        $lang = $this->detectLanguage();
        $langPattern = implode('|', unserialize(SUPPORTED_LANGS)); // ku|en|ar
        
        // Auth routes (BEFORE language routes to prevent /{lang} catching them)
        $this->router->get('/login', 'AuthController@loginForm');
        $this->router->post('/login', 'AuthController@login');
        $this->router->get('/register', 'AuthController@registerForm');
        $this->router->post('/register', 'AuthController@register');
        $this->router->get('/logout', 'AuthController@logout');

        // Admin routes (BEFORE language routes)
        $this->router->get('/admin', 'Admin\\DashboardController@index');
        $this->router->get('/admin/articles', 'Admin\\ArticleController@index');
        $this->router->get('/admin/articles/create', 'Admin\\ArticleController@create');
        $this->router->post('/admin/articles/store', 'Admin\\ArticleController@store');
        $this->router->get('/admin/articles/edit/{id}', 'Admin\\ArticleController@edit');
        $this->router->post('/admin/articles/update/{id}', 'Admin\\ArticleController@update');
        $this->router->get('/admin/articles/delete/{id}', 'Admin\\ArticleController@delete');
        $this->router->get('/admin/categories', 'Admin\\CategoryController@index');
        $this->router->post('/admin/categories/store', 'Admin\\CategoryController@store');
        $this->router->post('/admin/categories/update/{id}', 'Admin\\CategoryController@update');
        $this->router->get('/admin/categories/delete/{id}', 'Admin\\CategoryController@delete');
        $this->router->get('/admin/users', 'Admin\\UserController@index');
        $this->router->get('/admin/users/create', 'Admin\\UserController@create');
        $this->router->get('/admin/users/edit/{id}', 'Admin\\UserController@edit');
        $this->router->post('/admin/users/store', 'Admin\\UserController@store');
        $this->router->post('/admin/users/update/{id}', 'Admin\\UserController@update');
        $this->router->get('/admin/users/delete/{id}', 'Admin\\UserController@delete');
        $this->router->get('/admin/comments', 'Admin\\CommentController@index');
        $this->router->get('/admin/comments/approve/{id}', 'Admin\\CommentController@approve');
        $this->router->get('/admin/comments/delete/{id}', 'Admin\\CommentController@delete');
        $this->router->get('/admin/media', 'Admin\\MediaController@index');
        $this->router->post('/admin/media/upload', 'Admin\\MediaController@upload');
        $this->router->post('/admin/media/delete/{id}', 'Admin\\MediaController@delete');
        $this->router->get('/admin/settings', 'Admin\\SettingsController@index');
        $this->router->post('/admin/settings/update', 'Admin\\SettingsController@update');
        $this->router->get('/admin/analytics', 'Admin\\AnalyticsController@index');
        $this->router->get('/admin/ads', 'Admin\\AdController@index');
        $this->router->post('/admin/ads/store', 'Admin\\AdController@store');
        $this->router->post('/admin/ads/update/{id}', 'Admin\\AdController@update');
        $this->router->post('/admin/ads/delete/{id}', 'Admin\\AdController@delete');
        $this->router->get('/admin/newsletters', 'Admin\\NewsletterController@index');
        $this->router->post('/admin/newsletters/send', 'Admin\\NewsletterController@send');
        $this->router->get('/admin/polls', 'Admin\\PollController@index');
        $this->router->post('/admin/polls/store', 'Admin\\PollController@store');
        $this->router->get('/admin/pages', 'Admin\\PageController@index');
        $this->router->get('/admin/pages/create', 'Admin\\PageController@create');
        $this->router->post('/admin/pages/store', 'Admin\\PageController@store');
        $this->router->get('/admin/pages/edit/{id}', 'Admin\\PageController@edit');
        $this->router->post('/admin/pages/update/{id}', 'Admin\\PageController@update');

        // API routes
        $this->router->get('/api/lang', 'Api\\LangController@change');
        $this->router->post('/api/newsletter/subscribe', 'Api\\NewsletterController@subscribe');
        $this->router->post('/api/comment', 'Api\\CommentController@store');
        $this->router->get('/api/articles/trending', 'Api\\ArticleApiController@trending');
        $this->router->get('/api/articles/search', 'Api\\ArticleApiController@search');
        $this->router->post('/api/bookmark', 'Api\\BookmarkController@toggle');
        $this->router->post('/api/poll/vote', 'Api\\PollController@vote');
        $this->router->get('/api/weather', 'Api\\WeatherController@get');

        // Feed & Sitemap
        $this->router->get('/feed/{lang}/rss', 'FeedController@rss');
        $this->router->get('/sitemap.xml', 'SitemapController@index');
        $this->router->get('/sitemap-{lang}.xml', 'SitemapController@language');
        
        // Public routes with language prefix (LAST - so they don't catch /admin, /login etc.)
        $this->router->get('/', 'HomeController@index');
        $this->router->addConstrained('GET', $langPattern, 'HomeController@index');
        $this->router->addConstrained('GET', $langPattern . '/category/{slug}', 'CategoryController@show');
        $this->router->addConstrained('GET', $langPattern . '/article/{slug}', 'ArticleController@show');
        $this->router->addConstrained('GET', $langPattern . '/author/{id}', 'AuthorController@show');
        $this->router->addConstrained('GET', $langPattern . '/search', 'SearchController@index');
        $this->router->addConstrained('GET', $langPattern . '/page/{slug}', 'PageController@show');
        $this->router->addConstrained('GET', $langPattern . '/tag/{slug}', 'TagController@show');
    }

    protected function detectLanguage(): string
    {
        $supported = unserialize(SUPPORTED_LANGS);
        $uri = trim($_SERVER['REQUEST_URI'] ?? '/', '/');
        $basePath = trim(str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/'), '', ROOT_PATH . '/public'), '/');
        
        if ($basePath) {
            $uri = preg_replace('#^' . preg_quote($basePath, '#') . '/?#', '', $uri);
        }
        
        $segments = explode('/', $uri);
        $firstSegment = $segments[0] ?? '';
        
        if (in_array($firstSegment, $supported)) {
            $_SESSION['lang'] = $firstSegment;
            return $firstSegment;
        }
        
        if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $supported)) {
            return $_SESSION['lang'];
        }
        
        // Browser detection
        $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2);
        if (in_array($browserLang, $supported)) {
            $_SESSION['lang'] = $browserLang;
            return $browserLang;
        }
        
        $_SESSION['lang'] = DEFAULT_LANG;
        return DEFAULT_LANG;
    }

    public function run(): void
    {
        try {
            $this->router->dispatch();
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                echo '<h1>Error</h1><pre>' . $e->getMessage() . '</pre><pre>' . $e->getTraceAsString() . '</pre>';
            } else {
                http_response_code(500);
                require VIEW_PATH . '/errors/500.php';
            }
        }
    }
}
