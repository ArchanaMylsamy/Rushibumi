<?php $__env->startSection('content'); ?>
    <div class="home-body">
        <?php if (isset($component)) { $__componentOriginal88d6acc4e25c26903813785ab61d2d2b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88d6acc4e25c26903813785ab61d2d2b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-body-title','data' => ['icon' => 'vti-top','title' => ''.e($pageTitle).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-body-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'vti-top','title' => ''.e($pageTitle).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88d6acc4e25c26903813785ab61d2d2b)): ?>
<?php $attributes = $__attributesOriginal88d6acc4e25c26903813785ab61d2d2b; ?>
<?php unset($__attributesOriginal88d6acc4e25c26903813785ab61d2d2b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88d6acc4e25c26903813785ab61d2d2b)): ?>
<?php $component = $__componentOriginal88d6acc4e25c26903813785ab61d2d2b; ?>
<?php unset($__componentOriginal88d6acc4e25c26903813785ab61d2d2b); ?>
<?php endif; ?>

        <?php if(!blank($videos)): ?>
            <div class="video-wrapper">
                <?php echo $__env->make($activeTemplate . 'partials.video.video_list', ['videos' => $videos], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php else: ?>
            <div class="empty-container">
                <?php echo $__env->make('Template::partials.empty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('style'); ?>
    <style>
        .spinner {
            text-align: center;
            margin-top: 20px;
            width: 100%;
        }

        .spinner i {
            font-size: 45px;
            color: #ff0000;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
<?php $__env->stopPush(); ?>



<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/plyr.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/plyr.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            'use strict';

            let currentPage = "<?php echo e($videos->currentPage()); ?>";
            const catrgorId = "<?php echo e($category->id); ?>"

            let url = "<?php echo e(route('video.get')); ?>";
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 5 && !lastPage) {
                    currentPage++;
                    loadMoreVideos(url, currentPage,catrgorId);
                }
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/category_videos.blade.php ENDPATH**/ ?>