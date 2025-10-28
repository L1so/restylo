<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\OutfitRecommendationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/outfit', [OutfitController::class, 'suggest']);

// New outfit recommendation endpoints
Route::get('/recommendations', [OutfitRecommendationController::class, 'getRecommendations']);
Route::get('/outfits/{condition}', [OutfitRecommendationController::class, 'getByWeatherCondition']);
Route::post('/test-algorithm', [OutfitRecommendationController::class, 'testAlgorithm']);
