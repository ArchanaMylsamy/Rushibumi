<div class="upload-visibility">
                <form class="upload-visibility__form" action="<?php echo e(route('user.' . $action . '.visibility.submit', $video->id)); ?>"
          method="post">
        <?php echo csrf_field(); ?>
        <div class="form-group select2-parent">
            <label class="form--label"><?php echo app('translator')->get('Category'); ?></label>
            <select class="select form--control select2-basic" name="category" id="video_category" required>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php if($video->category_id == $category->id ?? request()->category == $category->id): ?> selected <?php endif; ?>>
                        <?php echo e(__($category->name)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group select2-parent">
            <label class="form--label"><?php echo app('translator')->get('Tags'); ?> <small class="text-muted">(<?php echo app('translator')->get('Subject-based sequential tags will be suggested'); ?>)</small></label>
            <select class="form--control select2-auto-tokenize" name="tags[]" id="video_tags" required multiple>
                <?php $__currentLoopData = old('tags', $video->tags) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $videoTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($videoTag->tag); ?>" selected><?php echo e($videoTag->tag); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <small class="form-text text-muted"><?php echo app('translator')->get('Tags are suggested based on your previous videos and category subject'); ?></small>
        </div>
        <div class="form-group">
            <label class="form--label"><?php echo app('translator')->get('Visibility'); ?></label>
            <div class="check-type-wrapper">
                <label for="public" class="check-type check-type-primary">
                    <input class="check-type-input" type="radio" value="0" name="visibility" id="public"
                           <?php if($video->visibility == 0 ?? request()->visibility == 0): ?> checked <?php endif; ?>>

                    <span class="check-type-icon">
                        <svg class="check-circle" width="13" height="10" viewBox="0 0 13 10" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 5L4.5 8.5L12.5 0.5" stroke="currentColor" stroke-linecap="round" class="check">
                            </path>
                        </svg>
                    </span>
                    <span class="check-type-label"><?php echo app('translator')->get('Public'); ?></span>
                </label>

                <label for="private" class="check-type check-type-success">
                    <input class="check-type-input" type="radio" value="1" name="visibility" id="private"
                           <?php if($video->visibility == 1 ?? request()->visibility == 1): ?> checked <?php endif; ?>>

                    <span class="check-type-icon">
                        <svg class="check-circle" width="13" height="10" viewBox="0 0 13 10" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 5L4.5 8.5L12.5 0.5" stroke="currentColor" stroke-linecap="round" class="check">
                            </path>
                        </svg>
                    </span>
                    <span class="check-type-label"><?php echo app('translator')->get('Private'); ?></span>
                </label>
            </div>

        </div>
        <div class="form-group upload-buttons mb-0">
            <?php if(@$video->is_shorts_video): ?>
                <a class="btn btn--dark" href="<?php echo e(route('user.shorts.details.form', @$video->id)); ?>"><?php echo app('translator')->get('Previous'); ?> </a>
            <?php else: ?>
                <a class="btn btn--dark" href="<?php echo e(route('user.video.elements.form', @$video->id)); ?>"><?php echo app('translator')->get('Previous'); ?></a>
            <?php endif; ?>
            <button class="btn btn--base" type="submit"><?php echo app('translator')->get('Publish'); ?></button>
        </div>
    </form>
</div>

<?php $__env->startPush('style'); ?>
    <style>
        .select2-container .select2-selection--single {
            line-height: 28px !important;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable:first-child {
            border-radius: 5px 5px 0 0 !important;
        }

        .select2-results {
            border-radius: 5px;
            overflow: hidden;
        }
        .select2-container--default .select2-selection--multiple {
            min-height: 41px !important;
            height: unset !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            const tagsField = $('#video_tags');
            const categoryField = $('#video_category');
            const videoId = <?php echo e($video->id ?? 0); ?>;
            
            // Initialize Select2 for tags
            tagsField.select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: '<?php echo app('translator')->get('Enter tags based on content subject...'); ?>',
                ajax: {
                    url: "<?php echo e(route('user.video.fatch.tags')); ?>",
                    type: "get",
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page,
                            rows: 20,
                            category_id: categoryField.val(), // Pass category for subject-based suggestions
                            video_id: videoId
                        };
                    },
                    processResults: function(response, params) {
                        params.page = params.page || 1;
                        
                        // Format results with type indicators
                        const formattedResults = response.map(function(item) {
                            let text = item.text;
                            // Add indicator for sequential tags
                            if (item.type === 'user_sequential') {
                                text += ' (Your frequent)';
                            } else if (item.type === 'category_based') {
                                text += ' (Category-based)';
                            }
                            return {
                                id: item.id,
                                text: text,
                                subject: item.subject || ''
                            };
                        });
                        
                        return {
                            results: formattedResults,
                            pagination: {
                                more: params.page < response.length
                            }
                        };
                    },
                    cache: false
                },
                dropdownParent: tagsField.parent(),
                closeOnSelect: false, // Allow multiple selections
                minimumInputLength: 0 // Show suggestions even without typing
            });
            
            // When category changes, refresh tag suggestions
            categoryField.on('change', function() {
                // Trigger tag field to reload suggestions
                tagsField.val(null).trigger('change');
            });
            
            // Show suggestions on focus
            tagsField.on('select2:open', function() {
                // Trigger search with empty term to show all suggestions
                $(this).data('select2').dropdown.$search.val('').trigger('input');
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/video/visibility.blade.php ENDPATH**/ ?>