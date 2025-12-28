<?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="video-item">
        <a data-video_id="<?php echo e($video->id); ?>"
            class="video-item__thumb    <?php if($video->showEligible() && !$video->audience): ?> autoPlay <?php endif; ?>"
            href="<?php echo e(route('video.play', [$video->id, $video->slug])); ?> <?php if(@$playlist): ?> ?list=<?php echo e(@$playlist->slug); ?>&index=<?php echo e($index + 1); ?> <?php endif; ?>">
            <?php if($video->showEligible()): ?>
                <video class="video-player" controls playsinline preload="none"
                    data-poster="<?php echo e(getImage(getFilePath('thumbnail') . '/thumb_' . $video->thumb_image)); ?>">
                </video>
                <?php echo $__env->make('Template::partials.video.video_loader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php else: ?>
                <img src="<?php echo e(getImage(getFilePath('thumbnail') . '/thumb_' . $video->thumb_image)); ?>" alt="Video Thumb" loading="lazy">
                <span class="video-item__price"><span
                        class="text"><?php echo app('translator')->get('Only'); ?></span><?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($video->price, currencyFormat: false)); ?></span>
                <div class="premium-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"
                        aria-hidden="true" class="_24ydrq0 _1286nb17o _1286nb12r6">
                        <path
                            d="M486.2 50.2c-9.6-3.8-20.5-1.3-27.5 6.2l-98.2 125.5-83-161.1C273 13.2 264.9 8.5 256 8.5s-17.1 4.7-21.5 12.3l-83 161.1L53.3 56.5c-7-7.5-17.9-10-27.5-6.2C16.3 54 10 63.2 10 73.5v333c0 35.8 29.2 65 65 65h362c35.8 0 65-29.2 65-65v-333c0-10.3-6.3-19.5-15.8-23.3">
                        </path>
                    </svg>
                </div>
            <?php endif; ?>
            <?php if($video->duration): ?>
                <span class="video-item__duration"><?php echo e($video->duration); ?></span>
            <?php endif; ?>
        </a>
        <div class="video-item__content">
            <div class="channel-info">
                <a class="video-item__channel-author" href="<?php echo e(route('preview.channel', $video->user->slug)); ?>">
                    <img class="fit-image"
                        src="<?php echo e(getImage(getFilePath('userProfile') . '/' . $video->user->image, isAvatar: true)); ?>"
                        alt="image" loading="lazy">
                </a>
                <a class="channel"
                    href="<?php echo e(route('preview.channel', $video->user->slug)); ?>"><?php echo e(__($video->user->channel_name)); ?></a>
            </div>
            <h5 class="title">
                <a
                    href="<?php echo e(route('video.play', [$video->id, $video->slug])); ?><?php if(@$playlist): ?> ?list=<?php echo e(@$playlist->slug); ?>&index=<?php echo e($index + 1); ?> <?php endif; ?> "><?php echo e(__($video->title)); ?></a>
            </h5>
            <div class="meta">
                <span class="view"><?php echo e(formatNumber($video->views)); ?> <?php echo app('translator')->get('views'); ?></span>
                <span class="date"><?php echo e($video->created_at->diffForHumans()); ?></span>
                <?php if(request()->routeIs('preview.playlist.videos') && $user->id == auth()->id()): ?>
                    <div class="playlist-card__btn">
                        <a href="javascript:void(0)"
                            data-action="<?php echo e(route('user.playlist.video.remove', ['video_id' => $video->id, 'playlist_id' => @$playlist->id])); ?>"
                            data-question="<?php echo app('translator')->get('Are you sure you want to remove this video from the playlist?'); ?>" class="btn confirmationBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-trash-2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                <line x1="10" x2="10" y1="11" y2="17" />
                                <line x1="14" x2="14" y1="11" y2="17" />
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

<?php if(!request()->routeIs('home')): ?>
    <?php $__env->startPush('script'); ?>
        <script>
            $(document).ready(function() {
                playersInitiate()
            });

            const controls = [

            ];


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
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/video/video_list.blade.php ENDPATH**/ ?>