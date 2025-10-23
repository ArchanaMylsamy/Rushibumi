<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoFile;
use App\Models\VideoResolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;

class VideoQualityController extends Controller
{
    /**
     * Detect and update video file resolutions
     */
    public function detectVideoResolutions()
    {
        try {
            // Initialize FFProbe
            $ffprobe = FFProbe::create();
            
            $videoFiles = VideoFile::whereNull('quality')->orWhere('quality', '')->get();
            $updated = 0;
            
            foreach ($videoFiles as $videoFile) {
                $filePath = $this->getVideoFilePath($videoFile);
                
                if ($filePath && file_exists($filePath)) {
                    try {
                        // Get video dimensions
                        $dimensions = $ffprobe
                            ->streams($filePath)
                            ->videos()
                            ->first()
                            ->getDimensions();
                            
                        $width = $dimensions->getWidth();
                        $height = $dimensions->getHeight();
                        
                        // Determine quality label
                        $quality = $this->determineQualityLabel($width, $height);
                        
                        // Update the video file record
                        $videoFile->update([
                            'quality' => $quality,
                            'width' => $width,
                            'height' => $height
                        ]);
                        
                        $updated++;
                        
                    } catch (\Exception $e) {
                        \Log::error("Error processing video file {$videoFile->id}: " . $e->getMessage());
                    }
                }
            }
            
            return response()->json([
                'status' => 'success',
                'message' => "Updated {$updated} video files with resolution data"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error detecting video resolutions: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get video file path
     */
    private function getVideoFilePath($videoFile)
    {
        $video = $videoFile->video;
        
        if ($video->storage_id == 0) {
            // Local storage
            return 'assets/videos/' . $videoFile->file_name;
        } else {
            // External storage - you may need to implement this based on your storage setup
            return null;
        }
    }
    
    /**
     * Determine quality label based on dimensions
     */
    private function determineQualityLabel($width, $height)
    {
        $pixels = $width * $height;
        
        if ($pixels >= 2073600) { // 1920x1080
            return '1080p';
        } elseif ($pixels >= 921600) { // 1280x720
            return '720p';
        } elseif ($pixels >= 480000) { // 854x480
            return '480p';
        } elseif ($pixels >= 230400) { // 640x360
            return '360p';
        } elseif ($pixels >= 92160) { // 426x240
            return '240p';
        } else {
            return 'auto';
        }
    }
    
    /**
     * Get available qualities for a video
     */
    public function getVideoQualities($videoId)
    {
        $video = Video::with('videoFiles')->findOrFail($videoId);
        
        $qualities = $video->videoFiles()
            ->whereNotNull('quality')
            ->where('quality', '!=', '')
            ->orderByRaw("CASE 
                WHEN quality = '1080p' THEN 1
                WHEN quality = '720p' THEN 2
                WHEN quality = '480p' THEN 3
                WHEN quality = '360p' THEN 4
                WHEN quality = '240p' THEN 5
                ELSE 6
            END")
            ->get()
            ->map(function ($file) {
                return [
                    'id' => $file->id,
                    'quality' => $file->quality,
                    'width' => $file->width ?? 0,
                    'height' => $file->height ?? 0,
                    'url' => route('video.path', encrypt($file->id))
                ];
            });
            
        return response()->json([
            'status' => 'success',
            'qualities' => $qualities
        ]);
    }
    
    /**
     * Stream video with quality selection
     */
    public function streamVideoWithQuality($videoId, $quality = null)
    {
        $video = Video::with('videoFiles')->findOrFail($videoId);
        
        // If no quality specified, get the highest available
        if (!$quality) {
            $videoFile = $video->videoFiles()
                ->whereNotNull('quality')
                ->orderByRaw("CASE 
                    WHEN quality = '1080p' THEN 1
                    WHEN quality = '720p' THEN 2
                    WHEN quality = '480p' THEN 3
                    WHEN quality = '360p' THEN 4
                    WHEN quality = '240p' THEN 5
                    ELSE 6
                END")
                ->first();
        } else {
            $videoFile = $video->videoFiles()
                ->where('quality', $quality)
                ->first();
        }
        
        if (!$videoFile) {
            abort(404, 'Video quality not found');
        }
        
        return $this->streamVideo($videoFile->file_name, $video->storage_id, $video);
    }
    
    /**
     * Stream video file (copied from SiteController)
     */
    private function streamVideo($fileName, $storageId, $video)
    {
        if ($storageId == 0) {
            $filePath = 'assets/videos/' . $fileName;

            if (!file_exists($filePath)) {
                abort(404);
            }

            $size   = filesize($filePath);
            $start  = 0;
            $end    = $size - 1;
            $length = $size;

            $headers = [
                'Content-Type'  => 'application/octet-stream',
                'Accept-Ranges' => 'bytes',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma'        => 'no-cache',
                'Expires'       => '0',
            ];

            if (request()->headers->has('Range')) {
                preg_match('/bytes=(\d+)-(\d*)/', request()->header('Range'), $matches);
                $start = intval($matches[1]);
                if (isset($matches[2]) && $matches[2] !== '') {
                    $end = intval($matches[2]);
                }
                $length = $end - $start + 1;

                $headers['Content-Range']  = "bytes $start-$end/$size";
                $headers['Content-Length'] = $length;
                $status                    = 206;
            } else {
                $headers['Content-Length'] = $size;
                $status                    = 200;
            }

            $stream = function () use ($filePath, $start, $length) {
                $handle = fopen($filePath, 'rb');
                fseek($handle, $start);
                $bufferSize = 8192;

                while (!feof($handle) && $length > 0) {
                    $readLength = min($bufferSize, $length);
                    echo fread($handle, $readLength);
                    flush();
                    $length -= $readLength;
                }

                fclose($handle);
            };

            return response()->stream($stream, $status, $headers);
        }

        return redirect()->away(getVideo($fileName, $video));
    }
}
