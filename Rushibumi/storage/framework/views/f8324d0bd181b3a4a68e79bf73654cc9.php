<?php $__env->startSection('content'); ?>
    <div class="channel-body">
        <div class="channel-cover">
            <img src="<?php echo e(getImage(getFilePath('cover') . '/' . $user->cover_image)); ?>" alt="Channel Cover Photo">
            <div class="social">

                <?php if(@$user->social_links?->facebook): ?>
                    <a class="social__link" href="<?php echo e(@$user->social_links?->facebook); ?>" target="__blank"><i
                           class="vti-facebook"></i></a>
                <?php endif; ?>
                <?php if(@$user->social_links?->twitter): ?>
                    <a class="social__link" href="<?php echo e(@$user->social_links?->twitter); ?>" target="__blank"><i
                           class="vti-twitter"></i></a>
                <?php endif; ?>
                <?php if(@$user->social_links?->instragram): ?>
                    <a class="social__link" href="<?php echo e(@$user->social_links?->instragram); ?>" target="__blank"><i
                           class="vti-instagram"></i></a>
                <?php endif; ?>
                <?php if(@$user->social_links?->descord): ?>
                    <a class="social__link" href="<?php echo e(@$user->social_links?->descord); ?>" target="__blank"><i
                           class="vti-descord"></i></a>
                <?php endif; ?>
                <?php if(@$user->social_links?->descord): ?>
                    <a class="social__link" href="<?php echo e(@$user->social_links?->tiktok); ?>" target="__blank"><i
                           class="vti-tiktok"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="channel-header">
            <div class="channel-header__content">
                <div class="avatar">
                    <img class="fit-image"
                         src="<?php echo e(getImage(getFilePath('userProfile') . '/' . $user->image, isAvatar: true)); ?>"
                         alt="Channel Profile Picture">
                </div>
                <h3 class="name"><?php echo e($user->channel_name); ?></h3>
                <span class="username"><span>@</span><?php echo e($user->username); ?></span>
                <div class="meta">

                    <span> <span class="subscribeCount"><?php echo e(formatNumber($subscriberCount ?? 0)); ?></span>
                        <?php echo app('translator')->get('subscribers'); ?></span>
                    <?php if($user->id == auth()->id()): ?>
                        <span><?php echo e($videosCount ?? 0); ?> <?php echo app('translator')->get('videos'); ?></span>
                    <?php else: ?>
                        <span><?php echo e($user->videos->where('visibility', Status::PUBLIC)->where('status', Status::PUBLISHED)->count()); ?>

                            <?php echo app('translator')->get('videos'); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(auth()->check() && auth()->id() != $user->id): ?>
                <?php
                    $authUser = auth()->user();
                    $subscribed = in_array($authUser->id, $authUser->isSubscribe());
                ?>
                <div class="channel-header__buttons subscriber-btn">
                    <button
                            class="btn cta <?php if(!$subscribed): ?> btn--white  subcriberBtn <?php else: ?>  btn--white outline unSubcriberBtn <?php endif; ?>">
                        <?php if($subscribed): ?>
                            <?php echo app('translator')->get('Unsubscribe'); ?>
                        <?php else: ?>
                            <?php echo app('translator')->get('Subscribe'); ?>

                            <span class="shape">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        <?php endif; ?>
                    </button>
                </div>
            <?php endif; ?>
            <?php if(request()->routeIs('preview.playlist.videos')): ?>
                <div class="playlist-title">
                    <p><?php echo e(__(@$playlist->title)); ?> <?php echo app('translator')->get('Playlist Collection'); ?></p>
                </div>
                <?php if(@$playlist->playlist_subscription == Status::YES && gs('is_playlist_sell')): ?>
                    <?php

                        $isPurchased = true;
                        if (@$playlist->playlist_subscription) {
                            $isPurchased = false;
                        }
                        if (auth()->check()) {
                            $viewer = auth()->user();
                            if (@$playlist->playlist_subscription) {
                                $isPurchased = in_array(@$playlist->id, $viewer->purchasedPlaylistId);
                            }
                        }

                    ?>
                    <div class="premium-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"
                             aria-hidden="true" class="_24ydrq0 _1286nb17o _1286nb12r6">
                            <path
                                  d="M486.2 50.2c-9.6-3.8-20.5-1.3-27.5 6.2l-98.2 125.5-83-161.1C273 13.2 264.9 8.5 256 8.5s-17.1 4.7-21.5 12.3l-83 161.1L53.3 56.5c-7-7.5-17.9-10-27.5-6.2C16.3 54 10 63.2 10 73.5v333c0 35.8 29.2 65 65 65h362c35.8 0 65-29.2 65-65v-333c0-10.3-6.3-19.5-15.8-23.3">
                            </path>
                        </svg>
                    </div>
                    <?php if($isPurchased): ?>
                        <?php echo app('translator')->get('Purchased'); ?>
                    <?php elseif(!auth()->user() || $playlist->user_id !== @$viewer->id): ?>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="left purchase-price">
                                <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount(@$playlist->price, currencyFormat: false)); ?>

                            </div>
                            <div class="btn btn--base btn--sm premium-stock-text purchase-now"
                                 data-resource="<?php echo e(@$playlist); ?>">
                                <?php echo app('translator')->get('Purchase Now'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>


        </div>
        <div class="channel-tab">
            <a class="channel-tab__item <?php echo e(menuActive('preview.channel')); ?>"
               href="<?php echo e(route('preview.channel', $user->slug)); ?>"><?php echo app('translator')->get('Videos'); ?></a>
            <a class="channel-tab__item <?php echo e(menuActive(['preview.playlist', 'preview.playlist.videos'])); ?>"
               href="<?php echo e(route('preview.playlist', $user->slug)); ?>"><?php echo app('translator')->get('Playlists'); ?></a>
            <a class="channel-tab__item <?php echo e(menuActive('preview.shorts')); ?> "
               href="<?php echo e(route('preview.shorts', $user->slug)); ?>"><?php echo app('translator')->get('Shorts'); ?></a>
            <a class="channel-tab__item <?php echo e(menuActive('preview.live')); ?>"
               href="<?php echo e(route('preview.live', $user->slug)); ?>"><?php echo app('translator')->get('Live'); ?></a>
            <a class="channel-tab__item <?php echo e(menuActive('preview.about')); ?>"
               href="<?php echo e(route('preview.about', $user->slug)); ?>"><?php echo app('translator')->get('About'); ?></a>
            <?php if(gs('is_monthly_subscription') && (!auth()->check() || $user->id != auth()->id())): ?>
                <a class="channel-tab__item <?php echo e(menuActive('preview.monthly.plan')); ?>"
                   href="<?php echo e(route('preview.monthly.plan', $user->slug)); ?>"><?php echo app('translator')->get('Monthly Plan'); ?></a>
            <?php endif; ?>
        </div>

        <?php echo $__env->make($activeTemplate . 'partials.channel.' . $bladeName, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <?php if(auth()->check()): ?>
        
        <div class="modal scale-style fade custom--modal" id="unSubcriberModal" aria-labelledby="unSubcriberModalLabel"
             aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo app('translator')->get('Confirm Alert!'); ?></h5>
                        <button class="close modal-close-btn" data-bs-dismiss="modal" type="button" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure you want to unsubscribe this channel?'); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--sm btn--white outline" data-bs-dismiss="modal"
                                type="button"><?php echo app('translator')->get('No'); ?></button>
                        <button class="btn btn--sm btn--white confirmUnsubscribe" type="button"><?php echo app('translator')->get('Yes'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(request()->routeIs('preview.playlist.videos')): ?>
        <?php echo $__env->make('Template::partials.gateway_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php if(auth()->check()): ?>
    <?php $__env->startPush('script'); ?>
        <script>
            (function($) {
                'use strict';
                $(document).on('click', 'button.cta', function() {
                    $(this).addClass('active');
                    setTimeout(() => {
                        $(this).removeClass('active');
                    }, 300);
                });
                // for subscribe
                $(document).on('click', '.unSubcriberBtn', function() {
                    $('#unSubcriberModal').modal('show');
                });

                $(document).on('click', '.confirmUnsubscribe', function() {
                    subscribers();
                    $('#unSubcriberModal').modal('hide');
                });

                $(document).on('click', '.subcriberBtn', function() {
                    subscribers();
                });

                function subscribers() {

                    $.ajax({
                        type: "post",
                        url: "<?php echo e(route('user.subscribe.channel', $user->id)); ?>",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                        },
                        success: function(response) {



                            if (response.remark === 'subscribed') {
                                $('.subscriber-btn').html(`
                  <button class="btn btn--white outline unSubcriberBtn"> <?php echo app('translator')->get('Unsubscribe'); ?></button> `)
                                $('.subscribeCount').text(response.data.subscriber_count)

                            } else if (response.remark === 'unsubscribe') {
                                $('.subscriber-btn').html(`
                 <button class="btn cta btn--white subcriberBtn"><?php echo app('translator')->get('Subscribe'); ?>
                                        <span class="shape">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </span></button>
                `)
                                $('.subscribeCount').text(response.data.subscriber_count)
                            } else {

                                notify('error', response.message);
                            }
                        }

                    });
                }

            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startPush('style'); ?>
    <style>
        .purchase-price {
            color: hsl(var(--white));
            font-weight: 600;
        }

        .premium-stock-text {
            text-decoration: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/channel/channel_preview.blade.php ENDPATH**/ ?>