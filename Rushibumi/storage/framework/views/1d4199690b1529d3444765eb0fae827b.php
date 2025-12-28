<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="card-title"><?php echo e(__($pageTitle)); ?></h5>
            </div>
            <div class="card-body">
                <div class="row gy-5">
                    <div class="col-md-6">
                        <div class="form-group form-group rounded-3 overflow-hidden">
                            <video class="video-player" data-poster="<?php echo e(getImage(getFilePath('thumbnail') . '/' . $video->thumb_image)); ?>" controls>
                                <?php $__currentLoopData = $video->videoFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <source src="<?php echo e(getVideo($file->file_name, $video)); ?>" type="video/mp4" size="<?php echo e($file->quality); ?>" />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </video>
                        </div>

                        <div class="text-end">
                            <button class="btn btn--base btn--sm w-100 addDuration"><i
                                   class="las la-plus"></i><?php echo app('translator')->get('Add Ad play Duration'); ?></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="<?php echo e(route('user.ad.play.duration', $video->slug)); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="form-group duration-wrapper">
                                <label class="form--label"><?php echo app('translator')->get('Ad Play Duration'); ?></label>
                                <?php
                                    $playDurations = old('play_durations', $video->adPlayDurations ?? []);
                                    $countPlaydurations = count($playDurations);

                                ?>

                                <?php $__currentLoopData = $playDurations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $duration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group input-group durationField">
                                        <input class="form--control form-control" name="play_durations[]" type="text" value="<?php echo e(is_object($duration) ? $duration->play_duration : $duration); ?>" readonly required>
                                        <span class="input-group-text"><i class="las la-clock"></i></span>

                                        <button class="btn btn--danger btn--sm removeDuration" type="button">
                                            <i class="las la-times"></i>
                                        </button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                            <div class="form-group submitBtn <?php if(blank($playDurations)): ?> d-none <?php endif; ?>">
                                <button class="btn btn--base"><?php echo app('translator')->get('Submit'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

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
                    'play-large',
                    'play',
                    'progress',
                    'current-time',
                    'duration',
                    'setting'
                ];

                const player = new Plyr('.video-player', {
                    controls,
                    ratio: '16:9',

                });

                var adTimesSet = [];
                var adsSetForInterval;
                var playDurations = "<?php echo e($countPlaydurations); ?>"; 
                var adminInterval = parseInt("<?php echo e(gs('ad_config')->per_minute); ?>");
                var adsPerInterval = parseInt("<?php echo e(gs('ad_config')->ad_views); ?>");

                $(document).ready(function() {
                
                    var duration = <?php echo json_encode($playDurations, 15, 512) ?>
                
                

                    var existingAdDurations = duration || '[]';
                    

                    $.each(existingAdDurations, function (indexInArray, adTime) { 
                         
                        var minutes = Math.floor(adTime.play_duration / 60);
                        var intervalBlock = Math.floor(minutes / adminInterval);
                        
                        adTimesSet.push({
                            intervalBlock: intervalBlock,
                            time: adTime.play_duration
                        });
                    });
                    if (existingAdDurations.length > 0) {
                        $('.submitBtn').removeClass('d-none');
                    }

                
                    
                });

                
                $('.addDuration').on('click', function() {
                
                    var currentTime = player.currentTime;
                    var minutes = Math.floor(currentTime / 60);
                    var intervalBlock = Math.floor(minutes / adminInterval);

                
                    adsSetForInterval = adTimesSet.filter(time => time.intervalBlock === intervalBlock).length;

                    if (adsSetForInterval < adsPerInterval) {
                        var seconds = (currentTime % 60).toFixed(0);
                        var formattedTime = `${minutes}.${seconds.padStart(2, '0')}`;

                    
                        $('.duration-wrapper').append(`
            <div class="form-group input-group durationField">
                <input type="text" name="play_durations[]" class="form--control form-control" value="${formattedTime}" readonly required>
                <span class="input-group-text"><i class="las la-clock"></i></span>
                <button class="btn btn--danger btn--sm removeDuration"><i class="las la-times"></i></button>
            </div>
        `);
                        $('.submitBtn').removeClass('d-none');
                        adTimesSet.push({
                            intervalBlock: intervalBlock,
                            time: formattedTime
                        });
                    } else {
                        notify('error','Maximum number of ads for this interval has already been added.');
                    }
                });

            
                $(document).on('click', '.removeDuration', function() {
                    var inputValue = $(this).siblings('input').val();
                    adTimesSet = adTimesSet.filter(adTime => adTime.time !== inputValue);
                    $(this).parent().remove();
                });

            });


        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
<style>
    /* Red & Black Theme Styling */
    .dashboard-content {
        background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #000000 100%);
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        padding: 20px;
    }

    /* Animated Background Effects */
    .dashboard-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(220, 20, 60, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(139, 0, 0, 0.2) 0%, transparent 50%),
            radial-gradient(circle at 40% 20%, rgba(178, 34, 34, 0.1) 0%, transparent 50%);
        animation: pulse-glow 8s ease-in-out infinite;
        z-index: 0;
    }

    @keyframes pulse-glow {
        0%, 100% {
            opacity: 0.5;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }

    /* Floating Particles */
    .dashboard-content::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-image: 
            radial-gradient(2px 2px at 20% 30%, rgba(220, 20, 60, 0.3), transparent),
            radial-gradient(2px 2px at 60% 70%, rgba(139, 0, 0, 0.3), transparent),
            radial-gradient(1px 1px at 50% 50%, rgba(255, 0, 0, 0.2), transparent),
            radial-gradient(1px 1px at 80% 10%, rgba(220, 20, 60, 0.2), transparent),
            radial-gradient(2px 2px at 40% 80%, rgba(139, 0, 0, 0.3), transparent);
        background-size: 200% 200%;
        animation: particle-move 20s linear infinite;
        z-index: 0;
    }

    @keyframes particle-move {
        0% {
            background-position: 0% 0%;
        }
        100% {
            background-position: 100% 100%;
        }
    }

    .dashboard-content > * {
        position: relative;
        z-index: 1;
    }

    /* Card Styling */
    .custom--card {
        background: rgba(0, 0, 0, 0.85) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(220, 20, 60, 0.1),
            inset 0 0 60px rgba(220, 20, 60, 0.05) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        animation: slideInUp 0.6s ease-out;
        position: relative;
        overflow: hidden;
    }

    .custom--card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(220, 20, 60, 0.1) 0%, transparent 70%);
        animation: rotate-glow 10s linear infinite;
        pointer-events: none;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes rotate-glow {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .card-title {
        background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        text-shadow: 0 0 30px rgba(220, 20, 60, 0.5);
        animation: text-shimmer 3s ease-in-out infinite;
    }

    @keyframes text-shimmer {
        0%, 100% {
            filter: brightness(1);
        }
        50% {
            filter: brightness(1.3);
        }
    }

    .card-header {
        background: rgba(0, 0, 0, 0.6) !important;
        border-bottom: 2px solid rgba(220, 20, 60, 0.3) !important;
    }

    .card-body {
        background: transparent !important;
    }

    /* Enhanced Input Fields */
    .form--control {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        padding: 12px 16px !important;
        transition: all 0.3s ease !important;
    }

    .form--control:focus {
        background: rgba(0, 0, 0, 0.8) !important;
        border-color: #dc143c !important;
        box-shadow: 
            0 0 0 3px rgba(220, 20, 60, 0.2),
            0 0 20px rgba(220, 20, 60, 0.3) !important;
        outline: none !important;
    }

    .form--control::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .form--label {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        margin-bottom: 8px;
    }

    /* Input Group */
    .input-group-text {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        border-left: none !important;
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .durationField .form--control {
        border-right: none !important;
    }

    /* Enhanced Button */
    .btn--base {
        background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 14px 24px !important;
        border-radius: 8px !important;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 15px rgba(220, 20, 60, 0.4) !important;
    }

    .btn--base::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn--base:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn--base:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(220, 20, 60, 0.6) !important;
        background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
    }

    .btn--base:active {
        transform: translateY(0);
    }

    .btn--danger {
        background: linear-gradient(135deg, #8b0000 0%, #dc143c 100%) !important;
        border: none !important;
        color: #ffffff !important;
    }

    .btn--danger:hover {
        background: linear-gradient(135deg, #dc143c 0%, #ff1744 100%) !important;
    }

    /* Video Player */
    .video-player {
        border-radius: 8px;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/ads/setting.blade.php ENDPATH**/ ?>