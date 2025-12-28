<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Subtitle;
use App\Models\Video;
use App\Models\WatchHistory;
use App\Models\WatchLater;
use App\Rules\FileTypeValidate;
use App\Traits\VideoManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    use VideoManager;

    public function __construct()
    {
        parent::__construct();
        $this->view = 'video';
    }

    public function elementsForm($id = 0)
    {
        abort_if(!$id, 404);

        $pageTitle = "Elements Details";
        $video     = Video::where('step', '>=', Status::SECOND_STEP)->authUser()->where('is_shorts_video', Status::NO)->findOrFail($id);
        return view('Template::user.video.elements', compact('pageTitle', 'video'));
    }

    public function elementsSubmit(Request $request, $id)
    {
        $request->validate([
            'audience'        => 'required|in:0,1',
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
        ], [
            'caption.*'       => 'Caption is required when subtitle file or language code is present.',
            'language_code.*' => "Language code must be a string and is required when caption or subtitle file is present.",
            'subtitle_file.*' => "Invalid subtitle format. Subtitle file is required when caption or language code is present.",
        ]);

        $video = Video::where('step', '>=', Status::SECOND_STEP)->authUser()->where('is_shorts_video', Status::NO)->findOrFail($id);

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
                    $notify[] = ['error', 'Couldn\'t upload your subtitle'];
                    return back()->withNotify($notify);
                }
                $subtitle->video_id      = $video->id;
                $subtitle->caption       = $request->caption[$key];
                $subtitle->language_code = $request->language_code[$key];
                $subtitle->save();
            }
        }

        $notify[] = ['success', 'Elements successfully save'];
        return to_route('user.video.visibility.form', $video->id)->withNotify($notify);
    }

    public function editVideo($id)
    {
        $id    = decrypt($id);
        $video = Video::authUser()->findOrFail($id);
        if ($video->step == Status::FIRST_STEP) {
            return redirect()->route('user.video.details.form', $video->id);
        } else if ($video->step == Status::SECOND_STEP) {
            return redirect()->route('user.video.elements.form', $video->id);
        } else if ($video->step == Status::THIRD_STEP) {
            return redirect()->route('user.video.visibility.form', $video->id);
        } else {
            return redirect()->route('user.video.upload.form', $video->id);
        }
    }

    public function addPlaylist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id'      => 'required|integer',
            'playlist_id'   => 'required|array|min:1',
            'playlist_id.*' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'remark'  => 'validation_error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $video = Video::published()->whereHas('user', function ($q) {
            $q->active();
        })->findOrFail($request->video_id);

        $playlists = Playlist::where('user_id', auth()->id())->whereIn('id', $request->playlist_id)->get();
        if (count($playlists) != count($request->playlist_id)) {
            return response()->json(['error' => "Something went wrong"]);
        }

        $video->playlists()->detach();
        $video->playlists()->attach($request->playlist_id);
        return response()->json(['success' => "Video successfully added to the playlist"]);
    }

    public function delete($id)
    {
        try {
            $id = decrypt($id);
            $video = Video::authUser()->with('videoFiles', 'subtitles', 'tags', 'storage')->find($id);
            
            // Check if video exists
            if (!$video) {
                $notify[] = ['error', 'Video not found or you do not have permission to delete this video'];
                return back()->withNotify($notify);
            }
            
            // Double check: Ensure video belongs to current user
            if ($video->user_id != auth()->id()) {
                $notify[] = ['error', 'You do not have permission to delete this video'];
                return back()->withNotify($notify);
            }

            // Delete video files
            foreach ($video->videoFiles as $videoFile) {
                if ($video->storage) {
                    $this->removeOldFile($video, $video->storage, $videoFile->file_name, 'videos');
                } else {
                    $filePath = getFilePath('video') . '/' . $videoFile->file_name;
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
                $videoFile->delete();
            }

            // Delete old video file if exists (for shorts or non-multi-quality videos)
            if ($video->video) {
                if ($video->storage) {
                    $this->removeOldFile($video, $video->storage, $video->video, 'videos');
                } else {
                    $filePath = getFilePath('video') . '/' . $video->video;
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }

            // Delete thumbnail
            if ($video->thumb_image) {
                $thumbPath = getFilePath('thumbnail') . '/' . $video->thumb_image;
                $thumbThumbPath = getFilePath('thumbnail') . '/thumb_' . $video->thumb_image;
                if (file_exists($thumbPath)) {
                    @unlink($thumbPath);
                }
                if (file_exists($thumbThumbPath)) {
                    @unlink($thumbThumbPath);
                }
            }

            // Delete subtitles
            foreach ($video->subtitles as $subtitle) {
                $subtitlePath = getFilePath('subtitle') . '/' . $subtitle->file;
                if (file_exists($subtitlePath)) {
                    @unlink($subtitlePath);
                }
                $subtitle->delete();
            }

            // Delete tags
            $video->tags()->delete();

            // Detach from playlists and plans (pivot tables)
            $video->playlists()->detach();
            $video->plans()->detach();

            // Delete related data (cascade should handle most, but being explicit)
            $video->userReactions()->delete();
            $video->allComments()->delete();
            $video->adPlayDurations()->delete();

            // Delete watch history and watch later entries
            WatchHistory::where('video_id', $video->id)->delete();
            WatchLater::where('video_id', $video->id)->delete();

            // Get video ID before deletion for cleanup
            $videoId = $video->id;
            
            // Change status to draft first to prevent it from showing in public queries immediately
            $video->status = \App\Constants\Status::DRAFT;
            $video->visibility = \App\Constants\Status::PRIVATE;
            $video->is_trending = \App\Constants\Status::NO; // Remove from trending
            $video->save();
            
            // Delete the video record (hard delete)
            $deleted = $video->delete();
            
            // Verify deletion - force delete if needed
            if (!$deleted || Video::find($videoId)) {
                // Force delete from database
                DB::table('videos')->where('id', $videoId)->where('user_id', auth()->id())->delete();
            }
            
            // Clear cache to remove any cached video lists
            if (function_exists('cache')) {
                cache()->flush();
            }

            $notify[] = ['success', 'Video deleted successfully'];
            return redirect()->route('user.videos')->withNotify($notify);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Failed to delete video: ' . $e->getMessage()];
            return back()->withNotify($notify);
        }
    }
}
