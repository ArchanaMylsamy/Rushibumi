<div class="home-body channel-body <?php if(!blank($videos)): ?> home-body__shorts <?php else: ?> empty-body__shorts <?php endif; ?>">
    <?php if(!blank($videos)): ?>
        <?php echo $__env->make($activeTemplate . 'partials.video.shorts_list', ['shortVideos' => $videos], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <div class="empty-container">
            <?php echo $__env->make('Template::partials.empty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    <?php endif; ?>
</div>
<div class="text-center d-none spinner mt-4" id="loading-spinner">
    <i class="las la-spinner"></i>
</div>
<!-- Spinner for loading more comments -->



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

        .empty-body__shorts {
            display: grid;
            grid-template-columns: unset;

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


            const controls = [

            ];


            $(document).ready(function() {
                shortPlayers();
              

            });


            function shortPlayers() {
                Plyr.setup('.shorts-video-player', {
                    controls,
                    ratio: '9:16',
                    muted: true,
                });

            }

            // for comment 
            let currentPage = "<?php echo e($videos->currentPage()); ?>";
            let lastPage = false;


            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 5 && !lastPage) {
                    currentPage++;
                    loadMoreVideos();

                }
            });


            function loadMoreVideos() {
                const route = "<?php echo e(route('load.shorts.video', $user->id)); ?>";

                $('#loading-spinner').removeClass('d-none');

                $.ajax({
                    url: `${route}?page=${currentPage}`,
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
                $('.home-body__shorts').append(videos);
                shortPlayers();
          

            }




        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/channel/shorts.blade.php ENDPATH**/ ?>