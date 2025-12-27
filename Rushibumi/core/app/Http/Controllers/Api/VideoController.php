<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Category;
use App\Models\Playlist;
use App\Models\VideoTag;
use App\Models\Subtitle;
use App\Rules\FileTypeValidate;
use App\Traits\VideoManager;
use Illuminate\Http\Request;
use App\Constants\Status;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    use VideoManager;
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
     * Get single video details
     */
    public function show(Request $request, $id)
    {
        $video = Video::published()
            ->public()
            ->where('is_shorts_video', Status::NO)
            ->where('id', $id)
            ->with([
                'user:id,username,firstname,lastname,display_name,image,channel_name,slug',
                'videoFiles',
                'category:id,name,slug,icon',
                'tags',
                'subtitles',
                'userReactions'
            ])
            ->whereHas('user', function ($q) {
                $q->active();
            })
            ->first();

        if (!$video) {
            return responseError('video_not_found', ['Video not found']);
        }

        // Check if user has purchased the video (if authenticated)
        $isPurchased = false;
        $isLiked = false;
        $isDisliked = false;
        $isInWatchLater = false;
        
        if (auth()->check()) {
            $user = auth()->user();
            $isPurchased = $user->purchasedVideos()
                ->where('video_id', $video->id)
                ->exists();
            
            $reaction = $video->userReactions()
                ->where('user_id', $user->id)
                ->first();
            
            if ($reaction) {
                $isLiked = $reaction->is_like == Status::YES;
                $isDisliked = $reaction->is_like == Status::NO;
            }
            
            $isInWatchLater = $user->watchLaters()
                ->where('video_id', $video->id)
                ->exists();
        }

        // Increment views
        $video->increment('views');

        return responseSuccess('video_fetched', 'Video fetched successfully', [
            'video' => [
                'id' => $video->id,
                'title' => $video->title,
                'slug' => $video->slug,
                'description' => $video->description,
                'duration' => $video->duration,
                'views' => $video->views ?? 0,
                'likes' => $video->userReactions()->where('is_like', Status::YES)->count(),
                'dislikes' => $video->userReactions()->where('is_like', Status::NO)->count(),
                'thumbnail' => $video->thumb_image ? getImage(getFilePath('thumbnail') . '/' . $video->thumb_image, getFileSize('thumbnail')) : null,
                'created_at' => $video->created_at->toISOString(),
                'user' => [
                    'id' => $video->user->id,
                    'username' => $video->user->username,
                    'channel_name' => $video->user->channel_name,
                    'slug' => $video->user->slug,
                    'display_name' => $video->user->display_name ?? ($video->user->firstname . ' ' . $video->user->lastname),
                    'image' => getImage(getFilePath('userProfile') . '/' . $video->user->image, getFileSize('userProfile')),
                ],
                'category' => $video->category ? [
                    'id' => $video->category->id,
                    'name' => $video->category->name,
                    'slug' => $video->category->slug,
                    'icon' => $video->category->icon,
                ] : null,
                'tags' => $video->tags->pluck('tag')->toArray(),
                'subtitles' => $video->subtitles->map(function ($subtitle) {
                    return [
                        'id' => $subtitle->id,
                        'language_code' => $subtitle->language_code,
                        'caption' => $subtitle->caption,
                        'file_url' => $subtitle->file ? getImage(getFilePath('subtitle') . '/' . $subtitle->file) : null,
                    ];
                }),
                'stock_video' => (bool) $video->stock_video,
                'price' => $video->price ?? 0,
                'is_purchased' => $isPurchased,
                'is_liked' => $isLiked,
                'is_disliked' => $isDisliked,
                'is_in_watch_later' => $isInWatchLater,
                'video_file_url' => $video->videoFiles->first() ? route('video.path', encrypt($video->videoFiles->first()->id)) : null,
            ]
        ]);
    }

    /**
     * Get related/suggested videos for a video
     * Returns videos from the same category, or by similar tags
     */
    public function suggestions(Request $request, $id)
    {
        $limit = $request->get('limit', 20);
        
        // Get the current video
        $video = Video::published()
            ->public()
            ->where('is_shorts_video', Status::NO)
            ->where('id', $id)
            ->with('tags')
            ->whereHas('user', function ($q) {
                $q->active();
            })
            ->first();

        if (!$video) {
            return responseError('video_not_found', ['Video not found']);
        }

        // Get video tags
        $videoTags = $video->tags->pluck('tag')->toArray();

        // Build query for related videos
        $query = Video::published()
            ->public()
            ->withoutOnlyPlaylist()
            ->where('is_shorts_video', Status::NO)
            ->where('id', '!=', $video->id)
            ->with(['user:id,username,firstname,lastname,display_name,image', 'videoFiles', 'category:id,name,slug'])
            ->whereHas('user', function ($q) {
                $q->active();
            });

        // Find videos from same category OR with similar tags
        $query->where(function ($q) use ($video, $videoTags) {
            // Same category
            if ($video->category_id) {
                $q->where('category_id', $video->category_id);
            }
            
            // OR similar tags (if video has tags)
            if (!empty($videoTags)) {
                $q->orWhereHas('tags', function ($tagQuery) use ($videoTags) {
                    $tagQuery->whereIn('tag', $videoTags);
                });
            }
        });

        // Get related videos
        $relatedVideos = $query->inRandomOrder()
            ->take($limit)
            ->get();

        // If no related videos found, get latest videos as fallback
        if ($relatedVideos->isEmpty()) {
            $relatedVideos = Video::published()
                ->public()
                ->withoutOnlyPlaylist()
                ->where('is_shorts_video', Status::NO)
                ->where('id', '!=', $video->id)
                ->with(['user:id,username,firstname,lastname,display_name,image', 'videoFiles', 'category:id,name,slug'])
                ->whereHas('user', function ($q) {
                    $q->active();
                })
                ->latest()
                ->take($limit)
                ->get();
        }

        // Transform videos for API
        $relatedVideos->transform(function ($relatedVideo) {
            return $this->transformVideo($relatedVideo);
        });

        return responseSuccess('suggestions_fetched', 'Suggested videos fetched successfully', [
            'videos' => $relatedVideos->values(),
            'count' => $relatedVideos->count(),
        ]);
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

    /**
     * Upload video chunk
     * POST /api/videos/upload-chunk
     */
    public function uploadChunk(Request $request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'extension' => ['required', 'in:mp4,mov,wmv,flv,avi,mkv'],
            'fileName'  => 'required|string',
            'index'     => 'required|integer',
            'uniqueId'  => 'required|string',
            'chunk'     => 'required|file',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        try {
            $file = $request->file('chunk');
            $fileName = $request->input('fileName');
            $index = $request->input('index');
            $uniqueId = $request->input('uniqueId');

            $tempDir = storage_path("app/temp/{$uniqueId}");

            if (!is_dir($tempDir)) {
                if (!mkdir($tempDir, 0755, true) && !is_dir($tempDir)) {
                    throw new \RuntimeException("Failed to create temporary directory: {$tempDir}");
                }
            }

            $chunkPath = "{$tempDir}/{$fileName}.part{$index}";

            if (file_exists($chunkPath)) {
                unlink($chunkPath);
            }

            if (!$file->move($tempDir, "{$fileName}.part{$index}")) {
                throw new \RuntimeException("Failed to move uploaded chunk to: {$chunkPath}");
            }

            return responseSuccess('chunk_uploaded', 'Chunk uploaded successfully.');
        } catch (\Exception $e) {
            return responseError('upload_error', ['An error occurred during chunk upload: ' . $e->getMessage()]);
        }
    }

    /**
     * Merge video chunks and process video
     * POST /api/videos/merge-chunks
     */
    public function mergeChunks(Request $request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'fileName' => 'required|string',
            'total' => 'required|integer',
            'uniqueId' => 'required|string',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        $fileName = $request->fileName;
        $totalChunks = $request->total;

        $tempPath = storage_path("app/temp/{$request->uniqueId}");
        $outputPath = storage_path("app/videos");

        if (!\Illuminate\Support\Facades\File::exists($outputPath)) {
            \Illuminate\Support\Facades\File::makeDirectory($outputPath, 0755, true);
        }

        $mergedFilePath = $outputPath . '/' . uniqid() . '_' . $fileName;
        $output = fopen($mergedFilePath, 'ab');

        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = $tempPath . "/{$fileName}.part{$i}";

            if (!file_exists($chunkPath)) {
                return responseError('missing_chunk', ["Missing chunk {$i}"]);
            }

            $chunk = fopen($chunkPath, 'rb');
            stream_copy_to_stream($chunk, $output);
            fclose($chunk);
            unlink($chunkPath);
        }

        fclose($output);

        if (\Illuminate\Support\Facades\File::exists($tempPath)) {
            \Illuminate\Support\Facades\File::deleteDirectory($tempPath);
        }

        try {
            $mimeType = mime_content_type($mergedFilePath);
            if (!str_starts_with($mimeType, 'video/')) {
                \Illuminate\Support\Facades\File::delete($mergedFilePath);
                return responseError('invalid_file', ['Uploaded file is not a valid video.']);
            }

            $uploadedFile = new \Illuminate\Http\UploadedFile(
                $mergedFilePath,
                basename($mergedFilePath),
                mime_content_type($mergedFilePath),
                null,
                true
            );

            if ($id) {
                $uploadVideo = Video::authUser()->where('is_shorts_video', Status::NO)->findOrFail($id);
            } else {
                $uploadVideo          = new Video();
                $uploadVideo->user_id = auth()->id();
                $uploadVideo->step    = Status::FIRST_STEP;
                $uploadVideo->is_shorts_video = Status::NO;
                $uploadVideo->save();
            }

            $fileName = now()->format('Y/F') . '/' . uniqid() . time() . '.' . $uploadedFile->getClientOriginalExtension();

            if (gs('ffmpeg_status')) {
                $result = $this->processVideo($uploadedFile, $uploadVideo, $id);
                if (!$result->success && !$id) {
                    $uploadVideo->delete();
                    \Illuminate\Support\Facades\DB::rollBack();
                    return responseError('processing_error', [$result->message]);
                }
            } else {
                if ($id) {
                    $videoFile = $uploadVideo->videoFiles()->first();
                    if (!$videoFile) {
                        \Illuminate\Support\Facades\DB::rollBack();
                        return responseError('video_file_error', ['Something went wrong']);
                    }

                    if (@$uploadVideo->storage) {
                        $this->removeOldFile($uploadVideo, @$uploadVideo->storage, $videoFile->file_name, 'videos');
                    }
                } else {
                    $videoFile = new \App\Models\VideoFile();
                }

                $videoFile->video_id  = $uploadVideo->id;
                $videoFile->file_name = fileUploader($uploadedFile, getFilePath('video') . '/' . now()->format('Y/F'), old: $videoFile->file_name ?? null, filename: $fileName);
                $videoFile->save();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\File::delete($mergedFilePath);
            return responseError('merge_error', ['FFProbe error: ' . $e->getMessage()]);
        }

        \Illuminate\Support\Facades\File::delete($mergedFilePath);

        return responseSuccess('video_uploaded', 'Video uploaded successfully.', [
            'video_id' => $uploadVideo->id,
            'step' => $uploadVideo->step,
        ]);
    }

    /**
     * Submit video details
     * POST /api/videos/{id}/details
     */
    public function submitDetails(Request $request, $id)
    {
        $video = Video::where('step', '>=', Status::FIRST_STEP)
            ->authUser()
            ->where('is_shorts_video', Status::NO)
            ->findOrFail($id);

        $isRequired = $video->thumb_image ? 'nullable' : 'required';

        $slug = $request->slug;
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'playlist'    => 'nullable|integer',
            'is_only_playlist' => 'required|integer|in:0,1',
            'thumb_image' => [$isRequired, new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'slug'        => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($slug, $id) {
                    $query = Video::where('slug', $slug)->where('id', '!=', $id)->where('is_shorts_video', Status::NO);
                    if ($query->exists()) {
                        $fail('The ' . $attribute . ' must be unique.');
                    }
                },
            ],
        ]);

        $playlist = null;
        if ($request->playlist) {
            $playlist = Playlist::authUser()->find($request->playlist);
            if (!$playlist) {
                return responseError('playlist_not_found', ['Playlist not found']);
            }
        }

        $video->title                       = $request->title;
        $video->slug                        = $request->slug;
        $video->description                 = $request->description;
        $video->is_only_playlist            = $request->is_only_playlist;

        if ($request->hasFile('thumb_image')) {
            try {
                $old                = $video->thumb_image;
                $video->thumb_image = fileUploader($request->thumb_image, getFilePath('thumbnail'), getFileSize('thumbnail'), $old, getFileThumb('thumbnail'));
            } catch (\Exception $exp) {
                return responseError('upload_error', ['Couldn\'t upload your thumbnail']);
            }
        }

        if ($video->status == Status::NO || $video->step < Status::SECOND_STEP) {
            $video->step = Status::SECOND_STEP;
        }

        $video->save();

        if ($playlist) {
            $playlist->videos()->syncWithoutDetaching([$video->id]);
        }

        return responseSuccess('details_saved', 'Details successfully saved.', [
            'video_id' => $video->id,
            'step' => $video->step,
        ]);
    }

    /**
     * Submit video elements (audience, stock video, subtitles)
     * POST /api/videos/{id}/elements
     */
    public function submitElements(Request $request, $id)
    {
        $request->validate([
            'audience'        => 'required|in:0,1',
            'price'           => 'required_with:stock_video',
            'caption.*'       => [
                'sometimes',
                function ($value, $fail) use ($request) {
                    if ($request->hasAny(['subtitle_file', 'language_code'])) {
                        if (empty($value)) {
                            $fail('Caption is required when subtitle file or language code is present.');
                        }
                    }
                },
            ],
            'language_code.*' => [
                'sometimes',
                'string',
                function ($value, $fail) use ($request) {
                    if ($request->hasAny(['subtitle_file', 'caption'])) {
                        if (empty($value)) {
                            $fail('Language code is required when caption or subtitle file is present.');
                        }
                    }
                },
            ],
            'subtitle_file.*' => [
                'sometimes',
                new FileTypeValidate(['vtt']),
                function ($value, $fail) use ($request) {
                    if ($request->hasAny(['caption', 'language_code'])) {
                        if (empty($value)) {
                            $fail('Subtitle file is required when caption or language code is present.');
                        }
                    }
                },
            ],
        ]);

        $video = Video::where('step', '>=', Status::SECOND_STEP)
            ->authUser()
            ->where('is_shorts_video', Status::NO)
            ->findOrFail($id);

        if ($request->old_subtitle) {
            $removeSub = array_diff($video->subtitles->pluck('id')->toArray(), $request->old_subtitle ?? []);
        } else {
            $removeSub = $video->subtitles->pluck('id')->toArray();
        }

        $video->subtitles()->whereIn('id', $removeSub)->get()->each(function ($old) {
            $filePath = getImage(getFilePath('subtitle') . '/' . $old->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $old->delete();
        });

        $video->audience = $request->audience;
        if ($request->stock_video) {
            $video->stock_video = Status::YES;
            $video->price       = $request->price;
        } else {
            $video->stock_video = Status::NO;
            $video->price       = 0;
        }

        if ($video->status == Status::NO || $video->step < Status::THIRD_STEP) {
            $video->step = Status::THIRD_STEP;
        }

        $video->save();

        if ($request->subtitle_file) {
            foreach ($request->subtitle_file as $key => $file) {
                $subtitle = new Subtitle();
                try {
                    $subtitle->file = fileUploader($file, getFilePath('subtitle'));
                } catch (\Exception $exp) {
                    return responseError('upload_error', ['Couldn\'t upload your subtitle']);
                }
                $subtitle->video_id      = $video->id;
                $subtitle->caption       = $request->caption[$key];
                $subtitle->language_code = $request->language_code[$key];
                $subtitle->save();
            }
        }

        return responseSuccess('elements_saved', 'Elements successfully saved.', [
            'video_id' => $video->id,
            'step' => $video->step,
        ]);
    }

    /**
     * Submit video visibility settings
     * POST /api/videos/{id}/visibility
     */
    public function submitVisibility(Request $request, $id)
    {
        $request->validate([
            'category'   => 'required|integer',
            'tags'       => 'required|array|min:1',
            'tags.*'     => 'required|string',
            'visibility' => 'required|in:0,1',
        ]);

        $video = Video::where('step', '>=', Status::THIRD_STEP)
            ->authUser()
            ->where('is_shorts_video', Status::NO)
            ->findOrFail($id);

        $category           = Category::active()->findOrFail($request->category);
        $video->category_id = $category->id;

        $video->visibility = $request->visibility;

        if ($video->status == Status::NO || $video->step <= Status::THIRD_STEP) {
            $video->step   = Status::FOURTH_STEP;
            $video->status = Status::PUBLISHED;
        }

        $video->save();

        if ($request->tags) {
            $oldTags = $video->tags;
            if ($oldTags) {
                $video->tags()->delete();
            }
            
            // Get category name as subject for subject-based tagging
            $subject = $video->category ? $video->category->name : null;
            
            foreach ($request->tags as $tag) {
                $videoTag           = new VideoTag();
                $videoTag->video_id = $video->id;
                $videoTag->tag      = $tag;
                $videoTag->subject  = $subject; // Store subject for sequential tagging
                $videoTag->save();
            }
        }

        return responseSuccess('visibility_saved', 'Visibility successfully saved.', [
            'video_id' => $video->id,
            'status' => $video->status,
            'step' => $video->step,
        ]);
    }
}

