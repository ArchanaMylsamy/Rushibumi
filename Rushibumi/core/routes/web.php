<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// Video Quality API Routes
Route::prefix('api/video')->name('api.video.')->group(function () {
    Route::get('{id}/qualities', 'VideoQualityController@getVideoQualities')->name('qualities');
    Route::get('{id}/stream/{quality}', 'VideoQualityController@streamVideoWithQuality')->name('stream');
    Route::post('detect-resolutions', 'VideoQualityController@detectVideoResolutions')->name('detect');
});



Route::get('cron', 'CronController@cron')->name('cron');
Route::namespace('User')->controller('CommentController')->prefix('comment')->name('user.comment.')->group(function () {
    Route::get('get-comment/{id}', 'getComment')->name('get');
});

Route::namespace('User')->controller('PlaylistController')->prefix('playlist')->name('user.playlist.')->group(function () {
    Route::get('load-videos/{id?}', 'loadVideos')->name('load.videos');
    Route::get('video-get/{id}', 'videoGet')->name('video.get');

});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::controller('User\ChannelController')
    ->prefix('channel')
    ->name('user.channel.')
    ->group(function () {
        Route::get('playlist-fetch/{id}', 'playlistFetch')->name('playlist.fetch');
    });

Route::controller('PreviewController')->prefix('preview')->name('preview.')->group(function () {
    Route::get('channel/{slug?}', 'channel')->name('channel');
    Route::get('playlist/{slug?}', 'playlist')->name('playlist');
    Route::get('playlist/videos/{playlistSlug?}/{userSlug?}', 'playlistVideos')->name('playlist.videos');
    Route::get('shorts/{slug?}', 'shorts')->name('shorts');
    Route::get('live/{slug?}', 'live')->name('live');
    Route::get('about/{slug?}', 'about')->name('about');
    Route::get('monthly-plan/{slug?}', 'monthlyPlan')->name('monthly.plan');
});

Route::namespace('User')->controller('PlanController')->prefix('plan')->name('plan.')->group(function () {
    Route::get('videos/{id}', 'viewPlanVideos')->name('videos');
    Route::get('playlist/videos/{id}', 'viewPlaylistVideos')->name('playlist.videos');
    Route::get('playlists/{id}', 'viewPlanPlaylists')->name('playlists');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function () {
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');
    Route::get('videos/{id?}', 'getAllVideos')->name('video.get');
    Route::get('trending-list', 'trendingList')->name('trending.list');
    Route::get('shorts-list', 'shortsList')->name('shorts.list');
    Route::get('load-shorts/{id?}', 'loadShorts')->name('load.shorts.video');
    

    Route::get('play/{id?}/{slug?}', 'playVideo')->name('video.play');
    Route::get('short-play/{id?}/{slug?}', 'shortPlayVideo')->name('short.play');
    Route::post('short-view/{id?}', 'shortView')->name('short.view');

    Route::get('embed/{id?}/{slug?}', 'embedVideo')->name('embed');

    
    Route::get('video-path/{id?}','videoPath')->name('video.path');
    Route::get('shorts-path/{id?}','shortsPath')->name('short.path');


    Route::get('fetch-ad', 'fetchAd')->name('fetch.ad');
    Route::get('redirect-ad/{id?}/{video_id}', 'redirectAd')->name('redirect.ad');
    Route::post('feed-ad-click', 'feedAdClick')->name('feed.ad.click');
    Route::post('video-ad-play', 'videoAdPlay')->name('video.ad.play');

    Route::get('get-video-source/{id}', 'getVideoSource')->name('get.video.source');
 



    Route::get('category/{slug}', 'categoryVideo')->name('category.video');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('search', 'search')->name('search');
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});

// Live Stream Routes
Route::controller(\App\Http\Controllers\LiveStreamController::class)->prefix('live')->name('live.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('watch/{id}/{slug?}', 'watch')->name('watch');
    Route::get('stream-info/{id}', 'getStreamInfo')->name('stream.info');
    Route::get('debug/{id}', 'debugStream')->name('debug');
    Route::get('comments/{id}', 'getComments')->name('comments');
    Route::post('comment/{id}', 'addComment')->name('comment.add');
    Route::get('recording/{id}', 'getRecordedVideo')->name('recording');
    Route::post('update-duration/{id}', 'updateDuration')->name('update.duration');
});
