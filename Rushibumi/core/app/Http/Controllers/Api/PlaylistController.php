<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Video;
use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlaylistController extends Controller
{
    /**
     * Get all playlists (user's own playlists)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);

        $playlists = Playlist::where('user_id', $user->id)
            ->with(['user:id,username,firstname,lastname,display_name,image'])
            ->withCount('videos')
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        $playlists->getCollection()->transform(function ($playlist) {
            return [
                'id' => $playlist->id,
                'title' => $playlist->title,
                'slug' => $playlist->slug,
                'description' => $playlist->description,
                'visibility' => $playlist->visibility,
                'visibility_text' => $playlist->visibility == Status::PUBLIC ? 'Public' : 'Private',
                'video_count' => $playlist->videos_count,
                'price' => $playlist->price ?? 0,
                'playlist_subscription' => (bool) $playlist->playlist_subscription,
                'created_at' => $playlist->created_at->toISOString(),
                'updated_at' => $playlist->updated_at->toISOString(),
            ];
        });

        return responseSuccess('playlists_fetched', 'Playlists fetched successfully', [
            'playlists' => $playlists->items(),
            'pagination' => [
                'current_page' => $playlists->currentPage(),
                'last_page' => $playlists->lastPage(),
                'per_page' => $playlists->perPage(),
                'total' => $playlists->total(),
                'from' => $playlists->firstItem(),
                'to' => $playlists->lastItem(),
            ]
        ]);
    }

    /**
     * Get single playlist with videos
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $playlist = Playlist::where('user_id', $user->id)
            ->with(['videos' => function ($q) {
                $q->published()
                    ->public()
                    ->with(['user:id,username,firstname,lastname,display_name,image', 'category:id,name,slug'])
                    ->whereHas('user', function ($query) {
                        $query->active();
                    });
            }])
            ->find($id);

        if (!$playlist) {
            return responseError('playlist_not_found', ['Playlist not found']);
        }

        $videos = $playlist->videos->map(function ($video) {
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
            ];
        });

        return responseSuccess('playlist_fetched', 'Playlist fetched successfully', [
            'playlist' => [
                'id' => $playlist->id,
                'title' => $playlist->title,
                'slug' => $playlist->slug,
                'description' => $playlist->description,
                'visibility' => $playlist->visibility,
                'visibility_text' => $playlist->visibility == Status::PUBLIC ? 'Public' : 'Private',
                'video_count' => $playlist->videos->count(),
                'price' => $playlist->price ?? 0,
                'playlist_subscription' => (bool) $playlist->playlist_subscription,
                'created_at' => $playlist->created_at->toISOString(),
                'updated_at' => $playlist->updated_at->toISOString(),
                'videos' => $videos,
            ]
        ]);
    }

    /**
     * Create playlist
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $title = $request->title;

        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($title) {
                    $query = Playlist::where('title', $title)->where('user_id', auth()->id());
                    if ($query->exists()) {
                        $fail('The ' . $attribute . ' must be unique.');
                    }
                },
            ],
            'description' => 'nullable|string',
            'visibility' => 'required|in:0,1',
            'slug' => 'required|string|unique:playlists,slug',
            'playlist_subscription' => 'nullable|boolean',
            'price' => [
                'nullable',
                'numeric',
                Rule::requiredIf(function () use ($request) {
                    return $request->input('playlist_subscription') == 1;
                }),
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('playlist_subscription') == 1 && $value <= 0) {
                        $fail('The ' . $attribute . ' must be greater than 0 when subscription is enabled.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        $playlist = new Playlist();
        $playlist->title = $request->title;
        $playlist->slug = $request->slug;
        $playlist->user_id = $user->id;
        $playlist->description = $request->description;
        $playlist->visibility = $request->visibility;
        $playlist->price = $request->price ?? 0;
        $playlist->playlist_subscription = $request->playlist_subscription ? Status::ENABLE : Status::DISABLE;
        $playlist->save();

        return responseSuccess('playlist_created', 'Playlist created successfully', [
            'playlist' => [
                'id' => $playlist->id,
                'title' => $playlist->title,
                'slug' => $playlist->slug,
                'description' => $playlist->description,
                'visibility' => $playlist->visibility,
                'visibility_text' => $playlist->visibility == Status::PUBLIC ? 'Public' : 'Private',
                'price' => $playlist->price,
                'playlist_subscription' => (bool) $playlist->playlist_subscription,
                'created_at' => $playlist->created_at->toISOString(),
            ]
        ]);
    }

    /**
     * Update playlist
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $playlist = Playlist::where('user_id', $user->id)->find($id);

        if (!$playlist) {
            return responseError('playlist_not_found', ['Playlist not found']);
        }

        $title = $request->title;

        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($title, $id) {
                    $query = Playlist::where('title', $title)->where('user_id', auth()->id())->where('id', '!=', $id);
                    if ($query->exists()) {
                        $fail('The ' . $attribute . ' must be unique.');
                    }
                },
            ],
            'description' => 'nullable|string',
            'visibility' => 'required|in:0,1',
            'slug' => 'required|string|unique:playlists,slug,' . $id,
            'playlist_subscription' => 'nullable|boolean',
            'price' => [
                'nullable',
                'numeric',
                Rule::requiredIf(function () use ($request) {
                    return $request->input('playlist_subscription') == 1;
                }),
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('playlist_subscription') == 1 && $value <= 0) {
                        $fail('The ' . $attribute . ' must be greater than 0 when subscription is enabled.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        $playlist->title = $request->title;
        $playlist->slug = $request->slug;
        $playlist->description = $request->description;
        $playlist->visibility = $request->visibility;
        $playlist->price = $request->price ?? 0;
        $playlist->playlist_subscription = $request->playlist_subscription ? Status::ENABLE : Status::DISABLE;
        $playlist->save();

        return responseSuccess('playlist_updated', 'Playlist updated successfully', [
            'playlist' => [
                'id' => $playlist->id,
                'title' => $playlist->title,
                'slug' => $playlist->slug,
                'description' => $playlist->description,
                'visibility' => $playlist->visibility,
                'visibility_text' => $playlist->visibility == Status::PUBLIC ? 'Public' : 'Private',
                'price' => $playlist->price,
                'playlist_subscription' => (bool) $playlist->playlist_subscription,
                'updated_at' => $playlist->updated_at->toISOString(),
            ]
        ]);
    }

    /**
     * Delete playlist
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $playlist = Playlist::where('user_id', $user->id)->find($id);

        if (!$playlist) {
            return responseError('playlist_not_found', ['Playlist not found']);
        }

        $playlist->delete();

        return responseSuccess('playlist_deleted', 'Playlist deleted successfully');
    }

    /**
     * Add video to playlist
     */
    public function addVideo(Request $request, $id)
    {
        $user = $request->user();
        $playlist = Playlist::where('user_id', $user->id)->find($id);

        if (!$playlist) {
            return responseError('playlist_not_found', ['Playlist not found']);
        }

        $validator = Validator::make($request->all(), [
            'video_id' => 'required|array|min:1',
            'video_id.*' => 'required|integer|exists:videos,id',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        $videos = Video::published()->whereIn('id', $request->video_id)->get();
        
        if ($videos->count() != count($request->video_id)) {
            return responseError('invalid_videos', ['Some videos are invalid or not published']);
        }

        // Attach videos (won't duplicate if already exists)
        $playlist->videos()->syncWithoutDetaching($request->video_id);

        return responseSuccess('videos_added', 'Videos added to playlist successfully', [
            'playlist_id' => $playlist->id,
            'added_count' => count($request->video_id),
        ]);
    }

    /**
     * Remove video from playlist
     */
    public function removeVideo(Request $request, $id, $videoId)
    {
        $user = $request->user();
        $playlist = Playlist::where('user_id', $user->id)->find($id);

        if (!$playlist) {
            return responseError('playlist_not_found', ['Playlist not found']);
        }

        $playlist->videos()->detach($videoId);

        return responseSuccess('video_removed', 'Video removed from playlist successfully');
    }
}

