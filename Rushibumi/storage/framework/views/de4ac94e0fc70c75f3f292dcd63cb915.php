<?php $__env->startSection('content'); ?>
    <div class="home-body">
        <div class="wh-page-header home-body__item">
            <h3 class="page-title"><?php echo e(__($pageTitle)); ?></h3>
        </div>

        <?php if(!blank($videosHistories)): ?>
            <div class="wh-search-clear">
                <button class="wh-sm-search"><i class="vti-search"></i></button>
                <form class="watch-history-search">
                    <div class="form-group">
                        <input class="form--control" name="search" type="text" value="<?php echo e(request()->search); ?>"
                            placeholder="Search watch history">

                        <button class="btn" type="submit"><i class="vti-search"></i></button>
                    </div>
                </form>
                <button class="clear-history-btn confirmationBtn" data-action="<?php echo e(route('user.remove.all.history')); ?>"
                    data-question="<?php echo app('translator')->get('Are you sure you want to remove all history'); ?>?"><i class="vti-trash"></i>
                    <span class="text"><?php echo app('translator')->get('Remove all watch history'); ?></span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(!blank($videosHistories)): ?>
            <div class="video-wrapper">
        <?php endif; ?>
        <?php $__empty_1 = true; $__currentLoopData = $videosHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $videosHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="video-item">
                <a data-video_id="<?php echo e($videosHistory->video->id); ?>"
                    class="video-item__thumb <?php if($videosHistory->video->showEligible()): ?> autoPlay <?php endif; ?>"
                    href="<?php echo e(route('video.play', [$videosHistory->video->id, $videosHistory->video->slug])); ?>">
                    <?php if($videosHistory->video->showEligible()): ?>
                        <video class="video-player" controls playsinline
                            data-poster="<?php echo e(getImage(getFilePath('thumbnail') . '/thumb_' . $videosHistory->video->thumb_image)); ?>">
                        </video>
                        <?php echo $__env->make('Template::partials.video.video_loader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php else: ?>
                        <img src="<?php echo e(getImage(getFilePath('thumbnail') . '/thumb_' . $videosHistory->video->thumb_image)); ?>"
                            alt="<?php echo app('translator')->get('video_thumb'); ?>">
                        <span class="video-item__price"><span
                                class="text"><?php echo app('translator')->get('Only'); ?></span><?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($videosHistory->video->price, currencyFormat: false)); ?></span>
                        <div class="premium-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"
                                aria-hidden="true" class="_24ydrq0 _1286nb17o _1286nb12r6">
                                <path
                                    d="M486.2 50.2c-9.6-3.8-20.5-1.3-27.5 6.2l-98.2 125.5-83-161.1C273 13.2 264.9 8.5 256 8.5s-17.1 4.7-21.5 12.3l-83 161.1L53.3 56.5c-7-7.5-17.9-10-27.5-6.2C16.3 54 10 63.2 10 73.5v333c0 35.8 29.2 65 65 65h362c35.8 0 65-29.2 65-65v-333c0-10.3-6.3-19.5-15.8-23.3">
                                </path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <?php if($videosHistory->video->duration): ?>
                        <span class="video-item__duration"><?php echo e($videosHistory->video->duration); ?></span>
                    <?php endif; ?>
                </a>
                <div class="video-item__content">
                    <div class="channel-info">
                        <a class="video-item__channel-author" href="<?php echo e(route('preview.channel', $videosHistory->video->user->slug)); ?>">
                            <img class="fit-image"
                                src="<?php echo e(getImage(getFilePath('userProfile') . '/' . $videosHistory->video->user->image, isAvatar: true)); ?>"
                                alt="image">
                        </a>
                        <a class="channel"
                            href="<?php echo e(route('preview.channel', $videosHistory->video->user->slug)); ?>"><?php echo e(__($videosHistory->video->user->channel_name)); ?></a>
                    </div>
                    <h5 class="title">
                        <a href="<?php echo e(route('video.play', [$videosHistory->video->id, $videosHistory->video->slug])); ?>"><?php echo e(__($videosHistory->video->title)); ?></a>
                    </h5>
                    <div class="meta">
                        <span class="view"><?php echo e(formatNumber($videosHistory->video->views)); ?> <?php echo app('translator')->get('views'); ?></span>
                        <span class="date"><?php echo e($videosHistory->video->created_at->diffForHumans()); ?></span>
                        <div class="video-wh-item__action">
                            <button class="ellipsis-list__btn confirmationBtn"
                                data-action="<?php echo e(route('user.remove.history', $videosHistory->id)); ?>"
                                data-question="<?php echo app('translator')->get('Are you sure you want to remove this history'); ?>?"
                                title="<?php echo app('translator')->get('Remove from history'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-x">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                            <button class="ellipsis-list__btn shareBtn" data-video="<?php echo e($videosHistory->video); ?>"
                                data-url="<?php echo e(route('video.play', [$videosHistory->video->id, $videosHistory->video->slug])); ?>"
                                type="button"
                                title="<?php echo app('translator')->get('Share'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-share-2">
                                    <circle cx="18" cy="5" r="3" />
                                    <circle cx="6" cy="12" r="3" />
                                    <circle cx="18" cy="19" r="3" />
                                    <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                                    <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-container">
                <?php echo $__env->make('Template::partials.empty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endif; ?>
        <?php if(!blank($videosHistories)): ?>
            </div>
        <?php endif; ?>
        <?php echo e(paginateLinks($videosHistories)); ?>

    </div>

    <?php echo $__env->make('Template::partials.share', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve(['frontend' => 'true'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ConfirmationModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <!-- Slick Slider -->
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/slick.css')); ?>" rel="stylesheet">
    <!-- Owl Carousel -->
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/owl.theme.default.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/owl.carousel.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('assets/global/css/plyr.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <!-- Owl Carousel js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/owl.carousel.filter.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/global/js/plyr.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            'use strict';

            $(document).ready(function() {

                const controls = [
                   
                ];
                const players = Plyr.setup('.video-player', {
                    controls,
                    ratio: '16:9',
                    muted: true
                });


            });

            $('.confirmationBtn').on('click', function() {
                const modal = $('#confirmationModal');
                const action = $(this).data('action');
                const question = $(this).data('question');
                modal.find('.question').text(question);
                modal.find('form').attr('action', action);
                modal.modal('show')
            });

            $('.shareBtn').on('click', function() {
                const video = $(this).data('video');
                const url = $(this).data('url');

                let shareLink = `
        <a class="share-item whatsapp" href="https://api.whatsapp.com/send?text=${encodeURIComponent(url)}" target="_blank">
            <i class="lab la-whatsapp"></i>
        </a>
        <a class="share-item facebook" href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}" target="_blank">
            <i class="lab la-facebook-f"></i>
        </a>
        <a class="share-item twitter" href="https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(video.title)}" target="_blank">
            <i class="fa-brands fa-x-twitter"></i>
        </a>
        <a class="share-item envelope" href="mailto:?subject=${encodeURIComponent(video.title)}&body=${encodeURIComponent(url)}">
            <i class="las la-envelope"></i>
        </a>
    `;

                $('#shareModal').find('.share-items').html(shareLink);
                $('.copyText').val(url);
                $('#shareModal').modal('show');
            });


        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/watch_history.blade.php ENDPATH**/ ?>