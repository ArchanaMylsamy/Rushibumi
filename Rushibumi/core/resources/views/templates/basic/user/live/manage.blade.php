@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-content">
        <div class="card custom--card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">{{ __($pageTitle) }}</h3>
                <a href="{{ route('user.live.go.live') }}" class="btn btn--base btn-sm">
                    <i class="las la-video"></i> @lang('Go Live')
                </a>
            </div>
            <div class="card-body">
                @if($liveStreams->count() > 0)
                    <div class="table-responsive">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Viewers')</th>
                                    <th>@lang('Started')</th>
                                    <th class="text-center">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($liveStreams as $stream)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($stream->recorded_video && $stream->status != 'live')
                                                    <div class="stream-thumbnail-wrapper">
                                                        <a href="{{ route('live.watch', [$stream->id, $stream->slug]) }}" 
                                                           class="stream-thumbnail-link" 
                                                           title="@lang('Play recorded video')">
                                                            <div class="stream-thumbnail">
                                                                <video class="thumbnail-video" preload="none" muted playsinline>
                                                                    <source src="{{ url('live/recording/' . $stream->id) }}" type="video/webm">
                                                                </video>
                                                                <div class="play-overlay">
                                                                    <i class="las la-play"></i>
                                                                </div>
                                                                @if($stream->recorded_duration)
                                                                    <span class="video-duration-badge">
                                                                        {{ gmdate('i:s', $stream->recorded_duration) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>{{ Str::limit($stream->title, 40) }}</strong>
                                                    @if($stream->recorded_video && $stream->status != 'live')
                                                        <div class="stream-type-badge">
                                                            <i class="las la-video"></i> @lang('Webcam')
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($stream->status == 'live')
                                                <span class="badge badge--success">
                                                    <span class="live-dot-inline"></span> @lang('LIVE')
                                                </span>
                                            @elseif($stream->status == 'scheduled')
                                                <span class="badge badge--warning">@lang('Scheduled')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Ended')</span>
                                            @endif
                                        </td>
                                        <td>{{ formatNumber($stream->viewers_count) }}</td>
                                        <td>{{ $stream->started_at ? showDateTime($stream->started_at, 'd M Y h:i A') : '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('live.watch', [$stream->id, $stream->slug]) }}" 
                                                   class="btn btn--info btn-sm action-btn" title="@lang('Watch Stream')">
                                                    <i class="las la-eye"></i>
                                                </a>
                                                @if($stream->status != 'live')
                                                    <a href="javascript:void(0)" 
                                                       class="btn btn--info btn-sm action-btn confirmationBtn" 
                                                       data-action="{{ route('user.live.delete', $stream->id) }}"
                                                       data-question="@lang('Are you sure you want to delete this stream? This action cannot be undone.')"
                                                       title="@lang('Delete Stream')">
                                                        <i class="las la-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ paginateLinks($liveStreams) }}
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <i class="las la-video" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                        <h4>@lang('No Live Streams')</h4>
                        <p class="text-muted">@lang('You haven\'t created any live streams yet.')</p>
                        <a href="{{ route('user.live.go.live') }}" class="btn btn--base mt-3">
                            <i class="las la-video"></i> @lang('Go Live Now')
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .live-dot-inline {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            margin-right: 4px;
            animation: pulse 2s infinite;
        }
        .action-btn {
            color: #007bff !important;
            background: transparent !important;
            border: 1px solid #007bff;
            min-width: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .action-btn:hover {
            background: #007bff !important;
            color: #fff !important;
        }
        .action-btn i {
            color: inherit;
            font-size: 16px;
        }
        
        /* Stream Thumbnail Styles */
        .stream-thumbnail-wrapper {
            width: 120px;
            height: 68px;
            flex-shrink: 0;
        }
        
        .stream-thumbnail-link {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .stream-thumbnail {
            width: 100%;
            height: 100%;
            position: relative;
            background: #000;
            cursor: pointer;
        }
        
        .thumbnail-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        .stream-thumbnail:hover .play-overlay {
            opacity: 1;
        }
        
        .play-overlay i {
            font-size: 32px;
            color: #fff;
            background: rgba(0, 0, 0, 0.7);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .video-duration-badge {
            position: absolute;
            bottom: 4px;
            right: 4px;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 2px 6px;
            border-radius: 2px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .stream-type-badge {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
        
        .stream-type-badge i {
            margin-right: 4px;
        }
    </style>
@endsection

<x-confirmation-modal />

