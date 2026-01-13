<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">
        <div class="card custom--card" id="goLiveCard">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__($pageTitle)); ?></h3>
            </div>
            <div class="card-body">
                <form id="goLiveForm">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="form-label"><?php echo app('translator')->get('Stream Title'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="streamTitle" class="form-control form--control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label"><?php echo app('translator')->get('Description'); ?></label>
                                <textarea name="description" id="streamDescription" class="form-control form--control" rows="3"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><?php echo app('translator')->get('Category'); ?></label>
                                        <select name="category_id" id="streamCategory" class="form-control form--control">
                                            <option value=""><?php echo app('translator')->get('Select Category'); ?></option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><?php echo app('translator')->get('Visibility'); ?> <span class="text-danger">*</span></label>
                                        <select name="visibility" id="streamVisibility" class="form-control form--control" required>
                                            <option value="public"><?php echo app('translator')->get('Public'); ?></option>
                                            <option value="unlisted"><?php echo app('translator')->get('Unlisted'); ?></option>
                                            <option value="private"><?php echo app('translator')->get('Private'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail Upload Section - YouTube Style -->
                    <div class="thumbnail-section">
                        <h4 class="thumbnail-heading"><?php echo app('translator')->get('Thumbnail'); ?></h4>
                        <p class="thumbnail-description">
                            <?php echo app('translator')->get('Select or upload a picture that represents your stream. A good thumbnail stands out and draws viewers\' attention.'); ?>
                            <a href="#" class="thumbnail-learn-more"><?php echo app('translator')->get('Learn more'); ?></a>
                        </p>
                        <div class="thumbnail-upload-container">
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
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn--base w-100" id="startStreamBtn">
                            <i class="las la-video"></i> <?php echo app('translator')->get('Start Live Stream'); ?>
                        </button>
                    </div>
                </form>

                <!-- Streaming Interface (Hidden Initially) - Full Width Style -->
                <div id="streamingInterface" style="display: none;">
                    <div class="streaming-container">
                        <!-- Video Preview Area -->
                        <div class="stream-preview">
                            <div id="cameraPlaceholder" class="camera-placeholder" style="display: none;">
                                <i class="las la-video-slash"></i>
                                <p><?php echo app('translator')->get('Camera not available'); ?></p>
                            </div>
                            <video id="localVideo" autoplay muted playsinline class="preview-video" style="display: none;"></video>
                            
                            <!-- Top Overlay: LIVE Badge, Timer, Viewers, Likes -->
                            <div class="preview-overlay-top">
                                <div class="live-badge-large">
                                    <span class="live-dot-large"></span>
                                    <span class="live-text-large">LIVE</span>
                                </div>
                                <div class="stream-stats">
                                    <span id="streamTimer" class="timer">0:00</span>
                                    <span class="stat-item">
                                        <i class="las la-user"></i>
                                        <span id="viewerCount">0</span>
                                    </span>
                                    <span class="stat-item">
                                        <i class="las la-thumbs-up"></i>
                                        <span id="likeCount">0</span>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Bottom Control Bar -->
                            <div class="preview-controls-bar">
                                <div class="controls-left">
                                    <div class="stream-health">
                                        <span class="health-dot active"></span>
                                        <span class="health-dot active"></span>
                                        <span class="health-dot active"></span>
                                        <span class="health-dot active"></span>
                                        <span class="health-dot active"></span>
                                    </div>
                                    <button class="control-btn" id="micToggle" title="<?php echo app('translator')->get('Microphone'); ?>">
                                        <i class="las la-microphone"></i>
                                    </button>
                                    <button class="control-btn" id="screenShareBtn" title="<?php echo app('translator')->get('Share screen'); ?>">
                                        <i class="las la-desktop"></i>
                                    </button>
                                    <button class="control-btn" id="shareBtn" title="<?php echo app('translator')->get('Share'); ?>">
                                        <i class="las la-share-alt"></i>
                                    </button>
                                </div>
                                <div class="controls-right">
                                    <button class="btn-end-stream" id="stopStreamBtn">
                                        <?php echo app('translator')->get('End stream'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Full-width streaming interface */
        #goLiveCard {
            max-width: 100%;
            margin: 0;
        }

        #streamingInterface .card-body {
            padding: 0;
        }

        /* Full Width Streaming Interface */
        .streaming-container {
            width: 100%;
            padding: 0;
            background: #0f0f0f;
            min-height: calc(100vh - 150px);
        }

        .stream-preview {
            width: 100%;
            position: relative;
            background: #0f0f0f;
            overflow: hidden;
            min-height: calc(100vh - 150px);
            display: flex;
            flex-direction: column;
        }

        .preview-video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #000;
            flex: 1;
        }

        .camera-placeholder {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #000;
            color: #fff;
        }

        .camera-placeholder i {
            font-size: 80px;
            color: #666;
            margin-bottom: 20px;
        }

        .camera-placeholder p {
            color: #999;
            font-size: 16px;
        }

        /* Top Overlay */
        .preview-overlay-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            background: linear-gradient(to bottom, rgba(0,0,0,0.7), transparent);
            z-index: 10;
        }

        .live-badge-large {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ff0000;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
        }

        .live-dot-large {
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .stream-stats {
            display: flex;
            align-items: center;
            gap: 20px;
            color: #fff;
            font-size: 14px;
        }

        .timer {
            font-weight: 600;
            font-size: 16px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-item i {
            font-size: 16px;
        }

        /* Bottom Control Bar */
        .preview-controls-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10;
        }

        .controls-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stream-health {
            display: flex;
            gap: 4px;
        }

        .health-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #666;
        }

        .health-dot.active {
            background: #4caf50;
            animation: pulse-green 2s infinite;
        }

        .control-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .control-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .control-btn.active {
            background: rgba(255, 255, 255, 0.3);
        }

        .controls-right {
            display: flex;
            gap: 10px;
        }

        .btn-end-stream {
            background: #000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-end-stream:hover {
            background: #1a1a1a;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes pulse-green {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        /* YouTube Style Thumbnail Section */
        .thumbnail-section {
            margin-top: 30px;
            padding: 20px;
            background: hsl(var(--card-bg));
            border-radius: 8px;
            border: 1px solid hsl(var(--border-color));
        }

        .thumbnail-heading {
            color: hsl(var(--heading-color));
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .thumbnail-description {
            color: hsl(var(--body-color));
            font-size: 14px;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .thumbnail-learn-more {
            color: #3ea6ff;
            text-decoration: none;
            margin-left: 4px;
        }

        .thumbnail-learn-more:hover {
            text-decoration: underline;
        }

        .thumbnail-upload-container {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .thumbnail-upload-box {
            width: 320px;
            height: 180px;
            background: hsl(var(--card-two-bg));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
            border: 2px dashed hsl(var(--border-color));
        }

        .thumbnail-upload-box:hover {
            background: hsl(var(--card-bg));
            border-color: #3ea6ff;
        }

        .thumbnail-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            width: 100%;
            height: 100%;
            gap: 12px;
        }

        .thumbnail-upload-icon {
            position: relative;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnail-upload-icon i:first-child {
            font-size: 48px;
            color: hsl(var(--body-color));
            opacity: 0.6;
        }

        .thumbnail-plus-icon {
            position: absolute;
            top: -4px;
            right: -4px;
            font-size: 20px;
            color: #fff;
            background: #3ea6ff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnail-upload-text {
            color: hsl(var(--body-color));
            font-size: 14px;
        }

        .thumbnail-preview-wrapper {
            position: relative;
            width: 320px;
            height: 180px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid hsl(var(--border-color));
        }

        .thumbnail-preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-remove-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
        }

        .thumbnail-remove-btn:hover {
            background: rgba(0, 0, 0, 0.9);
        }

        [data-theme="light"] .thumbnail-remove-btn {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        [data-theme="light"] .thumbnail-remove-btn:hover {
            background: rgba(255, 255, 255, 1);
        }

        .thumbnail-change-btn {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: background 0.2s;
        }

        .thumbnail-change-btn:hover {
            background: rgba(0, 0, 0, 0.9);
        }

        [data-theme="light"] .thumbnail-change-btn {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        [data-theme="light"] .thumbnail-change-btn:hover {
            background: rgba(255, 255, 255, 1);
        }

        /* End Stream Modal Styles */
        .end-stream-modal-content {
            background: #2a2a2a;
            color: #fff;
            border-radius: 12px;
            border: none;
        }

        .end-stream-modal-body {
            padding: 24px;
            text-align: center;
        }

        .end-stream-title {
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .end-stream-message {
            color: #aaa;
            font-size: 14px;
            margin: 0;
            line-height: 1.5;
        }

        .end-stream-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 16px 24px;
            border-top: 1px solid #333;
        }

        .btn-not-yet {
            background: #3a3a3a;
            border: 1px solid #444;
            color: #fff;
            padding: 10px 24px;
            border-radius: 4px;
            font-weight: 500;
        }

        .btn-not-yet:hover {
            background: #4a4a4a;
            color: #fff;
            border-color: #555;
        }

        .btn-end-confirm {
            background: #fff;
            border: none;
            color: #000;
            padding: 10px 24px;
            border-radius: 4px;
            font-weight: 600;
        }

        .btn-end-confirm:hover {
            background: #f0f0f0;
            color: #000;
        }

        /* Stream Finished Modal Styles */
        .stream-finished-content {
            background: #1a1a1a;
            color: #fff;
            border-radius: 12px;
        }

        .stream-finished-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #333;
            background: #2a2a2a;
        }

        .stream-finished-header h4 {
            margin: 0;
            color: #fff;
            font-size: 16px;
        }

        .stream-finished-body {
            padding: 20px;
        }

        .finished-video-preview {
            width: 100%;
            background: #000;
            border-radius: 8px;
            min-height: 300px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .video-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 300px;
            color: #666;
        }

        .video-placeholder i {
            font-size: 64px;
            margin-bottom: 15px;
        }

        .finished-video-preview video {
            width: 100%;
            height: auto;
            max-height: 400px;
        }

        .finished-stream-info {
            margin-bottom: 20px;
        }

        .finished-stream-info h3 {
            color: #fff;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .broadcaster-name {
            color: #aaa;
            font-size: 14px;
            margin: 0;
        }

        .stream-analytics {
            background: #2a2a2a;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .analytics-item {
            text-align: center;
        }

        .analytics-label {
            color: #aaa;
            font-size: 12px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .analytics-value {
            color: #fff;
            font-size: 20px;
            font-weight: 600;
        }

        .stream-finished-footer {
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            border-top: 1px solid #333;
        }

        .btn-dismiss {
            background: transparent;
            border: 1px solid #444;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-dismiss:hover {
            background: #333;
        }

        .btn-edit-studio {
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-edit-studio:hover {
            background: #0056b3;
            color: #fff;
        }


        @media (max-width: 768px) {
            .analytics-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <!-- End Stream Confirmation Modal -->
    <div class="modal fade" id="endStreamModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content end-stream-modal-content">
                <div class="modal-body end-stream-modal-body">
                    <h5 class="end-stream-title"><?php echo app('translator')->get('End Stream'); ?></h5>
                    <p class="end-stream-message"><?php echo app('translator')->get('Your stream will stop immediately and you will no longer be live.'); ?></p>
                </div>
                <div class="modal-footer end-stream-modal-footer">
                    <button type="button" class="btn btn-secondary btn-not-yet" data-bs-dismiss="modal"><?php echo app('translator')->get('Not yet'); ?></button>
                    <button type="button" class="btn btn-danger btn-end-confirm" id="confirmEndStreamBtn"><?php echo app('translator')->get('End'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stream Finished Modal -->
    <div class="modal fade" id="streamFinishedModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content stream-finished-content">
                <div class="stream-finished-header">
                    <h4><?php echo app('translator')->get('Stream Finished'); ?></h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="stream-finished-body">
                    <div class="finished-video-preview" id="finishedVideoPreview">
                        <div class="video-placeholder">
                            <i class="las la-video"></i>
                            <p><?php echo app('translator')->get('Processing recording...'); ?></p>
                        </div>
                    </div>
                    <div class="finished-stream-info">
                        <h3 id="finishedStreamTitle">-</h3>
                        <p class="broadcaster-name"><?php echo e(auth()->user()->channel_name ?? auth()->user()->username); ?></p>
                    </div>
                    <div class="stream-analytics">
                        <div class="analytics-grid">
                            <div class="analytics-item">
                                <div class="analytics-label"><?php echo app('translator')->get('Views'); ?></div>
                                <div class="analytics-value" id="analyticsViews">0</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label"><?php echo app('translator')->get('Avg. view duration'); ?></div>
                                <div class="analytics-value" id="analyticsAvgDuration">0:00</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label"><?php echo app('translator')->get('Peak concurrents'); ?></div>
                                <div class="analytics-value" id="analyticsPeak">0</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label"><?php echo app('translator')->get('Total likes'); ?></div>
                                <div class="analytics-value" id="analyticsLikes">0</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label"><?php echo app('translator')->get('New subscribers'); ?></div>
                                <div class="analytics-value" id="analyticsSubscribers">0</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label"><?php echo app('translator')->get('Total chats'); ?></div>
                                <div class="analytics-value" id="analyticsChats">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stream-finished-footer">
                    <button type="button" class="btn-dismiss" data-bs-dismiss="modal"><?php echo app('translator')->get('Dismiss'); ?></button>
                    <a href="#" id="editInStudioBtn" class="btn-edit-studio"><?php echo app('translator')->get('Edit in studio'); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        let mediaStream = null;
        let mediaRecorder = null;
        let streamId = null;
        let chunks = [];
        let streamStartTime = null;
        let streamTimerInterval = null;
        let isMicMuted = false;
        let currentStreamTitle = '';
        let currentStreamDescription = '';

        // Thumbnail upload functionality
        const thumbnailInput = document.getElementById('thumbnailInput');
        const thumbnailUploadBox = document.getElementById('thumbnailUploadBox');
        const thumbnailPreviewWrapper = document.getElementById('thumbnailPreviewWrapper');
        const thumbnailPreview = document.getElementById('thumbnailPreview');
        const removeThumbnailBtn = document.getElementById('removeThumbnailBtn');
        const changeThumbnailBtn = document.getElementById('changeThumbnailBtn');

        thumbnailInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        thumbnailPreview.src = e.target.result;
                        thumbnailUploadBox.style.display = 'none';
                        thumbnailPreviewWrapper.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('<?php echo app('translator')->get("Please select an image file"); ?>');
                    this.value = '';
                }
            }
        });

        removeThumbnailBtn.addEventListener('click', function() {
            thumbnailInput.value = '';
            thumbnailPreview.src = '';
            thumbnailUploadBox.style.display = 'flex';
            thumbnailPreviewWrapper.style.display = 'none';
        });

        changeThumbnailBtn.addEventListener('click', function() {
            thumbnailInput.click();
        });

        document.getElementById('goLiveForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const startBtn = document.getElementById('startStreamBtn');
            startBtn.disabled = true;
            startBtn.innerHTML = '<i class="las la-spinner la-spin"></i> <?php echo app('translator')->get("Starting..."); ?>';

            try {
                // Request camera and microphone access
                mediaStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: { ideal: 1280 },
                        height: { ideal: 720 },
                        facingMode: 'user'
                    },
                    audio: true
                });

                // Show local video
                const localVideo = document.getElementById('localVideo');
                const cameraPlaceholder = document.getElementById('cameraPlaceholder');
                
                if (mediaStream.getVideoTracks().length > 0) {
                    localVideo.srcObject = mediaStream;
                    localVideo.style.display = 'block';
                    cameraPlaceholder.style.display = 'none';
                } else {
                    cameraPlaceholder.style.display = 'flex';
                    localVideo.style.display = 'none';
                }

                // Start the stream on server with FormData to include thumbnail
                const response = await fetch('<?php echo e(route("user.live.start")); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    streamId = data.stream_id;
                    streamStartTime = new Date();
                    currentStreamTitle = formData.get('title');
                    currentStreamDescription = formData.get('description') || '';
                    
                    // Hide form and card header, show streaming interface
                    document.getElementById('goLiveForm').style.display = 'none';
                    document.getElementById('streamingInterface').style.display = 'block';
                    document.querySelector('#goLiveCard .card-header').style.display = 'none';

                    // Start MediaRecorder for local recording
                    startMediaRecorder();

                    // Start timer
                    startStreamTimer();

                    // Start updating viewer count
                    startViewerUpdates();
                } else {
                    alert('Failed to start stream. Please try again.');
                    startBtn.disabled = false;
                    startBtn.innerHTML = '<i class="las la-video"></i> <?php echo app('translator')->get("Start Live Stream"); ?>';
                }
            } catch (error) {
                console.error('Error accessing media devices:', error);
                alert('Unable to access camera/microphone. Please check permissions.');
                startBtn.disabled = false;
                startBtn.innerHTML = '<i class="las la-video"></i> <?php echo app('translator')->get("Start Live Stream"); ?>';
            }
        });

        let chunkIndex = 0;

        function setupMediaRecorder() {
            if (!mediaRecorder) return;
            
            mediaRecorder.ondataavailable = async function(event) {
                if (event.data.size > 0) {
                    chunks.push(event.data);
                    await uploadChunk(event.data, chunkIndex);
                    chunkIndex++;
                }
            };
            
            mediaRecorder.onstop = async function() {
                if (chunks.length > 0) {
                    const finalBlob = new Blob(chunks, { type: 'video/webm' });
                    await uploadChunk(finalBlob, chunkIndex, true);
                    chunks = [];
                }
            };
        }

        function startMediaRecorder() {
            try {
                const options = { mimeType: 'video/webm;codecs=vp8,opus' };
                mediaRecorder = new MediaRecorder(mediaStream, options);
                setupMediaRecorder();
                
                // Start recording with 5 second intervals for better chunk management
                mediaRecorder.start(5000); // Collect data every 5 seconds
            } catch (error) {
                console.error('MediaRecorder error:', error);
            }
        }

        async function uploadChunk(chunkData, index, isFinal = false) {
            if (!streamId) return;

            try {
                const formData = new FormData();
                const blob = chunkData instanceof Blob ? chunkData : new Blob([chunkData], { type: 'video/webm' });
                formData.append('chunk', blob, `chunk_${index}.webm`);
                formData.append('chunk_index', index);
                formData.append('is_final', isFinal ? '1' : '0');

                const response = await fetch(`<?php echo e(url('user/live/upload-chunk')); ?>/${streamId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    console.log(`Chunk ${index} uploaded successfully`);
                }
            } catch (error) {
                console.error('Error uploading chunk:', error);
            }
        }

        function startStreamTimer() {
            streamTimerInterval = setInterval(() => {
                if (streamStartTime) {
                    const elapsed = Math.floor((new Date() - streamStartTime) / 1000);
                    const minutes = Math.floor(elapsed / 60);
                    const seconds = elapsed % 60;
                    document.getElementById('streamTimer').textContent = 
                        `${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
            }, 1000);
        }

        function startViewerUpdates() {
            setInterval(async () => {
                if (streamId) {
                    try {
                        const response = await fetch(`<?php echo e(url('live/stream-info')); ?>/${streamId}`);
                        const data = await response.json();
                        if (data.success && data.stream) {
                            document.getElementById('viewerCount').textContent = data.stream.viewers_count;
                        }
                    } catch (error) {
                        console.error('Error updating viewer count:', error);
                    }
                }
            }, 5000); // Update every 5 seconds
        }

        // Microphone toggle
        document.getElementById('micToggle').addEventListener('click', function() {
            if (mediaStream) {
                const audioTracks = mediaStream.getAudioTracks();
                if (audioTracks.length > 0) {
                    isMicMuted = !isMicMuted;
                    audioTracks[0].enabled = !isMicMuted;
                    this.classList.toggle('active', isMicMuted);
                    this.innerHTML = isMicMuted 
                        ? '<i class="las la-microphone-slash"></i>' 
                        : '<i class="las la-microphone"></i>';
                }
            }
        });

        // Screen sharing functionality
        let screenStream = null;
        let isScreenSharing = false;
        const screenShareBtn = document.getElementById('screenShareBtn');
        
        screenShareBtn.addEventListener('click', async function() {
            try {
                if (!isScreenSharing) {
                    // Start screen sharing
                    screenStream = await navigator.mediaDevices.getDisplayMedia({
                        video: {
                            cursor: 'always',
                            displaySurface: 'browser'
                        },
                        audio: true
                    });
                    
                    // Replace video source with screen share
                    const localVideo = document.getElementById('localVideo');
                    localVideo.srcObject = screenStream;
                    localVideo.style.display = 'block';
                    
                    // Update MediaRecorder to use screen stream
                    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                        mediaRecorder.stop();
                    }
                    
                    // Create new MediaRecorder with screen stream
                    const options = { mimeType: 'video/webm;codecs=vp8,opus' };
                    mediaRecorder = new MediaRecorder(screenStream, options);
                    
                    // Restart recording with screen stream
                    setupMediaRecorder();
                    mediaRecorder.start(5000);
                    
                    isScreenSharing = true;
                    this.classList.add('active');
                    this.title = '<?php echo app('translator')->get("Stop sharing screen"); ?>';
                    
                    // Handle when user stops sharing via browser UI
                    screenStream.getVideoTracks()[0].addEventListener('ended', () => {
                        stopScreenShare();
                    });
                } else {
                    // Stop screen sharing
                    stopScreenShare();
                }
            } catch (error) {
                console.error('Error sharing screen:', error);
                if (error.name === 'NotAllowedError') {
                    alert('<?php echo app('translator')->get("Screen sharing was denied. Please allow screen sharing permission."); ?>');
                } else {
                    alert('<?php echo app('translator')->get("Failed to share screen. Please try again."); ?>');
                }
            }
        });
        
        function stopScreenShare() {
            if (screenStream) {
                screenStream.getTracks().forEach(track => track.stop());
                screenStream = null;
            }
            
            // Switch back to camera
            if (mediaStream) {
                const localVideo = document.getElementById('localVideo');
                localVideo.srcObject = mediaStream;
                
                // Restart MediaRecorder with camera stream
                if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                    mediaRecorder.stop();
                }
                
                const options = { mimeType: 'video/webm;codecs=vp8,opus' };
                mediaRecorder = new MediaRecorder(mediaStream, options);
                setupMediaRecorder();
                mediaRecorder.start(5000);
            }
            
            isScreenSharing = false;
            screenShareBtn.classList.remove('active');
            screenShareBtn.title = '<?php echo app('translator')->get("Share screen"); ?>';
        }

        // Share button
        document.getElementById('shareBtn').addEventListener('click', function() {
            if (streamId) {
                const watchUrl = `<?php echo e(url('live/watch')); ?>/${streamId}`;
                if (navigator.share) {
                    navigator.share({
                        title: currentStreamTitle || 'Live Stream',
                        url: watchUrl
                    });
                } else {
                    // Copy to clipboard
                    navigator.clipboard.writeText(watchUrl).then(() => {
                        alert('<?php echo app('translator')->get("Stream URL copied to clipboard!"); ?>');
                    }).catch(() => {
                        // Fallback for older browsers
                        const textarea = document.createElement('textarea');
                        textarea.value = watchUrl;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                        alert('<?php echo app('translator')->get("Stream URL copied to clipboard!"); ?>');
                    });
                }
            }
        });

        // Show Stream Finished Modal
        function showStreamFinishedModal(streamId) {
            // Fetch stream details
            fetch(`<?php echo e(url('live/stream-info')); ?>/${streamId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.stream) {
                        const stream = data.stream;
                        
                        // Update modal content
                        document.getElementById('finishedStreamTitle').textContent = stream.title || '-';
                        document.getElementById('analyticsViews').textContent = stream.viewers_count || 0;
                        document.getElementById('analyticsPeak').textContent = stream.peak_viewers || 0;
                        document.getElementById('analyticsLikes').textContent = '0'; // TODO: Add likes
                        document.getElementById('analyticsSubscribers').textContent = '0'; // TODO: Add subscribers
                        document.getElementById('analyticsChats').textContent = '0'; // TODO: Add chat count
                        
                        // Calculate avg duration (simplified)
                        if (stream.recorded_duration) {
                            const minutes = Math.floor(stream.recorded_duration / 60);
                            const seconds = stream.recorded_duration % 60;
                            document.getElementById('analyticsAvgDuration').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                        }
                        
                        // Show video if recorded
                        const previewDiv = document.getElementById('finishedVideoPreview');
                        if (stream.recorded_video) {
                            previewDiv.innerHTML = `
                                <video controls style="width: 100%; height: auto; max-height: 400px;">
                                    <source src="<?php echo e(url('live/recording')); ?>/${streamId}" type="video/webm">
                                </video>
                            `;
                        }
                        
                        // Set edit button link
                        document.getElementById('editInStudioBtn').href = `<?php echo e(route('user.live.manage')); ?>`;
                        
                        // Show modal
                        const modal = new bootstrap.Modal(document.getElementById('streamFinishedModal'));
                        modal.show();
                        
                        // Redirect to manage page when modal is closed
                        document.getElementById('streamFinishedModal').addEventListener('hidden.bs.modal', function() {
                            window.location.href = '<?php echo e(route("user.live.manage")); ?>';
                        }, { once: true });
                    }
                })
                .catch(error => {
                    console.error('Error fetching stream info:', error);
                    // Still show modal with basic info
                    const modal = new bootstrap.Modal(document.getElementById('streamFinishedModal'));
                    modal.show();
                });
        }

        // Show End Stream confirmation modal
        document.getElementById('stopStreamBtn').addEventListener('click', function() {
            const endStreamModal = new bootstrap.Modal(document.getElementById('endStreamModal'));
            endStreamModal.show();
        });

        // Handle End Stream confirmation
        document.getElementById('confirmEndStreamBtn').addEventListener('click', async function() {
            const endStreamModal = bootstrap.Modal.getInstance(document.getElementById('endStreamModal'));
            const confirmBtn = this;
            
            // Disable button to prevent double clicks
            confirmBtn.disabled = true;
            confirmBtn.textContent = '<?php echo app('translator')->get("Ending..."); ?>';

            if (streamId) {
                try {
                    // Stop the stream on server IMMEDIATELY (like YouTube)
                    const response = await fetch(`<?php echo e(url('user/live/stop')); ?>/${streamId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        }
                    });

                    const data = await response.json();
                    
                    // Close the end stream modal
                    endStreamModal.hide();
                    
                    if (data.success) {
                        // Stop timer immediately
                        if (streamTimerInterval) {
                            clearInterval(streamTimerInterval);
                        }
                        
                        // Stop screen sharing if active
                        if (isScreenSharing && screenStream) {
                            stopScreenShare();
                        }
                        
                        // Stop media stream immediately
                        if (mediaStream) {
                            mediaStream.getTracks().forEach(track => track.stop());
                        }

                        // Stop media recorder in background (don't wait for it)
                        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                            mediaRecorder.stop();
                            // Let it finish in background, don't wait
                        }

                        // Show Stream Finished modal
                        showStreamFinishedModal(data.stream_id);
                    } else {
                        alert('<?php echo app('translator')->get("Failed to end stream. Please try again."); ?>');
                        confirmBtn.disabled = false;
                        confirmBtn.textContent = '<?php echo app('translator')->get("End"); ?>';
                    }
                } catch (error) {
                    console.error('Error stopping stream:', error);
                    endStreamModal.hide();
                    alert('<?php echo app('translator')->get("Error ending stream. Please try again."); ?>');
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = '<?php echo app('translator')->get("End"); ?>';
                }
            } else {
                endStreamModal.hide();
                confirmBtn.disabled = false;
                confirmBtn.textContent = '<?php echo app('translator')->get("End"); ?>';
            }
        });

        // Reset button when modal is closed without confirming
        document.getElementById('endStreamModal').addEventListener('hidden.bs.modal', function() {
            const confirmBtn = document.getElementById('confirmEndStreamBtn');
            confirmBtn.disabled = false;
            confirmBtn.textContent = '<?php echo app('translator')->get("End"); ?>';
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/live/go_live.blade.php ENDPATH**/ ?>