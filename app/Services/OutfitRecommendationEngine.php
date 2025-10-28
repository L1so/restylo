<?php

namespace App\Services;

use App\Models\OutfitCombination;

/**
 * Outfit Recommendation Engine
 * 
 * This service implements a rule-based algorithm that matches weather conditions
 * and temperature data to appropriate outfit suggestions from the database.
 * 
 * Algorithm Logic:
 * 1. Analyze weather condition and temperature
 * 2. Map weather API conditions to database categories
 * 3. Apply temperature-based filtering rules
 * 4. Query outfit combinations database
 * 5. Return random matches with contextual explanations
 */
class OutfitRecommendationEngine
{
    /**
     * Temperature thresholds for outfit categorization
     */
    private const TEMP_HOT = 25;      // Above 25°C - prefer lighter clothing
    private const TEMP_COLD = 15;     // Below 15°C - prefer warmer clothing
    
    /**
     * Weather condition mapping from API to database categories
     * 
     * Maps various weather API condition strings to our four main categories:
     * - sunny: Clear, bright weather
     * - rainy: Precipitation requiring waterproof items
     * - cloudy: Overcast, mild conditions
     * - cold: Low temperature or winter conditions
     */
    private const WEATHER_MAPPING = [
        'sunny' => [
            'sunny', 'clear', 'fair', 'bright', 'sunshine',
            'partly cloudy', 'mostly sunny'
        ],
        'rainy' => [
            'rain', 'drizzle', 'shower', 'storm', 'thunder',
            'thunderstorm', 'heavy rain', 'light rain', 'moderate rain',
            'torrential rain', 'downpour'
        ],
        'cloudy' => [
            'cloud', 'overcast', 'fog', 'mist', 'hazy',
            'partly cloudy', 'mostly cloudy', 'grey', 'gray'
        ],
        'cold' => [
            'snow', 'sleet', 'blizzard', 'freezing', 'ice',
            'frost', 'winter', 'cold', 'chilly'
        ]
    ];

    /**
     * Generate outfit recommendations based on weather data
     * 
     * @param array $weatherData Weather data from WeatherService
     * @param int $count Number of recommendations to return (default: 3)
     * @return array Recommendations with outfits and explanations
     */
    public function generateRecommendations(array $weatherData, int $count = 3): array
    {
        // Extract weather information
        $temperature = $weatherData['temperature_c'] ?? 20;
        $condition = strtolower($weatherData['condition'] ?? 'unknown');
        $location = $weatherData['location'] ?? [];
        
        // Step 1: Map weather condition to database category
        $weatherCategory = $this->mapWeatherCondition($condition, $temperature);
        
        // Step 2: Apply temperature-based refinement
        $refinedCategory = $this->refineByTemperature($weatherCategory, $temperature);
        
        // Step 3: Query outfit combinations from database
        $outfits = $this->getOutfitSuggestions($refinedCategory, $count);
        
        // Step 4: Generate recommendations with explanations
        $recommendations = [];
        foreach ($outfits as $outfit) {
            $recommendations[] = [
                'outfit' => $outfit,
                'explanation' => $this->generateExplanation($outfit, $temperature, $condition, $location),
                'confidence' => $this->calculateConfidence($weatherCategory, $refinedCategory, $temperature)
            ];
        }
        
        return [
            'weather_analysis' => [
                'temperature' => $temperature,
                'condition' => $condition,
                'mapped_category' => $weatherCategory,
                'refined_category' => $refinedCategory,
                'location' => $location
            ],
            'recommendations' => $recommendations,
            'algorithm_meta' => [
                'total_available' => OutfitCombination::forWeather($refinedCategory)->count(),
                'selection_method' => 'random_sampling',
                'confidence_factors' => $this->getConfidenceFactors($weatherCategory, $temperature)
            ]
        ];
    }

    /**
     * Map weather API condition to database weather category
     * 
     * Uses fuzzy string matching to find the best category match
     * 
     * @param string $condition Weather condition from API
     * @param float $temperature Temperature for fallback logic
     * @return string Database weather category
     */
    private function mapWeatherCondition(string $condition, float $temperature): string
    {
        $condition = strtolower(trim($condition));
        
        // Direct keyword matching
        foreach (self::WEATHER_MAPPING as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($condition, $keyword)) {
                    return $category;
                }
            }
        }
        
        // Fallback logic based on temperature
        if ($temperature > self::TEMP_HOT) {
            return 'sunny';
        } elseif ($temperature < self::TEMP_COLD) {
            return 'cold';
        } else {
            return 'cloudy'; // Default neutral condition
        }
    }

    /**
     * Refine weather category based on temperature thresholds
     * 
     * Applies business rules for temperature-based outfit selection:
     * - Hot weather (>25°C) → prefer lighter clothing even if cloudy
     * - Cold weather (<15°C) → prefer warm clothing even if sunny
     * 
     * @param string $baseCategory Initial weather category
     * @param float $temperature Current temperature
     * @return string Refined weather category
     */
    private function refineByTemperature(string $baseCategory, float $temperature): string
    {
        // Hot weather override: prefer light clothes
        if ($temperature > self::TEMP_HOT && $baseCategory === 'cloudy') {
            return 'sunny'; // Promote to sunny for lighter clothing
        }
        
        // Cold weather override: prefer warm clothes
        if ($temperature < self::TEMP_COLD && in_array($baseCategory, ['sunny', 'cloudy'])) {
            return 'cold'; // Promote to cold for warmer clothing
        }
        
        // Keep rainy category regardless of temperature for waterproof needs
        return $baseCategory;
    }

    /**
     * Query outfit combinations from database
     * 
     * @param string $weatherCategory Weather category to filter by
     * @param int $count Number of outfits to retrieve
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getOutfitSuggestions(string $weatherCategory, int $count): \Illuminate\Database\Eloquent\Collection
    {
        return OutfitCombination::getRandomForWeather($weatherCategory, $count);
    }

    /**
     * Generate contextual explanation for outfit recommendation
     * 
     * Creates natural language explanation linking weather to outfit choice
     * 
     * @param OutfitCombination $outfit Recommended outfit
     * @param float $temperature Current temperature
     * @param string $condition Weather condition
     * @param array $location Location information
     * @return string Explanation text
     */
    private function generateExplanation(OutfitCombination $outfit, float $temperature, string $condition, array $location): string
    {
        $locationName = $location['name'] ?? 'your area';
        $tempText = $temperature ? "{$temperature}°C" : "current temperature";
        
        // Base template
        $explanation = "Perfect for {$tempText} {$condition} weather in {$locationName}. ";
        
        // Add specific reasoning based on weather condition
        switch ($outfit->weather_condition) {
            case 'sunny':
                if ($temperature > self::TEMP_HOT) {
                    $explanation .= "The light fabrics and breathable materials will keep you cool and comfortable in the heat.";
                } else {
                    $explanation .= "Great for enjoying the sunshine while staying stylish and comfortable.";
                }
                break;
                
            case 'rainy':
                $explanation .= "The waterproof and water-resistant items will keep you dry, while the layers provide flexibility for changing conditions.";
                break;
                
            case 'cloudy':
                $explanation .= "The versatile layering allows you to adapt to temperature changes throughout the day.";
                break;
                
            case 'cold':
                if ($temperature < self::TEMP_COLD) {
                    $explanation .= "The warm materials and insulating layers will protect you from the cold while maintaining your style.";
                } else {
                    $explanation .= "Provides good coverage and warmth for cooler conditions.";
                }
                break;
        }
        
        return $explanation;
    }

    /**
     * Calculate confidence score for recommendation
     * 
     * @param string $originalCategory Original weather mapping
     * @param string $refinedCategory Final category after temperature refinement
     * @param float $temperature Current temperature
     * @return float Confidence score (0.0 to 1.0)
     */
    private function calculateConfidence(string $originalCategory, string $refinedCategory, float $temperature): float
    {
        $baseConfidence = 0.8; // Base confidence for weather matching
        
        // Reduce confidence if temperature override was applied
        if ($originalCategory !== $refinedCategory) {
            $baseConfidence -= 0.1;
        }
        
        // Increase confidence for extreme temperatures
        if ($temperature > self::TEMP_HOT || $temperature < self::TEMP_COLD) {
            $baseConfidence += 0.1;
        }
        
        return min(1.0, max(0.5, $baseConfidence));
    }

    /**
     * Get factors that influenced confidence calculation
     * 
     * @param string $weatherCategory Mapped weather category
     * @param float $temperature Current temperature
     * @return array Confidence factors for debugging/transparency
     */
    private function getConfidenceFactors(string $weatherCategory, float $temperature): array
    {
        return [
            'weather_match' => 'Weather condition successfully mapped to category',
            'temperature_range' => $temperature > self::TEMP_HOT ? 'hot' : ($temperature < self::TEMP_COLD ? 'cold' : 'moderate'),
            'category_used' => $weatherCategory,
            'outfit_availability' => OutfitCombination::forWeather($weatherCategory)->count() . ' outfits available'
        ];
    }

    /**
     * Get available weather categories
     * 
     * @return array List of valid weather categories
     */
    public function getAvailableCategories(): array
    {
        return array_keys(self::WEATHER_MAPPING);
    }

    /**
     * Get temperature thresholds for reference
     * 
     * @return array Temperature threshold values
     */
    public function getTemperatureThresholds(): array
    {
        return [
            'hot_threshold' => self::TEMP_HOT,
            'cold_threshold' => self::TEMP_COLD
        ];
    }
}