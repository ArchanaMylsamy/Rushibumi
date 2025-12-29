<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\WatchHistory;
use App\Models\WatchLater;
use App\Traits\VideoManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShortsController extends Controller
{
    use VideoManager;

    public function __construct()
    {
    
        parent::__construct();
        $this->view = 'shorts';
        $this->shorts = true;
    }

    public function editShorts($id){
        $video = Video::authUser()->findOrFail($id);
        if($video->step == 1){
            return redirect()->route('user.shorts.details.form', $video->id);
        }else if($video->step == 2){
            return redirect()->route('user.shorts.visibility.form', $video->id);
        }else{
            return redirect()->route('user.shorts.upload.form', $video->id);
        }
    }

    public function delete($id)
    {
        try {
            $id = decrypt($id);
            $video = Video::authUser()->where('is_shorts_video', \App\Constants\Status::YES)
                ->with('subtitles', 'tags', 'storage')->find($id);
            
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

            // Delete video file
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

            // Delete related data
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

            $notify[] = ['success', 'Short deleted successfully'];
            return redirect()->route('user.shorts')->withNotify($notify);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Failed to delete short: ' . $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

}
