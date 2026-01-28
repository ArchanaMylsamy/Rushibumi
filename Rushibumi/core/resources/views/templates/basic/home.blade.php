@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="home-body">
        {{-- Top Banner: Show Feed Ad (Top Position) if available, otherwise show Google AdSense --}}
        @php
            $hasTopAds = isset($topAds) && $topAds->count() > 0;
            // Randomly select one top ad from all available top ads
            $selectedTopAd = $hasTopAds ? $topAds->random() : null;
        @endphp

        @if($hasTopAds && $selectedTopAd)
            {{-- Show Feed Ad as Top Banner (randomly selected) --}}
            @include($activeTemplate . 'partials.video.top_ad_banner', ['topAd' => $selectedTopAd])
        @else
            {{-- Show Google AdSense Banner --}}
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
        @endif

        {{-- Top Ad from Feed Ads - will be shown at the beginning of videos grid --}}
 
        @php
            // Create varied pattern: multiple rows, then shorts, then one row, then shorts, etc.
            $videosPerRow = 3;
            $hasShorts = !blank($shortVideos);
            $hasVideos = !blank($allVideos);
           
            // Pattern: [rows_count, rows_count, rows_count, ...]
            // Example: [2, 1, 3, 1, 2] means: 2 rows videos, shorts, 1 row videos, shorts, 3 rows videos, shorts, etc.
            $pattern = [2, 1, 3, 1, 2]; // Varied pattern
            $videoGroups = [];
            $currentIndex = 0;
            $patternIndex = 0;
           
            if ($hasVideos) {
                $allVideosCollection = $allVideos;
                $totalVideos = $allVideosCollection->count();
               
                while ($currentIndex < $totalVideos) {
                    $rowsInThisGroup = $pattern[$patternIndex % count($pattern)];
                    $videosInThisGroup = $rowsInThisGroup * $videosPerRow;
                   
                    // Get the slice of videos for this group (keep as collection)
                    $groupVideos = $allVideosCollection->slice($currentIndex, $videosInThisGroup);
                   
                    if ($groupVideos->isNotEmpty()) {
                        $videoGroups[] = $groupVideos;
                        $currentIndex += $groupVideos->count();
                    } else {
                        break;
                    }
                   
                    $patternIndex++;
                }
            }
        @endphp
 
        @if ($hasVideos || $hasShorts)
            @php
                $groupIndex = 0;
                $totalGroups = count($videoGroups);
                $availableFeedAds = isset($feedAds) && $feedAds->count() > 0 ? collect($feedAds) : collect();
                
                // Calculate total videos across all groups
                $totalVideos = $allVideos->count();
                $totalAds = $availableFeedAds->count();
                
                // Create random ad positions - distribute ads randomly throughout all videos
                // First ad will be shown at the top (position 1), rest distributed randomly
                $adPositions = [];
                if ($totalAds > 0 && $totalVideos > 0) {
                    // Create shuffled list of ads for random distribution
                    $shuffledAds = $availableFeedAds->shuffle()->values();
                    
                    // First ad goes at position 1 (top of the grid)
                    if ($totalAds > 0) {
                        $adPositions[1] = $shuffledAds[0];
                        $usedPositions = [1];
                        
                        // Distribute remaining ads randomly throughout videos
                        if ($totalAds > 1) {
                            // Calculate spacing for remaining ads
                            $remainingAds = $totalAds - 1;
                            $remainingVideos = max(1, $totalVideos - 1); // Exclude position 1
                            $baseSpacing = floor($remainingVideos / ($remainingAds + 1));
                            $minGap = max(2, $baseSpacing); // Minimum gap between ads
                            
                            for ($i = 1; $i < $totalAds; $i++) {
                                // Calculate base position (evenly distributed, starting from position 2)
                                $basePosition = 2 + ($i - 1) * $baseSpacing;
                                
                                // Add randomness: vary position by up to ±30% of spacing
                                $variance = floor($baseSpacing * 0.3);
                                $randomOffset = $variance > 0 ? rand(-$variance, $variance) : 0;
                                $position = max(2, min($totalVideos, $basePosition + $randomOffset));
                                
                                // Ensure minimum gap from other ads
                                $attempts = 0;
                                while ($attempts < 20) {
                                    $valid = true;
                                    foreach ($usedPositions as $usedPos) {
                                        if (abs($position - $usedPos) < $minGap) {
                                            $valid = false;
                                            // Try a different position
                                            $position = max(2, min($totalVideos, $position + ($position < $usedPos ? -1 : 1) * $minGap));
                                            break;
                                        }
                                    }
                                    
                                    if ($valid) {
                                        break;
                                    }
                                    $attempts++;
                                }
                                
                                // If still not valid, use base position
                                if (!$valid) {
                                    $position = $basePosition;
                                }
                                
                                $usedPositions[] = $position;
                                $adPositions[$position] = $shuffledAds[$i];
                            }
                        }
                    }
                    
                    // Sort positions to ensure ads are inserted in order
                    ksort($adPositions);
                }
                
                // Initialize counters OUTSIDE the loop so they persist across all video groups
                $videoCount = 0;
                $adsShown = 0; // Track how many ads have been shown
            @endphp

            {{-- Show shorts at the beginning if there are no videos --}}
            @if ($hasShorts && !$hasVideos)
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

            @foreach ($videoGroups as $videoGroup)
                {{-- Display Video Group - All videos and ads in ONE continuous grid --}}
                @if (!blank($videoGroup))
                    @if ($groupIndex == 0)
                        <x-home-body-title icon="vti-video" title="Videos" />
                    @endif
                   
                    {{-- ONE video-wrapper for entire group - videos and ads mixed together --}}
                    <div class="video-wrapper">
                        @foreach($videoGroup as $videoIndex => $video)
                            @php
                                $videoCount++;
                                $shouldShowAd = false;
                                $adToShow = null;
                                
                                // Check if we should show an ad at this position (random distribution)
                                if (isset($adPositions[$videoCount])) {
                                    $adToShow = $adPositions[$videoCount];
                                    $shouldShowAd = true;
                                    $adsShown++;
                                }
                            @endphp
                            
                            {{-- Display the video --}}
                            @include($activeTemplate . 'partials.video.video_list', ['videos' => collect([$video])])
                            
                            {{-- Insert ad at this position if scheduled - randomly distributed in grid --}}
                            @if($shouldShowAd && $adToShow)
                                @include($activeTemplate . 'partials.video.feed_ad', ['feedAd' => $adToShow])
                            @endif
                        @endforeach
                    </div>
                @endif
 
                {{-- Display Shorts after each video group (between groups, not after the last) --}}
                @if ($hasShorts && $groupIndex < $totalGroups - 1)
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
 
                @php $groupIndex++; @endphp
            @endforeach
 
            {{-- Show shorts after last video group if there's only one group or if shorts haven't been shown yet --}}
            @if ($hasShorts && $hasVideos && $totalGroups > 0 && $totalGroups == 1)
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
 
            {{-- Display remaining paginated videos for infinite scroll --}}
            @if (!blank($videos) && $videos->hasMorePages())
                <div class="text-center d-none spinner mt-4 w-100" id="loading-spinner">
                    <i class="las la-spinner"></i>
                </div>
            @endif
        @endif
 
        @if (blank($shortVideos) && blank($allVideos))
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
                    if (typeof window.adsbygoogle !== 'undefined') {
                        (window.adsbygoogle = window.adsbygoogle || []).push({});
                    }
                } catch (e) {
                    // Silently handle AdSense errors - script may not be loaded
                }
            }, 500);
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