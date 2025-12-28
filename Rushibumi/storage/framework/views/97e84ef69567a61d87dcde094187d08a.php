<?php $__env->startSection('content'); ?>
    <div class="home-body importExport-body">
        <div class="upload-import-area">
            <div class="upload-import-area__header">
                <h3 class="upload-import-area__title">
                    <?php echo app('translator')->get('Upload new video'); ?>
                </h3>
            </div>

            <?php if(request()->routeIs('user.shorts.*')): ?>
                <ul class="upload-list">
                    <li
                        class="upload-list__item  <?php if(@$video->step == Status::THIRD_STEP): ?> active <?php else: ?>  <?php echo e(menuActive(['user.shorts.upload.form', 'user.shorts.details.form', 'user.shorts.visibility.form'])); ?> <?php endif; ?>">
                        <a class="upload-list__link " href="<?php echo e(route('user.shorts.upload.form', @$video->id)); ?>">
                            <span class="circle">1</span>
                            <span class="text"><?php echo app('translator')->get('Upload'); ?></span>
                        </a>
                    </li>
                    <li
                        class="upload-list__item   <?php if(@$video->step == Status::THIRD_STEP): ?> active <?php else: ?>  <?php echo e(menuActive(['user.shorts.details.form', 'user.shorts.visibility.form'])); ?> <?php endif; ?>">
                        <a class="upload-list__link <?php if(@$video->step < Status::FIRST_STEP): ?> disabled-link <?php endif; ?> " href="<?php echo e(route('user.shorts.details.form', @$video->id)); ?>">
                            <span class="circle">2</span>
                            <?php echo app('translator')->get('Details'); ?>
                        </a>
                    </li>

                    <li class="upload-list__item  <?php if(@$video->step == Status::THIRD_STEP): ?> active <?php else: ?>  <?php echo e(menuActive(['user.shorts.visibility.form'])); ?> <?php endif; ?>">
                        <a class="upload-list__link <?php if(@$video->step < Status::SECOND_STEP): ?> disabled-link <?php endif; ?>" href="<?php echo e(route('user.shorts.visibility.form', @$video->id)); ?>">
                            <span class="circle">3</span>
                            <?php echo app('translator')->get('Visibility'); ?>
                        </a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="upload-list">
                    <li
                        class="upload-list__item <?php if(@$video->step == Status::FOURTH_STEP): ?> active <?php else: ?>  <?php echo e(menuActive(['user.video.upload.form', 'user.video.details.form', 'user.video.elements.form', 'user.video.visibility.form'])); ?> <?php endif; ?>">
                        <a class="upload-list__link" href="<?php echo e(route('user.video.upload.form', @$video->id)); ?>">
                            <span class="circle">1</span>
                            <?php echo app('translator')->get('Upload'); ?>
                        </a>
                    </li>
                    <li
                        class="upload-list__item  <?php if(@$video->step == Status::FOURTH_STEP): ?> active <?php else: ?> <?php echo e(menuActive(['user.video.details.form', 'user.video.elements.form', 'user.video.visibility.form'])); ?> <?php endif; ?>">
                        <a class="upload-list__link <?php if(@$video->step < Status::FIRST_STEP): ?> disabled-link <?php endif; ?>" href="<?php echo e(route('user.video.details.form', @$video->id)); ?>">
                            <span class="circle">2</span>
                            <?php echo app('translator')->get('Details'); ?>
                        </a>
                    </li>
                    <li
                        class="upload-list__item <?php if(@$video->step == Status::FOURTH_STEP): ?> active <?php else: ?> <?php echo e(menuActive(['user.video.elements.form', 'user.video.visibility.form'])); ?> <?php endif; ?>">
                        <a class="upload-list__link <?php if(@$video->step < Status::SECOND_STEP): ?> disabled-link <?php endif; ?> " href="<?php echo e(route('user.video.elements.form', @$video->id)); ?>">
                            <span class="circle">3</span>
                            <?php echo app('translator')->get('Elements'); ?>
                        </a>
                    </li>
                    <li class="upload-list__item  <?php if(@$video->step == Status::FOURTH_STEP): ?> active <?php else: ?> <?php echo e(menuActive(['user.video.visibility.form'])); ?> <?php endif; ?>">
                        <a class="upload-list__link <?php if(@$video->step < Status::THIRD_STEP): ?> disabled-link <?php endif; ?>" href="<?php echo e(route('user.video.visibility.form', @$video->id)); ?>">
                            <span class="circle">4</span>
                            <?php echo app('translator')->get('Visibility'); ?>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>

            <div class="uplaod_wrapper">

                <?php echo $__env->yieldContent('uplaod_content'); ?>

                <?php if(request()->routeIs(['user.video.upload.form', 'user.shorts.upload.form'])): ?>
                    <p class="upload-import-area__desc">
                        <span>
                            <?php echo app('translator')->get('By submitting your videos to ' . gs('site_name') . ', you acknowledge that you agree to ' . gs('site_name')); ?>
                            <?php if(gs('agree')): ?>
                                <?php
                                    $policyPages = getContent('policy_pages.element', false, orderById: true);
                                ?>
                                <?php $__currentLoopData = $policyPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="link text--white fw-semibold"
                                       href="<?php echo e(route('policy.pages', $policy->slug)); ?>" target="__blank"
                                       target="_blank"><?php echo e(__($policy->data_values->title)); ?></a>
                                    <?php if(!$loop->last): ?>
                                        ,
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php echo app('translator')->get('Please be sure not to violate others copyright or privacy rights'); ?>.
                        </span>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            color: #6c757d;
            text-decoration: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/upload.blade.php ENDPATH**/ ?>