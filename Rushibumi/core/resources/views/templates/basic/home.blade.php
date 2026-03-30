@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="home-body">
        {{-- Top/banner ad removed from home page --}}
 
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
                
                // Create random ad positions distributed through the feed (not pinned at top)
                $adPositions = [];
                if ($totalAds > 0 && $totalVideos > 0) {
                    // Create shuffled list of ads for random distribution
                    $shuffledAds = $availableFeedAds->shuffle()->values();
                    $usedPositions = [];
                    // Keep ads away from the first card when possible.
                    $minInsertPosition = $totalVideos >= 3 ? 3 : ($totalVideos >= 2 ? 2 : 1);
                    $baseSpacing = floor($totalVideos / ($totalAds + 1));
                    $minGap = max(2, $baseSpacing);

                    for ($i = 0; $i < $totalAds; $i++) {
                        $basePosition = ($i + 1) * max(1, $baseSpacing);
                        $basePosition = max($minInsertPosition, $basePosition);

                        $variance = floor(max(1, $baseSpacing) * 0.3);
                        $randomOffset = $variance > 0 ? rand(-$variance, $variance) : 0;
                        $position = max($minInsertPosition, min($totalVideos, $basePosition + $randomOffset));

                        $attempts = 0;
                        while ($attempts < 20) {
                            $valid = true;
                            foreach ($usedPositions as $usedPos) {
                                if (abs($position - $usedPos) < $minGap) {
                                    $valid = false;
                                    $position = max($minInsertPosition, min($totalVideos, $position + ($position < $usedPos ? -1 : 1) * $minGap));
                                    break;
                                }
                            }
                            if ($valid) {
                                break;
                            }
                            $attempts++;
                        }

                        if (!$valid) {
                            $position = max($minInsertPosition, min($totalVideos, $basePosition));
                        }

                        $usedPositions[] = $position;
                        $adPositions[$position] = $shuffledAds[$i];
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