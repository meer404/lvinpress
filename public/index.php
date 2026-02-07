<?php
/**
 * LVINPress - Main Entry Point
 */

// Start session
session_name('lvinpress_session');
session_start();

// Load configuration
require_once dirname(__DIR__) . '/config/config.php';

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = APP_PATH . '/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Load core helpers
require_once APP_PATH . '/Helpers/functions.php';

// Initialize application
use App\Core\Application;

$app = new Application();
$app->run();
