@php
    // Track impression
    if (isset($feedAd)) {
        $feedAd->incrementImpressions();
    }
@endphp

<div class="video-item feed-ad-item" data-ad-id="{{ $feedAd->id ?? '' }}" data-ad-type="{{ $feedAd->ad_type }}">
    {{-- Feed Ads: Image, GIF, and Video types --}}
    @if($feedAd->ad_type == 3)
        {{-- Video Ad --}}
        <div class="video-item__thumb feed-ad-thumb feed-ad-video-container">
            @php
                $videoUrl = asset(getFilePath('video') . '/' . $feedAd->video);
                $posterImage = $feedAd->image ? getImage(getFilePath('thumbnail') . '/' . $feedAd->image) : null;
            @endphp
            <video class="video-player feed-ad-video-player" 
                   data-poster="{{ $posterImage }}"
                   controls
                   playsinline
                   preload="metadata">
                <source src="{{ $videoUrl }}" type="video/mp4">
                @lang('Your browser does not support the video tag.')
            </video>
            <span class="ad-badge-feed">@lang('Ad')</span>
            @if($feedAd->url)
                <a href="{{ $feedAd->url }}" 
                   target="_blank"
                   class="feed-ad-video-link"
                   onclick="trackAdClick({{ $feedAd->id ?? 'null' }})"></a>
            @endif
        </div>
    @else
        {{-- Image or GIF Ad --}}
        @if($feedAd->url)
            <a href="{{ $feedAd->url }}" 
               class="video-item__thumb feed-ad-thumb" 
               target="_blank"
               onclick="trackAdClick({{ $feedAd->id ?? 'null' }})">
        @else
            <div class="video-item__thumb feed-ad-thumb">
        @endif
            @if($feedAd->ad_type == 2)
                {{-- GIF Ad --}}
                @php
                    // For GIFs, try original path first, then check if thumb_ exists (for old uploads)
                    $gifOriginalPath = getFilePath('thumbnail') . '/' . $feedAd->image;
                    $gifThumbPath = getFilePath('thumbnail') . '/thumb_' . $feedAd->image;
                    // Check which file exists - prefer original for GIFs to preserve animation
                    $gifSrc = (file_exists(public_path($gifOriginalPath)) && is_file(public_path($gifOriginalPath))) 
                        ? $gifOriginalPath 
                        : ((file_exists(public_path($gifThumbPath)) && is_file(public_path($gifThumbPath))) 
                            ? $gifThumbPath 
                            : $gifOriginalPath); // Default to original path
                @endphp
                <img src="{{ getImage($gifSrc) }}" 
                     alt="{{ $feedAd->title }}" 
                     loading="lazy"
                     class="feed-ad-image">
            @else
                {{-- Static Image Ad --}}
                @php
                    // For images, try thumb_ version first, then fallback to original
                    $imageThumbPath = getFilePath('thumbnail') . '/thumb_' . $feedAd->image;
                    $imageOriginalPath = getFilePath('thumbnail') . '/' . $feedAd->image;
                    // Check which file exists
                    $imageSrc = (file_exists(public_path($imageThumbPath)) && is_file(public_path($imageThumbPath))) 
                        ? $imageThumbPath 
                        : ((file_exists(public_path($imageOriginalPath)) && is_file(public_path($imageOriginalPath))) 
                            ? $imageOriginalPath 
                            : $imageThumbPath); // Default to thumb path (getImage will handle missing file)
                @endphp
                <img src="{{ getImage($imageSrc) }}" 
                     alt="{{ $feedAd->title }}" 
                     loading="lazy"
                     class="feed-ad-image">
            @endif
            <span class="ad-badge-feed">@lang('Ad')</span>
        @if($feedAd->url)
            </a>
        @else
            </div>
        @endif
    @endif
    
    <div class="video-item__content">
        <div class="channel-info">
            <div class="video-item__channel-author">
                <div class="fit-image ad-placeholder-icon">
                    <i class="las la-ad"></i>
                </div>
            </div>
            <span class="channel">@lang('Advertisement')</span>
        </div>
        <h5 class="title">
            @if($feedAd->url)
                <a href="{{ $feedAd->url }}" target="_blank" onclick="trackAdClick({{ $feedAd->id ?? 'null' }})">
                    {{ __($feedAd->title) }}
                </a>
            @else
                {{ __($feedAd->title) }}
            @endif
        </h5>
    </div>
</div>

@push('style')
<style>
    /* Ensure feed ads maintain grid layout - same as video items */
    .feed-ad-item,
    .video-wrapper .feed-ad-item,
    .home-body .video-wrapper .feed-ad-item {
        position: relative;
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        background: transparent !important;
        border: none !important;
        border-radius: 0 !important;
        overflow: visible !important; /* Ensure content is not cut off */
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: none !important;
        display: flex !important;
        flex-direction: column !important;
        cursor: pointer;
        grid-column: auto !important; /* Ensure it fits in grid */
        flex: 0 0 auto !important; /* Don't grow or shrink */
        box-sizing: border-box !important;
    }
    
    /* Ensure video-wrapper maintains 3-column grid even with ads */
    .video-wrapper,
    .home-body .video-wrapper {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 24px !important;
        flex-wrap: nowrap !important;
        justify-content: unset !important;
        align-items: unset !important;
    }
    
    @media (max-width: 1199px) {
        .video-wrapper,
        .home-body .video-wrapper {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 20px !important;
            flex-wrap: nowrap !important;
            justify-content: unset !important;
        }
    }
    
    @media (max-width: 991px) {
        .video-wrapper,
        .home-body .video-wrapper {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 18px !important;
            flex-wrap: nowrap !important;
            justify-content: unset !important;
        }
    }
    
    @media (max-width: 767px) {
        .video-wrapper,
        .home-body .video-wrapper {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 16px !important;
            flex-wrap: nowrap !important;
            justify-content: unset !important;
        }
    }
    
    @media (max-width: 575px) {
        .video-wrapper,
        .home-body .video-wrapper {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 16px !important;
            flex-wrap: nowrap !important;
            justify-content: unset !important;
        }
    }

    .feed-ad-item:hover {
        transform: translateY(-4px);
    }

    .feed-ad-thumb,
    .feed-ad-item .feed-ad-thumb,
    .feed-ad-item .video-item__thumb {
        position: relative;
        cursor: pointer;
        display: block;
        overflow: hidden; /* Keep hidden for border-radius, but ensure content fits */
        border-radius: 18px;
        width: 100% !important;
        aspect-ratio: 16 / 9 !important;
        height: auto !important;
        background: transparent;
        flex-shrink: 0;
        border: none;
        margin-bottom: 12px;
        box-sizing: border-box;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        transition: box-shadow 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .feed-ad-image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        display: block;
        border-radius: 18px !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box;
        border: none !important;
        outline: none;
        vertical-align: top;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .feed-ad-item:hover .feed-ad-image {
        transform: scale(1.1);
    }

    /* Video Ad Container */
    .feed-ad-video-container {
        position: relative;
        padding: 0 !important;
        width: 100% !important;
        height: 100% !important;
    }

    .feed-ad-video-player {
        width: 100% !important;
        height: 100% !important;
        border-radius: 18px !important;
        object-fit: cover !important;
        display: block !important;
    }

    .feed-ad-video-link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        cursor: pointer;
    }

    .ad-badge-feed {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(220, 20, 60, 0.9);
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 2;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    .feed-ad-item .video-item__content {
        padding: 0 !important;
        background: transparent !important;
        position: relative;
        z-index: 2;
        flex: 1;
        display: flex;
        flex-direction: column;
        border-top: none;
    }

    .ad-placeholder-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(var(--base-rgb), 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: hsl(var(--base));
        font-size: 18px;
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

    // Initialize Plyr for video ads when page loads
    $(document).ready(function() {
        // Initialize video ad players
        const videoAdPlayers = document.querySelectorAll('.feed-ad-video-player:not([data-plyr-initialized])');
        
        if (videoAdPlayers.length > 0 && typeof Plyr !== 'undefined') {
            videoAdPlayers.forEach(videoEl => {
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
                        const adId = videoEl.closest('.feed-ad-item')?.getAttribute('data-ad-id');
                        if (adId) {
                            // Track video ad play (you can add a separate endpoint for this)
                            trackAdClick(adId);
                        }
                    });
                } catch (e) {
                    console.warn('Plyr initialization error for ad video:', e);
                }
            });
        }
    });

</script>
@endpush
