<div class="channel-live-content">
    <div class="live-streams-section">
        <?php if($liveStreams->count() > 0): ?>
            <div class="live-streams-grid">
                <?php $__currentLoopData = $liveStreams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stream): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="live-stream-item">
                        <a href="<?php echo e(route('live.watch', [$stream->id, $stream->slug])); ?>" class="live-stream-link">
                            <div class="live-stream-thumbnail">
                                <?php if($stream->recorded_video): ?>
                                    <video class="thumbnail-video" preload="none" muted playsinline>
                                        <source src="<?php echo e(url('live/recording/' . $stream->id)); ?>" type="video/webm">
                                    </video>
                                    <div class="play-overlay">
                                        <i class="las la-play"></i>
                                    </div>
                                    <?php if($stream->recorded_duration): ?>
                                        <span class="video-duration-badge">
                                            <?php echo e(gmdate('i:s', $stream->recorded_duration)); ?>

                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="no-thumbnail">
                                        <i class="las la-video"></i>
                                    </div>
                                <?php endif; ?>
                                <?php if($stream->status == 'live'): ?>
                                    <span class="live-badge-thumbnail">
                                        <span class="live-dot-small"></span>
                                        LIVE
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="live-stream-info">
                                <h4 class="live-stream-title"><?php echo e(Str::limit($stream->title, 60)); ?></h4>
                                <div class="live-stream-meta">
                                    <span class="stream-type">
                                        <i class="las la-video"></i> <?php echo app('translator')->get('Webcam'); ?>
                                    </span>
                                    <span class="stream-visibility">
                                        <?php if($stream->visibility == 'private'): ?>
                                            <i class="las la-lock"></i> <?php echo app('translator')->get('Private'); ?>
                                        <?php elseif($stream->visibility == 'unlisted'): ?>
                                            <i class="las la-eye-slash"></i> <?php echo app('translator')->get('Unlisted'); ?>
                                        <?php else: ?>
                                            <i class="las la-globe"></i> <?php echo app('translator')->get('Public'); ?>
                                        <?php endif; ?>
                                    </span>
                                    <span class="stream-date">
                                        <?php echo e($stream->started_at ? showDateTime($stream->started_at, 'M d, Y') : showDateTime($stream->created_at, 'M d, Y')); ?>

                                    </span>
                                </div>
                                <div class="live-stream-stats">
                                    <span><i class="las la-eye"></i> <?php echo e(formatNumber($stream->viewers_count)); ?> <?php echo app('translator')->get('views'); ?></span>
                                    <?php if($stream->peak_viewers > 0): ?>
                                        <span><i class="las la-users"></i> <?php echo e(formatNumber($stream->peak_viewers)); ?> <?php echo app('translator')->get('peak'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="mt-4">
                <?php echo e(paginateLinks($liveStreams)); ?>

            </div>
        <?php else: ?>
            <div class="empty-state text-center py-5">
                <i class="las la-broadcast-tower" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                <h4><?php echo app('translator')->get('No Live Streams'); ?></h4>
                <p class="text-muted"><?php echo app('translator')->get('This channel has no live streams yet.'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('style'); ?>
<style>
    .channel-live-content {
        padding: 20px 0;
    }
    
    .live-streams-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .live-stream-item {
        background: var(--card-bg, #fff);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .live-stream-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    
    .live-stream-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }
    
    .live-stream-thumbnail {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 aspect ratio */
        background: #000;
        overflow: hidden;
    }
    
    .thumbnail-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-thumbnail {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #1a1a1a;
        color: #666;
    }
    
    .no-thumbnail i {
        font-size: 48px;
    }
    
    .play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.2s;
    }
    
    .live-stream-item:hover .play-overlay {
        opacity: 1;
    }
    
    .play-overlay i {
        font-size: 48px;
        color: #fff;
        background: rgba(0, 0, 0, 0.7);
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .video-duration-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .live-badge-thumbnail {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #ff0000;
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .live-dot-small {
        width: 6px;
        height: 6px;
        background: #fff;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    
    .live-stream-info {
        padding: 12px;
    }
    
    .live-stream-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--heading-color, #000);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .live-stream-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .stream-type,
    .stream-visibility,
    .stream-date {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .live-stream-stats {
        display: flex;
        gap: 16px;
        font-size: 12px;
        color: #666;
    }
    
    .live-stream-stats span {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    @media (max-width: 768px) {
        .live-streams-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/channel/live.blade.php ENDPATH**/ ?>