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

        <div class="row gy-3 playlists-wrapper">
            <?php if($playlists->count() > 0): ?>
                <div class="playlist-card-wrapper mt-5">
                    <?php echo $__env->make($activeTemplate . 'partials.playlist_list', ['playlists' => $playlists], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <div class="text-center d-none spinner mt-4 w-100" id="loading-spinner">
                    <i class="las la-spinner"></i>
                </div>
            <?php else: ?>
                <div class="empty-container">
                    <?php echo $__env->make('Template::partials.empty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            <?php endif; ?>

        </div>
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
    </style>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            'use strict';

            // for playlists
            let currentPage = "<?php echo e($playlists->currentPage()); ?>";
            currentPage = parseInt(currentPage) + 1;
            let lastPage = false;




            $(window).scroll(function() {

                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 0 && !lastPage) {
                    currentPage++;
                    loadPlaylist();
                }
            });

            function loadPlaylist() {
                const route = "<?php echo e(route('user.playlist.load')); ?>";
                $('#loading-spinner').removeClass('d-none');
                $.ajax({
                    url: `${route}?page=${currentPage}`,
                    type: 'GET',
                    success: function(response) {

                        if (response.status === 'success') {
                            $('#loading-spinner').addClass('d-none');
                            $('.playlist-card-wrapper').append(response.data.playlists);
                            if (currentPage >= response.data.last_page) {
                                lastPage = true;
                            }
                        }
                    }
                });
            }

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/playlists.blade.php ENDPATH**/ ?>