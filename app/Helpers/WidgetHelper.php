<?php
namespace App\Helpers;

use App\Core\Cache;

class WidgetHelper
{
    private Cache $cache;

    public function __construct()
    {
        $this->cache = new Cache();
    }

    public function getWeather(string $city = 'Erbil'): array
    {
        $cacheKey = 'weather_' . md5($city);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Using Open-Meteo API (No key required)
        $coords = [
            'Erbil' => ['lat' => 36.19, 'lon' => 44.01],
            'Sulaymaniyah' => ['lat' => 35.56, 'lon' => 45.44],
            'Duhok' => ['lat' => 36.86, 'lon' => 42.99],
            'Baghdad' => ['lat' => 33.31, 'lon' => 44.36],
        ];

        $lat = $coords[$city]['lat'] ?? 36.19;
        $lon = $coords[$city]['lon'] ?? 44.01;

        $url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m,weather_code&timezone=auto";
        
        $data = [
            'temp' => 25,
            'condition' => 'sunny',
            'city' => $city
        ];

        try {
            $json = @file_get_contents($url);
            if ($json) {
                $response = json_decode($json, true);
                if (isset($response['current'])) {
                    $data['temp'] = $response['current']['temperature_2m'];
                    $code = $response['current']['weather_code'];
                    $data['condition'] = $this->getWeatherIcon($code);
                }
            }
        } catch (\Exception $e) {
            // Fallback to default
        }

        $this->cache->set($cacheKey, $data, 3600); // 1 hour cache
        return $data;
    }

    private function getWeatherIcon(int $code): string
    {
        // WMO Weather interpretation codes (WW)
        if ($code === 0) return 'sun';
        if (in_array($code, [1, 2, 3])) return 'cloud-sun';
        if (in_array($code, [45, 48])) return 'smog';
        if (in_array($code, [51, 53, 55, 61, 63, 65])) return 'cloud-rain';
        if (in_array($code, [71, 73, 75, 77])) return 'snowflake';
        if (in_array($code, [95, 96, 99])) return 'bolt';
        return 'cloud';
    }

    public function getCurrency(): array
    {
        $cacheKey = 'currency_rates';
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Mock data for currency rates (relative to IQD)
        // In a real app, you'd fetch this from a local exchange API
        $data = [
            'USD_BUY' => 148000,
            'USD_SELL' => 148250,
            'EUR_BUY' => 160000,
            'EUR_SELL' => 160500,
            'gold_21' => 525000, // IQD per Mithqal
            'gold_18' => 450000
        ];

        $this->cache->set($cacheKey, $data, 3600); // 1 hour cache
        return $data;
    }
}
