<?php $__currentLoopData = $relatedVideos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedVideo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="video-item">
        <a data-video_id="<?php echo e($relatedVideo->id); ?>" href="<?php echo e(route('video.play', [$relatedVideo->id, $relatedVideo->slug])); ?>"
           class="video-item__thumb  <?php if($relatedVideo->showEligible() && !$relatedVideo->audience): ?> autoPlay <?php endif; ?>">
            <video class="related-video-player video-player"  controls
                   data-poster="<?php echo e(getImage(getFilePath('thumbnail') . '/' . $relatedVideo->thumb_image)); ?>">
            </video>
           <?php echo $__env->make('Template::partials.video.video_loader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if(!$relatedVideo->showEligible()): ?>
                <span class="video-item__price">
                    <span class="text"><?php echo app('translator')->get('Only'); ?></span>
                    <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($relatedVideo->price, currencyFormat: false)); ?>

                </span>

                <div class="premium-icon releted-pre-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"
                         aria-hidden="true" class="_24ydrq0 _1286nb17o _1286nb12r6">
                        <path
                              d="M486.2 50.2c-9.6-3.8-20.5-1.3-27.5 6.2l-98.2 125.5-83-161.1C273 13.2 264.9 8.5 256 8.5s-17.1 4.7-21.5 12.3l-83 161.1L53.3 56.5c-7-7.5-17.9-10-27.5-6.2C16.3 54 10 63.2 10 73.5v333c0 35.8 29.2 65 65 65h362c35.8 0 65-29.2 65-65v-333c0-10.3-6.3-19.5-15.8-23.3">
                        </path>
                    </svg>
                </div>
            <?php endif; ?>
            <?php if($relatedVideo->duration): ?>
                <span class="video-item__duration"><?php echo e($relatedVideo->duration); ?></span>
            <?php endif; ?>
        </a>
        <div class="video-item__content">
            <h6 class="title">
                <a href="<?php echo e(route('video.play', [$relatedVideo->id, $relatedVideo->slug])); ?>"><?php echo e(__($relatedVideo->title)); ?></a>
            </h6>
            <a href="<?php echo e(route('preview.channel', $relatedVideo->user->slug)); ?>" class="channel"><?php echo e(__($relatedVideo->user->channel_name)); ?></a>
            <div class="meta">
                <span class="view"><?php echo e(formatNumber($relatedVideo->views)); ?> <?php echo app('translator')->get('views'); ?></span>
                <span class="date"><?php echo e($relatedVideo->created_at->diffForHumans()); ?></span>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .releted-pre-icon {
            top: 5px;
            left: 5px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/video/related_video.blade.php ENDPATH**/ ?>