@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <div class="play-body">
        <div class="play-video">
            <div class="primary ps-0">
                @php
                    // Handle both numeric and string status values
                    $rawStatus = $liveStream->status;
                    if (is_numeric($rawStatus)) {
                        $statusMap = [0 => 'scheduled', 1 => 'live', 2 => 'ended', 3 => 'cancelled'];
                        $actualStatus = $statusMap[$rawStatus] ?? 'ended';
                    } else {
                        $actualStatus = $rawStatus;
                    }
                    
                    $isLive = ($actualStatus === 'live');
                    $isScheduled = ($actualStatus === 'scheduled');
                    $isEnded = ($actualStatus === 'ended' || $actualStatus === 'cancelled');
                    
                    // Check if recorded video exists
                    $hasRecording = false;
                    $recordingPath = null;
                    if ($liveStream->recorded_video) {
                        $recordingPath = public_path($liveStream->recorded_video);
                        $hasRecording = file_exists($recordingPath);
                    }
                @endphp

                <div class="primary__videoPlayer video-item__thumb mainVideo" data-live-stream-id="{{ $liveStream->id }}">
                    @if($isLive)
                        <div id="live-stream-player" class="live-stream-container">
                            <div class="live-stream-placeholder">
                                <div class="stream-status">
                                    <div class="live-icon">
                                        <span class="live-dot-large"></span>
                                        <i class="las la-video"></i>
                                    </div>
                                    <h3>@lang('Stream is Live!')</h3>
                                    <p>@lang('The broadcaster is currently streaming.')</p>
                                </div>
                            </div>
                            <div class="live-indicator">
                                <span class="live-dot"></span>
                                <span class="live-text">LIVE</span>
                            </div>
                        </div>
                    @elseif($isScheduled)
                        <div class="scheduled-stream">
                            <div class="scheduled-content">
                                <i class="las la-clock" style="font-size: 48px; color: #fff; margin-bottom: 20px;"></i>
                                <h3>@lang('Stream Scheduled')</h3>
                                <p>@lang('This stream is scheduled to start at')</p>
                                <p class="scheduled-time">{{ $liveStream->scheduled_at ? showDateTime($liveStream->scheduled_at, 'F d, Y h:i A') : '-' }}</p>
                            </div>
                        </div>
                    @elseif($hasRecording && $recordingPath)
                        {{-- Show recorded video exactly like regular videos --}}
                        <video class="video-player" data-amount="0" muted playsinline
                            preload="metadata" 
                            data-db-duration="{{ $liveStream->recorded_duration ?? 0 }}">
                            <source src="{{ url('live/recording/' . $liveStream->id) }}?t={{ time() }}" type="video/webm">
                            <source src="{{ url('live/recording/' . $liveStream->id) }}?t={{ time() }}" type="video/mp4">
                            @lang('Your browser does not support the video tag.')
                        </video>
                        @include('Template::partials.video.video_loader')
                    @else
                        <div class="ended-stream">
                            <div class="ended-content">
                                <i class="las la-stop-circle" style="font-size: 48px; color: #fff; margin-bottom: 20px;"></i>
                                <h3>@lang('Stream Ended')</h3>
                                <p>@lang('This live stream has ended.')</p>
                                @if($liveStream->ended_at)
                                    <p class="ended-time">@lang('Ended at') {{ showDateTime($liveStream->ended_at, 'F d, Y h:i A') }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="ad-wrapper position-relative adVideo d-none">
                </div>

                <div class="primary__video-content">
                    <h4 class="primary__vtitle">{{ __($liveStream->title) }}</h4>

                    <div class="primary__videometa">
                        <div class="items">
                            <span class="view">
                                <span class="icon"><i class="fa-regular fa-eye"></i></span>
                                {{ formatNumber($liveStream->viewers_count) }} @lang('views')
                            </span>
                            @if($liveStream->started_at)
                                <span class="date">
                                    <span class="icon"><i class="fa-regular fa-clock"></i></span>
                                    {{ $liveStream->started_at->diffForHumans() }}
                                </span>
                            @else
                                <span class="date">
                                    <span class="icon"><i class="fa-regular fa-clock"></i></span>
                                    {{ $liveStream->created_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                        <div class="meta-buttons">
                            <div class="meta-react-wrapper">
                                <div class="meta-react-inner">
                                    <button class="meta-buttons__button" disabled>
                                        <span class="icon"><i class="vti-like"></i></span>
                                        <span class="text">0</span>
                                    </button>
                                    <button class="meta-buttons__button" disabled>
                                        <span class="icon"><i class="vti-dislike"></i></span>
                                    </button>
                                </div>
                            </div>
                            <button class="meta-buttons__button shareBtn" data-bs-toggle="modal" data-bs-target="#shareModal">
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" fill="currentColor" clip-rule="evenodd"
                                            d="M4 11c.55228 0 1 .4477 1 1v8a.99997.99997 0 0 0 1 1h12c.2652 0 .5196-.1054.7071-.2929A1.0001 1.0001 0 0 0 19 20v-8c0-.5523.4477-1 1-1s1 .4477 1 1v8a2.9999 2.9999 0 0 1-.8787 2.1213A2.9999 2.9999 0 0 1 18 23H6a3.00006 3.00006 0 0 1-3-3v-8c0-.5523.44772-1 1-1Zm8-10c.2652 0 .5196.10536.7071.29289l4 4c.3905.39053.3905 1.02369 0 1.41422-.3905.39052-1.0237.39052-1.4142 0L12 3.41421l-3.29289 3.2929c-.39053.39052-1.02369.39052-1.41422 0-.39052-.39053-.39052-1.02369 0-1.41422l4.00001-4A.99997.99997 0 0 1 12 1Z">
                                        </path>
                                        <path fill-rule="evenodd"
                                            d="M12 1c.5523 0 1 .44772 1 1v13c0 .5523-.4477 1-1 1s-1-.4477-1-1V2c0-.55228.4477-1 1-1Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <span class="text">@lang('Share')</span>
                            </button>
                        </div>
                    </div>
                    <div class="primary__channel">
                        <div class="author">
                            <a class="author__thumb" href="{{ route('preview.channel', $liveStream->user->slug) }}">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . $liveStream->user->image, isAvatar: true) }}"
                                    alt="image">
                            </a>
                            <div class="author__content">
                                <a href="{{ route('preview.channel', $liveStream->user->slug) }}" class="channel-name">
                                    {{ $liveStream->user->channel_name ? $liveStream->user->channel_name : $liveStream->user->fullname }}
                                </a>
                                <span class="author__subscriber">
                                    <span class="subscriberCount">{{ formatNumber($liveStream->user->subscribers()->count()) }}</span>
                                    @lang('Subscriber')
                                </span>
                            </div>
                        </div>

                        @if (auth()->check() && auth()->id() != $liveStream->user_id)
                            @php
                                $subscribed = $liveStream->user
                                    ->subscribers()
                                    ->where('following_id', auth()->id())
                                    ->exists();
                            @endphp
                            <div class="subscriber-btn">
                                <button
                                    class="btn cta @if (!$subscribed) btn--white subcriberBtn @else  btn--white outline unSubcriberBtn @endif">
                                    @if (!$subscribed)
                                        @lang('Subscribe')
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
                                    @else
                                        @lang('Unsubscribe')
                                    @endif
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="primary__desc">
                        <div class="primary__desc-text">
                            @if($liveStream->description)
                                {{ __($liveStream->description) }}
                            @else
                                @lang('No description available.')
                            @endif
                        </div>
                    </div>

                    <div class="primary__comment d-none d-xl-block">
                        <div class="top">
                            <h5 class="comment-number">
                                <span class="commentCount" id="comments-count">0</span> @lang('Comments')
                            </h5>
                        </div>
                        @if (auth()->check())
                            <div class="comment-form-wrapper">
                                <span class="comment-author">
                                    <img class="fir-image"
                                        src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()->image, isAvatar: true) }}"
                                        alt="image">
                                </span>
                                <form class="comment-form" id="commentForm">
                                    @csrf
                                    <div class="form-group position-relative">
                                        <textarea class="form--control commentBox" name="comment" placeholder="@lang('Add a comment')"></textarea>
                                        <button class="comment-btn" type="submit">
                                            <svg class="lucide lucide-send-horizontal" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z" />
                                                <path d="M6 12h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="primary__comment-list comment-box__content d-none d-xl-block">
                        <div class="comment-bow-wrapper" id="commentsContainer">
                            <!-- Comments will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="secondary">
                {{-- Related videos or other content can go here --}}
            </div>
        </div>
    </div>

    @php
        // Create video object with all required properties for the modal
        $videoForModal = (object)[
            'id' => $liveStream->id, 
            'slug' => $liveStream->slug, 
            'title' => $liveStream->title,
            'price' => 0, // Live streams are free
            'playlists' => collect([]) // Live streams don't have playlists
        ];
    @endphp
    @include('Template::partials.play_video_page_modal', [
        'video' => $videoForModal,
        'playlists' => $playlists ?? collect([]),
        'isLiveStream' => true, // Flag to use live routes instead of video routes
        'watchRoute' => route('live.watch', [$liveStream->id, $liveStream->slug])
    ])

@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/plyr.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/plyr.js') }}"></script>
@endpush

@push('style')
    <style>
        .live-stream-container {
            position: relative;
            width: 100%;
            background: #000;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .live-stream-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .stream-status {
            text-align: center;
            color: #fff;
        }

        .live-icon {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .live-icon i {
            font-size: 64px;
            color: #fff;
            position: relative;
            z-index: 2;
        }

        .live-dot-large {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: rgba(255, 0, 0, 0.3);
            border-radius: 50%;
            animation: pulse-large 2s infinite;
            z-index: 1;
        }

        @keyframes pulse-large {
            0%, 100% { 
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.3;
            }
            50% { 
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0.1;
            }
        }

        .live-indicator {
            position: absolute;
            top: 15px;
            left: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 0, 0, 0.9);
            padding: 6px 12px;
            border-radius: 4px;
            z-index: 10;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .live-text {
            color: #fff;
            font-weight: bold;
            font-size: 12px;
        }

        .scheduled-stream, .ended-stream {
            width: 100%;
            min-height: 500px;
            background: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .scheduled-content, .ended-content {
            text-align: center;
        }

        .scheduled-time, .ended-time {
            font-size: 18px;
            color: #ff6b6b;
            margin-top: 10px;
        }
    </style>
@endpush

@push('script')
    <script>
        const streamId = {{ $liveStream->id }};
        let commentsInterval = null;
        let statusCheckInterval = null;
        let wasLive = {{ $isLive ? 'true' : 'false' }};
        
        // Load comments
        function loadComments() {
            fetch(`{{ url('live/comments') }}/${streamId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById('commentsContainer');
                        const countEl = document.getElementById('comments-count');
                        
                        if (countEl) {
                            countEl.textContent = data.comments.length;
                        }
                        
                        if (container) {
                            container.innerHTML = '';
                            data.comments.forEach(comment => {
                                const commentEl = document.createElement('div');
                                commentEl.className = 'comment-item';
                                commentEl.innerHTML = `
                                    <div class="comment-author">
                                        <img src="${comment.user_image || ''}" alt="${comment.user_name}">
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-header">
                                            <span class="comment-author-name">${comment.user_name}</span>
                                            <span class="comment-time">${comment.time_ago}</span>
                                        </div>
                                        <div class="comment-text">${comment.comment}</div>
                                    </div>
                                `;
                                container.appendChild(commentEl);
                            });
                        }
                    }
                })
                .catch(error => console.error('Error loading comments:', error));
        }

        // Submit comment
        document.getElementById('commentForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const commentText = formData.get('comment');
            
            if (!commentText.trim()) return;

            fetch(`{{ url('live/comment') }}/${streamId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ comment: commentText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.querySelector('.commentBox').value = '';
                    loadComments();
                }
            })
            .catch(error => console.error('Error posting comment:', error));
        });

        // Load comments on page load
        if (wasLive) {
            loadComments();
            commentsInterval = setInterval(loadComments, 3000);
        }

        // Check stream status
        function checkStreamStatus() {
            fetch(`{{ url('live/stream-info') }}/${streamId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.stream) {
                        const isLive = data.stream.status === 'live' || data.stream.status === 1;
                        if (!isLive && wasLive) {
                            wasLive = false;
                            if (commentsInterval) {
                                clearInterval(commentsInterval);
                            }
                            location.reload();
                        }
                    }
                })
                .catch(error => console.error('Error checking status:', error));
        }

        if (wasLive) {
            statusCheckInterval = setInterval(checkStreamStatus, 5000);
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (commentsInterval) clearInterval(commentsInterval);
            if (statusCheckInterval) clearInterval(statusCheckInterval);
        });

        // Initialize Plyr video player for recorded videos (same as regular videos)
        $(document).ready(function() {
            const videoPlayer = document.querySelector('.video-player');
            if (videoPlayer) {
                const controls = [
                    'rewind',
                    'play',
                    'fast-forward',
                    'progress',
                    'current-time',
                    'duration',
                    'mute',
                    'volume',
                    'settings',
                    'fullscreen',
                    'pip',
                ];

                let singleplayer = null;
                let progressUpdateInterval = null;
                
                // Get database duration (most accurate)
                const dbDuration = parseInt(videoPlayer.getAttribute('data-db-duration')) || 0;
                let useDbDuration = dbDuration > 0;

                // Helper function to format time as mm:ss
                function formatTime(seconds) {
                    if (!isFinite(seconds) || isNaN(seconds) || seconds < 0) {
                        return '00:00';
                    }
                    const mins = Math.floor(seconds / 60);
                    const secs = Math.floor(seconds % 60);
                    return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                }

                // Helper function to check if duration is valid
                function isValidDuration(duration) {
                    return isFinite(duration) && !isNaN(duration) && duration > 0;
                }
                
                // Function to get the duration to use (prefer video file duration, it's more accurate)
                function getDuration() {
                    const videoDuration = videoPlayer.duration;
                    
                    // Always prefer video file duration if available (it's the actual video length)
                    if (isValidDuration(videoDuration)) {
                        // If video duration differs significantly from database, use video duration
                        // (video file duration is always more accurate)
                        if (dbDuration > 0 && Math.abs(videoDuration - dbDuration) > 2) {
                            console.log('Video duration (' + videoDuration + 's) differs from database (' + dbDuration + 's), using video duration');
                            // Update database with correct duration via AJAX
                            updateDatabaseDuration(videoDuration);
                        }
                        return videoDuration;
                    }
                    
                    // Fallback to database duration if video duration not available yet
                    return dbDuration > 0 ? dbDuration : 0;
                }
                
                // Function to update database with correct duration
                function updateDatabaseDuration(correctDuration) {
                    fetch('{{ url("live/update-duration") }}/{{ $liveStream->id }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ duration: Math.round(correctDuration) })
                    }).catch(err => console.log('Could not update duration:', err));
                }

                // Function to update progress bar and duration display
                function updateProgress() {
                    if (!videoPlayer || !singleplayer) return;
                    
                    const duration = getDuration();
                    const currentTime = videoPlayer.currentTime;
                    
                    // Update duration display - use database duration immediately
                    if (duration > 0) {
                        const durationElements = document.querySelectorAll('.plyr__time--duration');
                        durationElements.forEach(function(el) {
                            el.textContent = formatTime(duration);
                        });
                    }
                    
                    // Update progress bar
                    if (duration > 0 && currentTime >= 0) {
                        const progressBar = singleplayer.elements?.progress?.querySelector('.plyr__progress__played');
                        if (progressBar) {
                            const percent = Math.min(100, Math.max(0, (currentTime / duration) * 100));
                            progressBar.style.width = percent + '%';
                        }
                        
                        // Update buffer if available
                        const progressBuffer = singleplayer.elements?.progress?.querySelector('.plyr__progress__buffer');
                        if (progressBuffer && videoPlayer.buffered.length > 0) {
                            const bufferedEnd = videoPlayer.buffered.end(videoPlayer.buffered.length - 1);
                            const bufferedPercent = Math.min(100, Math.max(0, (bufferedEnd / duration) * 100));
                            progressBuffer.style.width = bufferedPercent + '%';
                        }
                    }
                }

                try {
                    singleplayer = new Plyr('.video-player', {
                        controls,
                        ratio: '16:9',
                        autoplay: false,
                        clickToPlay: true,
                    });

                    // Unmute on user interaction
                    singleplayer.on('ready', function() {
                        console.log('Plyr player ready, database duration:', dbDuration);
                        singleplayer.muted = false;
                        
                        // Set duration immediately from database
                        if (dbDuration > 0) {
                            updateProgress();
                        }
                    });

                    // Handle loadedmetadata event - duration is now available
                    videoPlayer.addEventListener('loadedmetadata', function() {
                        console.log('Video metadata loaded, duration:', videoPlayer.duration);
                        updateProgress();
                    });

                    // Handle timeupdate event - continuously update progress during playback
                    videoPlayer.addEventListener('timeupdate', function() {
                        updateProgress();
                    }, { passive: true });

                    // Handle seeked event - update after seeking
                    videoPlayer.addEventListener('seeked', function() {
                        console.log('Video seeked, current time:', videoPlayer.currentTime);
                        updateProgress();
                    });

                    // Also listen to Plyr's timeupdate event
                    singleplayer.on('timeupdate', function() {
                        updateProgress();
                    });

                    // Listen for duration changes
                    videoPlayer.addEventListener('durationchange', function() {
                        console.log('Duration changed:', videoPlayer.duration);
                        updateProgress();
                    });

                    // Listen for loadeddata event
                    videoPlayer.addEventListener('loadeddata', function() {
                        console.log('Video data loaded, duration:', videoPlayer.duration);
                        updateProgress();
                    });

                    // Listen for canplay event
                    videoPlayer.addEventListener('canplay', function() {
                        console.log('Video can play, duration:', videoPlayer.duration);
                        updateProgress();
                    });

                    // Set up continuous update interval during playback for smoother updates
                    singleplayer.on('play', function() {
                        console.log('Video playing, duration:', videoPlayer.duration);
                        updateProgress();
                        
                        // Set up interval for smooth progress updates
                        if (!progressUpdateInterval) {
                            progressUpdateInterval = setInterval(function() {
                                if (!videoPlayer.paused) {
                                    updateProgress();
                                }
                            }, 100); // Update every 100ms for smooth progress
                        }
                    });

                    // Clear interval when paused
                    singleplayer.on('pause', function() {
                        if (progressUpdateInterval) {
                            clearInterval(progressUpdateInterval);
                            progressUpdateInterval = null;
                        }
                        updateProgress();
                    });

                    // Hide loader when video is ready
                    const loader = document.getElementById('loader');
                    if (loader) {
                        singleplayer.on('canplay', function() {
                            loader.style.display = 'none';
                        });
                        singleplayer.on('loadeddata', function() {
                            loader.style.display = 'none';
                        });
                        singleplayer.on('loadedmetadata', function() {
                            loader.style.display = 'none';
                        });
                    }

                    // Handle video errors
                    singleplayer.on('error', function(event) {
                        console.error('Video error:', event);
                        if (loader) {
                            loader.innerHTML = '<p style="color: #fff; padding: 20px;">Error loading video. Please try refreshing the page.</p>';
                        }
                    });

                    // Force video to load metadata
                    videoPlayer.load();
                } catch (error) {
                    console.error('Plyr initialization error:', error);
                    // Fallback: use native video controls
                    if (videoPlayer) {
                        videoPlayer.controls = true;
                        videoPlayer.load();
                    }
                }
            }
        });
    </script>
@endpush
