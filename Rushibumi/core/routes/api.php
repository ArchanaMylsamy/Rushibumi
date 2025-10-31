<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\ShortController;

/*
|--------------------------------------------------------------------------
| API Routes for Flutter Application
|--------------------------------------------------------------------------
|
| These routes are separate from web routes and return JSON responses.
| They don't interfere with existing web functionality.
|
*/

Route::prefix('api')->group(function () {
    
    // Public API Routes
    Route::post('login', [AuthController::class, 'login']);
    
    // Get Videos and Shorts (Public - no authentication required)
    Route::get('videos', [VideoController::class, 'index']);
    Route::get('shorts', [ShortController::class, 'index']);
    
    // Protected Routes (Require Authentication Token)
    Route::middleware('auth:sanctum')->group(function () {
        
        // Auth Routes
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        
    });
});

