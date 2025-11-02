<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use App\Constants\Status;
use Carbon\Carbon;

class WatchHistoryController extends Controller
{
    /**
     * Get watch history list (paginated)
     * 
     * How it works:
     * - Returns all videos user has watched, sorted by last_view (most recent first)
     * - Includes full video details with thumbnail, user info, category
     * - Shows when video was last viewed (last_view timestamp)
     * 
     * Usage in Flutter:
     * GET /api/history?page=1&per_page=20
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        
        $user = auth()->user();
        
        // Get watch history with video relationships
        // Order by last_view DESC (most recently watched first)
        $watchHistories = $user->watchHistories()
            ->with(['video' => function($query) {
                $query->published()
                    ->with(['user:id,username,firstname,lastname,display_name,image', 'videoFiles', 'category:id,name,slug'])
                    ->whereHas('user', function ($q) {
                        $q->active();
                    });
            }])
            ->whereHas('video', function($q) {
                $q->published()
                  ->whereHas('user', function ($query) {
                      $query->active();
                  });
            })
            ->orderBy('last_view', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        // Transform for API response
        $videos = $watchHistories->getCollection()->map(function ($watchHistory) {
            if (!$watchHistory->video) {
                return null;
            }
            
            $video = $this->transformVideo($watchHistory->video);
            
            // Add history-specific data
            $video['history'] = [
                'id' => $watchHistory->id,
                'last_view' => $watchHistory->last_view ? $watchHistory->last_view->toISOString() : null,
                'added_at' => $watchHistory->created_at->toISOString(),
            ];
            
            return $video;
        })->filter();

        return responseSuccess('history_fetched', 'Watch history fetched successfully', [
            'videos' => $videos->values(),
            'pagination' => [
                'current_page' => $watchHistories->currentPage(),
                'last_page' => $watchHistories->lastPage(),
                'per_page' => $watchHistories->perPage(),
                'total' => $watchHistories->total(),
                'from' => $watchHistories->firstItem(),
                'to' => $watchHistories->lastItem(),
            ]
        ]);
    }

    /**
     * Add or update video in watch history
     * 
     * How it works:
     * - When user watches a video, call this endpoint
     * - If video already in history: Updates last_view timestamp
     * - If video not in history: Creates new history entry
     * - This is called automatically when video page is visited (web) or when video plays (API)
     * 
     * Usage in Flutter:
     * POST /api/history/add/{videoId}
     * 
     * Flow:
     * 1. User opens video in Flutter app
     * 2. When video starts playing → Call this API
     * 3. API checks if history exists
     * 4. If exists: Update last_view = now()
     * 5. If not: Create new WatchHistory record
     */
    public function add(Request $request, $videoId)
    {
        // Find video (must be published and user must be active)
        $video = Video::published()
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->find($videoId);

        if (!$video) {
            return responseError('video_not_found', ['The requested video could not be found']);
        }

        $user = auth()->user();
        
        // Check if history already exists for this video
        $watchHistory = $user->watchHistories()->where('video_id', $video->id)->first();

        if ($watchHistory) {
            // Update existing: Just update the last_view timestamp
            $watchHistory->last_view = Carbon::now();
            $watchHistory->save();
            $isNew = false;
        } else {
            // Create new history entry
            $watchHistory = new WatchHistory();
            $watchHistory->user_id = $user->id;
            $watchHistory->video_id = $video->id;
            $watchHistory->last_view = Carbon::now();
            $watchHistory->save();
            $isNew = true;
        }

        return responseSuccess('history_added', $isNew ? 'Video added to watch history' : 'Watch history updated', [
            'video' => $this->transformVideo($video),
            'history' => [
                'id' => $watchHistory->id,
                'last_view' => $watchHistory->last_view->toISOString(),
                'is_new' => $isNew
            ]
        ]);
    }

    /**
     * Remove single video from watch history
     * 
     * Usage in Flutter:
     * DELETE /api/history/remove/{videoId}
     * 
     * Alternative: Remove by history ID
     * DELETE /api/history/remove-by-id/{historyId}
     */
    public function remove(Request $request, $videoId)
    {
        $user = auth()->user();
        
        // Remove by video_id
        $watchHistory = $user->watchHistories()->where('video_id', $videoId)->first();

        if (!$watchHistory) {
            return responseError('not_found', ['Video not found in watch history']);
        }

        $watchHistory->delete();

        return responseSuccess('history_removed', 'Video removed from watch history successfully');
    }

    /**
     * Remove video by history ID (alternative method)
     */
    public function removeById(Request $request, $historyId)
    {
        $user = auth()->user();
        $watchHistory = WatchHistory::where('user_id', $user->id)->find($historyId);

        if (!$watchHistory) {
            return responseError('not_found', ['History record not found']);
        }

        $watchHistory->delete();

        return responseSuccess('history_removed', 'Video removed from watch history successfully');
    }

    /**
     * Remove all videos from watch history
     * 
     * Usage in Flutter:
     * DELETE /api/history/remove-all
     */
    public function removeAll(Request $request)
    {
        $user = auth()->user();
        $count = $user->watchHistories()->count();
        $user->watchHistories()->delete();

        return responseSuccess('history_cleared', 'All watch history removed successfully', [
            'removed_count' => $count
        ]);
    }

    /**
     * Transform video for API response
     * Same format as VideoController for consistency
     */
    private function transformVideo($video)
    {
        $user = auth()->user();
        $isPurchased = false;
        
        if ($user) {
            $isPurchased = $user->purchasedVideos()
                ->where('video_id', $video->id)
                ->exists();
        }

        return [
            'id' => $video->id,
            'title' => $video->title,
            'slug' => $video->slug,
            'description' => $video->description,
            'duration' => $video->duration ?? null,
            'views' => $video->views ?? 0,
            'likes' => $video->userReactions()->where('is_like', Status::YES)->count(),
            'thumbnail' => $video->thumb_image ? getImage(getFilePath('thumbnail') . '/' . $video->thumb_image, getFileSize('thumbnail')) : null,
            'created_at' => $video->created_at->toISOString(),
            'user' => [
                'id' => $video->user->id,
                'username' => $video->user->username,
                'display_name' => $video->user->display_name ?? ($video->user->firstname . ' ' . $video->user->lastname),
                'image' => getImage(getFilePath('userProfile') . '/' . $video->user->image, getFileSize('userProfile')),
            ],
            'category' => $video->category ? [
                'id' => $video->category->id,
                'name' => $video->category->name,
                'slug' => $video->category->slug,
            ] : null,
            'stock_video' => (bool) $video->stock_video,
            'is_purchased' => $isPurchased,
            'video_file_url' => $video->videoFiles->first() ? route('video.path', encrypt($video->videoFiles->first()->id)) : null,
        ];
    }
}

