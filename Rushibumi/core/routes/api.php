<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\ShortController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\WatchHistoryController;
use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\WatchLaterController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\AccountSettingController;
use App\Http\Controllers\Api\ReactionController;
use App\Http\Controllers\Api\SubscribeController;

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
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    // Get Categories (for sidebar)
    Route::get('categories', [CategoryController::class, 'index']);
    
    // Get Videos and Shorts (Public - no authentication required)
    Route::get('videos', [VideoController::class, 'index']);
    Route::get('videos/search', [VideoController::class, 'search']); // Search and filter videos
    Route::get('videos/category/{identifier}', [VideoController::class, 'byCategorySlug']); // Accepts both slug and ID
    Route::get('videos/{id}/suggestions', [VideoController::class, 'suggestions']); // Get related/suggested videos (must be before videos/{id})
    Route::get('videos/{id}', [VideoController::class, 'show']); // Get single video details
    Route::get('shorts', [ShortController::class, 'index']);
    Route::get('shorts/search', [ShortController::class, 'search']); // Search and filter shorts
    
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
        
        // Channel Routes
        Route::prefix('channel')->name('channel.')->group(function () {
            Route::get('{userId}', [ChannelController::class, 'show'])->name('show');
            Route::post('create', [ChannelController::class, 'create'])->name('create');
        });
        
        // Watch Later Routes
        Route::prefix('watch-later')->name('watch-later.')->group(function () {
            Route::get('/', [WatchLaterController::class, 'index'])->name('index');
            Route::post('add/{videoId}', [WatchLaterController::class, 'add'])->name('add');
            Route::delete('remove/{videoId}', [WatchLaterController::class, 'remove'])->name('remove');
            Route::post('toggle/{videoId}', [WatchLaterController::class, 'toggle'])->name('toggle');
        });
        
        // Playlist Routes
        Route::prefix('playlists')->name('playlists.')->group(function () {
            Route::get('/', [PlaylistController::class, 'index'])->name('index');
            Route::post('/', [PlaylistController::class, 'store'])->name('store');
            Route::get('{id}', [PlaylistController::class, 'show'])->name('show');
            Route::put('{id}', [PlaylistController::class, 'update'])->name('update');
            Route::delete('{id}', [PlaylistController::class, 'destroy'])->name('destroy');
            Route::post('{id}/videos', [PlaylistController::class, 'addVideo'])->name('add-video');
            Route::delete('{id}/videos/{videoId}', [PlaylistController::class, 'removeVideo'])->name('remove-video');
        });
        
        // Account Settings Routes
        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/', [AccountSettingController::class, 'show'])->name('show');
            Route::put('/', [AccountSettingController::class, 'update'])->name('update');
            Route::put('profile', [AccountSettingController::class, 'updateProfile'])->name('update-profile');
            Route::post('change-password', [AccountSettingController::class, 'changePassword'])->name('change-password');
        });
        
        // Reaction Routes (Like/Dislike)
        Route::prefix('reactions')->name('reactions.')->group(function () {
            Route::post('like/{videoId}', [ReactionController::class, 'like'])->name('like');
            Route::post('dislike/{videoId}', [ReactionController::class, 'dislike'])->name('dislike');
            Route::post('toggle/{videoId}', [ReactionController::class, 'toggle'])->name('toggle');
            Route::get('status/{videoId}', [ReactionController::class, 'status'])->name('status');
        });
        
        // Subscribe Routes
        Route::prefix('subscribe')->name('subscribe.')->group(function () {
            Route::post('toggle/{userId}', [SubscribeController::class, 'toggle'])->name('toggle');
            Route::post('{userId}', [SubscribeController::class, 'subscribe'])->name('subscribe');
            Route::delete('{userId}', [SubscribeController::class, 'unsubscribe'])->name('unsubscribe');
            Route::get('status/{userId}', [SubscribeController::class, 'status'])->name('status');
            Route::get('my-subscriptions', [SubscribeController::class, 'mySubscriptions'])->name('my-subscriptions');
            Route::get('subscribers/{userId}', [SubscribeController::class, 'subscribers'])->name('subscribers');
        });
        
        // Video Upload Routes
        Route::prefix('videos')->name('videos.')->group(function () {
            Route::post('upload-chunk/{id?}', [VideoController::class, 'uploadChunk'])->name('upload-chunk');
            Route::post('merge-chunks/{id?}', [VideoController::class, 'mergeChunks'])->name('merge-chunks');
            Route::post('{id}/details', [VideoController::class, 'submitDetails'])->name('submit-details');
            Route::post('{id}/elements', [VideoController::class, 'submitElements'])->name('submit-elements');
            Route::post('{id}/visibility', [VideoController::class, 'submitVisibility'])->name('submit-visibility');
        });
        
        // Shorts Upload Routes
        Route::prefix('shorts')->name('shorts.')->group(function () {
            Route::post('upload-chunk/{id?}', [ShortController::class, 'uploadChunk'])->name('upload-chunk');
            Route::post('merge-chunks/{id?}', [ShortController::class, 'mergeChunks'])->name('merge-chunks');
            Route::post('{id}/details', [ShortController::class, 'submitDetails'])->name('submit-details');
            Route::post('{id}/visibility', [ShortController::class, 'submitVisibility'])->name('submit-visibility');
        });
        
    });
});

