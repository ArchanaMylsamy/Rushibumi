<div class="upload">
    <div class="upload__outer">
        <div class="upload__dragBox">
            <div class="upload-box">
                <span class="progress-ring">
                    <svg>
                        <circle cx="80" cy="80" r="70" />
                    </svg>
                </span>
                <span class="spiner-upload"></span>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-file-video-2">
                        <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        <rect width="8" height="6" x="2" y="12" rx="1" />
                        <path d="m10 15.5 4 2.5v-6l-4 2.5" />
                    </svg>
                </span>
                <span class="progress-value"></span>
            </div>



            <!-- Progress UI -->
            <div class="progress-area" style="display: none; margin-top: 1rem;">
                <div class="progress-bar"
                    style="height: 6px; background: hsl(var(--info)); width: 0%; transition: width 0.4s;"></div>
                <p class="progress-text" style="margin-top: 0.5rem; text-align: center;">0%</p>
            </div>

            <h4 class="title StepTitle"><?php echo app('translator')->get('Drag and drop video files to upload'); ?></h4>
            <span class="tagDes"><?php echo app('translator')->get('Your video will be private until you publish them'); ?></span>
            <input class="uploadFile" id="upload__uploadFile" type="file" ondragover="drag()" ondrop="drop()"
                accept="video/*" />
        </div>

        <?php if(!request()->routeIs('user.shorts.*') && gs('ffmpeg_status')): ?>
            <p class="text mt-3"><?php echo app('translator')->get('Supported Resulation: '); ?>
                (
                <?php $__currentLoopData = $resolutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resolution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span><?php echo e($resolution->width); ?> X <?php echo e($resolution->height); ?></span>
                    <?php if(!$loop->last): ?>
                        ,
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                )
            </p>
        <?php endif; ?>

        <p class="text mt-3">
            <?php echo app('translator')->get('Allowed File Extensions: .mp4, .mov, .wmv, .flv, .avi, .mkv'); ?>
        </p>
        <label class="btn btn--base" for="upload__uploadFile"><?php echo app('translator')->get('Select Files'); ?></label>
    </div>
</div>

<?php $__env->startPush('style'); ?>
    <style>
        .upload-box {
            height: 160px;
            width: 160px;
            border-radius: 50%;
            position: relative;
            margin: 0 auto 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: hsl(var(--white) / .1);
            border: 1px dashed hsl(var(--white) / .3);
        }

        .animation-box.upload-box {
            border-color: hsl(var(--info));
            background: hsl(var(--info) / .1);
        }

        .progress-ring {
            position: absolute;
            top: -1px;
            left: -1px;
            width: 160px;
            height: 160px;
            z-index: 2;
            pointer-events: none;
        }

        .progress-ring svg {
            transform: rotate(-90deg);
            width: 100%;
            height: 100%;
        }

        .progress-ring circle {
            fill: none;
            stroke-width: 6;
            stroke-linecap: round;
            stroke: #E7112A;
            stroke-dasharray: 440;
            stroke-dashoffset: 440;
            transition: stroke-dashoffset 0.4s linear;
        }

        .upload-box>*:not(.progress-ring) {
            z-index: 3;
            position: relative;
        }

        .progress-value {
            position: absolute;
            font-size: 20px;
            font-weight: bold;
            color: #E7112A;
            display: block;
            z-index: 4;
        }
    </style>
    <?php $__env->startPush('script'); ?>
        <script>
            (function($) {
                "use strict";

                const shorts = "<?php echo e($isShorts); ?>";

                function drag() {
                    document.getElementById('upload__uploadFile').parentNode.className = 'draging upload__dragBox';
                }

                function drop() {
                    document.getElementById('upload__uploadFile').parentNode.className = 'upload__dragBox';
                }

                const circle = document.querySelector('.progress-ring circle');
                const radius = circle.r.baseVal.value;
                const circumference = 2 * Math.PI * radius;

                circle.style.strokeDasharray = `${circumference}`;
                circle.style.strokeDashoffset = `${circumference}`;

                function setProgress(percent) {
                    const offset = circumference - (percent / 100) * circumference;
                    circle.style.strokeDashoffset = offset;
                    $('.progress-value').text(`${percent}%`).show();
                }

                function resetProgress() {
                    setProgress(0);
                    $('.upload-box').removeClass('uploading');
                    $('.progress-value').hide();
                }

                $(document).ready(function() {
                    $('.uploadFile').on('change', async function() {
                        const file = this.files[0];
                        if (!file) return;

                        $('.upload-box').addClass('uploading');
                        $('.icon').hide();
                        setProgress(0);
                        $('.StepTitle').text('Uploading your file, please wait...');

                        const chunkSize = 10 * 1024 * 1024; // 5MB
                        const totalChunks = Math.ceil(file.size / chunkSize);
                        const extension = file.name.split('.').pop();
                        const fileName = `${Date.now()}-${Math.floor(Math.random() * 100000)}.${extension}`;
                        const uniqueId = "<?php echo e(uniqid()); ?>";

                        const uploadUrl = shorts ? "<?php echo e(route('user.shorts.upload', @$video->id)); ?>" :
                            "<?php echo e(route('user.video.upload', @$video->id)); ?>";

                        const mergeUrl = "<?php echo e(route('user.video.merge', @$video->id)); ?>";


                        for (let i = 0; i < totalChunks; i++) {
                            const chunk = file.slice(i * chunkSize, (i + 1) * chunkSize);
                            const formData = new FormData();
                            formData.append('chunk', chunk);
                            formData.append('extension', extension);
                            formData.append('fileName', fileName);
                            formData.append('uniqueId', uniqueId);
                            formData.append('index', i);

                            try {
                                const response = await fetch(uploadUrl, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                                    },
                                    body: formData
                                });

                                const result = await response.json();

                                if (!response.ok || result.error || result.status === 'error') {
                                    notify('error', result.message || result.error ||
                                        'Something went wrong');
                                    resetProgress();
                                    $('.StepTitle').text('Upload failed.');
                                    $('.icon').show();
                                    return;
                                }

                                const percent = Math.round(((i + 1) / totalChunks) * 100);
                                setProgress(percent);

                            } catch (error) {
                        
                                notify('error', 'Upload Failed.');

                                resetProgress();

                                $('.StepTitle').text('Upload failed.');
                                $('.icon').show();
                                return;
                            }
                        }


                        $('.StepTitle').text('Merging File, please wait...');


                        let mergePercent = 95;
                        setProgress(mergePercent);

                        let mergeInterval = setInterval(() => {
                            if (mergePercent < 95) {
                                mergePercent++;
                                setProgress(mergePercent);
                            }
                        }, 150);

                        try {
                            const mergeResponse = await fetch(mergeUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                                },
                                body: JSON.stringify({
                                    fileName: fileName,
                                    shorts: shorts ? 1 : 0,
                                    total: totalChunks,
                                    uniqueId: uniqueId
                                })
                            });

                            const response = await mergeResponse.json();
                            clearInterval(mergeInterval);

                            if (!mergeResponse.ok || response.error || response.status === 'error') {
                                notify('error', response.message || response.error || 'Merge failed');
                                resetProgress();
                                $('.StepTitle').text('Merge failed.');
                                $('.icon').show();
                                return;
                            }

                            if (response.status === 'success') {
                                setProgress(100);
                                notify('success', response.message);

                                if ("<?php echo e(@gs('is_storage')); ?>" == 1 && "<?php echo e(@$availableStorage); ?>" == true) {
                                    uploadLiveServer(response);
                                } else {
                                    getRedirectMethod(response);
                                }
                            }

                        } catch (error) {
                            clearInterval(mergeInterval);
                            notify('error', 'Merge error.');
                            resetProgress();
                            $('.StepTitle').text('Merge failed.');
                            $('.icon').show();
                        }
                    });
                });



                function uploadLiveServer(response) {
                    $('.StepTitle').text('Uploading to server, please wait...');
                    let fakePercent = 0;
                    let interval = setInterval(() => {
                        if (fakePercent < 95) {
                            fakePercent++;
                            setProgress(fakePercent);
                        }
                    }, 100);

                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(route('user.video.upload.server')); ?>/" + response.data.video.id,
                        success: function(res) {
                            clearInterval(interval);
                            setProgress(100);
                            if (res.success) {
                                getRedirectMethod(res);
                            } else {
                                
                                $('.StepTitle').text('Server upload failed.');
                                notify('error', res.error);
                                resetProgress();
                                $('.icon').show();
                            }
                        }
                    });
                }

                

                function getRedirectMethod(response) {
                    console.log(response);
                    $('.StepTitle').text('File uploaded successfully!');
                    notify('success', response.success);
                    let route = response.data.video.is_shorts_video == '1' ?
                        "<?php echo e(route('user.shorts.details.form', '')); ?>/" + response.data.video.id :
                        "<?php echo e(route('user.video.details.form', '')); ?>/" + response.data.video.id;
                    window.location.href = route;
                }

            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/video/file.blade.php ENDPATH**/ ?>