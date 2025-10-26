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
    // Get the client IP as detected by Laravel (honors trusted proxies if configured)
    $clientIp = $request->ip();

    // If request comes from localhost or private network, let WeatherAPI use auto:ip
    $localIps = ['127.0.0.1', '::1'];
    $isLocalIp = in_array($clientIp, $localIps, true) || preg_match('/^(10\.|172\.(1[6-9]|2[0-9]|3[0-1])|192\.168\.)/', $clientIp) === 1;

    $ipForApi = $isLocalIp ? null : $clientIp;

        // Get event type from request (default to 'casual')
        $event = (string) $request->input('event', 'casual');

    // Fetch weather. WeatherService will use the given IP; if null it falls back to auto:ip.
    $weather = $weatherService->getCurrentWeather($ipForApi);

        $tempC = $weather['temperature_c'] ?? null;
        $condition = $weather['condition'] ?? 'unknown';
        $location = $weather['location'] ?? [];

        // Build a clear, natural-language prompt for the AI
        $place = trim(implode(', ', array_filter([$location['name'] ?? null, $location['region'] ?? null, $location['country'] ?? null])));
        if (empty($place)) {
            $place = 'your area';
        }

        $prompt = "Suggest a daily outfit for {$condition} weather";
        if ($tempC !== null) {
            $prompt .= " with temperature {$tempC}°C";
        }
        $prompt .= " in {$place} for a {$event} event. Provide a short list of items and a brief rationale (2-4 sentences).";

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
}
