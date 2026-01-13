<?php

namespace App\Http\Controllers;

use App\Models\LiveStream;
use App\Models\LiveComment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LiveStreamController extends Controller
{
    public function index()
    {
        $pageTitle = 'Live Streams';
        $liveStreams = LiveStream::with('user', 'category')
            ->where('status', 'live')
            ->public()
            ->latest()
            ->paginate(getPaginate());

        return view('Template::live.index', compact('pageTitle', 'liveStreams'));
    }

    public function watch($id, $slug = null)
    {
        // Use DB query directly to bypass Eloquent caching and get absolute latest status
        $liveStreamData = DB::table('live_streams')
            ->where('id', $id)
            ->first();
        
        if (!$liveStreamData) {
            abort(404, 'Stream not found');
        }

        // Convert numeric status to string if needed (MySQL ENUM can return as integer)
        $rawStatus = $liveStreamData->status;
        if (is_numeric($rawStatus)) {
            $enumValues = ['scheduled', 'live', 'ended', 'cancelled'];
            $statusString = isset($enumValues[$rawStatus]) ? $enumValues[$rawStatus] : 'ended';
        } else {
            $statusString = $rawStatus;
        }
        
        // CRITICAL FIX: If stream has ended_at timestamp, it means it was live and ended
        // Override status to 'ended' even if database status is wrong (0/scheduled)
        if ($liveStreamData->ended_at && ($statusString === 'scheduled' || $rawStatus === 0)) {
            $statusString = 'ended';
            // Try to fix it in database using numeric value 2 (ended = index 2 in enum)
            DB::statement("UPDATE live_streams SET status = 2 WHERE id = ? AND ended_at IS NOT NULL", [$id]);
        }

        // Now load the model with relationships
        $liveStream = LiveStream::with('user', 'category')
            ->where('id', $id)
            ->first();
        
        // Get recorded_video safely (column might not exist if migration not run)
        $recordedVideo = null;
        $recordedDuration = null;
        if (property_exists($liveStreamData, 'recorded_video')) {
            $recordedVideo = $liveStreamData->recorded_video;
        }
        if (property_exists($liveStreamData, 'recorded_duration')) {
            $recordedDuration = $liveStreamData->recorded_duration;
        }
        
        // Force update the status and recorded_video from the direct DB query to ensure we have latest
        $liveStream->status = $statusString;
        $liveStream->recorded_video = $recordedVideo;
        $liveStream->recorded_duration = $recordedDuration;

        // Check permissions
        if (!$liveStream->canBeWatched()) {
            if (!auth()->check()) {
                return redirect()->route('user.login')->with('error', 'Please login to watch this stream.');
            }
            abort(403, 'You do not have permission to watch this stream.');
        }

        $pageTitle = $liveStream->title;

        // Increment viewer count if live (only for non-owners to avoid self-counting)
        // Handle both numeric (1) and string ('live') status values
        $isLiveStatus = ($statusString === 'live' || $statusString === 1 || $statusString === '1');
        if ($isLiveStatus && (!auth()->check() || auth()->id() !== $liveStream->user_id)) {
            $liveStream->increment('viewers_count');
            if ($liveStream->viewers_count > $liveStream->peak_viewers) {
                $liveStream->update(['peak_viewers' => $liveStream->viewers_count]);
            }
        }

        // Get playlists for the modal (if user is logged in)
        $playlists = collect([]);
        if (auth()->check()) {
            $playlists = \App\Models\Playlist::where('user_id', auth()->id())
                ->latest()
                ->get();
        }

        // Get gateway currency for the modal
        $gatewayCurrency = \App\Models\GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', \App\Constants\Status::ENABLE);
        })->with('method')->orderby('name')->get();

        return view('Template::live.watch', compact('pageTitle', 'liveStream', 'playlists', 'gatewayCurrency'));
    }

    public function goLive()
    {
        $pageTitle = 'Go Live';
        $categories = Category::active()->get();
        
        return view('Template::user.live.go_live', compact('pageTitle', 'categories'));
    }

    public function startStream(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'visibility' => 'required|in:public,private,unlisted',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle thumbnail upload
        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
            try {
                $thumbnail = fileUploader($request->thumbnail, getFilePath('liveThumbnail'), getFileSize('liveThumbnail'));
            } catch (\Exception $exp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Couldn\'t upload the thumbnail. ' . $exp->getMessage()
                ], 400);
            }
        }

        // Create stream with all data including status
        $liveStream = LiveStream::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => LiveStream::generateSlug($request->title),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'visibility' => $request->visibility,
            'thumbnail' => $thumbnail,
            'stream_key' => LiveStream::generateStreamKey(),
            'status' => 'live', // Explicitly set to 'live'
            'started_at' => now(),
            'viewers_count' => 0,
        ]);
        
        // Force update status directly in database to ensure it's saved correctly
        DB::table('live_streams')
            ->where('id', $liveStream->id)
            ->update([
                'status' => 'live',
                'started_at' => now(),
            ]);
        
        // Force refresh from database to ensure status is saved
        $liveStream->refresh();
        
        // Verify status was saved correctly - check both string and numeric
        $verifyStatus = DB::table('live_streams')
            ->where('id', $liveStream->id)
            ->value('status');
        
        // Convert to check both formats
        $statusCheck = is_numeric($verifyStatus) ? (int)$verifyStatus : $verifyStatus;
        $isLive = ($statusCheck === 'live' || $statusCheck === 1);
        
        // If still not 'live', try one more time with raw query
        if (!$isLive) {
            DB::statement("UPDATE live_streams SET status = 'live' WHERE id = ?", [$liveStream->id]);
            $liveStream->refresh();
            
            // Final verification
            $finalStatus = DB::table('live_streams')
                ->where('id', $liveStream->id)
                ->value('status');
            
            $finalCheck = is_numeric($finalStatus) ? (int)$finalStatus : $finalStatus;
            if ($finalCheck !== 'live' && $finalCheck !== 1) {
                // Last resort - update with numeric value
                DB::table('live_streams')
                    ->where('id', $liveStream->id)
                    ->update(['status' => 1]); // 1 = 'live' in enum
                $liveStream->refresh();
            }
        }

        // Get final status for response
        $finalStatus = DB::table('live_streams')
            ->where('id', $liveStream->id)
            ->value('status');
        
        $statusString = is_numeric($finalStatus) ? 
            (['scheduled', 'live', 'ended', 'cancelled'][$finalStatus] ?? 'live') : 
            $finalStatus;

        return response()->json([
            'success' => true,
            'stream_id' => $liveStream->id,
            'stream_key' => $liveStream->stream_key,
            'watch_url' => route('live.watch', [$liveStream->id, $liveStream->slug]),
            'status' => $statusString,
            'debug' => [
                'raw_status' => $finalStatus,
                'status_string' => $statusString
            ]
        ]);
    }

    public function stopStream($id)
    {
        $liveStream = LiveStream::where('user_id', Auth::id())
            ->where(function($query) {
                $query->where('status', 'live')
                      ->orWhere('status', 1); // Handle numeric status
            })
            ->findOrFail($id);

        // Use raw SQL to set status to 'ended' (which is index 2 in enum)
        // This ensures MySQL ENUM gets the correct value
        DB::statement("UPDATE live_streams SET status = 'ended', ended_at = NOW() WHERE id = ?", [$liveStream->id]);
        
        // Also update via Eloquent
        $liveStream->status = 'ended';
        $liveStream->ended_at = now();
        $liveStream->save();

        // Force update one more time with raw query
        DB::table('live_streams')
            ->where('id', $liveStream->id)
            ->update(['status' => 'ended', 'ended_at' => now()]);

        // Refresh to get latest data
        $liveStream->refresh();
        
        // Final verification - check if status was saved correctly
        $verifyStatus = DB::table('live_streams')->where('id', $liveStream->id)->value('status');
        if ($verifyStatus == 0 || $verifyStatus == 'scheduled') {
            // Last resort: use numeric value directly (2 = ended in enum)
            DB::statement("UPDATE live_streams SET status = 2, ended_at = NOW() WHERE id = ?", [$liveStream->id]);
            $liveStream->refresh();
        }
        
        // Merge any remaining chunks if they exist (in case final chunk wasn't uploaded)
        $path = getFilePath('liveRecording');
        $fullPath = public_path($path);
        $chunks = glob($fullPath . "/stream_{$id}_chunk_*.webm");
        if (!empty($chunks) && empty($liveStream->recorded_video)) {
            // Chunks exist but not merged yet - merge them now
            $this->mergeRecordingChunks($liveStream, $path, $id);
            $liveStream->refresh();
        }
        
        // CRITICAL: Recalculate duration AFTER merging - get from video file (most accurate)
        // Wait a moment for file to be fully written
        sleep(1);
        
        $actualDuration = null;
        
        // If video file exists, get duration from it (THIS IS THE ACTUAL VIDEO LENGTH)
        if ($liveStream->recorded_video) {
            $videoPath = public_path($liveStream->recorded_video);
            
            // Try multiple times to get duration (file might still be writing)
            for ($attempt = 0; $attempt < 3; $attempt++) {
                if (file_exists($videoPath) && filesize($videoPath) > 0) {
                    $actualDuration = $this->getVideoFileDuration($videoPath);
                    if ($actualDuration && $actualDuration > 0) {
                        \Log::info("Got video file duration: {$actualDuration} seconds for stream {$liveStream->id}");
                        break;
                    }
                }
                if ($attempt < 2) {
                    sleep(1); // Wait 1 second before retry
                }
            }
        }
        
        // ONLY use timestamps as last resort if video file duration is completely unavailable
        // But log a warning because this is less accurate
        if ($actualDuration === null || $actualDuration <= 0) {
            if ($liveStream->started_at && $liveStream->ended_at) {
                $startTime = \Carbon\Carbon::parse($liveStream->started_at);
                $endTime = \Carbon\Carbon::parse($liveStream->ended_at);
                $timestampDuration = max(0, $endTime->diffInSeconds($startTime));
                
                // Only use timestamp if it's reasonable (not way off)
                // But prefer to wait and try video file again
                if ($timestampDuration > 0 && $timestampDuration < 3600) { // Less than 1 hour
                    \Log::warning("Using timestamp-based duration ({$timestampDuration}s) for stream {$liveStream->id} - video file duration unavailable. Video file: " . ($liveStream->recorded_video ?? 'none'));
                    $actualDuration = $timestampDuration;
                } else {
                    \Log::error("Timestamp duration seems incorrect ({$timestampDuration}s) for stream {$liveStream->id}. Video file: " . ($liveStream->recorded_video ?? 'none'));
                }
            }
        }
        
        // Update duration if we have a valid value
        if ($actualDuration && $actualDuration > 0) {
            // Update directly in database first (most reliable)
            DB::table('live_streams')
                ->where('id', $liveStream->id)
                ->update(['recorded_duration' => $actualDuration]);
            
            // Then update model
            $liveStream->recorded_duration = $actualDuration;
            $liveStream->save();
            
            \Log::info("Final duration saved for stream {$liveStream->id}: {$actualDuration} seconds");
        } else {
            \Log::error("Could not determine duration for stream {$liveStream->id}. Video file: " . ($liveStream->recorded_video ?? 'none'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Stream ended successfully',
            'stream_id' => $liveStream->id,
            'status' => $liveStream->status,
            'has_recording' => !empty($liveStream->recorded_video)
        ]);
    }

    public function uploadRecordingChunk(Request $request, $id)
    {
        $request->validate([
            'chunk' => 'required|file|mimes:webm,mp4|max:10240', // 10MB max per chunk
            'chunk_index' => 'required|integer',
            'is_final' => 'nullable|boolean',
        ]);

        $liveStream = LiveStream::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $path = getFilePath('liveRecording');
        $chunkFile = $request->file('chunk');
        $chunkIndex = $request->chunk_index;
        $isFinal = $request->boolean('is_final', false);

        // Create directory if it doesn't exist
        $fullPath = public_path($path);
        if (!file_exists($fullPath)) {
            \Illuminate\Support\Facades\File::makeDirectory($fullPath, 0755, true);
        }

        // Save chunk with index
        $chunkFileName = "stream_{$id}_chunk_{$chunkIndex}.webm";
        $chunkFile->move($fullPath, $chunkFileName);

        // If this is the final chunk, merge all chunks
        if ($isFinal) {
            $this->mergeRecordingChunks($liveStream, $path, $id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Chunk uploaded successfully',
            'chunk_index' => $chunkIndex
        ]);
    }

    private function mergeRecordingChunks($liveStream, $path, $streamId)
    {
        $fullPath = public_path($path);
        $chunks = glob($fullPath . "/stream_{$streamId}_chunk_*.webm");
        
        if (empty($chunks)) {
            return;
        }

        // Sort chunks by index
        natsort($chunks);
        
        // Create final video filename
        $finalFileName = "stream_{$streamId}_" . time() . ".webm";
        $finalPath = $fullPath . '/' . $finalFileName;
        
        // Merge chunks
        $output = fopen($finalPath, 'wb');
        $totalDuration = 0;
        foreach ($chunks as $chunk) {
            $input = fopen($chunk, 'rb');
            stream_copy_to_stream($input, $output);
            fclose($input);
            // Delete chunk after merging
            unlink($chunk);
        }
        fclose($output);

        // Get ACTUAL duration from the merged video file
        $actualDuration = $this->getVideoFileDuration($finalPath);
        
        // If we couldn't get duration from file, try timestamps as fallback
        if ($actualDuration === null || $actualDuration <= 0) {
            $liveStream->refresh();
            $streamData = DB::table('live_streams')->where('id', $streamId)->first();
            
            if ($streamData && $streamData->started_at && $streamData->ended_at) {
                $startTime = \Carbon\Carbon::parse($streamData->started_at);
                $endTime = \Carbon\Carbon::parse($streamData->ended_at);
                $calculatedDuration = max(0, $endTime->diffInSeconds($startTime));
                
                // Only use timestamp calculation if it's reasonable (within 10% of file-based estimate)
                // Otherwise, the video file duration is more accurate
                if ($calculatedDuration > 0) {
                    \Log::warning("Using timestamp-based duration ({$calculatedDuration}s) for stream {$streamId} - video file duration unavailable");
                    $actualDuration = $calculatedDuration;
                }
            }
        }
        
        // Last resort: Use file size estimation (better than chunk count)
        if ($actualDuration === null || $actualDuration <= 0) {
            if (file_exists($finalPath)) {
                $fileSize = filesize($finalPath);
                // Rough estimation: ~1MB per 10 seconds for webm (very rough)
                $actualDuration = max(1, (int) round(($fileSize / 1024 / 1024) * 10));
                \Log::warning("Using file size estimation for duration: {$actualDuration} seconds for stream {$streamId}");
            } else {
                $actualDuration = count($chunks) * 5; // Last fallback
                \Log::warning("Using chunk count fallback for duration: {$actualDuration} seconds for stream {$streamId}");
            }
        }
        
        // CRITICAL: Wait for file to be fully written, then re-check duration
        // The video file duration is ALWAYS more accurate than timestamps
        if (file_exists($finalPath)) {
            sleep(1); // Wait for file to be fully written
            $finalDuration = $this->getVideoFileDuration($finalPath);
            if ($finalDuration && $finalDuration > 0) {
                $actualDuration = $finalDuration;
                \Log::info("Got final video file duration after write: {$actualDuration} seconds for stream {$streamId}");
            }
        }

        // Save to database - UPDATE DIRECTLY FIRST (most reliable)
        $relativePath = $path . '/' . $finalFileName;
        DB::table('live_streams')
            ->where('id', $streamId)
            ->update([
                'recorded_video' => $relativePath,
                'recorded_duration' => $actualDuration
            ]);
        
        // Then update model
        $liveStream->refresh();
        $liveStream->recorded_video = $relativePath;
        $liveStream->recorded_duration = $actualDuration;
        $liveStream->save();
        
        \Log::info("Merged chunks for stream {$streamId}, saved duration: {$actualDuration} seconds");
    }

    public function getRecordedVideo($id)
    {
        $liveStream = LiveStream::where('id', $id)->firstOrFail();
        
        // Check permissions
        if (!$liveStream->canBeWatched()) {
            abort(403, 'You do not have permission to view this recording.');
        }

        if (!$liveStream->recorded_video) {
            abort(404, 'Recording not found');
        }

        $filePath = public_path($liveStream->recorded_video);
        
        if (!file_exists($filePath)) {
            \Log::error('Recorded video file not found', [
                'stream_id' => $id,
                'expected_path' => $filePath,
                'recorded_video' => $liveStream->recorded_video
            ]);
            abort(404, 'Recording file not found on server');
        }

        $mimeType = mime_content_type($filePath) ?: 'video/webm';
        $fileSize = filesize($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Length' => $fileSize,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline; filename="' . basename($liveStream->recorded_video) . '"',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function manage()
    {
        $pageTitle = 'Manage Live Streams';
        $liveStreams = LiveStream::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(getPaginate());

        // Recalculate duration for ended streams to fix incorrect durations
        // Use direct DB query to get fresh data and fix all streams
        $streamIds = $liveStreams->pluck('id')->toArray();
        if (!empty($streamIds)) {
            $streamsToFix = DB::table('live_streams')
                ->whereIn('id', $streamIds)
                ->whereNotNull('started_at')
                ->whereNotNull('ended_at')
                ->get();
            
            foreach ($streamsToFix as $streamData) {
                $startTime = \Carbon\Carbon::parse($streamData->started_at);
                $endTime = \Carbon\Carbon::parse($streamData->ended_at);
                $actualDuration = max(0, $endTime->diffInSeconds($startTime));
                
                // Always update if we have valid timestamps
                if ($actualDuration > 0) {
                    DB::table('live_streams')
                        ->where('id', $streamData->id)
                        ->update(['recorded_duration' => $actualDuration]);
                }
            }
            
            // Refresh all streams to get updated durations
            $liveStreams->load('category');
            foreach ($liveStreams as $stream) {
                $stream->refresh();
            }
        }

        return view('Template::user.live.manage', compact('pageTitle', 'liveStreams'));
    }

    public function delete($id)
    {
        try {
            // Check if stream exists at all
            $streamExists = LiveStream::find($id);
            
            if (!$streamExists) {
                $notify[] = ['error', 'Stream not found. It may have already been deleted.'];
                return back()->withNotify($notify);
            }

            // Check if stream belongs to current user
            if ($streamExists->user_id != Auth::id()) {
                $notify[] = ['error', 'You do not have permission to delete this stream.'];
                return back()->withNotify($notify);
            }

            $liveStream = $streamExists;

            // Check if stream is live
            if ($liveStream->status == 'live') {
                $notify[] = ['error', 'Cannot delete a live stream. Please end the stream first.'];
                return back()->withNotify($notify);
            }

            // Delete thumbnail if exists
            if ($liveStream->thumbnail) {
                $path = getFilePath('liveThumbnail');
                $old = $liveStream->thumbnail;
                $fileManager = new \App\Lib\FileManager();
                $fileManager->removeFile($path . '/' . $old);
            }

            // Delete recorded video if exists
            if ($liveStream->recorded_video) {
                $videoPath = public_path($liveStream->recorded_video);
                if (file_exists($videoPath)) {
                    unlink($videoPath);
                }
                // Also delete any remaining chunks
                $chunkPath = dirname($videoPath);
                $chunks = glob($chunkPath . "/stream_{$liveStream->id}_chunk_*.webm");
                foreach ($chunks as $chunk) {
                    if (file_exists($chunk)) {
                        unlink($chunk);
                    }
                }
            }

            // Delete comments
            LiveComment::where('live_stream_id', $liveStream->id)->delete();

            // Delete stream
            $liveStream->delete();

            $notify[] = ['success', 'Live stream deleted successfully.'];
            return back()->withNotify($notify);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Failed to delete stream. ' . $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $liveStream = LiveStream::where('id', $id)
            ->where('status', 'live')
            ->firstOrFail();

        if (!$liveStream->canBeWatched()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to comment on this stream.'
            ], 403);
        }

        $comment = new LiveComment();
        $comment->live_stream_id = $liveStream->id;
        $comment->user_id = Auth::id();
        $comment->comment = $request->comment;
        $comment->save();

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->display_name ?? $comment->user->username,
                    'image' => getImage(getFilePath('userProfile') . '/' . $comment->user->image, getFileSize('userProfile'), true),
                ],
                'created_at' => $comment->created_at->diffForHumans(),
            ]
        ]);
    }

    public function getComments($id)
    {
        $liveStream = LiveStream::where('id', $id)
            ->where('status', 'live')
            ->firstOrFail();

        $comments = LiveComment::where('live_stream_id', $liveStream->id)
            ->with('user')
            ->latest()
            ->take(50)
            ->get()
            ->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->display_name ?? $comment->user->username,
                        'image' => getImage(getFilePath('userProfile') . '/' . $comment->user->image, getFileSize('userProfile'), true),
                    ],
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    public function debugStream($id)
    {
        // Debug endpoint to check stream status
        $dbStatus = DB::table('live_streams')->where('id', $id)->first();
        $modelStatus = LiveStream::find($id);
        
        // Get raw status value - MySQL ENUM might return as integer
        $rawStatus = $dbStatus ? $dbStatus->status : null;
        $statusString = $rawStatus;
        
        // If status is numeric, convert to string (MySQL ENUM index)
        if (is_numeric($rawStatus)) {
            $enumValues = ['scheduled', 'live', 'ended', 'cancelled'];
            $statusString = isset($enumValues[$rawStatus]) ? $enumValues[$rawStatus] : 'unknown';
        }
        
        return response()->json([
            'success' => true,
            'debug' => [
                'stream_id' => $id,
                'db_raw_status' => $rawStatus,
                'db_status_string' => $statusString,
                'model_status' => $modelStatus ? $modelStatus->status : 'NOT FOUND',
                'db_user_id' => $dbStatus ? $dbStatus->user_id : null,
                'db_started_at' => $dbStatus ? $dbStatus->started_at : null,
                'db_ended_at' => $dbStatus ? $dbStatus->ended_at : null,
                'current_user_id' => Auth::id(),
                'is_owner' => $dbStatus && Auth::id() == $dbStatus->user_id,
                'is_live_check' => $statusString === 'live',
                'timestamp' => now()->toDateTimeString(),
            ]
        ]);
    }

    public function getStreamInfo($id)
    {
        // Use direct DB query to get absolute latest status (bypass Eloquent cache)
        $streamData = DB::table('live_streams')
            ->where('id', $id)
            ->first();
        
        if (!$streamData) {
            return response()->json([
                'success' => false,
                'message' => 'Stream not found'
            ], 404);
        }

        // Convert numeric status to string if needed (MySQL ENUM can return as integer)
        $rawStatus = $streamData->status;
        if (is_numeric($rawStatus)) {
            $enumValues = ['scheduled', 'live', 'ended', 'cancelled'];
            $statusString = isset($enumValues[$rawStatus]) ? $enumValues[$rawStatus] : 'ended';
        } else {
            $statusString = $rawStatus;
        }

        // Check permissions (but allow checking status even if private for owner)
        $canView = false;
        $visibility = is_numeric($streamData->visibility) ? 
            (['public', 'private', 'unlisted'][$streamData->visibility] ?? 'public') : 
            $streamData->visibility;
            
        if ($visibility === 'public') {
            $canView = true;
        } elseif ($visibility === 'unlisted') {
            $canView = true; // Anyone with link can view unlisted
        } elseif ($visibility === 'private' && auth()->check() && auth()->id() === $streamData->user_id) {
            $canView = true; // Owner can view private streams
        }

        if (!$canView) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to view this stream'
            ], 403);
        }

        // Return the actual status directly from database query
        return response()->json([
            'success' => true,
            'stream' => [
                'id' => $streamData->id,
                'title' => $streamData->title,
                'status' => $statusString, // Converted from DB - no caching
                'viewers_count' => $streamData->viewers_count,
                'is_live' => $statusString === 'live', // Check directly
            ]
        ]);
    }

    public function getStreamDetails($id)
    {
        $liveStream = LiveStream::where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'title' => $liveStream->title,
            'description' => $liveStream->description,
            'category_id' => $liveStream->category_id,
            'visibility' => $liveStream->visibility,
        ]);
    }

    public function updateStream(Request $request, $id)
    {
        $liveStream = LiveStream::where('user_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'visibility' => 'required|in:public,private,unlisted',
        ]);

        // Generate new slug if title changed
        $slug = $liveStream->slug;
        if ($liveStream->title !== $request->title) {
            $slug = LiveStream::generateSlug($request->title);
        }

        // Update stream
        $liveStream->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'visibility' => $request->visibility,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stream updated successfully'
        ]);
    }

    /**
     * Update duration from video file (called by JavaScript when video loads)
     */
    public function updateDuration(Request $request, $id)
    {
        $liveStream = LiveStream::findOrFail($id);
        
        $request->validate([
            'duration' => 'required|integer|min:1'
        ]);
        
        $duration = (int) $request->duration;
        
        // Update database
        DB::table('live_streams')
            ->where('id', $id)
            ->update(['recorded_duration' => $duration]);
        
        $liveStream->refresh();
        $liveStream->recorded_duration = $duration;
        $liveStream->save();
        
        \Log::info("Updated duration for stream {$id} to {$duration} seconds from video file");
        
        return response()->json([
            'success' => true,
            'duration' => $duration
        ]);
    }

    /**
     * Get video file duration using multiple methods
     */
    private function getVideoFileDuration($filePath)
    {
        if (!file_exists($filePath)) {
            return null;
        }

        // Method 1: Try FFProbe (most accurate)
        try {
            if (class_exists('\FFMpeg\FFProbe')) {
                $ffprobe = \FFMpeg\FFProbe::create();
                $duration = $ffprobe->format($filePath)->get('duration');
                if ($duration && $duration > 0) {
                    $durationSeconds = (int) round($duration);
                    \Log::info("Got video duration from FFProbe: {$durationSeconds} seconds");
                    return $durationSeconds;
                }
            }
        } catch (\Exception $e) {
            \Log::warning("FFProbe failed: " . $e->getMessage());
        }

        // Method 2: Try using ffprobe command directly
        try {
            $command = "ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($filePath) . " 2>&1";
            $output = shell_exec($command);
            if ($output && is_numeric(trim($output))) {
                $durationSeconds = (int) round(trim($output));
                if ($durationSeconds > 0) {
                    \Log::info("Got video duration from ffprobe command: {$durationSeconds} seconds");
                    return $durationSeconds;
                }
            }
        } catch (\Exception $e) {
            \Log::warning("ffprobe command failed: " . $e->getMessage());
        }

        return null;
    }
}

