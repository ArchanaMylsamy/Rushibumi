<?php $__currentLoopData = $shortVideos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="short-item">
        <a href="<?php echo e(route('preview.channel', $video->user->slug)); ?>" class="short-item__channel">
            <img class="fit-image" src="<?php echo e(getImage(getFilePath('userProfile') . '/' . @$video->user?->image)); ?>"
                 alt="Short Author">
        </a>
        <a href="<?php echo e(route('short.play', [$video->id, $video->slug])); ?>"  class="short-item__thumb shortsAutoPlay">
            <video class="shorts-video-player" controls playsinline >
                <source src=" <?php echo e(route('short.path', encrypt($video->id))); ?>" type="video/mp4" />
            </video>
           <?php echo $__env->make('Template::partials.video.video_loader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </a>
        <div class="short-item__content">
            <h5 class="short-item__title">
                <a href="<?php echo e(route('short.play', [$video->id, $video->slug])); ?>"><?php echo e(__($video->title)); ?></a>
            </h5>
        </div>
        <span class="short-item__view"><?php echo e(formatNumber($video->views)); ?> <?php echo app('translator')->get('views'); ?></span>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/video/shorts_list.blade.php ENDPATH**/ ?>