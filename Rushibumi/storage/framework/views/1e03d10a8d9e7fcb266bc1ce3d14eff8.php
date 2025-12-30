<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="card-title"><?php echo e(__($pageTitle)); ?></h5>
            </div>
            <div class="card-body">
                <?php if(!blank($shorts)): ?>
                    <div class="dashboard-video">
                        <?php $__currentLoopData = $shorts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="video-item">
                                <a class="video-item__thumb playModal shortsAutoPlay" href="<?php echo e(route('short.play', [$video->id, $video->slug])); ?>"
                                   target="__blank">
                                    <video class="shorts-video-player" controls>
                                        <source src="<?php echo e(getVideo($video->video, $video)); ?>"
                                                type="video/mp4" />
                                    </video>
                                </a>
                                <div class="video-item__manage mt-3 me-3">
                                    <a class="video-item__edit" href="<?php echo e(route('user.shorts.edit', $video->id)); ?>"><i
                                           class="las la-edit"></i></a>
                                    <a class="video-item__edit confirmationBtn" 
                                       href="javascript:void(0)"
                                       data-action="<?php echo e(route('user.shorts.delete', encrypt($video->id))); ?>"
                                       data-question="<?php echo app('translator')->get('Are you sure you want to delete this short? This action cannot be undone.'); ?>"
                                       style="color: #dc3545;"><i class="las la-trash"></i></a>
                                </div>
                                <div class="video-item__content">
                                    <h5 class="title">
                                        <a href="<?php echo e(route('video.play', [$video->id, $video->slug])); ?>"><?php echo e(__($video->title)); ?></a>
                                    </h5>
                                    <div class="meta d-flex justify-content-between ">
                                        <div>
                                            <span class="view"><?php echo e(formatNumber($video->views)); ?> <?php echo app('translator')->get('views'); ?></span>
                                            <span
                                                  class="like"><?php echo e(formatNumber($video->userReactions()->like()->count())); ?>

                                                <?php echo app('translator')->get('Likes'); ?></span>
                                        </div>
                                        <div>
                                            <?php
                                                echo $video->statusBadge;
                                            ?>
                                        </div>
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
                <?php
                    echo paginateLinks($shorts);
                ?>
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
        
        .video-item__edit i {
            font-size: 18px;
        }
        
        .dashboard-video {
            grid-template-columns: repeat(4, 1fr);
        }

        @media (max-width: 1199px) {
            .dashboard-video {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767px) {
            .dashboard-video {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 575px) {
            .dashboard-video {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/global/css/plyr.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/plyr.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            'use strict';

            $(document).ready(function() {

                const controls = [
                    'duration',
                ];
                const players = Plyr.setup('.shorts-video-player', {
                    controls,
                    ratio: '9:16',

                });

                $('.shortsAutoPlay').each(function() {
                    const player = $(this).find('.shorts-video-player')[0];

                    $(this).on('mouseenter', function() {
                        player.muted = true;
                        player.play();

                    });

                    $(this).on('mouseleave', function() {
                        player.pause();
                        player.currentTime = 0;

                    });
                });


            });




        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/shorts/list.blade.php ENDPATH**/ ?>