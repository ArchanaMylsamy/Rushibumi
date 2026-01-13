<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">
        <div class="card custom--card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><?php echo e(__($pageTitle)); ?></h3>
                <a href="<?php echo e(route('user.live.go.live')); ?>" class="btn btn--base btn-sm">
                    <i class="las la-video"></i> <?php echo app('translator')->get('Go Live'); ?>
                </a>
            </div>
            <div class="card-body">
                <?php if($liveStreams->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Title'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Viewers'); ?></th>
                                    <th><?php echo app('translator')->get('Started'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $liveStreams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stream): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if($stream->recorded_video && $stream->status != 'live'): ?>
                                                    <div class="stream-thumbnail-wrapper">
                                                        <a href="<?php echo e(route('live.watch', [$stream->id, $stream->slug])); ?>" 
                                                           class="stream-thumbnail-link" 
                                                           title="<?php echo app('translator')->get('Play recorded video'); ?>">
                                                            <div class="stream-thumbnail">
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
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <strong><?php echo e(Str::limit($stream->title, 40)); ?></strong>
                                                    <?php if($stream->recorded_video && $stream->status != 'live'): ?>
                                                        <div class="stream-type-badge">
                                                            <i class="las la-video"></i> <?php echo app('translator')->get('Webcam'); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($stream->status == 'live'): ?>
                                                <span class="badge badge--success">
                                                    <span class="live-dot-inline"></span> <?php echo app('translator')->get('LIVE'); ?>
                                                </span>
                                            <?php elseif($stream->status == 'scheduled'): ?>
                                                <span class="badge badge--warning"><?php echo app('translator')->get('Scheduled'); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge--danger"><?php echo app('translator')->get('Ended'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(formatNumber($stream->viewers_count)); ?></td>
                                        <td><?php echo e($stream->started_at ? showDateTime($stream->started_at, 'd M Y h:i A') : '-'); ?></td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?php echo e(route('live.watch', [$stream->id, $stream->slug])); ?>" 
                                                   class="btn btn--info btn-sm action-btn" title="<?php echo app('translator')->get('Watch Stream'); ?>">
                                                    <i class="las la-eye"></i>
                                                </a>
                                                <?php if($stream->status != 'live'): ?>
                                                    <a href="javascript:void(0)" 
                                                       class="btn btn--info btn-sm action-btn confirmationBtn" 
                                                       data-action="<?php echo e(route('user.live.delete', $stream->id)); ?>"
                                                       data-question="<?php echo app('translator')->get('Are you sure you want to delete this stream? This action cannot be undone.'); ?>"
                                                       title="<?php echo app('translator')->get('Delete Stream'); ?>">
                                                        <i class="las la-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <?php echo e(paginateLinks($liveStreams)); ?>

                    </div>
                <?php else: ?>
                    <div class="empty-state text-center py-5">
                        <i class="las la-video" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                        <h4><?php echo app('translator')->get('No Live Streams'); ?></h4>
                        <p class="text-muted"><?php echo app('translator')->get('You haven\'t created any live streams yet.'); ?></p>
                        <a href="<?php echo e(route('user.live.go.live')); ?>" class="btn btn--base mt-3">
                            <i class="las la-video"></i> <?php echo app('translator')->get('Go Live Now'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <style>
        .live-dot-inline {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            margin-right: 4px;
            animation: pulse 2s infinite;
        }
        .action-btn {
            color: #007bff !important;
            background: transparent !important;
            border: 1px solid #007bff;
            min-width: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .action-btn:hover {
            background: #007bff !important;
            color: #fff !important;
        }
        .action-btn i {
            color: inherit;
            font-size: 16px;
        }
        
        /* Stream Thumbnail Styles */
        .stream-thumbnail-wrapper {
            width: 120px;
            height: 68px;
            flex-shrink: 0;
        }
        
        .stream-thumbnail-link {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .stream-thumbnail {
            width: 100%;
            height: 100%;
            position: relative;
            background: #000;
            cursor: pointer;
        }
        
        .thumbnail-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
        
        .stream-thumbnail:hover .play-overlay {
            opacity: 1;
        }
        
        .play-overlay i {
            font-size: 32px;
            color: #fff;
            background: rgba(0, 0, 0, 0.7);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .video-duration-badge {
            position: absolute;
            bottom: 4px;
            right: 4px;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 2px 6px;
            border-radius: 2px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .stream-type-badge {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
        
        .stream-type-badge i {
            margin-right: 4px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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


<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/live/manage.blade.php ENDPATH**/ ?>