<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutfitCombination extends Model
{
    protected $fillable = [
        'name',
        'top',
        'bottom',
        'shoes',
        'weather_condition',
        'image_url',
    ];

    protected $casts = [
        'weather_condition' => 'string',
    ];

    /**
     * Scope to filter outfits by weather condition
     */
    public function scopeForWeather($query, $weatherCondition)
    {
        return $query->where('weather_condition', $weatherCondition);
    }

    /**
     * Get random outfits for a weather condition
     */
    public static function getRandomForWeather($weatherCondition, $count = 3)
    {
        return static::forWeather($weatherCondition)->inRandomOrder()->limit($count)->get();
    }
}
