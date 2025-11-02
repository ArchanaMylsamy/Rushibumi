<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\ShortController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\WatchHistoryController;

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
    
    // Get Categories (for sidebar)
    Route::get('categories', [CategoryController::class, 'index']);
    
    // Get Videos and Shorts (Public - no authentication required)
    Route::get('videos', [VideoController::class, 'index']);
    Route::get('videos/category/{identifier}', [VideoController::class, 'byCategorySlug']); // Accepts both slug and ID
    Route::get('shorts', [ShortController::class, 'index']);
    
    // Protected Routes (Require Authentication Token)
    Route::middleware('auth:sanctum')->group(function () {
        
        // Auth Routes
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        
        // Watch History Routes
        Route::prefix('history')->name('history.')->group(function () {
            Route::get('/', [WatchHistoryController::class, 'index'])->name('index');
            Route::post('add/{videoId}', [WatchHistoryController::class, 'add'])->name('add');
            Route::delete('remove/{videoId}', [WatchHistoryController::class, 'remove'])->name('remove');
            Route::delete('remove-by-id/{historyId}', [WatchHistoryController::class, 'removeById'])->name('remove-by-id');
            Route::delete('remove-all', [WatchHistoryController::class, 'removeAll'])->name('remove-all');
        });
        
    });
});

