<!-- Header -->
<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(gs()->siteName(__($pageTitle))); ?></title>
    <?php echo $__env->make('partials.seo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <link href="<?php echo e(siteFavIcon()); ?>" rel="shortcut icon">
    <link href="<?php echo e(asset('assets/global/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/global/css/all.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/global/css/line-awesome.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset($activeTemplateTrue . 'css/owl.theme.default.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/owl.carousel.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/vt-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/main.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/custom.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldPushContent('style-lib'); ?>

    <link
        href="<?php echo e(asset($activeTemplateTrue . 'css/color.php')); ?>?color=<?php echo e(gs('base_color')); ?>&secondColor=<?php echo e(gs('secondary_color')); ?>"
        rel="stylesheet">
    <?php echo $__env->yieldPushContent('style'); ?>

    <style>
        body {
            display: none;
        }

        [data-theme="light"] {
            background-color: hsl(var(--white));
        }

        [data-theme="dark"] {
            background-color: hsl(var(--black));
        }
    </style>
    
    <!-- Preconnect to improve resource loading -->
    <link rel="preconnect" href="<?php echo e(url('/')); ?>">
    <link rel="dns-prefetch" href="<?php echo e(url('/')); ?>">

</head>
<?php echo loadExtension('google-analytics') ?>

<body>
    <?php echo $__env->yieldPushContent('fbComment'); ?>

    <div class="preloader">
        <span class="loader"></span>
        <div class="loading loading06">
            <?php $__currentLoopData = str_split(gs('site_name')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $char): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span data-text="<?php echo e($char); ?>"><?php echo e($char); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="body-overlay"></div>
    <div class="sidebar-overlay"></div>
    <a class="scroll-top"><i class="fas fa-arrow-up"></i></a>

    <?php echo $__env->yieldContent('app'); ?>

    <?php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    ?>

    <?php if($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie')): ?>
        <div class="cookies-card hide">
            <div class="cookies-card__icon">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="cookies-card__content"><?php echo e($cookie->data_values->short_desc); ?> <a class="text--base"
                    href="<?php echo e(route('cookie.policy')); ?>" target="_blank"><?php echo app('translator')->get('learn more'); ?></a></p>
            <div class="cookies-card__btn mt-3 d-flex gap-2">
                <a class="btn btn--base btn--sm policy" href="javascript:void(0)"><?php echo app('translator')->get('Allow'); ?></a>
                <a class="btn btn--white outline btn--sm policy" href="javascript:void(0)"><?php echo app('translator')->get('Cookie Reject'); ?></a>
            </div>
        </div>
    <?php endif; ?>

    <script src="<?php echo e(asset('assets/global/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/bootstrap.bundle.min.js')); ?>"></script>

    <script src="<?php echo e(asset($activeTemplateTrue . 'js/owl.carousel.min.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('script-lib'); ?>

    <?php echo loadExtension('tawk-chat') ?>
    <?php echo $__env->make('partials.notify', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php if(gs('pn')): ?>
        <?php echo $__env->make('partials.push_script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/main.js')); ?>"></script>

    <script>
        let lastPage = false;
        function loadMoreVideos(url, currentPage, categoryId=0) {

                $('#loading-spinner').removeClass('d-none');
                $.ajax({
                    url: `${url}?page=${currentPage}&category_id=${categoryId}`,
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#loading-spinner').addClass('d-none');
                            appendVideos(response.data.videos);
                            if (currentPage >= response.data.last_page) {
                                lastPage = true;
                            }
                        } else {
                            notify('error', response.message.error);
                        }
                    }
                });
            }

            function appendVideos(videos) {
                $('.video-wrapper').append(videos);
                // Call global playersInitiate if it exists, otherwise initialize directly
                if (typeof playersInitiate === 'function') {
                    playersInitiate();
                } else {
                    // Fallback initialization
                    initializeVideoPlayers();
                }
            }

            // Global function to initialize video players
            function initializeVideoPlayers() {
                const videoPlayers = document.querySelectorAll('.video-player:not([data-plyr-initialized])');
                
                if (videoPlayers.length === 0) return;
                
                // First, initialize videos that are already visible
                videoPlayers.forEach(videoEl => {
                    const rect = videoEl.getBoundingClientRect();
                    const isVisible = rect.top < window.innerHeight + 100 && rect.bottom > -100;
                    
                    if (isVisible && !videoEl.hasAttribute('data-plyr-initialized')) {
                        try {
                            const player = new Plyr(videoEl, {
                                controls: [],
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
                                    controls: [],
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
                    rootMargin: '100px'
                });
                
                remainingVideos.forEach(player => {
                    observer.observe(player);
                });
            }

            // Make it globally available
            window.playersInitiate = initializeVideoPlayers;

    </script>


    <?php echo $__env->yieldPushContent('script'); ?>

    <script>
        (function($) {
            "use strict";

            $('.policy').on('click', function() {
                $.get('<?php echo e(route('cookie.accept')); ?>',
                    function(response) {
                        $('.cookies-card').addClass('d-none');
                    });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }
            });


            function formatState(state) {
                if (!state.id) return state.text;
                let gatewayData = $(state.element).data();
                return $(
                    `<div class="d-flex gap-2">${gatewayData.imageSrc ? `<div class="select2-image-wrapper"><img class="select2-image" src="${gatewayData.imageSrc}"></div>` : '' }<div class="select2-content"> <p class="select2-title">${gatewayData.title}</p><p class="select2-subtitle">${gatewayData.subtitle}</p></div></div>`
                );
            }

            $('.select2').each(function(index, element) {
                $(element).select2();
            });


            $('.select2-basic').each(function(index, element) {
                $(element).select2({
                    dropdownParent: $(element).closest('.select2-parent')
                });

            });

            $('.select2-auto-tokenize').each(function(index, element) {
                $(element).select2({
                    tags: true,
                    tokenSeparators: [','],
                });
            });

            if ("<?php echo e(!request()->routeIs('user.advertiser.create.ad')); ?>") {

                Array.from(document.querySelectorAll('table')).forEach(table => {
                    let heading = table.querySelectorAll('thead tr th');
                    Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                        Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                            colum.setAttribute('data-label', heading[i].innerText)
                        });
                    });
                });
            }


            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });


            var isScrolling = false;

            $(window).on('scroll', function() {
                isScrolling = true;
                clearTimeout($.data(this, 'scrollTimer'));
                $.data(this, 'scrollTimer', setTimeout(() => {
                    isScrolling = false;
                }, 200));
            });






            // for video - Optimized with caching and debounce

            let loader;
            let player;
            let mouseleaveClass;
            let videoSourceCache = {}; // Cache video sources to avoid repeated AJAX calls
            let hoverTimeout = null;

            // Debounce function
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            $(document).on('mouseenter', '.autoPlay', function() {
                if (!isScrolling) {
                    const parent = $(this);
                    loader = parent.find('.video-loader');
                    const videoElement = parent.find('.video-player')[0];
                    const id = parent.data('video_id');

                    if (!videoElement) return;

                    // Clear any existing timeout
                    if (hoverTimeout) {
                        clearTimeout(hoverTimeout);
                    }

                    // Ensure Plyr is initialized for this video
                    if (!videoElement.hasAttribute('data-plyr-initialized')) {
                        try {
                            const plyrPlayer = new Plyr(videoElement, {
                                controls: [],
                                ratio: '16:9',
                                muted: true,
                            });
                            videoElement.setAttribute('data-plyr-initialized', 'true');
                        } catch (e) {
                            console.warn('Plyr initialization error on hover:', e);
                        }
                    }

                    // Debounce the video loading
                    hoverTimeout = setTimeout(function() {
                        // Check cache first
                        if (videoSourceCache[id]) {
                            loader.hide();
                            const src = `<source src="${videoSourceCache[id].path}" type="video/mp4" size="${videoSourceCache[id].quality}" />`;
                            parent.find('.video-player').empty().append(src);
                            videoElement.load();
                            videoElement.muted = true;
                            videoElement.play().catch(function(error) {
                                console.warn('Autoplay failed:', error);
                            });
                            return;
                        }

                        loader.show();

                        $.ajax({
                            type: "GET",
                            url: `<?php echo e(route('get.video.source', '')); ?>/${id}`,
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Cache the response
                                    videoSourceCache[id] = {
                                        path: response.path,
                                        quality: response.quality
                                    };
                                    
                                    loader.hide();
                                    const src = `<source src="${response?.path}" type="video/mp4" size="${response?.quality}" />`;
                                    parent.find('.video-player').empty().append(src);
                                    videoElement.load();
                                    videoElement.muted = true;
                                    videoElement.play().catch(function(error) {
                                        console.warn('Autoplay failed:', error);
                                    });
                                } else {
                                    loader.hide();
                                }
                            },
                            error: function(error) {
                                loader.hide();
                                console.warn('Video source loading error:', error);
                            }
                        });
                    }, 200); // 200ms debounce delay
                }
            });

            $(document).on('mouseleave', '.autoPlay', function() {
                // Clear timeout if user leaves before video loads
                if (hoverTimeout) {
                    clearTimeout(hoverTimeout);
                    hoverTimeout = null;
                }
                
                const videoElement = $(this).find('.video-player')[0];
                if (videoElement) {
                    videoElement.pause();
                    videoElement.currentTime = 0;
                    $(this).find('.video-player').empty();
                }
                if (loader) loader.hide();
            });




            // for short auto pllay
            let shortPlayer;

            $(document).on('mouseenter', '.shortsAutoPlay', function() {
                shortPlayer = $(this).find('.shorts-video-player')[0];
                shortPlayer.load();
                shortPlayer.play();
            });


            $(document).on('mouseleave', '.shortsAutoPlay', function() {
                const shortPlayer = $(this).find('.shorts-video-player')[0];
                shortPlayer.load();
                shortPlayer.pause();
                shortPlayer.currentTime = 0;
            });






        })(jQuery);
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/layouts/app.blade.php ENDPATH**/ ?>