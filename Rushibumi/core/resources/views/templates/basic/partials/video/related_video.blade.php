@foreach ($relatedVideos as $relatedVideo)
    <div class="video-item">
        <a data-video_id="{{$relatedVideo->id}}" href="{{ route('video.play', [$relatedVideo->id, $relatedVideo->slug]) }}"
           class="video-item__thumb  @if ($relatedVideo->showEligible() && !$relatedVideo->audience) autoPlay @endif">
            <video class="related-video-player video-player"  controls
                   data-poster="{{ getImage(getFilePath('thumbnail') . '/' . $relatedVideo->thumb_image) }}">
            </video>
           @include('Template::partials.video.video_loader')
            @if (!$relatedVideo->showEligible())
                <span class="video-item__price">
                    <span class="text">@lang('Only')</span>
                    {{ gs('cur_sym') }}{{ showAmount($relatedVideo->price, currencyFormat: false) }}
                </span>
 
                <div class="premium-icon releted-pre-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"
                         aria-hidden="true" class="_24ydrq0 _1286nb17o _1286nb12r6">
                        <path
                              d="M486.2 50.2c-9.6-3.8-20.5-1.3-27.5 6.2l-98.2 125.5-83-161.1C273 13.2 264.9 8.5 256 8.5s-17.1 4.7-21.5 12.3l-83 161.1L53.3 56.5c-7-7.5-17.9-10-27.5-6.2C16.3 54 10 63.2 10 73.5v333c0 35.8 29.2 65 65 65h362c35.8 0 65-29.2 65-65v-333c0-10.3-6.3-19.5-15.8-23.3">
                        </path>
                    </svg>
                </div>
            @endif
            @if($relatedVideo->duration)
                <span class="video-item__duration">{{ $relatedVideo->duration }}</span>
            @endif
        </a>
        <div class="video-item__content">
            <h6 class="title">
                <a href="{{ route('video.play', [$relatedVideo->id, $relatedVideo->slug]) }}">{{ __($relatedVideo->title) }}</a>
            </h6>
            <a href="{{ route('preview.channel', $relatedVideo->user->slug) }}" class="channel">
                {{ __($relatedVideo->user->channel_name) }}
            </a>
            <div class="meta">
                <span class="view">{{ formatNumber($relatedVideo->views) }} @lang('views')</span>
                <span class="separator">•</span>
                <span class="date">{{ $relatedVideo->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <button class="video-item__menu" type="button" aria-label="More options">
            <i class="fas fa-ellipsis-v"></i>
        </button>
    </div>
@endforeach
 
@push('style')
    <style>
        .releted-pre-icon {
            top: 5px;
            left: 5px;
        }
       
        /* Related Videos Layout - YouTube Style */
        .play-video .secondary__playlist .video-item {
            display: flex !important;
            flex-direction: row !important;
            align-items: flex-start !important;
            gap: 12px !important;
            margin-bottom: 12px !important;
            width: 100% !important;
            position: relative;
        }
       
        .play-video .secondary__playlist .video-item__thumb {
            flex-shrink: 0 !important;
            width: 168px !important;
            height: 94px !important;
            min-width: 168px !important;
            max-width: 168px !important;
            max-height: 94px !important;
            border-radius: 4px !important;
            overflow: hidden;
            position: relative;
            background: hsl(var(--dark));
        }
       
        .play-video .secondary__playlist .video-item__thumb video,
        .play-video .secondary__playlist .video-item__thumb .video-player,
        .play-video .secondary__playlist .video-item__thumb img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }
       
        .play-video .secondary__playlist .video-item__content {
            flex: 1 !important;
            min-width: 0 !important;
            padding: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
            align-items: flex-start !important;
        }
       
        .play-video .secondary__playlist .video-item__content .title {
            margin: 0 !important;
            margin-bottom: 0 !important;
            line-height: 1.4 !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: 100% !important;
        }
       
        .play-video .secondary__playlist .video-item__content .title a {
            color: hsl(var(--text-color)) !important;
            text-decoration: none !important;
        }
       
        .play-video .secondary__playlist .video-item__content .title a:hover {
            color: hsl(var(--base)) !important;
        }
       
        .play-video .secondary__playlist .video-item__content .channel {
            font-size: 12px !important;
            color: hsl(var(--body-color)) !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            line-height: 1.4 !important;
            margin: 0 !important;
        }
       
        .play-video .secondary__playlist .video-item__content .channel:hover {
            color: hsl(var(--text-color)) !important;
        }
       
        .play-video .secondary__playlist .video-item__content .channel .verified-badge {
            font-size: 12px !important;
            color: hsl(var(--body-color)) !important;
        }
       
        .play-video .secondary__playlist .video-item__content .meta {
            font-size: 12px !important;
            color: hsl(var(--body-color)) !important;
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
            line-height: 1.4 !important;
            margin: 0 !important;
        }
       
        .play-video .secondary__playlist .video-item__content .meta .separator {
            color: hsl(var(--body-color)) !important;
        }
       
        .play-video .secondary__playlist .video-item__menu {
            flex-shrink: 0 !important;
            width: 24px !important;
            height: 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: transparent !important;
            border: none !important;
            color: hsl(var(--text-color)) !important;
            cursor: pointer !important;
            opacity: 0 !important;
            transition: opacity 0.2s !important;
            padding: 0 !important;
            margin-top: 2px !important;
        }
       
        .play-video .secondary__playlist .video-item:hover .video-item__menu {
            opacity: 1 !important;
        }
       
        .play-video .secondary__playlist .video-item__menu:hover {
            color: hsl(var(--base)) !important;
        }
       
        .play-video .secondary__playlist .video-item__menu i {
            font-size: 16px !important;
        }
       
        .play-video .secondary__playlist .video-item__duration {
            position: absolute !important;
            bottom: 4px !important;
            right: 4px !important;
            background: rgba(0, 0, 0, 0.8) !important;
            color: hsl(var(--static-white)) !important;
            padding: 2px 4px !important;
            border-radius: 2px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            line-height: 1.2 !important;
        }
       
        @media screen and (max-width: 1499px) {
            .play-video .secondary__playlist .video-item__thumb {
                width: 140px !important;
                height: 78px !important;
                min-width: 140px !important;
                max-width: 140px !important;
                max-height: 78px !important;
            }
        }
       
        @media screen and (max-width: 1399px) {
            .play-video .secondary__playlist .video-item__thumb {
                width: 120px !important;
                height: 68px !important;
                min-width: 120px !important;
                max-width: 120px !important;
                max-height: 68px !important;
            }
        }
       
        @media screen and (max-width: 1199px) {
            .play-video .secondary__playlist .video-item__thumb {
                width: 120px !important;
                height: 68px !important;
                min-width: 120px !important;
                max-width: 120px !important;
                max-height: 68px !important;
            }
           
            .play-video .secondary__playlist .video-item__content .title {
                font-size: 13px !important;
            }
        }
       
        @media screen and (max-width: 424px) {
            .play-video .secondary__playlist .video-item {
                flex-direction: column !important;
                gap: 8px !important;
            }
           
            .play-video .secondary__playlist .video-item__thumb {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 16 / 9 !important;
                min-width: 100% !important;
                max-width: 100% !important;
                max-height: none !important;
            }
           
            .play-video .secondary__playlist .video-item__menu {
                position: absolute !important;
                top: 8px !important;
                right: 8px !important;
                opacity: 1 !important;
                background: rgba(0, 0, 0, 0.6) !important;
                border-radius: 50% !important;
            }
        }
    </style>
@endpush