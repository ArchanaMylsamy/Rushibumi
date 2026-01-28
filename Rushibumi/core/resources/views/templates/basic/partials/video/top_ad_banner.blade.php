@php
    // Track impression
    if (isset($topAd)) {
        $topAd->incrementImpressions();
    }
@endphp

<div class="top-ad-banner" data-ad-id="{{ $topAd->id ?? '' }}" data-ad-type="{{ $topAd->ad_type }}">
    <div class="ad-shimmer"></div>
    <div class="ad-content">
        @if($topAd->ad_type == 3)
            {{-- Video Ad --}}
            @php
                $videoUrl = asset(getFilePath('video') . '/' . $topAd->video);
                $posterImage = $topAd->image ? getImage(getFilePath('thumbnail') . '/' . $topAd->image) : null;
            @endphp
            <div class="top-ad-video-container">
                <video class="video-player top-ad-video-player" 
                       data-poster="{{ $posterImage }}"
                       controls
                       playsinline
                       preload="metadata">
                    <source src="{{ $videoUrl }}" type="video/mp4">
                    @lang('Your browser does not support the video tag.')
                </video>
                @if($topAd->url)
                    <a href="{{ $topAd->url }}" 
                       target="_blank"
                       class="top-ad-video-link"
                       onclick="trackAdClick({{ $topAd->id ?? 'null' }})"></a>
                @endif
            </div>
        @else
            {{-- Image or GIF Ad --}}
            @if($topAd->url)
                <a href="{{ $topAd->url }}" 
                   target="_blank"
                   onclick="trackAdClick({{ $topAd->id ?? 'null' }})"
                   class="top-ad-link">
            @endif
                @if($topAd->ad_type == 2)
                    {{-- GIF Ad --}}
                    @php
                        $gifOriginalPath = getFilePath('thumbnail') . '/' . $topAd->image;
                        $gifThumbPath = getFilePath('thumbnail') . '/thumb_' . $topAd->image;
                        $gifSrc = (file_exists(public_path($gifOriginalPath)) && is_file(public_path($gifOriginalPath))) 
                            ? $gifOriginalPath 
                            : ((file_exists(public_path($gifThumbPath)) && is_file(public_path($gifThumbPath))) 
                                ? $gifThumbPath 
                                : $gifOriginalPath);
                    @endphp
                    <img src="{{ getImage($gifSrc) }}" 
                         alt="{{ $topAd->title }}" 
                         loading="lazy"
                         class="top-ad-image">
                @else
                    {{-- Static Image Ad --}}
                    @php
                        $imageThumbPath = getFilePath('thumbnail') . '/thumb_' . $topAd->image;
                        $imageOriginalPath = getFilePath('thumbnail') . '/' . $topAd->image;
                        $imageSrc = (file_exists(public_path($imageThumbPath)) && is_file(public_path($imageThumbPath))) 
                            ? $imageThumbPath 
                            : ((file_exists(public_path($imageOriginalPath)) && is_file(public_path($imageOriginalPath))) 
                                ? $imageOriginalPath 
                                : $imageThumbPath);
                    @endphp
                    <img src="{{ getImage($imageSrc) }}" 
                         alt="{{ $topAd->title }}" 
                         loading="lazy"
                         class="top-ad-image">
                @endif
            @if($topAd->url)
                </a>
            @endif
        @endif
    </div>
</div>

@push('style')
<style>
    /* Top Ad Banner - Full Width Responsive Banner */
    .top-ad-banner {
        width: calc(100% + 40px); /* Break out of home-body padding (20px on each side) */
        margin-left: -20px; /* Offset home-body padding */
        margin-right: -20px;
        background: rgba(var(--base-rgb), 0.03);
        border: 1px solid rgba(var(--base-rgb), 0.1);
        border-radius: 0;
        border-left: none;
        border-right: none;
        padding: 0;
        margin-bottom: 25px;
        margin-top: 0;
        /* Responsive banner: maintains 728:90 aspect ratio, fills full screen width */
        aspect-ratio: 728 / 90;
        height: auto;
        min-height: 90px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .top-ad-banner {
            width: calc(100% + 30px);
            margin-left: -15px;
            margin-right: -15px;
        }
    }
    
    @media (max-width: 480px) {
        .top-ad-banner {
            width: calc(100% + 24px);
            margin-left: -12px;
            margin-right: -12px;
        }
    }

    .top-ad-banner:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .top-ad-banner .ad-shimmer {
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

    .top-ad-banner .ad-content {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .top-ad-banner .ad-badge {
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

    .top-ad-link {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        cursor: pointer;
    }

    .top-ad-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 12px;
        display: block;
        /* Responsive: fills banner maintaining 728:90 aspect ratio */
    }

    /* Video Ad Container */
    .top-ad-video-container {
        position: relative;
        width: 100%;
        max-width: 100%;
    }

    .top-ad-video-player {
        width: 100%;
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
        display: block;
        margin: 0 auto;
    }

    .top-ad-video-link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        cursor: pointer;
    }

    /* Light Theme */
    [data-theme="light"] .top-ad-banner {
        background: rgba(0, 0, 0, 0.02);
        border-color: rgba(0, 0, 0, 0.08);
    }

    [data-theme="light"] .top-ad-banner .ad-shimmer {
        background: linear-gradient(90deg,
            transparent 0%,
            rgba(0, 0, 0, 0.05) 50%,
            transparent 100%
        );
    }

    /* Dark Theme */
    [data-theme="dark"] .top-ad-banner {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.08);
    }

    [data-theme="dark"] .top-ad-banner .ad-shimmer {
        background: linear-gradient(90deg,
            transparent 0%,
            rgba(255, 255, 255, 0.08) 50%,
            transparent 100%
        );
    }

    /* Responsive Design - Maintain 728:90 aspect ratio on all screens */
    @media (max-width: 768px) {
        .top-ad-banner {
            max-width: 100%;
            /* Aspect ratio will maintain automatically */
            margin-bottom: 20px;
        }

        .top-ad-banner .ad-badge {
            font-size: 9px;
            padding: 5px 12px;
            letter-spacing: 1.2px;
        }

        .top-ad-video-player {
            height: 100%;
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .top-ad-banner {
            /* Aspect ratio maintained automatically */
        }

        .top-ad-banner .ad-badge {
            font-size: 8px;
            padding: 4px 10px;
            letter-spacing: 1px;
            left: 15px;
        }
    }
</style>
@endpush

@push('script')
<script>
    function trackAdClick(adId) {
        if (!adId) return;
        
        // Track click via AJAX
        fetch('{{ route("feed.ad.click") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ad_id: adId
            })
        }).catch(err => {
            console.log('Ad click tracking error:', err);
        });
    }

    // Initialize Plyr for top banner video ads when page loads
    $(document).ready(function() {
        // Initialize top banner video ad players
        const topAdVideoPlayers = document.querySelectorAll('.top-ad-video-player:not([data-plyr-initialized])');
        
        if (topAdVideoPlayers.length > 0 && typeof Plyr !== 'undefined') {
            topAdVideoPlayers.forEach(videoEl => {
                try {
                    const player = new Plyr(videoEl, {
                        controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
                        ratio: '16:9',
                        muted: false,
                        autoplay: false,
                    });
                    
                    videoEl.setAttribute('data-plyr-initialized', 'true');
                    
                    // Track play event
                    player.on('play', function() {
                        const adId = videoEl.closest('.top-ad-banner')?.getAttribute('data-ad-id');
                        if (adId) {
                            // Track video ad play
                            trackAdClick(adId);
                        }
                    });
                } catch (e) {
                    console.warn('Plyr initialization error for top ad video:', e);
                }
            });
        }
    });
</script>
@endpush
