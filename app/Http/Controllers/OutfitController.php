<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OutfitController extends Controller
{
    /**
     * Suggest an outfit based on client IP-derived weather and an event type.
     *
     * Accepts optional query/body parameter `event` (e.g., casual, formal, sport).
     *
     * @param Request $request
     * @param WeatherService $weatherService
     * @param AIService $aiService
     * @return JsonResponse
     */
    public function suggest(Request $request, WeatherService $weatherService, AIService $aiService): JsonResponse
    {
        // Check for manual location override (for testing/debugging)
        $locationOverride = $request->input('location');
        
        if ($locationOverride) {
            // Use manual location if provided
            $locationQuery = $locationOverride;
        } else {
            // Get the client IP as detected by Laravel (honors trusted proxies if configured)
            $clientIp = $request->ip();

            // If request comes from localhost or private network, let WeatherAPI use auto:ip
            $localIps = ['127.0.0.1', '::1'];
            $isLocalIp = in_array($clientIp, $localIps, true) || preg_match('/^(10\.|172\.(1[6-9]|2[0-9]|3[0-1])|192\.168\.)/', $clientIp) === 1;

            $locationQuery = $isLocalIp ? null : $clientIp;
        }

        // Get event type from request (default to 'casual')
        $event = (string) $request->input('event', 'casual');

        // Fetch weather. WeatherService will use the given location query; if null it falls back to auto:ip.
        $weather = $weatherService->getCurrentWeather($locationQuery);

        $tempC = $weather['temperature_c'] ?? null;
        $condition = $weather['condition'] ?? 'unknown';
        $location = $weather['location'] ?? [];

        // Build a clear, natural-language prompt for the AI
        $place = trim(implode(', ', array_filter([$location['name'] ?? null, $location['region'] ?? null, $location['country'] ?? null])));
        if (empty($place)) {
            $place = 'your area';
        }

        $timeOfDay = date('A') === 'AM' ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening');
        $season = $this->getCurrentSeason($location['lat'] ?? null);
        
        $prompt = "As a professional stylist, suggest a practical {$event} outfit for {$condition} weather";
        if ($tempC !== null) {
            $prompt .= " at {$tempC}°C ({$this->celsiusToFahrenheit($tempC)}°F)";
        }
        $prompt .= " in {$place} for {$timeOfDay} activities";
        if ($season) {
            $prompt .= " during {$season}";
        }
        $prompt .= ". Please format your response with clear categories:\n\n";
        $prompt .= "**Top:** [Specific shirt/blouse/top recommendation with fabric and color]\n";
        $prompt .= "**Bottom:** [Specific pants/skirt/bottom recommendation with style and fabric]\n";
        $prompt .= "**Shoes:** [Specific footwear recommendation appropriate for weather and occasion]\n\n";
        $prompt .= "Then provide a brief styling rationale (2-3 sentences) explaining why these choices work well for the weather and cultural context.";

        try {
            $suggestion = $aiService->generate($prompt);
        } catch (\Throwable $e) {
            // If AI service fails (e.g., API payload mismatch or network), fall back to a simple heuristic
            $temp = $tempC !== null ? "{$tempC}°C" : 'an unknown temperature';
            $suggestion = "Suggested outfit for {$condition} weather ({$temp}) for a {$event} event:\n" .
                "- Top: a neutral-layered top (e.g., T-shirt + light jacket)\n" .
                "- Bottom: comfortable trousers or jeans\n" .
                "- Shoes: weather-appropriate (waterproof if rainy)\n" .
                "Brief: Choose breathable layers so you can adapt to changing conditions. (AI unavailable)";
        }

        return response()->json([
            'weather' => [
                'temperature_c' => $tempC,
                'temperature_f' => $weather['temperature_f'] ?? null,
                'condition' => $condition,
                'location' => $location,
            ],
            'prompt' => $prompt,
            'suggestion' => $suggestion,
        ]);
    }

    /**
     * Convert Celsius to Fahrenheit
     */
    private function celsiusToFahrenheit(?float $celsius): ?int
    {
        if ($celsius === null) {
            return null;
        }
        return (int) round(($celsius * 9/5) + 32);
    }

    /**
     * Determine current season based on latitude and current date
     */
    private function getCurrentSeason(?float $latitude): ?string
    {
        if ($latitude === null) {
            return null;
        }

        $month = (int) date('n'); // 1-12
        $isNorthernHemisphere = $latitude > 0;

        if ($isNorthernHemisphere) {
            return match(true) {
                in_array($month, [12, 1, 2]) => 'winter',
                in_array($month, [3, 4, 5]) => 'spring',
                in_array($month, [6, 7, 8]) => 'summer',
                in_array($month, [9, 10, 11]) => 'autumn',
                default => null
            };
        } else {
            // Southern hemisphere - seasons are opposite
            return match(true) {
                in_array($month, [12, 1, 2]) => 'summer',
                in_array($month, [3, 4, 5]) => 'autumn',
                in_array($month, [6, 7, 8]) => 'winter',
                in_array($month, [9, 10, 11]) => 'spring',
                default => null
            };
        }
    }
}
