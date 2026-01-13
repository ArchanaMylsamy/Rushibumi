<?php $__env->startSection('content'); ?>
    <?php
        $content = getContent('monetization_page.content', true);

    ?>
    <div class="setting-content">
        <h3 class="setting-content__title mb-0"><?php echo e(__($content->data_values->title)); ?></h3>
        <span class="subtitle"><?php echo e(__($content->data_values->subtitle)); ?></span>
        <div class="monetization-card">
            <h3 class="monetization-card__title"><?php echo e(__($content->data_values->card_title)); ?></h3>
            <?php if(!$user->profile_complete): ?>
                <span class="monetization-card__tagline"><?php echo e(__($content->data_values->card_tagline)); ?></span>
                <a href="<?php echo e(route('user.channel.create')); ?>" class="btn btn--base"><?php echo app('translator')->get('Create Channel'); ?></a>
            <?php elseif($totalSubscriber >= gs('minimum_subscribe') && $totalViews >= gs('minimum_views') && !$user->monetization_status): ?>
                <span class="monetization-card__tagline"><?php echo e(__($content->data_values->congratulation_message)); ?></span>
                <a href="<?php echo e(route('user.monetization.apply')); ?>" class="btn btn--base"><?php echo app('translator')->get('Apply'); ?></a>
            <?php elseif($user->monetization_status == Status::MONETIZATION_APPLYING): ?>
                <span class="monetization-card__tagline"><?php echo e(__($content->data_values->review_message)); ?></span>
            <?php elseif($user->monetization_status == Status::MONETIZATION_APPROVED): ?>
                <span class="monetization-card__tagline"><?php echo e(__($content->data_values->active_message)); ?></span>
            <?php elseif($user->monetization_status == Status::MONETIZATION_CANCEL): ?>
                <span class="monetization-card__tagline"><?php echo e(__($content->data_values->rejected_message)); ?></span>
                <a href="<?php echo e(route('user.monetization.apply')); ?>" class="btn btn--base"><?php echo app('translator')->get('Apply Again'); ?></a>
            <?php endif; ?>

            <img class="img"
                src="<?php echo e(frontendImage('monetization_page', $content->data_values->first_image, '202x137')); ?>"
                alt="image">
        </div>


        <div class="monetization-progress">
            <h5 class="title"><?php echo app('translator')->get('Meet the conditions for application'); ?> <span class="icon"><i class="vti-info"></i></span></h5>
            <div class="progress-wrap">
                <div class="progress-item">
                    <div class="progress" data-percent="<?php echo e($subscriberInPercent); ?>%">
                        <div class="progressbar"></div>
                    </div>
                    <h6 class="progress-item__caption"><?php echo e($totalSubscriber); ?> <?php echo app('translator')->get('Subscribers'); ?></h6>
                    <span class="progress-item__number"><?php echo e(formatNumber(gs('minimum_subscribe'))); ?></span>
                </div>

                <div class="progress-item">
                    <div class="progress" data-percent="<?php echo e($viewInPercent); ?>%">
                        <div class="progressbar"></div>
                    </div>
                    <h6 class="progress-item__caption"><?php echo e($totalViews); ?> <?php echo app('translator')->get('views'); ?></h6>
                    <span class="progress-item__number"><?php echo e(formatNumber(gs('minimum_views'))); ?></span>
                </div>
            </div>
        </div>


        <?php if(gs('monetization_status') && $user->monetization_status == Status::MONETIZATION_INITIATE): ?>
            <div class="monetization-card paid">
                <h3 class="monetization-card__title"><?php echo app('translator')->get('Paid Monetization'); ?></h3>
                <p class="monetization-card__desc">
                    <?php echo app('translator')->get('Spend'); ?> <?php echo e(showAmount(gs('monetization_amount'))); ?> <?php echo app('translator')->get('to activate monetization quickly, enjoy all the benefits, and start making money'); ?>.
                </p>
                <a href="<?php echo e(route('user.deposit.index', ['id' => 0, 'monetization' => true])); ?>"
                    class="btn btn--base"><?php echo app('translator')->get('Active'); ?></a>
                <img class="img"
                    src="<?php echo e(frontendImage('monetization_page', $content->data_values->second_image, '202x137')); ?>"
                    alt="image">
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            'use strict';

            $(document).ready(function() {
                // Monitization Progressbar

                $('.progress').each(function() {

                    $(this).find('.progressbar').animate({
                        width: $(this).attr('data-percent')
                    }, 3000);

                });


            });

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/setting/monetization.blade.php ENDPATH**/ ?>