<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Category;
use App\Models\Playlist;
use App\Models\VideoTag;
use App\Rules\FileTypeValidate;
use App\Traits\VideoManager;
use Illuminate\Http\Request;
use App\Constants\Status;
use Illuminate\Support\Facades\Validator;

class ShortController extends Controller
{
    use VideoManager;
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

    /**
     * Upload short chunk
     * POST /api/shorts/upload-chunk
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
     * Merge short chunks and process video
     * POST /api/shorts/merge-chunks
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
                $uploadVideo = Video::authUser()->where('is_shorts_video', Status::YES)->findOrFail($id);
            } else {
                $uploadVideo          = new Video();
                $uploadVideo->user_id = auth()->id();
                $uploadVideo->step    = Status::FIRST_STEP;
                $uploadVideo->is_shorts_video = Status::YES;
                $uploadVideo->save();
            }

            $fileName = now()->format('Y/F') . '/' . uniqid() . time() . '.' . $uploadedFile->getClientOriginalExtension();

            try {
                if (@$uploadVideo->storage) {
                    $this->removeOldFile($uploadVideo, @$uploadVideo->storage, $uploadVideo->video, 'videos');
                }

                $uploadVideo->video = fileUploader($uploadedFile, getFilePath('video') . '/' . now()->format('Y/F'), old: $uploadVideo->video ?? null, filename: $fileName);
                $uploadVideo->save();
            } catch (\Exception $exp) {
                \Illuminate\Support\Facades\DB::rollBack();
                return responseError('upload_error', ['Couldn\'t upload your video']);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\File::delete($mergedFilePath);
            return responseError('merge_error', ['Error: ' . $e->getMessage()]);
        }

        \Illuminate\Support\Facades\File::delete($mergedFilePath);

        return responseSuccess('short_uploaded', 'Short uploaded successfully.', [
            'video_id' => $uploadVideo->id,
            'step' => $uploadVideo->step,
        ]);
    }

    /**
     * Submit short details
     * POST /api/shorts/{id}/details
     */
    public function submitDetails(Request $request, $id)
    {
        $video = Video::where('step', '>=', Status::FIRST_STEP)
            ->authUser()
            ->where('is_shorts_video', Status::YES)
            ->findOrFail($id);

        $slug = $request->slug;
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'playlist'    => 'nullable|integer',
            'is_only_playlist' => 'required|integer|in:0,1',
            'thumb_image' => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'slug'        => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($slug, $id) {
                    $query = Video::where('slug', $slug)->where('id', '!=', $id)->where('is_shorts_video', Status::YES);
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
     * Submit short visibility settings
     * POST /api/shorts/{id}/visibility
     */
    public function submitVisibility(Request $request, $id)
    {
        $request->validate([
            'category'   => 'required|integer',
            'tags'       => 'required|array|min:1',
            'tags.*'     => 'required|string',
            'visibility' => 'required|in:0,1',
        ]);

        $video = Video::where('step', '>=', Status::SECOND_STEP)
            ->authUser()
            ->where('is_shorts_video', Status::YES)
            ->findOrFail($id);

        $category           = Category::active()->findOrFail($request->category);
        $video->category_id = $category->id;

        $video->visibility = $request->visibility;

        if ($video->status == Status::NO || $video->step <= Status::SECOND_STEP) {
            $video->step   = Status::THIRD_STEP;
            $video->status = Status::PUBLISHED;
        }

        $video->save();

        if ($request->tags) {
            $oldTags = $video->tags;
            if ($oldTags) {
                $video->tags()->delete();
            }
            foreach ($request->tags as $tag) {
                $videoTag           = new VideoTag();
                $videoTag->video_id = $video->id;
                $videoTag->tag      = $tag;
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

