<?php

namespace App\Console\Commands;

use App\Models\VideoFile;
use Illuminate\Console\Command;
use FFMpeg\FFProbe;

class DetectVideoResolutions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:detect-resolutions {--force : Force re-detection of all videos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detect and update video file resolutions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting video resolution detection...');
        
        try {
            $ffprobe = FFProbe::create();
            
            $query = VideoFile::query();
            
            if (!$this->option('force')) {
                $query->whereNull('quality')->orWhere('quality', '');
            }
            
            $videoFiles = $query->get();
            $updated = 0;
            $errors = 0;
            
            $progressBar = $this->output->createProgressBar($videoFiles->count());
            $progressBar->start();
            
            foreach ($videoFiles as $videoFile) {
                try {
                    $filePath = $this->getVideoFilePath($videoFile);
                    
                    if ($filePath && file_exists($filePath)) {
                        // Get video dimensions
                        $dimensions = $ffprobe
                            ->streams($filePath)
                            ->videos()
                            ->first()
                            ->getDimensions();
                            
                        $width = $dimensions->getWidth();
                        $height = $dimensions->getHeight();
                        
                        // Get bitrate
                        $bitrate = $ffprobe
                            ->format($filePath)
                            ->get('bit_rate');
                        
                        // Determine quality label
                        $quality = $this->determineQualityLabel($width, $height);
                        
                        // Update the video file record
                        $videoFile->update([
                            'quality' => $quality,
                            'width' => $width,
                            'height' => $height,
                            'bitrate' => $bitrate
                        ]);
                        
                        $updated++;
                        $this->line("\nUpdated: {$videoFile->file_name} -> {$quality} ({$width}x{$height})");
                    } else {
                        $this->warn("\nFile not found: {$videoFile->file_name}");
                        $errors++;
                    }
                    
                } catch (\Exception $e) {
                    $this->error("\nError processing {$videoFile->file_name}: " . $e->getMessage());
                    $errors++;
                }
                
                $progressBar->advance();
            }
            
            $progressBar->finish();
            
            $this->newLine();
            $this->info("Resolution detection completed!");
            $this->info("Updated: {$updated} files");
            if ($errors > 0) {
                $this->warn("Errors: {$errors} files");
            }
            
        } catch (\Exception $e) {
            $this->error('Error during resolution detection: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
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
}
