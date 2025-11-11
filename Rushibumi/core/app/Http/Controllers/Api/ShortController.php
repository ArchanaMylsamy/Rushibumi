<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Constants\Status;

class ShortController extends Controller
{
    /**
     * Get all shorts list
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $userId = $request->get('user_id');
        $page = $request->get('page', 1);
        
        $query = Video::published()
            ->public()
            ->where('is_shorts_video', Status::YES)
            ->with(['user:id,username,firstname,lastname,display_name,image'])
            ->whereHas('user', function ($q) {
                $q->active();
            })
            ->latest();

        // Filter by user
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $shorts = $query->paginate($perPage, ['*'], 'page', $page);

        // Transform shorts for API
        $shorts->getCollection()->transform(function ($short) {
            return $this->transformShort($short);
        });

        return responseSuccess('shorts_fetched', 'Shorts fetched successfully', [
            'shorts' => $shorts->items(),
            'pagination' => [
                'current_page' => $shorts->currentPage(),
                'last_page' => $shorts->lastPage(),
                'per_page' => $shorts->perPage(),
                'total' => $shorts->total(),
                'from' => $shorts->firstItem(),
                'to' => $shorts->lastItem(),
            ]
        ]);
    }

    /**
     * Transform short for API response
     */
    private function transformShort($short)
    {
        $isLiked = false;
        if (auth()->check()) {
            $user = auth()->user();
            $isLiked = $short->userReactions()
                ->where('user_id', $user->id)
                ->where('is_like', Status::YES)
                ->exists();
        }

        return [
            'id' => $short->id,
            'title' => $short->title,
            'slug' => $short->slug,
            'description' => $short->description,
            'duration' => $short->duration,
            'views' => $short->views ?? 0,
            'likes' => $short->userReactions()->where('is_like', Status::YES)->count(),
            'thumbnail' => $short->thumb_image ? getImage(getFilePath('thumbnail') . '/' . $short->thumb_image, getFileSize('thumbnail')) : null,
            'video_url' => route('short.path', encrypt($short->id)),
            'created_at' => $short->created_at->toISOString(),
            'user' => [
                'id' => $short->user->id,
                'username' => $short->user->username,
                'display_name' => $short->user->display_name ?? ($short->user->firstname . ' ' . $short->user->lastname),
                'image' => getImage(getFilePath('userProfile') . '/' . $short->user->image, getFileSize('userProfile')),
            ],
            'is_liked' => $isLiked,
        ];
    }

    /**
     * Search and Filter Shorts
     */
    public function search(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $userId = $request->get('user_id');
        $page = $request->get('page', 1);
        
        // Get filter parameters
        $search = $request->get('search'); // Search keyword
        $sortBy = $request->get('sort_by', 'latest'); // latest, views, likes, oldest
        $dateFrom = $request->get('date_from'); // Y-m-d format
        $dateTo = $request->get('date_to'); // Y-m-d format
        $minViews = $request->get('min_views');
        $maxViews = $request->get('max_views');
        
        $query = Video::published()
            ->public()
            ->where('is_shorts_video', Status::YES)
            ->with(['user:id,username,firstname,lastname,display_name,image'])
            ->whereHas('user', function ($q) {
                $q->active();
            });

        // Search by keyword
        if ($search) {
            // Set search in request for searchable macro
            $request->merge(['search' => $search]);
            $query->searchable(['title', 'description', 'tags:tag', 'user:username', 'user:channel_name']);
        }

        // Filter by user
        if ($userId) {
            $query->where('user_id', $userId);
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

        $shorts = $query->paginate($perPage, ['*'], 'page', $page);

        // Transform shorts for API
        $shorts->getCollection()->transform(function ($short) {
            return $this->transformShort($short);
        });

        return responseSuccess('shorts_fetched', 'Shorts fetched successfully', [
            'shorts' => $shorts->items(),
            'filters_applied' => [
                'search' => $search,
                'user_id' => $userId,
                'sort_by' => $sortBy,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'min_views' => $minViews,
                'max_views' => $maxViews,
            ],
            'pagination' => [
                'current_page' => $shorts->currentPage(),
                'last_page' => $shorts->lastPage(),
                'per_page' => $shorts->perPage(),
                'total' => $shorts->total(),
                'from' => $shorts->firstItem(),
                'to' => $shorts->lastItem(),
            ]
        ]);
    }
}

