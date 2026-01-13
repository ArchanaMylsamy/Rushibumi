@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header mb-4">
                    <h2 class="page-title">@lang('Live Streams')</h2>
                </div>

                @if($liveStreams->count() > 0)
                    <div class="live-streams-grid">
                        @foreach($liveStreams as $stream)
                            <div class="live-stream-card">
                                <a href="{{ route('live.watch', [$stream->id, $stream->slug]) }}" class="stream-link">
                                    <div class="stream-thumbnail">
                                        @if($stream->thumbnail)
                                            <img src="{{ getImage(getFilePath('liveThumbnail') . '/' . $stream->thumbnail, getFileSize('liveThumbnail')) }}" 
                                                 alt="{{ $stream->title }}">
                                        @else
                                            <div class="no-thumbnail">
                                                <i class="las la-video"></i>
                                            </div>
                                        @endif
                                        <div class="live-badge">
                                            <span class="live-dot"></span>
                                            <span>LIVE</span>
                                        </div>
                                        <div class="viewers-count">
                                            <i class="las la-eye"></i>
                                            {{ formatNumber($stream->viewers_count) }}
                                        </div>
                                    </div>
                                    <div class="stream-info">
                                        <h4 class="stream-title">{{ Str::limit($stream->title, 60) }}</h4>
                                        <div class="stream-meta">
                                            <span class="stream-author">{{ $stream->user->display_name ?? $stream->user->username }}</span>
                                            @if($stream->category)
                                                <span class="stream-category">{{ $stream->category->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ paginateLinks($liveStreams) }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="las la-video" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                        <h3>@lang('No Live Streams')</h3>
                        <p>@lang('There are no live streams at the moment. Check back later!')</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .live-streams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .live-stream-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .live-stream-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }

        .stream-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stream-thumbnail {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            background: #000;
            overflow: hidden;
        }

        .stream-thumbnail img,
        .no-thumbnail {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-thumbnail {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1a1a1a;
            color: #666;
            font-size: 48px;
        }

        .live-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 0, 0, 0.9);
            color: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .live-dot {
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .viewers-count {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stream-info {
            padding: 15px;
        }

        .stream-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .stream-meta {
            display: flex;
            gap: 10px;
            font-size: 14px;
            color: #666;
        }

        .stream-author {
            font-weight: 500;
        }

        .stream-category {
            color: #999;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
    </style>
@endsection

