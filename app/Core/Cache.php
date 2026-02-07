<?php
namespace App\Core;

class Cache
{
    private string $cacheDir;
    private int $defaultTtl = 3600; // 1 hour

    public function __construct()
    {
        $this->cacheDir = __DIR__ . '/../../storage/cache/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function get(string $key)
    {
        $filename = $this->getFilename($key);
        if (!file_exists($filename)) {
            return null;
        }

        $data = include $filename;
        if (!$data || !is_array($data) || !isset($data['expire'])) {
            return null;
        }

        if (time() > $data['expire']) {
            unlink($filename);
            return null;
        }

        return $data['value'];
    }

    public function set(string $key, $value, int $ttl = null): bool
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $filename = $this->getFilename($key);
        
        $data = [
            'expire' => time() + $ttl,
            'value' => $value
        ];

        return file_put_contents($filename, '<?php return ' . var_export($data, true) . ';') !== false;
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    public function forget(string $key): bool
    {
        $filename = $this->getFilename($key);
        if (file_exists($filename)) {
            return unlink($filename);
        }
        return false;
    }
    
    public function flush(): bool
    {
        $files = glob($this->cacheDir . '*.php');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        return true;
    }

    private function getFilename(string $key): string
    {
        return $this->cacheDir . md5($key) . '.php';
    }
}
