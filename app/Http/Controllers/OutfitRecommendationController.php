<?php

namespace App\Http\Controllers;

use App\Models\OutfitCombination;
use App\Services\WeatherService;
use App\Services\OutfitRecommendationEngine;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OutfitRecommendationController extends Controller
{
    /**
     * Get outfit recommendations using the advanced recommendation engine
     */
    public function getRecommendations(
        Request $request, 
        WeatherService $weatherService, 
        OutfitRecommendationEngine $recommendationEngine
    ): JsonResponse {
        try {
            // Get current weather data
            $weather = $weatherService->getCurrentWeather();
            
            // Get number of recommendations (default: 3, max: 10)
            $count = min(10, max(1, $request->input('count', 3)));
            
            // Generate recommendations using the rule-based algorithm
            $recommendations = $recommendationEngine->generateRecommendations($weather, $count);
            
            return response()->json([
                'success' => true,
                'weather_data' => $weather,
                'analysis' => $recommendations['weather_analysis'],
                'recommendations' => $recommendations['recommendations'],
                'meta' => $recommendations['algorithm_meta'],
                'timestamp' => now()->toISOString(),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to generate outfit recommendations',
                'message' => $e->getMessage(),
                'timestamp' => now()->toISOString(),
            ], 500);
        }
    }

    /**
     * Get outfits by specific weather condition
     */
    public function getByWeatherCondition(string $condition): JsonResponse
    {
        $validConditions = ['sunny', 'rainy', 'cloudy', 'cold'];
        
        if (!in_array($condition, $validConditions)) {
            return response()->json([
                'error' => 'Invalid weather condition',
                'valid_conditions' => $validConditions,
            ], 400);
        }
        
        $outfits = OutfitCombination::forWeather($condition)->get();
        
        return response()->json([
            'weather_condition' => $condition,
            'outfits' => $outfits,
            'count' => $outfits->count(),
        ]);
    }

    /**
     * Test the recommendation algorithm with custom weather data
     */
    public function testAlgorithm(Request $request, OutfitRecommendationEngine $recommendationEngine): JsonResponse
    {
        // Validate input
        $request->validate([
            'temperature' => 'required|numeric|between:-50,60',
            'condition' => 'required|string|max:100',
            'location' => 'sometimes|array',
            'count' => 'sometimes|integer|between:1,10'
        ]);

        try {
            // Create mock weather data for testing
            $mockWeatherData = [
                'temperature_c' => $request->input('temperature'),
                'condition' => $request->input('condition'),
                'location' => $request->input('location', [
                    'name' => 'Test Location',
                    'region' => 'Test Region',
                    'country' => 'Test Country'
                ])
            ];

            $count = $request->input('count', 3);

            // Generate recommendations
            $recommendations = $recommendationEngine->generateRecommendations($mockWeatherData, $count);

            return response()->json([
                'success' => true,
                'test_input' => $mockWeatherData,
                'analysis' => $recommendations['weather_analysis'],
                'recommendations' => $recommendations['recommendations'],
                'meta' => $recommendations['algorithm_meta'],
                'algorithm_info' => [
                    'temperature_thresholds' => $recommendationEngine->getTemperatureThresholds(),
                    'available_categories' => $recommendationEngine->getAvailableCategories()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Algorithm test failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}