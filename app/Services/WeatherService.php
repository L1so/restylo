<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    /**
     * Get current weather using WeatherAPI. If an IP is provided, it will be used;
     * otherwise the API's auto:ip feature is used.
     *
     * @param string|null $ip
     * @return array
     */
    public function getCurrentWeather(?string $ip = null): array
    {
        $key = config('services.weatherapi.key') ?: env('WEATHER_API_KEY');
        if (empty($key)) {
            throw new \RuntimeException('WEATHER_API_KEY not set in config/services.php or .env');
        }

        $query = $ip ?: 'auto:ip';
        $url = 'https://api.weatherapi.com/v1/current.json';

        // Use withoutVerifying only in development mode
        $httpClient = config('app.env') === 'production' 
            ? Http::timeout(30) 
            : Http::withoutVerifying()->timeout(30);
            
        $response = $httpClient->get($url, [
            'key' => $key,
            'q' => $query,
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException('WeatherAPI request failed: ' . $response->body());
        }

        $data = $response->json();

        $current = $data['current'] ?? [];
        $location = $data['location'] ?? [];

        return [
            'temperature_c' => $current['temp_c'] ?? null,
            'temperature_f' => $current['temp_f'] ?? null,
            'condition' => $current['condition']['text'] ?? null,
            'location' => [
                'name' => $location['name'] ?? null,
                'region' => $location['region'] ?? null,
                'country' => $location['country'] ?? null,
                'lat' => $location['lat'] ?? null,
                'lon' => $location['lon'] ?? null,
            ],
            'raw' => $data,
        ];
    }
}
