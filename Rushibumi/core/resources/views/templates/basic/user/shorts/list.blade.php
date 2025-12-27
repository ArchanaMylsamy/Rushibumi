@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-content">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="card-title">{{ __($pageTitle) }}</h5>
            </div>
            <div class="card-body">
                @if (!blank($shorts))
                    <div class="dashboard-video">
                        @foreach ($shorts as $video)
                            <div class="video-item">
                                <a class="video-item__thumb playModal shortsAutoPlay" href="{{ route('short.play', [$video->id, $video->slug]) }}"
                                   target="__blank">
                                    <video class="shorts-video-player" controls>
                                        <source src="{{ getVideo($video->video, $video) }}"
                                                type="video/mp4" />
                                    </video>
                                </a>
                                <div class="video-item__manage mt-3 me-3">
                                    <a class="video-item__edit" href="{{ route('user.shorts.edit', $video->id) }}"><i
                                           class="las la-edit"></i></a>
                                    <a class="video-item__edit confirmationBtn" 
                                       href="javascript:void(0)"
                                       data-action="{{ route('user.shorts.delete', encrypt($video->id)) }}"
                                       data-question="@lang('Are you sure you want to delete this short? This action cannot be undone.')"
                                       style="color: #dc3545;"><i class="las la-trash"></i></a>
                                </div>
                                <div class="video-item__content">
                                    <h5 class="title">
                                        <a href="{{ route('video.play', [$video->id, $video->slug]) }}">{{ __($video->title) }}</a>
                                    </h5>
                                    <div class="meta d-flex justify-content-between ">
                                        <div>
                                            <span class="view">{{ formatNumber($video->views) }} @lang('views')</span>
                                            <span
                                                  class="like">{{ formatNumber($video->userReactions()->like()->count()) }}
                                                @lang('Likes')</span>
                                        </div>
                                        <div>
                                            @php
                                                echo $video->statusBadge;
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="row py-60">
                        <div class="empty-container empty-card-two">
                            @include('Template::partials.empty')
                        </div>
                    </div>
                @endif
                @php
                    echo paginateLinks($shorts);
                @endphp
            </div>
        </div>
    </div>
    
    <x-confirmation-modal frontend="true" />
@endsection

@push('style')
    <style>
        .video-item__manage {
            display: flex !important;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .video-item__edit.confirmationBtn {
            color: #dc3545 !important;
            opacity: 1 !important;
            visibility: visible !important;
            display: grid !important;
            place-content: center !important;
            border-color: rgba(220, 53, 69, 0.3) !important;
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
        
        .video-item__edit.confirmationBtn:hover {
            background-color: rgba(220, 53, 69, 0.2) !important;
            border-color: #dc3545 !important;
        }
        
        .video-item__edit.confirmationBtn i {
            color: #dc3545 !important;
            font-size: 18px !important;
        }
        
        .video-item__edit.confirmationBtn:hover i {
            color: #c82333 !important;
        }
        
        .video-item__edit i {
            font-size: 18px;
        }
        
        .dashboard-video {
            grid-template-columns: repeat(4, 1fr);
        }

        @media (max-width: 1199px) {
            .dashboard-video {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767px) {
            .dashboard-video {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 575px) {
            .dashboard-video {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/plyr.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/plyr.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $(document).ready(function() {

                const controls = [
                    'duration',
                ];
                const players = Plyr.setup('.shorts-video-player', {
                    controls,
                    ratio: '9:16',

                });

                $('.shortsAutoPlay').each(function() {
                    const player = $(this).find('.shorts-video-player')[0];

                    $(this).on('mouseenter', function() {
                        player.muted = true;
                        player.play();

                    });

                    $(this).on('mouseleave', function() {
                        player.pause();
                        player.currentTime = 0;

                    });
                });


            });




        })(jQuery);
    </script>
@endpush
