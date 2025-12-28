<?php $__env->startSection('content'); ?>
    <div class="home-body">
        <!-- Google AdSense - Top Banner (Full Width) -->
        <div class="adsense-top-banner">
            <div class="ad-shimmer"></div>
            <div class="ad-content">
                <span class="ad-badge">Advertisement</span>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-3940256099942544"
                     data-ad-slot="6300978111"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
            </div>
        </div>

        <?php if(!blank($shortVideos)): ?>
            <?php if (isset($component)) { $__componentOriginal88d6acc4e25c26903813785ab61d2d2b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88d6acc4e25c26903813785ab61d2d2b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-body-title','data' => ['icon' => 'vti-short','title' => 'Shorts']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-body-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'vti-short','title' => 'Shorts']); ?>
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
            <section class="shorts-section">
                <div class="row gy-4">
                    <div class="col-lg-12">
                        <div class="short_slider owl-carousel">
                            <?php echo $__env->make($activeTemplate . 'partials.video.shorts_list', [
                                'shortVideos' => $shortVideos,
                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if(!blank($videos)): ?>
            <?php if (isset($component)) { $__componentOriginal88d6acc4e25c26903813785ab61d2d2b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88d6acc4e25c26903813785ab61d2d2b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-body-title','data' => ['icon' => 'vti-video','title' => 'Videos']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-body-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'vti-video','title' => 'Videos']); ?>
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

            <div class="video-wrapper">
                <?php echo $__env->make($activeTemplate . 'partials.video.video_list', ['videos' => $videos], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <div class="text-center d-none spinner mt-4 w-100" id="loading-spinner">
                <i class="las la-spinner"></i>
            </div>
        <?php endif; ?>

        <?php if(blank($shortVideos) && blank($videos)): ?>
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

        /* Google AdSense - Top Banner Only */
        .adsense-top-banner {
            width: 100%;
            background: rgba(var(--base-rgb), 0.03);
            border: 1px solid rgba(var(--base-rgb), 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            min-height: 100px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .adsense-top-banner:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .ad-shimmer {
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.1) 50%, 
                transparent 100%
            );
            animation: shimmerMove 4s infinite;
        }

        @keyframes shimmerMove {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .ad-content {
            position: relative;
            z-index: 2;
            width: 100%;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ad-badge {
            position: absolute;
            top: -10px;
            left: 20px;
            background: hsl(var(--base));
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 3;
        }

        /* Light Theme */
        [data-theme="light"] .adsense-top-banner {
            background: rgba(0, 0, 0, 0.02);
            border-color: rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .ad-shimmer {
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(0, 0, 0, 0.05) 50%, 
                transparent 100%
            );
        }

        /* Dark Theme */
        [data-theme="dark"] .adsense-top-banner {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.08);
        }

        [data-theme="dark"] .ad-shimmer {
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.08) 50%, 
                transparent 100%
            );
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .adsense-top-banner {
                min-height: 80px;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 10px;
            }

            .ad-content {
                min-height: 50px;
            }

            .ad-badge {
                font-size: 9px;
                padding: 5px 12px;
                letter-spacing: 1.2px;
            }
        }

        @media (max-width: 480px) {
            .adsense-top-banner {
                min-height: 60px;
                padding: 12px;
                border-radius: 8px;
            }

            .ad-badge {
                font-size: 8px;
                padding: 4px 10px;
                letter-spacing: 1px;
                left: 15px;
            }
        }

        /* AdSense Container */
        .adsbygoogle {
            width: 100%;
            display: block !important;
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
        'use strict';

        const controls = [];

        $(document).ready(function() {
            playersInitiate();
            
            // Initialize Google AdSense Ad
            setTimeout(function() {
                try {
                    (adsbygoogle = window.adsbygoogle || []).push({});
                } catch (e) {
                    console.log('AdSense initialization:', e);
                }
            }, 100);
        });

        function playersInitiate() {
            // Initialize players for visible videos using Intersection Observer
            const videoPlayers = document.querySelectorAll('.video-player:not([data-plyr-initialized])');
            
            if (videoPlayers.length === 0) return;
            
            // First, initialize videos that are already visible
            videoPlayers.forEach(videoEl => {
                const rect = videoEl.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight + 100 && rect.bottom > -100;
                
                if (isVisible && !videoEl.hasAttribute('data-plyr-initialized')) {
                    try {
                        const player = new Plyr(videoEl, {
                            controls,
                            ratio: '16:9',
                            muted: true,
                        });
                        videoEl.setAttribute('data-plyr-initialized', 'true');
                    } catch (e) {
                        console.warn('Plyr initialization error:', e);
                    }
                }
            });
            
            // Then set up observer for videos not yet visible
            const remainingVideos = document.querySelectorAll('.video-player:not([data-plyr-initialized])');
            if (remainingVideos.length === 0) return;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.hasAttribute('data-plyr-initialized')) {
                        try {
                            const player = new Plyr(entry.target, {
                                controls,
                                ratio: '16:9',
                                muted: true,
                            });
                            entry.target.setAttribute('data-plyr-initialized', 'true');
                            observer.unobserve(entry.target);
                        } catch (e) {
                            console.warn('Plyr initialization error:', e);
                        }
                    }
                });
            }, {
                rootMargin: '100px' // Start loading 100px before video enters viewport
            });
            
            remainingVideos.forEach(player => {
                observer.observe(player);
            });
        }

        $(document).ready(function() {
            const shortPlayers = Plyr.setup('.shorts-video-player', {
                controls,
                ratio: '9:16',
                muted: true,
            });
        });

        let currentPage = "<?php echo e($videos->currentPage()); ?>";
        let url = "<?php echo e(route('video.get')); ?>";

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 5 && !lastPage) {
                currentPage++;
                loadMoreVideos(url, currentPage);
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/home.blade.php ENDPATH**/ ?>