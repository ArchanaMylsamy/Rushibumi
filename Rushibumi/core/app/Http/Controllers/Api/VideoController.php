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

    /**
     * Get videos by category slug or ID (for Flutter sidebar click)
     * Accepts both slug (string) and ID (numeric)
     */
    public function byCategorySlug(Request $request, $identifier)
    {
        $perPage = $request->get('per_page', 20);
        $trending = $request->get('trending', false);
        $page = $request->get('page', 1);

        // Try to find by ID first (if numeric), then by slug
        if (is_numeric($identifier)) {
            $category = \App\Models\Category::active()->find($identifier);
        } else {
            $category = \App\Models\Category::active()->where('slug', $identifier)->first();
        }
        
        if (!$category) {
            return responseError('category_not_found', ['Category not found or inactive']);
        }

        $query = Video::published()
            ->public()
            ->withoutOnlyPlaylist()
            ->where('is_shorts_video', Status::NO)
            ->where('category_id', $category->id)
            ->with(['user:id,username,firstname,lastname,display_name,image', 'videoFiles', 'category:id,name,slug'])
            ->whereHas('user', function ($q) {
                $q->active();
            });

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
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'icon' => $category->icon,
            ],
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
     * Search and Filter Videos
     * Supports multiple filters and search criteria
     */
    public function search(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        
        // Get filter parameters
        $search = $request->get('search'); // Search keyword
        $categoryId = $request->get('category_id');
        $userId = $request->get('user_id');
        $trending = $request->get('trending', false);
        $stockVideo = $request->get('stock_video'); // true/false
        $isShorts = $request->get('is_shorts', false); // true for shorts, false for regular videos
        $sortBy = $request->get('sort_by', 'latest'); // latest, views, likes, oldest
        $dateFrom = $request->get('date_from'); // Y-m-d format
        $dateTo = $request->get('date_to'); // Y-m-d format
        $minViews = $request->get('min_views');
        $maxViews = $request->get('max_views');

        // Build query
        $query = Video::published()
            ->public()
            ->withoutOnlyPlaylist()
            ->where('is_shorts_video', $isShorts ? Status::YES : Status::NO)
            ->with(['user:id,username,firstname,lastname,display_name,image', 'videoFiles', 'category:id,name,slug'])
            ->whereHas('user', function ($q) {
                $q->active();
            });

        // Search by keyword (title, description, tags, category, channel)
        if ($search) {
            // Set search in request for searchable macro
            $request->merge(['search' => $search]);
            $query->searchable(['title', 'category:name', 'description', 'tags:tag', 'user:username', 'user:channel_name']);
        }

        // Filter by category
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter by user/channel
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Filter by stock video
        if ($stockVideo !== null) {
            if ($stockVideo == 'true' || $stockVideo === true || $stockVideo == 1) {
                $query->where('stock_video', Status::YES);
            } else {
                $query->where('stock_video', Status::NO);
            }
        } else {
            // Default: exclude stock videos unless specifically requested
            $query->where('stock_video', Status::NO);
        }

        // Filter by trending
        if ($trending) {
            $query->where(function ($q) {
                $q->whereDate('created_at', '>=', now()->subDays(7))
                  ->orWhere('is_trending', Status::YES);
            });
        }

        // Filter by date range
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Filter by views range
        if ($minViews !== null) {
            $query->where('views', '>=', $minViews);
        }
        if ($maxViews !== null) {
            $query->where('views', '<=', $maxViews);
        }

        // Sort options
        switch ($sortBy) {
            case 'views':
                $query->orderByDesc('views');
                break;
            case 'likes':
                // Order by likes count (requires subquery or join)
                $query->withCount(['userReactions as likes_count' => function ($q) {
                    $q->where('is_like', Status::YES);
                }])->orderByDesc('likes_count');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $videos = $query->paginate($perPage, ['*'], 'page', $page);

        // Transform videos for API
        $videos->getCollection()->transform(function ($video) {
            return $this->transformVideo($video);
        });

        return responseSuccess('videos_fetched', 'Videos fetched successfully', [
            'videos' => $videos->items(),
            'filters_applied' => [
                'search' => $search,
                'category_id' => $categoryId,
                'user_id' => $userId,
                'trending' => $trending,
                'stock_video' => $stockVideo,
                'is_shorts' => $isShorts,
                'sort_by' => $sortBy,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'min_views' => $minViews,
                'max_views' => $maxViews,
            ],
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
}

