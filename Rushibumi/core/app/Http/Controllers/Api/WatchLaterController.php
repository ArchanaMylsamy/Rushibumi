<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\WatchLater;
use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WatchLaterController extends Controller
{
    /**
     * Get all watch later videos
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);

        $watchLaters = WatchLater::where('user_id', $user->id)
            ->with(['video' => function ($q) {
                $q->published()
                    ->public()
                    ->with(['user:id,username,firstname,lastname,display_name,image', 'category:id,name,slug'])
                    ->whereHas('user', function ($query) {
                        $query->active();
                    });
            }])
            ->whereHas('video', function ($q) {
                $q->published()->public();
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        $videos = $watchLaters->getCollection()->map(function ($watchLater) {
            $video = $watchLater->video;
            if (!$video) {
                return null;
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
                'added_at' => $watchLater->created_at->toISOString(),
            ];
        })->filter();

        return responseSuccess('watch_later_fetched', 'Watch later videos fetched successfully', [
            'videos' => $videos->values(),
            'pagination' => [
                'current_page' => $watchLaters->currentPage(),
                'last_page' => $watchLaters->lastPage(),
                'per_page' => $watchLaters->perPage(),
                'total' => $watchLaters->total(),
                'from' => $watchLaters->firstItem(),
                'to' => $watchLaters->lastItem(),
            ]
        ]);
    }

    /**
     * Add video to watch later
     */
    public function add(Request $request, $videoId)
    {
        $user = $request->user();

        $video = Video::published()
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->find($videoId);

        if (!$video) {
            return responseError('video_not_found', ['The requested video could not be found']);
        }

        // Check if already in watch later
        $existingWatchLater = $user->watchLaters()->where('video_id', $video->id)->first();

        if ($existingWatchLater) {
            return responseError('already_added', ['Video is already in your watch later list']);
        }

        $watchLater = new WatchLater();
        $watchLater->user_id = $user->id;
        $watchLater->video_id = $video->id;
        $watchLater->save();

        return responseSuccess('watch_later_added', 'Video added to watch later successfully', [
            'video_id' => $video->id,
            'title' => $video->title,
        ]);
    }

    /**
     * Remove video from watch later
     */
    public function remove(Request $request, $videoId)
    {
        $user = $request->user();

        $watchLater = $user->watchLaters()->where('video_id', $videoId)->first();

        if (!$watchLater) {
            return responseError('not_found', ['Video not found in watch later list']);
        }

        $watchLater->delete();

        return responseSuccess('watch_later_removed', 'Video removed from watch later successfully');
    }

    /**
     * Toggle watch later (add if not exists, remove if exists)
     */
    public function toggle(Request $request, $videoId)
    {
        $user = $request->user();

        $video = Video::published()
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->find($videoId);

        if (!$video) {
            return responseError('video_not_found', ['The requested video could not be found']);
        }

        $existingWatchLater = $user->watchLaters()->where('video_id', $video->id)->first();

        if ($existingWatchLater) {
            $existingWatchLater->delete();
            return responseSuccess('watch_later_removed', 'Video removed from watch later', [
                'is_in_watch_later' => false,
            ]);
        } else {
            $watchLater = new WatchLater();
            $watchLater->user_id = $user->id;
            $watchLater->video_id = $video->id;
            $watchLater->save();

            return responseSuccess('watch_later_added', 'Video added to watch later', [
                'is_in_watch_later' => true,
            ]);
        }
    }
}

