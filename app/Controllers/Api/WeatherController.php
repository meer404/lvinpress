<?php
namespace App\Controllers\Api;

use App\Core\Controller;

class WeatherController extends Controller
{
    public function get(): void
    {
        // Basic weather API - can be extended with real API
        $weather = [
            'location' => 'Erbil',
            'temp' => rand(15, 35),
            'condition' => ['sunny', 'cloudy', 'partly cloudy'][rand(0, 2)],
            'icon' => 'fa-sun'
        ];
        
        $this->json($weather);
    }
}
