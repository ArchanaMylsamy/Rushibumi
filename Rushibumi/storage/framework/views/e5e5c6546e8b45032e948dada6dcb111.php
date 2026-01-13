
<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">
        <div class="card custom--card">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__($pageTitle)); ?></h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('user.live.update', $liveStream->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="form-label"><?php echo app('translator')->get('Stream Title'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control form--control" value="<?php echo e(old('title', $liveStream->title)); ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"><?php echo app('translator')->get('Description'); ?></label>
                                <textarea name="description" class="form-control form--control" rows="3"><?php echo e(old('description', $liveStream->description)); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><?php echo app('translator')->get('Category'); ?></label>
                                        <select name="category_id" class="form-control form--control">
                                            <option value=""><?php echo app('translator')->get('Select Category'); ?></option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $liveStream->category_id) == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><?php echo app('translator')->get('Visibility'); ?> <span class="text-danger">*</span></label>
                                        <select name="visibility" class="form-control form--control" required>
                                            <option value="public" <?php echo e(old('visibility', $liveStream->visibility) == 'public' ? 'selected' : ''); ?>><?php echo app('translator')->get('Public'); ?></option>
                                            <option value="unlisted" <?php echo e(old('visibility', $liveStream->visibility) == 'unlisted' ? 'selected' : ''); ?>><?php echo app('translator')->get('Unlisted'); ?></option>
                                            <option value="private" <?php echo e(old('visibility', $liveStream->visibility) == 'private' ? 'selected' : ''); ?>><?php echo app('translator')->get('Private'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail Upload Section -->
                    <div class="thumbnail-section">
                        <h4 class="thumbnail-heading"><?php echo app('translator')->get('Thumbnail'); ?></h4>
                        <p class="thumbnail-description">
                            <?php echo app('translator')->get('Select or upload a picture that represents your stream. A good thumbnail stands out and draws viewers\' attention.'); ?>
                        </p>
                        <div class="thumbnail-upload-container">
                            <?php if($liveStream->thumbnail): ?>
                                <div class="thumbnail-preview-wrapper" id="thumbnailPreviewWrapper">
                                    <img id="thumbnailPreview" src="<?php echo e(getImage(getFilePath('liveThumbnail') . '/' . $liveStream->thumbnail, getFileSize('liveThumbnail'))); ?>" alt="Thumbnail Preview" class="thumbnail-preview-image">
                                    <button type="button" class="thumbnail-remove-btn" id="removeThumbnailBtn">
                                        <i class="las la-times"></i>
                                    </button>
                                    <button type="button" class="thumbnail-change-btn" id="changeThumbnailBtn">
                                        <i class="las la-edit"></i> <?php echo app('translator')->get('Change'); ?>
                                    </button>
                                </div>
                                <div class="thumbnail-upload-box" id="thumbnailUploadBox" style="display: none;">
                                    <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*" class="d-none">
                                    <label for="thumbnailInput" class="thumbnail-upload-label">
                                        <div class="thumbnail-upload-icon">
                                            <i class="las la-image"></i>
                                            <i class="las la-plus thumbnail-plus-icon"></i>
                                        </div>
                                        <span class="thumbnail-upload-text"><?php echo app('translator')->get('Upload thumbnail'); ?></span>
                                    </label>
                                </div>
                            <?php else: ?>
                                <div class="thumbnail-upload-box" id="thumbnailUploadBox">
                                    <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*" class="d-none">
                                    <label for="thumbnailInput" class="thumbnail-upload-label">
                                        <div class="thumbnail-upload-icon">
                                            <i class="las la-image"></i>
                                            <i class="las la-plus thumbnail-plus-icon"></i>
                                        </div>
                                        <span class="thumbnail-upload-text"><?php echo app('translator')->get('Upload thumbnail'); ?></span>
                                    </label>
                                </div>
                                <div class="thumbnail-preview-wrapper" id="thumbnailPreviewWrapper" style="display: none;">
                                    <img id="thumbnailPreview" src="" alt="Thumbnail Preview" class="thumbnail-preview-image">
                                    <button type="button" class="thumbnail-remove-btn" id="removeThumbnailBtn">
                                        <i class="las la-times"></i>
                                    </button>
                                    <button type="button" class="thumbnail-change-btn" id="changeThumbnailBtn">
                                        <i class="las la-edit"></i> <?php echo app('translator')->get('Change'); ?>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn--base">
                            <i class="las la-save"></i> <?php echo app('translator')->get('Update Stream'); ?>
                        </button>
                        <a href="<?php echo e(route('user.live.manage')); ?>" class="btn btn--secondary">
                            <?php echo app('translator')->get('Cancel'); ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .thumbnail-section {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
        }

        .thumbnail-heading {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .thumbnail-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .thumbnail-upload-container {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .thumbnail-upload-box {
            width: 200px;
            height: 120px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f9f9f9;
        }

        .thumbnail-upload-box:hover {
            border-color: #007bff;
            background: #f0f8ff;
        }

        .thumbnail-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            width: 100%;
            height: 100%;
            text-align: center;
            padding: 10px;
        }

        .thumbnail-upload-icon {
            position: relative;
            font-size: 32px;
            color: #999;
            margin-bottom: 8px;
        }

        .thumbnail-plus-icon {
            position: absolute;
            top: -8px;
            right: -8px;
            font-size: 16px;
            background: #007bff;
            color: #fff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnail-upload-text {
            font-size: 14px;
            color: #666;
        }

        .thumbnail-preview-wrapper {
            position: relative;
            width: 200px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #ddd;
        }

        .thumbnail-preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-remove-btn,
        .thumbnail-change-btn {
            position: absolute;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .thumbnail-remove-btn {
            top: 8px;
            right: 8px;
        }

        .thumbnail-change-btn {
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
        }

        .thumbnail-remove-btn:hover,
        .thumbnail-change-btn:hover {
            background: rgba(0, 0, 0, 0.9);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnailInput = document.getElementById('thumbnailInput');
            const thumbnailPreview = document.getElementById('thumbnailPreview');
            const thumbnailPreviewWrapper = document.getElementById('thumbnailPreviewWrapper');
            const thumbnailUploadBox = document.getElementById('thumbnailUploadBox');
            const removeThumbnailBtn = document.getElementById('removeThumbnailBtn');
            const changeThumbnailBtn = document.getElementById('changeThumbnailBtn');

            // Show preview when file is selected
            if (thumbnailInput) {
                thumbnailInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            thumbnailPreview.src = e.target.result;
                            thumbnailPreviewWrapper.style.display = 'block';
                            if (thumbnailUploadBox) {
                                thumbnailUploadBox.style.display = 'none';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Change thumbnail button
            if (changeThumbnailBtn) {
                changeThumbnailBtn.addEventListener('click', function() {
                    thumbnailInput.click();
                });
            }

            // Remove thumbnail button
            if (removeThumbnailBtn) {
                removeThumbnailBtn.addEventListener('click', function() {
                    thumbnailPreview.src = '';
                    thumbnailPreviewWrapper.style.display = 'none';
                    if (thumbnailUploadBox) {
                        thumbnailUploadBox.style.display = 'flex';
                    }
                    if (thumbnailInput) {
                        thumbnailInput.value = '';
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/live/edit.blade.php ENDPATH**/ ?>