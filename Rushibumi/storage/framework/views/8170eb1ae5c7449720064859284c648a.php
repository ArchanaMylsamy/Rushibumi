<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">
        <div class="card custom--card">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__($pageTitle)); ?></h3>
            </div>
            <div class="card-body">
                <?php if(!blank($videos)): ?>
                    <div class="dashboard-video">
                        <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="video-item">
                                <a data-video_id="<?php echo e($video->id); ?>" class="video-item__thumb  autoPlay"
                                    href="<?php echo e(route('video.play', [$video->id, $video->slug])); ?>" target="__blank">
                                    <video class="video-player"  controls
                                        <?php if($video->thumb_image): ?> data-poster="<?php echo e(getImage(getFilePath('thumbnail') . '/' . $video->thumb_image)); ?>" <?php endif; ?>>

                                    </video>
                                    <?php echo $__env->make('Template::partials.video.video_loader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </a>
                                <div class="video-item__content">
                                    <div class="d-flex justify-content-between gap-3 mb-3">
                                        <p class="video-status-badge">
                                            <?php
                                                echo $video->statusBadge;
                                            ?>
                                        </p>
                                        <div class="video-item__manage">
                                            <a class="video-item__edit"
                                                href="<?php echo e(route('user.video.edit', encrypt(@$video->id))); ?>"><i
                                                    class="las la-edit"></i></a>

                                            <a class="video-item__edit <?php if($video->status != Status::PUBLISHED): ?> disabled-link <?php endif; ?>  "
                                                href="<?php echo e(route('user.ad.setting', @$video->slug)); ?>"><i
                                                    class="las la-ad"></i></a>
                                            <a class="video-item__edit <?php if($video->status != Status::PUBLISHED): ?> disabled-link <?php endif; ?>  "
                                                href="<?php echo e(route('user.video.analytics', @$video->slug)); ?>"><i
                                                    class="las la-chart-pie"></i></a>
                                            
                                            <a class="video-item__edit confirmationBtn" 
                                                href="javascript:void(0)"
                                                data-action="<?php echo e(route('user.video.delete', encrypt($video->id))); ?>"
                                                data-question="<?php echo app('translator')->get('Are you sure you want to delete this video? This action cannot be undone.'); ?>"
                                                style="color: #dc3545;"><i class="las la-trash"></i></a>

                                        </div>

                                    </div>


                                    <h5 class="title">
                                        <a
                                            href="<?php echo e(route('video.play', [$video->id, $video->slug])); ?>"><?php echo e(__($video->title)); ?></a>
                                    </h5>

                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div class="meta">
                                            <span class="view"><?php echo e(formatNumber($video->views)); ?> <?php echo app('translator')->get('views'); ?></span>
                                            <span
                                                class="like"><?php echo e(formatNumber($video->userReactions()->like()->count())); ?>

                                                <?php echo app('translator')->get('Likes'); ?></span>
                                        </div>
                                        <span class="fs-12 fw-bold">
                                            <?php
                                                echo $video->visibilityStatus;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="row py-60">
                        <div class="empty-container empty-card-two">
                            <?php echo $__env->make('Template::partials.empty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($videos->hasPages()): ?>
                    <?php echo e(paginateLinks($videos)); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
    
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


<?php $__env->startPush('style'); ?>
    <style>
        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            color: #6c757d;
            /* Bootstrap's disabled color */
            text-decoration: none;
            /* Remove underline if needed */
        }
        
        .video-item__manage {
            display: flex !important;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .video-item__edit.confirmationBtn {
            color: #dc3545 !important;
            opacity: 1 !important;
            visibility: visible !important;
            display: grid !important;
            place-content: center !important;
            border-color: rgba(220, 53, 69, 0.3) !important;
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
        
        .video-item__edit.confirmationBtn:hover {
            background-color: rgba(220, 53, 69, 0.2) !important;
            border-color: #dc3545 !important;
        }
        
        .video-item__edit.confirmationBtn i {
            color: #dc3545 !important;
            font-size: 18px !important;
        }
        
        .video-item__edit.confirmationBtn:hover i {
            color: #c82333 !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/global/css/plyr.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/plyr.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/templates/basic/js/video-quality.js')); ?>"></script>
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

                });




            });


        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/video/list.blade.php ENDPATH**/ ?>