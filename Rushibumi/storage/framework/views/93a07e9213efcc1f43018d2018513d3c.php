<?php $__env->startSection('uplaod_content'); ?>
    <div class="upload-elements">
        <div class="upload-elements__subtitle">
            <div class="subtitle-content">
                <span class="subtitle-content__icon"><i class="vti-subtitle"></i></span>
                <h6 class="subtitle-content__title"><?php echo app('translator')->get('Add Subtittle'); ?></h6>
                <span class="subtitle-content__desc"><?php echo app('translator')->get('Reach a border audience by adding subtitle to your video'); ?></span>
            </div>


            <button class="add-subtitle-btn btn--success addSubtitleBtn">
                <span class="icon"><i class="las la-plus"></i></span>
            </button>
        </div>

        <form class="upload-elements-form" action="<?php echo e(route('user.video.elements.submit', $video->id)); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="subtitle-wrapper">
                <?php $__currentLoopData = old('caption', $video->subtitles) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subtitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="subtitle--content">
                        <button class="file-close-btn closeBtn" type="button">
                            <i class="las la-times"></i>
                        </button>
                        <div class="form-group">
                            <label class="sub-title-input" for="sub-title-input">
                                <span class="icon">
                                    <svg class="lucide lucide-captions" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="14" x="3" y="5" rx="2" ry="2" />
                                        <path d="M7 15h4M15 15h2M7 11h2M13 11h4" />
                                    </svg>
                                </span>
                                <span class="note-text">
                                    <span class="icon"><i class="fas fa-info-circle"></i></span> <?php echo app('translator')->get('Subtitle File (.vtt)'); ?>
                                </span>
                                <span class="text-success  note-text alertFile"></span>
                                <input class="form--control" id="sub-title-input" name="subtitle_file[]" type="file" hidden>
                                <input name="old_subtitle[]" type="hidden" value="<?php echo e(@$subtitle->id); ?>" accept=".vtt">
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label"><?php echo app('translator')->get('Caption'); ?></label>
                                    <input class="form--control" name="caption[]" type="text" value="<?php echo e(@old('caption')[$key] ?? @$subtitle->caption); ?>" placeholder="Caption (e.g., English)" required>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="form--label"><?php echo app('translator')->get('Language Code'); ?></label>
                                    <input class="form--control" name="language_code[]" type="text" value="<?php echo e(@old('language_code')[$key] ?? @$subtitle->language_code); ?>" placeholder="Language Code (e.g., en)" required>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="form-group audience">
                <label class="form--label">
                    <span class="text"><?php echo app('translator')->get('Audience'); ?></span>
                </label>

                <div class="check-type-wrapper">
                    <label class="check-type check-type-success" for="audience01">
                        <input class="check-type-input" id="audience01" name="audience" type="radio" value="0" <?php if(old('audience', $video->audience) == 0): ?> checked <?php endif; ?>>
                        <span class="check-type-icon">
                            <svg class="check-circle" width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="check" d="M1 5L4.5 8.5L12.5 0.5" stroke="currentColor" stroke-linecap="round">
                                </path>
                            </svg>
                        </span>
                        <span class="check-type-label"><?php echo app('translator')->get('All Ages can view this video'); ?></span>
                    </label>
                    <label class="check-type check-type-warning" for="audience02">
                        <input class="check-type-input" id="audience02" name="audience" type="radio" value="1" <?php if(old('audience', $video->audience) == 1): ?> checked <?php endif; ?>>
                        <span class="check-type-icon">
                            <svg class="check-circle" width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="check" d="M1 5L4.5 8.5L12.5 0.5" stroke="currentColor" stroke-linecap="round">
                                </path>
                            </svg>
                        </span>
                        <span class="check-type-label"><?php echo app('translator')->get('Only 18'); ?>+</span>
                    </label>
                </div>
            </div>


            <div class="form-group upload-buttons mb-0">
                <a class="btn btn--dark" href="<?php echo e(route('user.video.details.form', @$video->id)); ?>"><?php echo app('translator')->get('Previous'); ?></a>
                <button class="btn btn--base" type="submit"><?php echo app('translator')->get('Next Step'); ?></button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow:after {
            top: 8px !important;
        }

        span.input-group-text.btn--base {
            border: 1px solid transparent;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            let count = 0;

            $('.addSubtitleBtn').on('click', function() {


                if (count >= 5) {
                    notify('error', 'You are already added maximum subtitle');
                    return;
                }
                count++;

                $('.subtitle-wrapper').append(` <div class="subtitle--content">
                    <button type="button" class="file-close-btn closeBtn">
                        <i class="las la-times"></i>
                    </button>
                <div class="form-group">
                    <label for="sub-title-input${count}" class="sub-title-input">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-captions"><rect width="18" height="14" x="3" y="5" rx="2" ry="2"/><path d="M7 15h4M15 15h2M7 11h2M13 11h4"/></svg>
                        </span>
                        <span class="note-text">
                            <span class="icon"><i class="fas fa-info-circle"></i></span>  <?php echo app('translator')->get('Subtitle File (.vtt)'); ?>

                        </span>
                        <span class="text-success note-text alertFile"></span>
                        <input type="file" hidden class="form--control" id="sub-title-input${count}" name="subtitle_file[]"  accept=".vtt">
                    </label>

                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form--label required"><?php echo app('translator')->get('Caption'); ?></label>
                           <input type="text" placeholder="Capntion (e.x: English)" class="form--control" name="caption[]" required >
                       </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form--label required"><?php echo app('translator')->get('Language Code'); ?></label>
                            <input type="text" placeholder="Language Code (e.x: en)" class="form--control" name="language_code[]" required >
                        </div>
                    </div>
                </div>

            </div>`)

            });


            $(document).on('click', '.closeBtn', function() {

                count--;

                $(this).closest('.subtitle--content').remove();

            })


            $(document).on('change', '[name="subtitle_file[]"]', function() {
                $(this).siblings('.alertFile').text('File Selected');
            });



        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'partials.upload', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/video/elements.blade.php ENDPATH**/ ?>