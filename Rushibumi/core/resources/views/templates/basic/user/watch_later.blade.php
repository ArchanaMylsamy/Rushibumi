@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="home-body ">
        <div class="wh-page-header home-body__item">
            <h3 class="page-title">{{ __($pageTitle) }}</h3>
        </div>

        @if (!blank($watchLaters))
            <div class="wh-search-clear">
                <button class="wh-sm-search"><i class="vti-search"></i></button>
                <form class="watch-history-search">
                    <div class="form-group">
                        <input class="form--control" name="search" type="text" value="{{ request()->search }}"
                            placeholder="Search">
                        <button class="btn" type="submit"><i class="vti-search"></i></button>
                    </div>
                </form>
                <button class="clear-history-btn  confirmationBtn" data-action="{{ route('user.remove.all.watch.later') }}"
                    data-question="@lang('Are you sure you want to remove all video')?"><i class="vti-trash"></i> <span
                        class="text">@lang('Remove all watch Later')</span></button>
            </div>
        @endif

        @if (!blank($watchLaters))
            <div class="video-wrapper">
        @endif
        @forelse ($watchLaters as $watchLater)
            @php
                $user = auth()->user();
                $purchasedTrue = @$user
                    ?->purchasedVideos()
                    ->where('video_id', $watchLater->video->id)
                    ->exists();
            @endphp

            <div class="video-item">
                <a data-video_id="{{ $watchLater->video->id }}"
                    class="video-item__thumb @if (!$watchLater->video->stock_video || $watchLater->video->user_id == auth()->id() || $purchasedTrue) autoPlay @endif"
                    href="{{ route('video.play', [$watchLater->video->id, $watchLater->video->slug]) }}">
                    @if (!$watchLater->video->stock_video || $watchLater->video->user_id == auth()->id() || $purchasedTrue)
                        <video class="video-player" controls playsinline
                            data-poster="{{ getImage(getFilePath('thumbnail') . '/' . $watchLater->video->thumb_image) }}">
                        </video>
                        @include('Template::partials.video.video_loader')
                    @else
                        <img src="{{ getImage(getFilePath('thumbnail') . '/thumb_' . $watchLater->video->thumb_image) }}"
                            alt="Video Thumb">
                        <span class="video-item__price"><span
                                class="text">@lang('Only')</span>{{ gs('cur_sym') }}{{ showAmount($watchLater->video->price, currencyFormat: false) }}</span>
                        <div class="premium-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16"
                                aria-hidden="true" class="_24ydrq0 _1286nb17o _1286nb12r6">
                                <path
                                    d="M486.2 50.2c-9.6-3.8-20.5-1.3-27.5 6.2l-98.2 125.5-83-161.1C273 13.2 264.9 8.5 256 8.5s-17.1 4.7-21.5 12.3l-83 161.1L53.3 56.5c-7-7.5-17.9-10-27.5-6.2C16.3 54 10 63.2 10 73.5v333c0 35.8 29.2 65 65 65h362c35.8 0 65-29.2 65-65v-333c0-10.3-6.3-19.5-15.8-23.3">
                                </path>
                            </svg>
                        </div>
                    @endif
                    @if($watchLater->video->duration)
                        <span class="video-item__duration">{{ $watchLater->video->duration }}</span>
                    @endif
                </a>
                <div class="video-item__content">
                    <div class="channel-info">
                        <a class="video-item__channel-author" href="{{ route('preview.channel', $watchLater->video->user->slug) }}">
                            <img class="fit-image"
                                src="{{ getImage(getFilePath('userProfile') . '/' . $watchLater->video->user->image, isAvatar: true) }}"
                                alt="image">
                        </a>
                        <a class="channel"
                            href="{{ route('preview.channel', $watchLater->video->user->slug) }}">{{ __($watchLater->video->user->channel_name) }}</a>
                    </div>
                    <h5 class="title">
                        <a href="{{ route('video.play', [$watchLater->video->id, $watchLater->video->slug]) }}">{{ __($watchLater->video->title) }}</a>
                    </h5>
                    <div class="meta">
                        <span class="view">{{ formatNumber($watchLater->video->views) }} @lang('views')</span>
                        <span class="date">{{ $watchLater->video->created_at->diffForHumans() }}</span>
                        <div class="video-wh-item__action">
                            <button class="ellipsis-list__btn confirmationBtn"
                                data-action="{{ route('user.remove.watch.later', $watchLater->id) }}"
                                data-question="@lang('Are you sure you want to remove this video')?"
                                title="@lang('Remove from watch later')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-x">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                            <button class="ellipsis-list__btn shareBtn" data-video="{{ $watchLater->video }}"
                                data-url="{{ route('video.play', [$watchLater->video->id, $watchLater->video->slug]) }}"
                                type="button"
                                title="@lang('Share')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-share-2">
                                    <circle cx="18" cy="5" r="3" />
                                    <circle cx="6" cy="12" r="3" />
                                    <circle cx="18" cy="19" r="3" />
                                    <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                                    <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-container">
                @include('Template::partials.empty')
            </div>
        @endforelse
        @if (!blank($watchLaters))
            </div>
        @endif
    </div>

    @include('Template::partials.share')

    <x-confirmation-modal frontend='true' />
@endsection



@push('style-lib')
    <link href="{{ asset('assets/global/css/plyr.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/plyr.js') }}"></script>
    <script src="{{ asset('assets/templates/basic/js/video-quality.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $(document).ready(function() {

                const controls = [
             
                ];
                const players = Plyr.setup('.video-player', {
                    controls,
                    ratio: '16:9',
                    muted: true,

                });


       


            });

            $('.confirmationBtn').on('click', function() {
                const modal = $('#confirmationModal');
                const action = $(this).data('action');
                const question = $(this).data('question');
                modal.find('.question').text(question);
                modal.find('form').attr('action', action);
                modal.modal('show')
            });



            $('.shareBtn').on('click', function() {
                const video = $(this).data('video');
                const url = $(this).data('url');

                let shareLink = `
        <a class="share-item whatsapp" href="https://api.whatsapp.com/send?text=${encodeURIComponent(url)}" target="_blank">
            <i class="lab la-whatsapp"></i>
        </a>
        <a class="share-item facebook" href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}" target="_blank">
            <i class="lab la-facebook-f"></i>
        </a>
        <a class="share-item twitter" href="https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(video.title)}" target="_blank">
            <i class="fa-brands fa-x-twitter"></i>
        </a>
        <a class="share-item envelope" href="mailto:?subject=${encodeURIComponent(video.title)}&body=${encodeURIComponent(url)}">
            <i class="las la-envelope"></i>
        </a>
    `;

                $('#shareModal').find('.share-items').html(shareLink);
                $('.copyText').val(url);
                $('#shareModal').modal('show');
            });


        })(jQuery);
    </script>
@endpush
