<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Constants\Status;

class VideoController extends Controller
{
    /**
     * Get all videos list
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $categoryId = $request->get('category_id');
        $trending = $request->get('trending', false);
        $userId = $request->get('user_id');
        $page = $request->get('page', 1);
        
        $query = Video::published()
            ->public()
            ->withoutOnlyPlaylist()
            ->where('is_shorts_video', Status::NO)
            ->with(['user:id,username,firstname,lastname,display_name,image', 'videoFiles', 'category:id,name,slug'])
            ->whereHas('user', function ($q) {
                $q->active();
            });

        // Filter by category
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter by user
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Filter trending
        if ($trending) {
            $query->where(function ($q) {
                $q->whereDate('created_at', '>=', now()->subDays(7))
                  ->orWhere('is_trending', Status::YES);
            })->orderByDesc('views');
        } else {
            $query->latest();
        }

        $videos = $query->paginate($perPage, ['*'], 'page', $page);

        // Transform videos for API
        $videos->getCollection()->transform(function ($video) {
            return $this->transformVideo($video);
        });

        return responseSuccess('videos_fetched', 'Videos fetched successfully', [
            'videos' => $videos->items(),
            'pagination' => [
                'current_page' => $videos->currentPage(),
                'last_page' => $videos->lastPage(),
                'per_page' => $videos->perPage(),
                'total' => $videos->total(),
                'from' => $videos->firstItem(),
                'to' => $videos->lastItem(),
            ]
        ]);
    }

    /**
     * Transform video for API response
     */
    private function transformVideo($video)
    {
        $isPurchased = false;
        if (auth()->check()) {
            $user = auth()->user();
            $isPurchased = $user->purchasedVideos()
                ->where('video_id', $video->id)
                ->exists();
        }

        return [
            'id' => $video->id,
            'title' => $video->title,
            'slug' => $video->slug,
            'description' => $video->description,
            'duration' => $video->duration,
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

