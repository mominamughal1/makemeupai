<?php

use App\Http\Controllers\Api\AiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeauticianController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ClothingItemController;
use App\Http\Controllers\Api\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::get('/beauticians', [BeauticianController::class, 'index']);
Route::get('/beauticians/{id}', [BeauticianController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wardrobe', [ClothingItemController::class, 'index']);
    Route::post('/wardrobe', [ClothingItemController::class, 'store']);
    Route::delete('/wardrobe/{id}', [ClothingItemController::class, 'destroy']);
    Route::get('/recommendations', [RecommendationController::class, 'index']);
    Route::get('/ai/face-profile', [AiController::class, 'faceProfile']);
    Route::post('/ai/face-analysis', [AiController::class, 'faceAnalysis']);
    Route::post('/ai/look-recommendations', [AiController::class, 'lookRecommendations']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
});
