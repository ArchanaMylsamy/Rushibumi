@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="home-body">
        <!-- Google AdSense - Top Banner (Full Width) -->
        <div class="adsense-top-banner">
            <div class="ad-shimmer"></div>
            <div class="ad-content">
                <span class="ad-badge">Advertisement</span>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-3940256099942544"
                     data-ad-slot="6300978111"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
            </div>
        </div>

        @if (!blank($trendingVideos))
            <x-home-body-title icon="vti-top" title="Trending" />

            <section class="trending-section">
                <div class="video-item-wrapper">
                    @include($activeTemplate . 'partials.video.video_list', ['videos' => $trendingVideos])
                </div>
            </section>
        @endif

        @if (!blank($shortVideos))
            <x-home-body-title icon="vti-short" title="Shorts" />
            <section class="shorts-section">
                <div class="row gy-4">
                    <div class="col-lg-12">
                        <div class="short_slider owl-carousel">
                            @include($activeTemplate . 'partials.video.shorts_list', [
                                'shortVideos' => $shortVideos,
                            ])
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if (!blank($videos))
            <x-home-body-title icon="vti-video" title="Videos" />

            <div class="video-wrapper">
                @include($activeTemplate . 'partials.video.video_list', ['videos' => $videos])
            </div>
            <div class="text-center d-none spinner mt-4 w-100" id="loading-spinner">
                <i class="las la-spinner"></i>
            </div>
        @endif

        @if (blank($trendingVideos) && blank($shortVideos) && blank($videos))
            <div class="empty-container">
                @include('Template::partials.empty')
            </div>
        @endif
    </div>
@endsection

@push('style')
    <style>
        .spinner {
            text-align: center;
            margin-top: 20px;
        }

        .spinner i {
            font-size: 45px;
            color: #ff0000;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Google AdSense - Top Banner Only */
        .adsense-top-banner {
            width: 100%;
            background: rgba(var(--base-rgb), 0.03);
            border: 1px solid rgba(var(--base-rgb), 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            min-height: 100px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .adsense-top-banner:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .ad-shimmer {
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.1) 50%, 
                transparent 100%
            );
            animation: shimmerMove 4s infinite;
        }

        @keyframes shimmerMove {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .ad-content {
            position: relative;
            z-index: 2;
            width: 100%;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ad-badge {
            position: absolute;
            top: -10px;
            left: 20px;
            background: hsl(var(--base));
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 3;
        }

        /* Light Theme */
        [data-theme="light"] .adsense-top-banner {
            background: rgba(0, 0, 0, 0.02);
            border-color: rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .ad-shimmer {
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(0, 0, 0, 0.05) 50%, 
                transparent 100%
            );
        }

        /* Dark Theme */
        [data-theme="dark"] .adsense-top-banner {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.08);
        }

        [data-theme="dark"] .ad-shimmer {
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.08) 50%, 
                transparent 100%
            );
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .adsense-top-banner {
                min-height: 80px;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 10px;
            }

            .ad-content {
                min-height: 50px;
            }

            .ad-badge {
                font-size: 9px;
                padding: 5px 12px;
                letter-spacing: 1.2px;
            }
        }

        @media (max-width: 480px) {
            .adsense-top-banner {
                min-height: 60px;
                padding: 12px;
                border-radius: 8px;
            }

            .ad-badge {
                font-size: 8px;
                padding: 4px 10px;
                letter-spacing: 1px;
                left: 15px;
            }
        }

        /* AdSense Container */
        .adsbygoogle {
            width: 100%;
            display: block !important;
        }
    </style>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/plyr.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/plyr.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';

        const controls = [];

        $(document).ready(function() {
            playersInitiate();
            
            // Initialize Google AdSense Ad
            setTimeout(function() {
                try {
                    (adsbygoogle = window.adsbygoogle || []).push({});
                } catch (e) {
                    console.log('AdSense initialization:', e);
                }
            }, 100);
        });

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

        $(document).ready(function() {
            const shortPlayers = Plyr.setup('.shorts-video-player', {
                controls,
                ratio: '9:16',
                muted: true,
            });
        });

        let currentPage = "{{ $videos->currentPage() }}";
        let url = "{{ route('video.get') }}";

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 5 && !lastPage) {
                currentPage++;
                loadMoreVideos(url, currentPage);
            }
        });
    </script>
@endpush
