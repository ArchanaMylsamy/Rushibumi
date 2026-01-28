@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <div class="play-body">
        <div class="play-video">
            <div class="primary ps-0">
                <div class="primary__videoPlayer video-item__thumb mainVideo" data-price="{{ $video->price }}"
                    data-video-id="{{ $video->id }}" data-item_name="{{ $video->title }}">
                    @if ($purchasedTrue && $video->audience)
                        <div class="hidden-content ">
                            <div class="form-group">
                                <h4>{{ __(gs('vc_warning')->title) }}</h4>
                                <p class="mb-3">{{ __(gs('vc_warning')->description) }} </p>
                                <button class="btn btn--base SeeBtn">@lang('See Video')</button>
                            </div>
                        </div>
                    @endif

                    <video class="video-player" data-amount="{{ $video->price }}" muted playsinline autoplay
                        data-poster="{{ getImage(getFilePath('thumbnail') . '/' . $video->thumb_image) }}" controls>
                        @if ($purchasedTrue)
                            @foreach ($video->videoFiles as $file)
                              <source src="{{ route('video.path', encrypt($file->id)) }}" type="video/mp4"
                                    size="{{ $file->quality }}" />

                                    
                            @endforeach

                            @foreach ($video->subtitles as $index => $subtitle)
                                <track src="{{ asset(getFilePath('subtitle') . '/' . $subtitle->file) }}"
                                    srclang="{{ $subtitle->language_code }}" kind="captions"
                                    label="{{ $subtitle->caption }}" @if($index === 0) default @endif />
                            @endforeach
                        @endif
                    </video>
                    @include('Template::partials.video.video_loader')

                    @if (!$purchasedTrue)
                        <div class="premium-stock">
                            <div class="premium-stock-lock">
                                <svg class="lucide lucide-lock" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>

                            <div class="premium-stock-inner">
                                <div class="left">
                                    <div class="premium-stock-price">
                                        {{ gs('cur_sym') }}{{ showAmount($video->price, currencyFormat: false) }}
                                    </div>
                                    <div class="premium-stock-icon">
                                        <svg class="_24ydrq0 _1286nb17o _1286nb12r6" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16"
                                            height="16">
                                            <path
                                                d="M486.2 50.2c-9.6-3.8-20.5-1.3-27.5 6.2l-98.2 125.5-83-161.1C273 13.2 264.9 8.5 256 8.5s-17.1 4.7-21.5 12.3l-83 161.1L53.3 56.5c-7-7.5-17.9-10-27.5-6.2C16.3 54 10 63.2 10 73.5v333c0 35.8 29.2 65 65 65h362c35.8 0 65-29.2 65-65v-333c0-10.3-6.3-19.5-15.8-23.3">
                                            </path>
                                        </svg>
                                        @lang('Premium')
                                    </div>
                                </div>
                                <div class="premium-stock-text">
                                    @lang('Purchase Now')
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="ad-wrapper position-relative adVideo d-none ">
                </div>

                <div class="primary__video-content">
                    <h4 class="primary__vtitle">{{ __($video->title) }}</h4>

                    <div class="primary__videometa">
                        <div class="items">
                            <span class="view"> <span class="icon"><i class="fa-regular fa-eye"></i></span>
                                {{ formatNumber($video->views) }} @lang('views')</span>
                            <span class="date"> <span class="icon"><i class="fa-regular fa-clock"></i></span>
                                {{ $video->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="meta-buttons">

                            <div class="meta-react-wrapper">
                                <div class="meta-react-inner">
                                    <button class="meta-buttons__button reactionBtn" data-reaction="1">
                                        <span class="icon">
                                            @if ($video->isLikedByAuthUser)
                                                <i class="vti-like-fill reactionIcon"></i>
                                            @else
                                                <i class="vti-like reactionIcon"></i>
                                            @endif
                                        </span>
                                        <span class="text likeCount">{{ formatNumber($video->reactionLikeCount) }}</span>
                                    </button>
                                    <button class="meta-buttons__button reactionBtn" data-reaction="0">
                                        <span class="icon">
                                            @if ($video->isUnlikedByAuthUser)
                                                <i class="vti-dislike-fill reactionIcon"></i>
                                            @else
                                                <i class="vti-dislike reactionIcon"></i>
                                            @endif
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <button class="meta-buttons__button shareBtn">
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" fill="currentColor" clip-rule="evenodd"
                                            d="M4 11c.55228 0 1 .4477 1 1v8a.99997.99997 0 0 0 1 1h12c.2652 0 .5196-.1054.7071-.2929A1.0001 1.0001 0 0 0 19 20v-8c0-.5523.4477-1 1-1s1 .4477 1 1v8a2.9999 2.9999 0 0 1-.8787 2.1213A2.9999 2.9999 0 0 1 18 23H6a3.00006 3.00006 0 0 1-3-3v-8c0-.5523.44772-1 1-1Zm8-10c.2652 0 .5196.10536.7071.29289l4 4c.3905.39053.3905 1.02369 0 1.41422-.3905.39052-1.0237.39052-1.4142 0L12 3.41421l-3.29289 3.2929c-.39053.39052-1.02369.39052-1.41422 0-.39052-.39053-.39052-1.02369 0-1.41422l4.00001-4A.99997.99997 0 0 1 12 1Z">
                                        </path>
                                        <path fill-rule="evenodd"
                                            d="M12 1c.5523 0 1 .44772 1 1v13c0 .5523-.4477 1-1 1s-1-.4477-1-1V2c0-.55228.4477-1 1-1Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <span class="text">@lang('Share')</span>
                            </button>

                            @if ($video->subtitles->count() > 0)
                                <button class="meta-buttons__button transcriptBtn" data-video_id="{{ $video->id }}" data-subtitles="{{ $video->subtitles->map(function($subtitle) { return ['id' => $subtitle->id, 'caption' => $subtitle->caption, 'language_code' => $subtitle->language_code, 'file_url' => asset(getFilePath('subtitle') . '/' . $subtitle->file)]; })->toJson() }}">
                                    <span class="icon">
                                        <i class="fa-solid fa-closed-captioning"></i>
                                    </span>
                                    <span class="text">@lang('Transcript')</span>
                                </button>
                            @endif


                            @auth
                                <button class="meta-buttons__button watchLater">
                                    <span class="icon">
                                        @if ($watchLater)
                                            <svg class="lucide lucide-square-check-big" xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M21 10.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.5" />
                                                <path d="m9 11 3 3L22 4" />
                                            </svg>
                                        @else
                                            <svg class="lucide lucide-clock" xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10" />
                                                <polyline points="12 6 12 12 16 14" />
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="text"> @lang('Watch Later')</span>
                                </button>

                                <button class="meta-buttons__button saveBtn">
                                    <span class="icon">

                                        <svg class="lucide lucide-save" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                                        </svg>
                                    </span>
                                    <span class="text"> @lang('Save to Playlist')</span>
                                </button>
                            @endauth
                        </div>
                    </div>
                    <div class="primary__channel">
                        <div class="author">

                            <a class="author__thumb" href="{{ route('preview.channel', $video->user->slug) }}">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . $video->user->image, isAvatar: true) }}"
                                    alt="image">
                            </a>

                            <div class="author__content">
                                <a href="{{ route('preview.channel', $video->user->slug) }}" class="channel-name">
                                    {{ $video->user->channel_name ? $video->user->channel_name : $video->user->fullname }}
                                </a>
                                <span class="author__subscriber"><span
                                        class="subscriberCount">{{ formatNumber($video->user->subscribers()->count()) }}</span>
                                    @lang('Subscriber')</span>
                            </div>
                        </div>


                        @if (@auth()->id() != $video->user_id)
                            @php
                                $subscribed = $video->user
                                    ->subscribers()
                                    ->where('following_id', auth()->id())
                                    ->exists();
                            @endphp

                            <div class="subscriber-btn">
                                <button
                                    class="btn cta @if (!$subscribed) btn--white subcriberBtn @else  btn--white outline unSubcriberBtn @endif">
                                    @if (!$subscribed)
                                        @lang('Subscribe')
                                        <span class="shape">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </span>
                                    @else
                                        @lang('Unsubscribe')
                                    @endif
                                </button>
                            </div>
                            </section>
                        @endif
                    </div>
                    <div class="primary__desc">
                        <div class="primary__desc-text">
                            @php
                                $descriptionLimit = 100;
                                echo $video->description;
                            @endphp
                        </div>
                        @if (strlen($video->description) > $descriptionLimit)
                            <button class="primary__desc-button">@lang('Show More')</button>
                        @endif
                    </div>

                    <div class="primary__comment d-none d-xl-block">
                        <div class="top">
                            <h5 class="comment-number"><span class="commentCount">{{ count($video->allComments) }}</span>
                                @lang('Comments')</h5>

                            <div class="dropdown comment-sort">
                                <button class="btn btn--sm  d-flex align-items-center gap-2" type="button"
                                    id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="me-1">@lang('Sort by')</span>
                                    <i class="fas fa-sort"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item sort-comments" href="javascript:void(0)"
                                            data-sort="top">@lang('Top comments')</a></li>
                                    <li><a class="dropdown-item sort-comments" href="javascript:void(0)"
                                            data-sort="newest">@lang('Newest first')</a></li>
                                    <li><a class="dropdown-item sort-comments" href="javascript:void(0)"
                                            data-sort="oldest">@lang('Oldest first')</a></li>
                                </ul>
                            </div>
                        </div>
                        @if (auth()->check())
                            <div class="comment-form-wrapper">
                                <span class="comment-author">
                                    <img class="fir-image"
                                        src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()->image, isAvatar: true) }}"
                                        alt="image">
                                </span>

                                <form class="comment-form" method="post">
                                    @csrf
                                    <div class="form-group position-relative">

                                        <textarea class="form--control commentBox" name="comment" placeholder="Add a comment"></textarea>

                                        <button type="button" class="emoji-picker-btn" title="Add emoji">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                                <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                            </svg>
                                        </button>

                                        <button type="button" class="media-upload-btn" title="Upload video or GIF" data-type="video">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                                <circle cx="12" cy="13" r="3"></circle>
                                            </svg>
                                        </button>

                                        <input type="file" name="comment_media" class="comment-media-input d-none" accept="video/*,image/gif">
                                        <div class="comment-media-preview d-none"></div>

                                        <div class="emoji-picker-container" style="display: none;">
                                            <div class="emoji-picker">
                                                <div class="emoji-picker-header">
                                                    <input type="text" class="emoji-search" placeholder="Search emoji">
                                                </div>
                                                <div class="emoji-picker-categories">
                                                    <button class="emoji-category-btn active" data-category="people">😀</button>
                                                    <button class="emoji-category-btn" data-category="nature">❄️</button>
                                                    <button class="emoji-category-btn" data-category="food">🍰</button>
                                                    <button class="emoji-category-btn" data-category="activity">⚽</button>
                                                    <button class="emoji-category-btn" data-category="travel">🚗</button>
                                                    <button class="emoji-category-btn" data-category="objects">💡</button>
                                                    <button class="emoji-category-btn" data-category="symbols">💎</button>
                                                </div>
                                                <div class="emoji-picker-content">
                                                    <div class="emoji-category-title">PEOPLE</div>
                                                    <div class="emoji-grid" data-category="people"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="comment-btn" type="submit">
                                            <svg class="lucide lucide-send-horizontal" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z" />
                                                <path d="M6 12h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="primary__comment-list comment-box__content d-none d-xl-block">
                    <div class="comment-bow-wrapper">
                        @include($activeTemplate . 'partials.video.comments')
                    </div>
                </div>
                <div class="text-center spinner mt-4 d-none w-100" id="loading-spinner">
                    <i class="las la-spinner"></i>
                </div>
            </div>
            <div class="secondary">

                @if (@$relatedPlaylistVideos)
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                @if (@$plan)
                                    <h4 class="card-title">@lang('Plan'): {{ __($plan->name) }} @if ($palyPlaylist->title)
                                            / <span class="fs-14">@lang('Playlist-')
                                                {{ __($palyPlaylist->title) }}</span>
                                        @endif
                                    </h4>
                                @else
                                    <h4 class="card-title">{{ __($palyPlaylist->title) }}</h4>
                                @endif
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <p>@lang('videos') - {{ request()->index }}/{{ count($relatedPlaylistVideos) }}</p>
                                    @if (
                                        !@$plan &&
                                            $palyPlaylist->playlist_subscription == Status::YES &&
                                            gs('is_playlist_sell') &&
                                            !@$isPurchased &&
                                            (!auth()->user() || $palyPlaylist->user_id !== auth()->id()))
                                        <p class="price-text">@lang('Price') -
                                            <span>{{ gs('cur_sym') }}{{ showAmount($palyPlaylist->price, currencyFormat: false) }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            @if (!@$plan)
                                @if ($palyPlaylist->playlist_subscription == Status::YES && gs('is_playlist_sell'))
                                    @if (@$isPurchased)
                                        @lang('Purchased')
                                    @elseif(!auth()->user() || $palyPlaylist->user_id !== auth()->id())
                                        <button class="btn btn--base btn--sm premium-stock-text purchase-now btn--purchase"
                                            type="button" data-resource="{{ $palyPlaylist }}">
                                            <span>@lang('Purchase Now')</span>
                                        </button>
                                    @endif
                                @endif
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="secondary__playlist  playlist-releted-card mt-0">

                                @include($activeTemplate . 'partials.video.related_playlist_video', [
                                    'relatedVideos' => $relatedPlaylistVideos,
                                    'playlist' => $palyPlaylist,
                                ])
                            </div>
                        </div>
                    </div>
                @endif


                <div class="tag_sliders owl-carousel">
                    <a class="tag-item" href="{{ route('category.video', 'all') }}">@lang('All')</a>
                    @foreach ($categories as $category)
                        <a class="tag-item"
                            href="{{ route('category.video', $category->slug) }}">{{ __($category->name) }}</a>
                    @endforeach
                </div>

                @if (@$planPlaylists)
                    <div class="card custom--card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4 class="card-title mb-0">@lang('Plan'): {{ __($plan->name) }} -
                                    {{ $planPlaylists->count() }} @lang('Playlists')</h4>
                                @if ($palyPlaylist->title)
                                    <a class="see-plan-video-link" href="{{ getPlanVideoUrl($plan) }}">
                                        @lang('See Plan Videos')
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class=" playlist-wrapper playlist-releted-card">
                                @include($activeTemplate . 'partials.video.plan_playlist')
                            </div>
                        </div>
                    </div>
                @endif
                <div class="secondary__playlist">
                    @include($activeTemplate . 'partials.video.related_video')
                </div>
            </div>
            <div class="primary__comment d-xl-none d-block mt-5 mb-4">
                <div class="top mb-3">
                    <h5 class="comment-number"><span class="commentCount">{{ count($video->allComments) }}</span>
                        @lang('Comments')</h5>

                    <div class="dropdown comment-sort">
                        <button class="btn btn--sm text-white d-flex align-items-center gap-2" type="button"
                            id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-1">@lang('Sort by')</span>
                            <i class="fas fa-sort"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item sort-comments" href="javascript:void(0)"
                                    data-sort="top">@lang('Top comments')</a></li>
                            <li><a class="dropdown-item sort-comments" href="javascript:void(0)"
                                    data-sort="newest">@lang('Newest first')</a></li>
                            <li><a class="dropdown-item sort-comments" href="javascript:void(0)"
                                    data-sort="oldest">@lang('Oldest first')</a></li>
                        </ul>
                    </div>
                </div>
                @if (auth()->check())
                    <div class="primary__comment">
                        <div class="comment-form-wrapper">
                            <span class="comment-author">
                                <img class="fir-image"
                                    src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()->image, isAvatar: true) }}"
                                    alt="image">
                            </span>

                            <form class="comment-form" method="post">
                                @csrf
                                <div class="form-group position-relative">
                                    <textarea class="form--control commentBox" name="comment" placeholder="Add a comment"></textarea>
                                    
                                    <button type="button" class="emoji-picker-btn" title="Add emoji">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                            <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                            <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                        </svg>
                                    </button>

                                    <button type="button" class="media-upload-btn" title="Upload video or GIF" data-type="video">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                            <circle cx="12" cy="13" r="3"></circle>
                                        </svg>
                                    </button>

                                    <input type="file" name="comment_media" class="comment-media-input d-none" accept="video/*,image/gif">
                                    <div class="comment-media-preview d-none"></div>

                                    <div class="emoji-picker-container" style="display: none;">
                                        <div class="emoji-picker">
                                            <div class="emoji-picker-header">
                                                <input type="text" class="emoji-search" placeholder="Search emoji">
                                            </div>
                                            <div class="emoji-picker-categories">
                                                <button class="emoji-category-btn active" data-category="people">😀</button>
                                                <button class="emoji-category-btn" data-category="nature">❄️</button>
                                                <button class="emoji-category-btn" data-category="food">🍰</button>
                                                <button class="emoji-category-btn" data-category="activity">⚽</button>
                                                <button class="emoji-category-btn" data-category="travel">🚗</button>
                                                <button class="emoji-category-btn" data-category="objects">💡</button>
                                                <button class="emoji-category-btn" data-category="symbols">💎</button>
                                            </div>
                                            <div class="emoji-picker-content">
                                                <div class="emoji-category-title">PEOPLE</div>
                                                <div class="emoji-grid" data-category="people"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="comment-btn" type="submit">
                                        <svg class="lucide lucide-send-horizontal" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z" />
                                            <path d="M6 12h16" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
            <div class="primary d-xl-none d-block comment-box__content">
                <div class="comment-bow-wrapper">
                    @include($activeTemplate . 'partials.video.comments')
                </div>
            </div>
        </div>
    </div>

    {{-- Transcript Panel --}}
    <div class="transcript-box">
        <div class="transcript-box__header">
            <h5 class="transcript-box__title">@lang('Transcript')</h5>
            <button class="transcript-box__close-icon">
                <i class="las la-times"></i>
            </button>
        </div>
        <div class="transcript-box__content">
            <div class="transcript-language-selector" style="padding: 15px 20px; border-bottom: 1px solid hsl(var(--white)/.1);">
                <label style="color: hsl(var(--white)); margin-right: 10px; display: inline-block; vertical-align: middle;">@lang('Language'):</label>
                <select class="form--control transcript-language-select" style="display: inline-block; width: auto; min-width: 200px; vertical-align: middle;">
                    <option value="">@lang('Select Language')</option>
                </select>
            </div>
            <div class="transcript-text-content" style="padding: 20px; overflow-y: auto; flex: 1;">
                <p style="color: hsl(var(--body-color)); text-align: center;">@lang('Select a language to view transcript')</p>
            </div>
        </div>
    </div>

    {{-- all modal --}}
  
    @include($activeTemplate . 'partials.play_video_page_modal')

    {{-- login modal --}}
    @include($activeTemplate . 'partials.login_alert_modal')






@endsection

@push('style')
   <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/play-video.css') }}">
   <style>
       /* Embed share item styling */
       .custom--modal .modal-body .share-item.embed {
           background: #6c757d;
       }
       
       .custom--modal .modal-body .share-item.embed:hover {
           background: #5a6268;
       }
       
       .embed-code-section {
           animation: slideDown 0.3s ease-out;
       }
       
       @keyframes slideDown {
           from {
               opacity: 0;
               transform: translateY(-10px);
           }
           to {
               opacity: 1;
               transform: translateY(0);
           }
       }

       /* Emoji Picker Styles */
       .emoji-picker-btn {
           position: absolute;
           right: 50px;
           bottom: 10px;
           background: transparent;
           border: none;
           cursor: pointer;
           color: hsl(var(--base));
           padding: 5px;
           display: flex;
           align-items: center;
           justify-content: center;
           z-index: 10;
           transition: all 0.2s ease;
       }

       .emoji-picker-btn:hover {
           color: hsl(var(--base));
           transform: scale(1.1);
       }

       .form-group.position-relative {
           position: relative;
       }

       .emoji-picker-container {
           position: absolute;
           bottom: 100%;
           left: 0;
           margin-bottom: 10px;
           z-index: 1000;
           background: hsl(var(--white));
           border-radius: 12px;
           box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
           overflow: hidden;
           width: 352px;
           max-width: calc(100vw - 20px);
       }

       [data-theme="dark"] .emoji-picker-container {
           background: hsl(var(--black));
           border: 1px solid hsl(var(--border-color));
       }

       .emoji-picker {
           display: flex;
           flex-direction: column;
           height: 435px;
       }

       .emoji-picker-header {
           padding: 12px;
           border-bottom: 1px solid hsl(var(--border-color));
       }

       .emoji-search {
           width: 100%;
           padding: 8px 12px;
           border: 1px solid hsl(var(--border-color));
           border-radius: 8px;
           font-size: 14px;
           background: hsl(var(--section-bg));
           color: hsl(var(--text-color));
       }

       .emoji-picker-categories {
           display: flex;
           padding: 8px;
           gap: 4px;
           border-bottom: 1px solid hsl(var(--border-color));
           overflow-x: auto;
       }

       .emoji-category-btn {
           background: transparent;
           border: none;
           padding: 8px;
           cursor: pointer;
           font-size: 20px;
           border-radius: 6px;
           transition: all 0.2s ease;
           flex-shrink: 0;
       }

       .emoji-category-btn:hover {
           background: hsl(var(--section-bg));
       }

       .emoji-category-btn.active {
           background: hsl(var(--base));
           opacity: 0.8;
       }

       .emoji-picker-content {
           flex: 1;
           overflow-y: auto;
           padding: 12px;
       }

       .emoji-category-title {
           font-size: 12px;
           font-weight: 600;
           color: hsl(var(--text-color));
           margin-bottom: 8px;
           text-transform: uppercase;
           letter-spacing: 0.5px;
       }

       .emoji-grid {
           display: grid;
           grid-template-columns: repeat(8, 1fr);
           gap: 4px;
       }

       .emoji-item {
           font-size: 24px;
           padding: 8px;
           cursor: pointer;
           text-align: center;
           border-radius: 6px;
           transition: all 0.2s ease;
           user-select: none;
       }

       .emoji-item:hover {
           background: hsl(var(--section-bg));
           transform: scale(1.2);
       }

       /* Reply form emoji picker positioning */
       .reply-form {
           position: relative;
       }

       .reply-form .emoji-picker-container {
           bottom: auto;
           top: 100%;
           margin-top: 10px;
       }

       .reply-form .emoji-picker-btn {
           position: absolute;
           right: 50px;
           bottom: 10px;
       }

       .comment-form .emoji-picker-btn {
           position: absolute;
           right: 50px;
           bottom: 10px;
       }

       /* Media Upload Button Styles */
       .media-upload-btn {
           position: absolute;
           right: 90px;
           bottom: 10px;
           background: transparent;
           border: none;
           cursor: pointer;
           color: hsl(var(--base));
           padding: 5px;
           display: flex;
           align-items: center;
           justify-content: center;
           z-index: 10;
           transition: all 0.2s ease;
       }

       .media-upload-btn:hover {
           color: hsl(var(--base));
           transform: scale(1.1);
       }

       .reply-form .media-upload-btn {
           position: absolute;
           right: 90px;
           bottom: 10px;
       }

       .comment-form .media-upload-btn {
           position: absolute;
           right: 90px;
           bottom: 10px;
       }

       /* Media Preview Styles */
       .comment-media-preview {
           margin-top: 10px;
           padding: 10px;
           background: hsl(var(--section-bg));
           border-radius: 8px;
           position: relative;
       }

       .comment-media-preview img,
       .comment-media-preview video {
           max-width: 100%;
           max-height: 200px;
           border-radius: 8px;
           display: block;
       }

       .comment-media-preview .remove-media {
           position: absolute;
           top: 5px;
           right: 5px;
           background: rgba(0, 0, 0, 0.7);
           color: white;
           border: none;
           border-radius: 50%;
           width: 24px;
           height: 24px;
           cursor: pointer;
           display: flex;
           align-items: center;
           justify-content: center;
           font-size: 14px;
       }

       .comment-media-preview .remove-media:hover {
           background: rgba(0, 0, 0, 0.9);
       }

       /* Transcript box styles for regular video player */
       .transcript-box {
           position: fixed;
           width: 400px;
           right: -420px;
           top: 50%;
           transform: translateY(-50%);
           height: 70vh;
           max-height: 600px;
           background-color: hsl(var(--bg-color));
           visibility: hidden;
           opacity: 0;
           transition: all 0.3s linear;
           z-index: 9999;
           overflow-y: hidden;
           border: 1px solid hsl(var(--white)/.1);
           border-radius: 8px;
           display: flex;
           flex-direction: column;
           box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
       }

       .transcript-box.show-transcript {
           visibility: visible;
           opacity: 1;
           right: 20px;
       }

       @media (max-width: 991px) {
           .transcript-box {
               width: 100%;
               height: 100vh;
               max-height: 100vh;
               right: -100%;
               top: 0;
               transform: none;
               border-radius: 0;
           }

           .transcript-box.show-transcript {
               right: 0;
           }
       }

       .transcript-box__header {
           display: flex;
           justify-content: space-between;
           align-items: center;
           margin-bottom: 0;
           padding: 20px;
           padding-bottom: 0;
           flex-shrink: 0;
           border-bottom: 1px solid hsl(var(--white)/.1);
       }

       .transcript-box__title {
           margin-bottom: 0;
           color: hsl(var(--white));
           font-size: 18px;
           font-weight: 600;
       }

       .transcript-box__close-icon {
           color: hsl(var(--white));
           background: transparent;
           border: none;
           cursor: pointer;
           font-size: 20px;
           padding: 5px;
           display: flex;
           align-items: center;
           justify-content: center;
       }

       .transcript-box__close-icon:hover {
           color: hsl(var(--base));
       }

       .transcript-box__content {
           display: flex;
           flex-direction: column;
           flex: 1;
           overflow: hidden;
       }

       .transcript-text-content {
           flex: 1;
           overflow-y: auto;
           padding: 20px;
           color: hsl(var(--white));
           line-height: 1.6;
       }

       .transcript-text-content::-webkit-scrollbar {
           width: 5px;
       }

       .transcript-text-content::-webkit-scrollbar-thumb {
           background: hsl(var(--white) / .2);
           border-radius: 10px;
       }

       .transcript-text-content::-webkit-scrollbar-track {
           background: transparent;
       }

       .transcript-text-content .transcript-cue {
           margin-bottom: 12px;
           padding: 8px;
           border-radius: 4px;
           transition: background-color 0.2s;
           cursor: pointer;
       }

       .transcript-text-content .transcript-cue:hover {
           background-color: hsl(var(--white) / .1);
       }

       .transcript-text-content .transcript-cue.active {
           background-color: hsl(var(--base) / .3);
       }

       .transcript-text-content .transcript-time {
           color: hsl(var(--body-color));
           font-size: 12px;
           margin-right: 8px;
           font-weight: 500;
       }

       .transcript-language-selector {
           flex-shrink: 0;
           position: relative;
           z-index: 10;
       }

       /* Override all global select styles for transcript dropdown */
       .transcript-language-select {
           padding: 10px 35px 10px 15px !important;
           border-radius: 6px !important;
           font-size: 14px !important;
           cursor: pointer !important;
           z-index: 1000 !important;
           position: relative !important;
           min-width: 200px !important;
           width: auto !important;
           display: inline-block !important;
           visibility: visible !important;
           opacity: 1 !important;
           /* Remove ALL arrows - override global styles */
           -webkit-appearance: none !important;
           -moz-appearance: none !important;
           appearance: none !important;
           -ms-expand: none !important;
           /* Remove any background images from global CSS */
           background-image: none !important;
           background-repeat: no-repeat !important;
           background-position: right 12px center !important;
           background-size: 12px 12px !important;
       }

       /* Remove any pseudo-element arrows from global CSS */
       .transcript-language-select::before,
       .transcript-language-select::after {
           display: none !important;
           content: none !important;
       }

       /* Remove arrows from parent elements */
       .transcript-language-selector::before,
       .transcript-language-selector::after {
           display: none !important;
           content: none !important;
       }

       /* Dark theme styles - dark background */
       [data-theme="dark"] .transcript-language-select {
           background: hsl(var(--bg-color)) !important;
           color: hsl(var(--white)) !important;
           border: 1px solid hsl(var(--white) / 0.2) !important;
           background-image: none !important;
       }

       /* Light theme styles - white background */
       [data-theme="light"] .transcript-language-select {
           background: #ffffff !important;
           color: hsl(var(--text-color)) !important;
           border: 1px solid hsl(var(--border-color)) !important;
           background-image: none !important;
       }

       .transcript-language-select option {
           padding: 10px 15px !important;
           display: block !important;
           visibility: visible !important;
       }

       /* Dark theme option styles - dark background */
       [data-theme="dark"] .transcript-language-select option {
           background: hsl(var(--bg-color)) !important;
           color: hsl(var(--white)) !important;
       }

       /* Light theme option styles - white background */
       [data-theme="light"] .transcript-language-select option {
           background: #ffffff !important;
           color: hsl(var(--text-color)) !important;
       }

       /* Dark theme focus */
       [data-theme="dark"] .transcript-language-select:focus {
           outline: 2px solid hsl(var(--base)) !important;
           outline-offset: 2px !important;
           border-color: hsl(var(--base)) !important;
           background-color: hsl(var(--bg-color)) !important;
           background-image: none !important;
       }

       /* Light theme focus */
       [data-theme="light"] .transcript-language-select:focus {
           outline: 2px solid hsl(var(--base)) !important;
           outline-offset: 2px !important;
           border-color: hsl(var(--base)) !important;
           background-color: #ffffff !important;
           background-image: none !important;
       }

       .transcript-language-select:hover {
           border-color: hsl(var(--base)) !important;
       }

       /* Remove black background from related video players */
       .related-video-player,
       .related-video-player video,
       .video-item__thumb .related-video-player,
       .video-item__thumb .related-video-player video,
       .secondary__playlist .related-video-player,
       .secondary__playlist .related-video-player video {
           background: transparent !important;
           background-color: transparent !important;
       }

       /* Remove background from Plyr wrapper for related videos */
       .video-item__thumb .plyr,
       .video-item__thumb .plyr--video,
       .video-item__thumb .plyr__video-wrapper,
       .secondary__playlist .plyr,
       .secondary__playlist .plyr--video,
       .secondary__playlist .plyr__video-wrapper {
           background: transparent !important;
           background-color: transparent !important;
       }

       /* Ensure video element itself has no background */
       .video-item__thumb video.related-video-player {
           background: transparent !important;
           background-color: transparent !important;
       }

       /* Remove border radius from related video thumbnails - make them square */
       .secondary__playlist .video-item__thumb,
       .secondary__playlist .video-item__thumb img,
       .secondary__playlist .video-item__thumb video,
       .secondary__playlist .video-item__thumb .related-video-player,
       .secondary__playlist .video-item__thumb .plyr,
       .secondary__playlist .video-item__thumb .plyr--video,
       .secondary__playlist .video-item__thumb .plyr__video-wrapper {
           border-radius: 0 !important;
       }

       /* Fix thumbnail fitting - ensure video/image fills container completely */
       .secondary__playlist .video-item__thumb,
       .play-video .secondary__playlist .video-item__thumb {
           position: relative !important;
           overflow: hidden !important;
           display: block !important;
           background: transparent !important;
           background-color: transparent !important;
       }

       /* Remove any transforms or positioning that might shift content */
       .secondary__playlist .video-item__thumb video,
       .secondary__playlist .video-item__thumb .related-video-player,
       .secondary__playlist .video-item__thumb .video-player,
       .secondary__playlist .video-item__thumb img,
       .play-video .secondary__playlist .video-item__thumb video,
       .play-video .secondary__playlist .video-item__thumb .related-video-player,
       .play-video .secondary__playlist .video-item__thumb .video-player,
       .play-video .secondary__playlist .video-item__thumb img {
           position: absolute !important;
           top: 0 !important;
           left: 0 !important;
           right: 0 !important;
           bottom: 0 !important;
           width: 100% !important;
           height: 100% !important;
           min-width: 100% !important;
           min-height: 100% !important;
           max-width: 100% !important;
           max-height: 100% !important;
           object-fit: cover !important;
           object-position: center center !important;
           display: block !important;
           margin: 0 !important;
           padding: 0 !important;
           transform: none !important;
           vertical-align: top !important;
       }

       /* Ensure Plyr wrapper fills container completely */
       .secondary__playlist .video-item__thumb .plyr,
       .secondary__playlist .video-item__thumb .plyr--video,
       .secondary__playlist .video-item__thumb .plyr__video-wrapper,
       .secondary__playlist .video-item__thumb .plyr__poster,
       .play-video .secondary__playlist .video-item__thumb .plyr,
       .play-video .secondary__playlist .video-item__thumb .plyr--video,
       .play-video .secondary__playlist .video-item__thumb .plyr__video-wrapper,
       .play-video .secondary__playlist .video-item__thumb .plyr__poster {
           position: absolute !important;
           top: 0 !important;
           left: 0 !important;
           right: 0 !important;
           bottom: 0 !important;
           width: 100% !important;
           height: 100% !important;
           margin: 0 !important;
           padding: 0 !important;
           transform: none !important;
       }

       .secondary__playlist .video-item__thumb .plyr video,
       .secondary__playlist .video-item__thumb .plyr__video-wrapper video,
       .play-video .secondary__playlist .video-item__thumb .plyr video,
       .play-video .secondary__playlist .video-item__thumb .plyr__video-wrapper video {
           position: absolute !important;
           top: 0 !important;
           left: 0 !important;
           right: 0 !important;
           bottom: 0 !important;
           width: 100% !important;
           height: 100% !important;
           min-width: 100% !important;
           min-height: 100% !important;
           max-width: 100% !important;
           max-height: 100% !important;
           object-fit: cover !important;
           object-position: center center !important;
           margin: 0 !important;
           padding: 0 !important;
           transform: none !important;
       }
   </style>
@endpush

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

            let itemPrice = 0;
            let amount = parseFloat($('.amount').val() || 0);
            $(document).on('click', 'button.cta', function() {
                $(this).addClass('active');
                setTimeout(() => {
                    $(this).removeClass('active');
                }, 300);
            });

            $(document).ready(function() {
                $('.primary__desc-button').on('click', function() {
                    var descText = $('.primary__desc-text');
                    if (descText.hasClass('expanded')) {
                        descText.removeClass('expanded').css('max-height', '100px');
                        $(this).text('@lang('Show More')');
                    } else {
                        var scrollHeight = descText.prop('scrollHeight');
                        descText.addClass('expanded').css('max-height', scrollHeight + 'px');
                        $(this).text('@lang('Show Less')');
                    }
                });
            });


            $(document).ready(function() {
                $(document).on('input', '.commentBox', function() {
                    $(this).css('height', 'auto');
                    $(this).css('height', this.scrollHeight + 'px');

                });
            });


            const auth = "{{ auth()->user() }}";
            $('.submitBtn').on('click', function(e) {
                e.preventDefault();
                const url = "{{ route('user.video.add.playlist') }}";
                const formData = $('.add-video-form').serialize();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        $('#addVideoModal').modal('hide');


                        if (response.error) {
                            notify('error', response.error)
                        } else {
                            notify('success', response.success)
                        }
                    }

                });
            });


            $(document).ready(function() {
                // for vidoe player
                const purchasedTrue = "{{ $purchasedTrue }}"
                const authVideo = "{{ $video->user_id == auth()->id() }}"

                var controls = [];
                if (purchasedTrue || authVideo) {
                    controls = [
                        'rewind',
                        'play',
                        'fast-forward',
                        'progress',
                        'current-time',
                        'duration',
                        'mute',
                        'volume',
                        'settings',
                        'fullscreen',
                        'pip',

                    ];
                } else if (!auth) {
                    controls = [
                        'play-large',
                    ];
                    $(document).on('click', '.plyr__control--overlaid, .primary__videoPlayer ', function() {
                        singleplayer.pause();
                        $('#existModalCenter').modal('show');
                    });
                } else {
                    controls = [
                        'rewind',
                        'play',
                        'fast-forward',
                        'progress',
                        'current-time',
                        'duration',
                        'mute',
                        'volume',
                        'settings',
                        'fullscreen',
                        'pip',
                    ];
                }

                const singleplayer = new Plyr('.video-player', {
                    controls,
                    ratio: '16:9',
                    autoplay: true, // Enable autoplay
                    muted: true, // Start muted for autoplay compatibility
                    captions: {
                        active: true,
                        language: 'auto',
                        update: false
                    },
                    quality: {
                        default: 720,
                        options: [1080, 720, 480, 360, 240],
                        forced: true,
                        onChange: (quality) => {
                            // Handle quality change
                            console.log('Quality changed to:', quality);
                        }
                    }
                });

                // Enable captions if subtitles exist
                @if($video->subtitles->count() > 0)
                singleplayer.on('ready', function() {
                    // Enable captions by default
                    const tracks = singleplayer.media.textTracks;
                    if (tracks && tracks.length > 0) {
                        // Find the default track or first track
                        let defaultTrack = null;
                        for (let i = 0; i < tracks.length; i++) {
                            if (tracks[i].mode === 'showing' || tracks[i].default) {
                                defaultTrack = tracks[i];
                                break;
                            }
                        }
                        if (!defaultTrack && tracks.length > 0) {
                            defaultTrack = tracks[0];
                        }
                        if (defaultTrack) {
                            defaultTrack.mode = 'showing';
                        }
                    }
                });
                @endif
                
                // Make singleplayer globally accessible for transcript functionality
                window.singleplayer = singleplayer;


                const loader = document.getElementById('loader');


                $(document).ready(function() {
                    // Keep muted initially for autoplay compatibility
                    // Video will unmute after it starts playing
                });


                $(document).ready(function() {
                    // Unmute after video starts playing (for autoplay compatibility)
                    singleplayer.on('playing', function() {
                        if (singleplayer.muted) {
                            singleplayer.muted = false;
                        }
                    });
                    const palyPlaylist = @json(!blank($palyPlaylist));
                    const relatedVideo = @json(@$relatedVideos[0]);

                    singleplayer.once('ended', function() {
                        // Navigate to next video when current video ends
                        navigateToNextVideo();
                    });
                    
                    function navigateToNextVideo() {
                        if (palyPlaylist) {
                            const currentIndex = "{{ request()->index }}";
                            const index = parseInt(currentIndex);
                            const relatedPlaylistVideos = @json($relatedPlaylistVideos);

                            if (index - 1 < relatedPlaylistVideos.length) {
                                const nextVideo = relatedPlaylistVideos[index];

                                if (`{{ $plan && $plan->count() > 0 }}`) {
                                    if (`{{ !@$palyPlaylist->title }}`) {
                                        window.location.href =
                                            "{{ route('video.play', ['', '']) }}/" +
                                            nextVideo.id + "/" + nextVideo.slug +
                                            "?plan={{ @$plan->slug }}&index=" + (index + 1);
                                    } else {
                                        window.location.href =
                                            "{{ route('video.play', ['', '']) }}/" +
                                            nextVideo.id + "/" + nextVideo.slug +
                                            "?list={{ @$palyPlaylist->slug }}&index=" + (
                                                index + 1) + "&plan={{ @$plan->slug }}";
                                    }
                                } else {
                                    window.location.href =
                                        "{{ route('video.play', ['', '']) }}/" +
                                        nextVideo.id + "/" + nextVideo.slug +
                                        "?list={{ @$palyPlaylist->slug }}&index=" + (index + 1);
                                }
                            }
                        } else {
                            if (relatedVideo && Array(relatedVideo).length > 0) {
                                window.location.href = "{{ route('video.play', ['', '']) }}/" +
                                    relatedVideo?.id + "/" + relatedVideo?.slug;
                            }
                        }
                    }


                });


                let adPlayer = null;

                function adVideoPlayer(skipAfterSeconds) {
                    // Destroy existing player if any
                    if (adPlayer) {
                        try {
                            adPlayer.destroy();
                            adPlayer = null;
                        } catch(e) {
                            console.log('Error destroying ad player:', e);
                        }
                    }
                    
                    // Wait a bit for DOM to update, then initialize Plyr
                    setTimeout(function() {
                        const adVideoElement = document.querySelector('.ad-player');
                        if (!adVideoElement) {
                            console.error('Ad video element not found in DOM');
                            return;
                        }
                        
                        console.log('Initializing Plyr for ad video');
                        
                        try {
                            adPlayer = new Plyr(adVideoElement, {
                                controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
                                ratio: '16:9',
                                autoplay: true,
                                muted: true, // Start muted for autoplay
                            });
                            
                            if (!adPlayer) {
                                console.error('Failed to create Plyr instance');
                                return;
                            }
                            
                            // Set up timeupdate event for skip button
                            adPlayer.on('timeupdate', function() {
                                if (!adPlayer) return;
                                const skipAfter = skipAfterSeconds || 5;
                                const currentAdTime = Math.floor(adPlayer.currentTime);
                                let remainingTime = skipAfter - currentAdTime;
                                if (skipAfter > 0 && remainingTime > 0) {
                                    $('.skip-btn').attr('disabled', true).removeClass('d-none');
                                    $('.skip-btn').text(`Skip in ${remainingTime} seconds`)
                                        .removeClass('btn--base');
                                } else {
                                    $('.skip-btn').attr('disabled', false).addClass('skipAd')
                                        .addClass('btn--base');
                                    $('.skip-btn').text('Skip');
                                }
                            });

                            // Set up ended event
                            adPlayer.once('ended', function() {
                                if (!adPlayer) return;
                                adPlayer.pause();
                                $('.adVideo').addClass('d-none');
                                $('.adVideo').empty();
                                $('.mainVideo').removeClass('d-none');
                                
                                // Handle different ad types
                                if (currentAdType == 1) {
                                    // Pre-roll: Start main video
                                    preRollPlayed = true;
                                    resetPlayFlag(); // Reset flag so video can play
                                    singleplayer.play();
                                } else if (currentAdType == 3) {
                                    // Post-roll: Video already ended, don't restart
                                    postRollPlayed = true;
                                } else {
                                    // Mid-roll: Resume main video
                                    singleplayer.play();
                                }
                                
                                adPlaying = false;
                                currentAdType = null;
                            });
                            
                            // Unmute after user interaction or when playing
                            adPlayer.on('ready', function() {
                                console.log('Ad player ready');
                                // Try to unmute and play
                                setTimeout(function() {
                                    if (adPlayer) {
                                        adPlayer.muted = false;
                                        adPlayer.play().then(function() {
                                            console.log('Ad video playing successfully');
                                        }).catch(function(error) {
                                            console.log('Ad play error on ready:', error);
                                            // Try with muted autoplay
                                            if (adPlayer) {
                                                adPlayer.muted = true;
                                                adPlayer.play().catch(function(err) {
                                                    console.log('Ad play error even muted:', err);
                                                });
                                            }
                                        });
                                    }
                                }, 100);
                            });
                            
                            // Also try to play when video can play
                            adVideoElement.addEventListener('canplay', function() {
                                console.log('Ad video can play');
                                if (adPlayer && adPlayer.paused) {
                                    adPlayer.play().catch(function(error) {
                                        console.log('Ad play error on canplay:', error);
                                    });
                                }
                            });
                            
                            // Play immediately
                            setTimeout(function() {
                                if (adPlayer) {
                                    adPlayer.play().then(function() {
                                        console.log('Ad video playing');
                                    }).catch(function(error) {
                                        console.log('Ad play error:', error);
                                        // Try unmuted play after user interaction
                                        document.addEventListener('click', function playAdOnClick() {
                                            if (adPlayer && adPlayer.paused) {
                                                adPlayer.muted = false;
                                                adPlayer.play().catch(function(err) {
                                                    console.log('Ad play retry error:', err);
                                                });
                                                document.removeEventListener('click', playAdOnClick);
                                            }
                                        }, { once: true });
                                    });
                                }
                            }, 300);
                        } catch(error) {
                            console.error('Error initializing ad player:', error);
                        }
                    }, 200);
                }

                $(document).ready(function() {
                    let adTriggers = @json($adsDurations).map(Number);
                    let currentAdIndex = 0;
                    let adPlaying = false;
                    let preRollPlayed = false;
                    let postRollPlayed = false;
                    let currentAdType = null; // Track current ad type: 1=pre-roll, 2=mid-roll, 3=post-roll

                    let requestPending = false;
                    let adVideo = $('.adVideo');
                    let slug = "{{ $video->slug }}"

                    function playAd(response) {
                        console.log('Playing ad:', response.data); // Debug
                        const adId = response.data.ad_id;
                        const encryptedVideoId = "{{ encrypt(@$video->id) }}";
                        const skipAfter = response.data.skip_after || 5;
                        adPlaying = true;
                        singleplayer.pause();
                        $('.mainVideo').addClass('d-none');

                        // Build action URL
                        let actionUrl = response.data.action_url || response.data.ad_url || '';
                        let clickUrl = actionUrl;
                        if (!response.data.is_video_ad && actionUrl) {
                            clickUrl = "{{ route('redirect.ad', ['', '']) }}/" + adId + "/" + encryptedVideoId;
                        }

                        console.log('Ad video source:', response.data.ad_video_src); // Debug

                        // Create video element with proper attributes
                        const videoHtml = `
                            <video class="ad-player" playsinline controls autoplay muted preload="auto">
                                <source src="${response.data.ad_video_src}" type="video/mp4" />
                                Your browser does not support the video tag.
                            </video>
                            ${(response.data.ad_type == 2 || response.data.ad_type == 3) ?
                            `<div class="ad-info"><div class="ad-info__thumb"><img src="${response.data.ad_logo || ''}">
                            </div><div class="ad-info__content"><p>${response.data.ad_url || response.data.ad_title || ''}</p>
                            ${clickUrl ? `<a href="${clickUrl}" class="text-white" target="_blank">${response.data.button_label || 'Visit'}</a>` : ''}
                            </div></div>` : ''}
                            <button class="skip-btn btn btn--base btn--sm ad-btn" type="button" style="display:none;">Skip</button>`;

                        adVideo.html(videoHtml);
                        adVideo.removeClass('d-none');
                        
                        // Track play for VideoAd
                        if (response.data.is_video_ad) {
                            fetch('{{ route("video.ad.play") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    ad_id: adId
                                })
                            }).catch(err => {
                                console.log('VideoAd play tracking error:', err);
                            });
                        }
                        
                        // Wait for DOM to update before initializing player
                        setTimeout(function() {
                            // Initialize and play ad - event listeners will be attached inside adVideoPlayer
                            adVideoPlayer(skipAfter);
                        }, 100);
                    }

                    function requestAd(adType = null) {
                        if (requestPending) {
                            console.log('Ad request already pending');
                            return;
                        }
                        requestPending = true;
                        currentAdType = adType;
                        
                        console.log('Requesting ad, type:', adType, 'Video ID:', "{{ encrypt($video->id) }}");
                        
                        $.ajax({
                            type: "get",
                            url: "{{ route('fetch.ad') }}",
                            data: {
                                video_id: "{{ encrypt($video->id) }}",
                                ad_type: adType // 1=pre-roll, 2=mid-roll, 3=post-roll
                            },
                            dataType: "json",
                            success: function(response) {
                                console.log('Ad response received:', response);
                                if (response.status == 'success') {
                                    // Don't mark preRollPlayed here - it will be marked when ad finishes or is skipped
                                    playAd(response);
                                } else {
                                    // No ad available
                                    console.log('No ad available, response:', response);
                                    requestPending = false;
                                    currentAdType = null;
                                    resetPlayFlag(); // Reset flag
                                    
                                    // If pre-roll and no ad, start video
                                    if (adType == 1 && !preRollPlayed) {
                                        preRollPlayed = true;
                                        const audience = "{{ $video->audience }}";
                                        if (audience == 0) {
                                            if (purchasedTrue || authVideo) {
                                                console.log('Starting video (no pre-roll ad available)');
                                                singleplayer.play();
                                            }
                                        } else {
                                            // Video requires purchase, don't auto-play
                                            resetPlayFlag();
                                        }
                                    }
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Ad request error:', error, 'Status:', status, 'Response:', xhr.responseText);
                                requestPending = false;
                                currentAdType = null;
                                resetPlayFlag(); // Reset flag
                                
                                // If pre-roll and error, start video
                                if (adType == 1 && !preRollPlayed) {
                                    preRollPlayed = true;
                                    const audience = "{{ $video->audience }}";
                                    if (audience == 0) {
                                        if (purchasedTrue || authVideo) {
                                            console.log('Starting video (ad request error)');
                                            singleplayer.play();
                                        }
                                    } else {
                                        // Video requires purchase, don't auto-play
                                        resetPlayFlag();
                                    }
                                }
                            },
                            complete: function() {
                                requestPending = false;
                            }
                        });
                    }
                    
                    // Pre-roll ad: Play before video starts
                    function playPreRollAd() {
                        if (preRollPlayed || adPlaying || requestPending) {
                            console.log('Pre-roll skipped:', {preRollPlayed, adPlaying, requestPending});
                            return;
                        }
                        console.log('Playing pre-roll ad');
                        // Don't mark preRollPlayed here - it will be marked when ad finishes or is skipped
                        requestAd(1); // 1 = pre-roll
                    }
                    
                    // Post-roll ad: Play after video ends
                    function playPostRollAd() {
                        if (postRollPlayed || adPlaying || requestPending) return;
                        console.log('Playing post-roll ad');
                        requestAd(3); // 3 = post-roll
                        postRollPlayed = true;
                    }
                    
                    // Show loader when video is buffering
                    singleplayer.on('waiting', () => {
                        loader.style.display = 'block';
                    });

                    // Hide loader when playback starts or resumes
                    singleplayer.on('playing', () => {
                        loader.style.display = 'none';
                    });

                    // Hide loader on video end
                    singleplayer.on('ended', () => {
                        loader.style.display = 'none';
                    });

                    // Autoplay video when ready
                    singleplayer.on('ready', function() {
                        const audience = "{{ $video->audience }}";
                        if (audience == 0) {
                            if (purchasedTrue || authVideo) {
                                singleplayer.play().catch(function(error) {
                                    console.log('Autoplay failed, user interaction required:', error);
                                });
                            }
                        }
                    });

                    $(document).on('click', '.skipAd', function() {
                        adPlayer.pause();
                        $('.adVideo').addClass('d-none');
                        $('.primary_ad_player').empty();
                        $('.mainVideo').removeClass('d-none');
                        
                        // Handle different ad types
                        if (currentAdType == 1) {
                            // Pre-roll: Start main video
                            preRollPlayed = true;
                            resetPlayFlag(); // Reset flag so video can play
                            singleplayer.play();
                        } else if (currentAdType == 3) {
                            // Post-roll: Don't restart video (it already ended)
                            postRollPlayed = true;
                        } else {
                            // Mid-roll: Resume main video
                            singleplayer.play();
                        }
                        
                        adPlaying = false;
                        currentAdType = null;
                    })
                });

                const players = Plyr.setup('.related-video-player', {
                    controls: [],
                    ratio: '16:9',
                    muted: true,
                });








                // Autoplay video when page loads
                $(document).ready(function() {
                    const audience = "{{ $video->audience }}";
                    if (audience == 0) {
                        if (purchasedTrue || authVideo) {
                            setTimeout(function() {
                                singleplayer.play().catch(function(error) {
                                    console.log('Autoplay failed:', error);
                                });
                            }, 500);
                        }
                    }
                });

                $('.SeeBtn').on('click', function() {
                    $('.hidden-content').addClass('d-none');
                    singleplayer.play();
                });

                $('.reactionBtn').on('click', function() {
                    if (!auth) {
                        $('#existModalCenter').modal('show');
                        return;
                    }
                    const value = $(this).data('reaction');
                    const button = $(this);

                    $.ajax({
                        type: "post",
                        url: "{{ route('user.reaction', $video->id) }}",
                        dataType: "json",
                        data: {
                            is_like: value,
                        },
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            const likeButton = $('.reactionBtn[data-reaction="1"]');
                            const dislikeButton = $('.reactionBtn[data-reaction="0"]');
                            const likeIcon = likeButton.find('.reactionIcon');
                            const dislikeIcon = dislikeButton.find('.reactionIcon');


                            if (response.remark == 'like') {
                                likeIcon.removeClass('vti-like').addClass('vti-like-fill');
                                $('.likeCount').text(response.data.like_count);

                                dislikeIcon.removeClass('vti-dislike-fill').addClass(
                                    'vti-dislike');

                            } else if (response.remark == 'like_remove') {
                                likeIcon.removeClass('vti-like-fill').addClass('vti-like');
                                $('.likeCount').text(response.data.like_count);

                            } else if (response.remark == 'dislike') {
                                dislikeIcon.removeClass('vti-dislike').addClass(
                                    'vti-dislike-fill');
                                likeIcon.removeClass('vti-like-fill').addClass('vti-like');
                                $('.likeCount').text(response.data.like_count);

                            } else if (response.remark == 'dislike_remove') {
                                dislikeIcon.removeClass('vti-dislike-fill').addClass(
                                    'vti-dislike');

                            } else if (response.status == 'status') {
                                notify('error', response.message.error);
                            } else {
                                notify('error', 'Failed to update reaction');
                                return;
                            }

                        }
                    });
                });
                // end reacrtion
            });


            // for subscribe

            $(document).on('click', '.unSubcriberBtn', function() {
                $('#unSubcriberModal').modal('show');
            });


            $(document).on('click', '.confirmUnsubscribe', function() {
                subscribers();
                $('#unSubcriberModal').modal('hide');
            });


            $(document).on('click', '.subcriberBtn', function() {
                subscribers();
            });




            function subscribers() {

                if (!auth) {
                    $('#existModalCenter').modal('show');
                    return;
                }

                $.ajax({
                    type: "post",
                    url: "{{ route('user.subscribe.channel', $video->user_id) }}",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {


                        $('.subscriberCount').text(response.data.subscriber_count);

                        if (response.remark === 'subscribed') {
                            $('.subscriber-btn').html(`
                  <button class="btn btn--white outline unSubcriberBtn"> @lang('Unsubscribe')</button> `)

                        } else if (response.remark === 'unsubscribe') {
                            $('.subscriber-btn').html(`
                 <button class="btn cta btn--white  subcriberBtn">@lang('Subscribe')
                                        <span class="shape">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </span></button>
                                    `)
                        } else {
                            notify('error', response.message);
                        }
                    }

                });
            }

            // end subscribe

            // for watch later

            $('.watchLater').on('click', function() {
                if (!auth) {
                    $('#existModalCenter').modal('show');
                    return;
                }
                var button = $(this);

                $.ajax({
                    type: "post",
                    url: "{{ route('user.watch.later', $video->id) }}",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.remark == 'add_watch_later') {
                            button.find('.icon').html(`
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-check-big">
                        <path d="M21 10.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.5" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                `);
                        } else if (response.remark == 'watch_later_remove') {
                            button.find('.icon').html(`
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                `);
                        }
                    }
                });
            });


            // end watch later

            // for share


            $('.shareBtn').on('click', function() {
                $('#shareModal').modal('show');
            });



            $(document).on('click', '.copyBtn', function(e) {

                var input = $(this).parent('.share-embed').find('.copyText');
                if (input && input.select) {
                    input.select();
                    try {
                        document.execCommand('SelectAll')
                        document.execCommand('Copy', false, null);
                        input.blur();
                        notify('success', `Copied successfully`);
                    } catch (err) {
                        alert('Please press Ctrl/Cmd + C to copy');
                    }
                }
            });

            // end share


            // for comment
            let currentPage = 1;

            let lastPage = false;

            let currentSort = 'newest';

            let isLoading = false;

            $('.dropdown-menu .sort-comments').on('click', function() {
                const sortBy = $(this).data('sort');
                currentSort = sortBy;
                currentPage = 1;
                lastPage = false;
                isLoading = false;

                $('.sort-comments').removeClass('active');
                $(this).addClass('active');

                $('.comment-box__content').empty();
                $('#loading-spinner').removeClass('d-none');

                loadMoreComments();

            });

            // Media upload functionality
            $(document).on('click', '.media-upload-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const form = $(this).closest('.comment-form, .reply-form');
                const fileInput = form.find('.comment-media-input');
                fileInput.click();
            });

            $(document).on('change', '.comment-media-input', function(e) {
                const file = this.files[0];
                if (!file) return;

                const form = $(this).closest('.comment-form, .reply-form');
                const preview = form.find('.comment-media-preview');
                const fileType = file.type;

                // Validate file type
                if (!fileType.startsWith('video/') && fileType !== 'image/gif') {
                    notify('error', 'Please select a video or GIF file');
                    $(this).val('');
                    return;
                }

                // Validate file size (max 10MB)
                const maxSize = 10 * 1024 * 1024; // 10MB
                if (file.size > maxSize) {
                    notify('error', 'File size must be less than 10MB');
                    $(this).val('');
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.empty();
                    if (fileType.startsWith('video/')) {
                        preview.append(`
                            <video controls style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                                <source src="${e.target.result}" type="${fileType}">
                            </video>
                            <button type="button" class="remove-media" title="Remove">×</button>
                        `);
                    } else if (fileType === 'image/gif') {
                        preview.append(`
                            <img src="${e.target.result}" alt="GIF preview" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                            <button type="button" class="remove-media" title="Remove">×</button>
                        `);
                    }
                    preview.removeClass('d-none');
                };
                reader.readAsDataURL(file);
            });

            $(document).on('click', '.remove-media', function(e) {
                e.preventDefault();
                const form = $(this).closest('.comment-form, .reply-form');
                const preview = form.find('.comment-media-preview');
                const fileInput = form.find('.comment-media-input');
                preview.addClass('d-none').empty();
                fileInput.val('');
            });

            $('.comment-form').on('submit', function(e) {
                e.preventDefault();

                if (!auth) {
                    $('#existModalCenter').modal('show');
                    return;
                }

                const form = $(this);
                const formData = new FormData();
                const fileInput = form.find('.comment-media-input')[0]; // Get native DOM element
                
                // Add form fields
                const commentText = form.find('textarea[name="comment"]').val();
                const csrfToken = form.find('input[name="_token"]').val();
                
                if (!commentText || commentText.trim() === '') {
                    notify('error', 'Please enter a comment');
                    return;
                }
                
                formData.append('comment', commentText);
                if (csrfToken) {
                    formData.append('_token', csrfToken);
                }
                
                    // Add media file if selected
                    if (fileInput && fileInput.files && fileInput.files.length > 0) {
                        const selectedFile = fileInput.files[0];
                        console.log('📤 Uploading file:', {
                            name: selectedFile.name,
                            size: selectedFile.size,
                            type: selectedFile.type,
                            sizeMB: (selectedFile.size / 1024 / 1024).toFixed(2) + ' MB'
                        });
                        formData.append('comment_media', selectedFile);
                    } else {
                        console.log('⚠️ No file selected for upload');
                    }

                console.log('🚀 Sending comment request to:', "{{ route('user.comment.submit', $video->id) }}");
                
                $.ajax({
                    type: "post",
                    url: "{{ route('user.comment.submit', $video->id) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log('✅ Comment submitted successfully:', response);
                        
                        if (response.status === 'success') {
                            // Check if media was uploaded
                            if (response.data && response.data.comment) {
                                const commentHtml = $(response.data.comment);
                                const mediaContainer = commentHtml.find('.comment-media');
                                const hasMedia = mediaContainer.length > 0;
                                
                                if (hasMedia) {
                                    const mediaUrl = mediaContainer.data('media-url');
                                    const mediaPath = mediaContainer.data('media-path');
                                    const mediaType = mediaContainer.data('media-type');
                                    const videoSource = commentHtml.find('video source').attr('src');
                                    const imgSource = commentHtml.find('img').attr('src');
                                    
                                    console.log('📹 Media found in comment:', {
                                        hasMedia: true,
                                        mediaType: mediaType,
                                        mediaPath: mediaPath,
                                        mediaUrl: mediaUrl,
                                        videoSource: videoSource,
                                        imgSource: imgSource,
                                        fullUrl: videoSource || imgSource
                                    });
                                    
                                    // Verify the media URL is accessible
                                    if (mediaUrl) {
                                        console.log('🔗 Media URL:', mediaUrl);
                                        console.log('📍 Full path should be: assets/comments/' + mediaPath);
                                    }
                                } else {
                                    console.warn('⚠️ No media found in comment HTML');
                                }
                            }
                            
                            $('.commentBox').css('height', '');
                            $('.comment-box__content').prepend(response.data.comment);
                            
                            // After prepending, check if media is visible
                            setTimeout(function() {
                                const insertedMedia = $('.comment-box__content .comment-media').first();
                                if (insertedMedia.length > 0) {
                                    const mediaUrl = insertedMedia.data('media-url');
                                    console.log('✅ Media element inserted:', {
                                        exists: true,
                                        url: mediaUrl,
                                        visible: insertedMedia.is(':visible')
                                    });
                                    
                                    // Check if video can load
                                    const video = insertedMedia.find('video');
                                    if (video.length > 0) {
                                        video.on('loadedmetadata', function() {
                                            console.log('✅ Video metadata loaded successfully');
                                        });
                                        video.on('error', function(e) {
                                            console.error('❌ Video load error:', {
                                                error: e,
                                                src: video.find('source').attr('src')
                                            });
                                        });
                                    }
                                } else {
                                    console.warn('⚠️ Media element not found after insertion');
                                }
                            }, 100);
                            
                            form.trigger('reset');
                            form.find('.comment-media-preview').addClass('d-none').empty();
                            // Reset file input
                            if (fileInput) {
                                fileInput.value = '';
                            }
                            $('.commentCount').text(response.data.comment_count);
                            
                            console.log('✅ Comment displayed successfully');

                        } else {
                            notify('error', response.message.error);
                        }
                    },
                    error: function(xhr) {
                        console.error('❌ Comment submission failed:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            response: xhr.responseJSON,
                            responseText: xhr.responseText
                        });
                        
                        let errorMessage = 'An error occurred while submitting the comment';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            if (xhr.responseJSON.message.error) {
                                errorMessage = Array.isArray(xhr.responseJSON.message.error) 
                                    ? xhr.responseJSON.message.error.join(' ') 
                                    : xhr.responseJSON.message.error;
                            } else if (typeof xhr.responseJSON.message === 'string') {
                                errorMessage = xhr.responseJSON.message;
                            } else if (Array.isArray(xhr.responseJSON.message)) {
                                errorMessage = xhr.responseJSON.message.join(' ');
                            }
                        }
                        notify('error', errorMessage);
                    }
                });
            });

            $('.comment-box__content').on('scroll', function() {
                if (isLoading) return;
                let commentBox = $(this);
                let scrollTop = commentBox.scrollTop();
                let boxHeight = commentBox.outerHeight();
                let contentHeight = commentBox[0].scrollHeight;
                if (scrollTop + boxHeight >= contentHeight - 2 && !lastPage) {
                    currentPage++;
                    loadMoreComments();
                }
            });

            function loadMoreComments() {

                if (isLoading) return;
                isLoading = true;

                const commentsRoute = "{{ route('user.comment.get', $video->id) }}";
                $('#loading-spinner').removeClass('d-none');
                $.ajax({
                    url: `${commentsRoute}?page=${currentPage}&sort_by=${currentSort}`,
                    type: 'GET',
                    success: function(response) {
                        $('#loading-spinner').addClass('d-none');
                        if (response.status == 'success') {
                            $('.comment-box__content').append(response.data.commentHtml);
                            $('.commentCount').text(response.data.comment_count);
                            if (currentPage >= response.data.last_page) {
                                lastPage = true;
                            }
                        } else {
                            notify('error', response.message.error);
                        }
                    },
                    complete: function() {
                        isLoading = false;
                    }
                });
            }

            $(document).on('click', '.reply', function() {
                const replyForm = $(this).closest('.comment-box-item__content').find('.reply-form').first();
                replyForm.toggleClass('d-none');
            });


            $(document).on('submit', '.reply-form', function(e) {
                e.preventDefault();

                if (!auth) {
                    $('#existModalCenter').modal('show');
                    return;
                }

                const form = $(this);
                const formData = new FormData();
                const fileInput = form.find('.comment-media-input')[0]; // Get native DOM element
                
                // Add form fields
                const commentText = form.find('textarea[name="comment"]').val();
                const replyTo = form.find('input[name="reply_to"]').val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content') || form.find('input[name="_token"]').val();
                
                if (!commentText || commentText.trim() === '') {
                    notify('error', 'Please enter a comment');
                    return;
                }
                
                formData.append('comment', commentText);
                formData.append('reply_to', replyTo);
                if (csrfToken) {
                    formData.append('_token', csrfToken);
                }
                
                    // Add media file if selected
                    if (fileInput && fileInput.files && fileInput.files.length > 0) {
                        const selectedFile = fileInput.files[0];
                        console.log('📤 Uploading reply file:', {
                            name: selectedFile.name,
                            size: selectedFile.size,
                            type: selectedFile.type,
                            sizeMB: (selectedFile.size / 1024 / 1024).toFixed(2) + ' MB'
                        });
                        formData.append('comment_media', selectedFile);
                    } else {
                        console.log('⚠️ No file selected for reply upload');
                    }

                console.log('🚀 Sending reply request to:', "{{ route('user.comment.reply') }}");
                
                $.ajax({
                    type: "post",
                    url: "{{ route('user.comment.reply') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log('✅ Reply submitted successfully:', response);
                        
                        if (response.status === 'success') {
                            // Check if media was uploaded in reply
                            if (response.data && response.data.reply) {
                                const replyHtml = $(response.data.reply);
                                const hasMedia = replyHtml.find('.comment-media').length > 0;
                                console.log('📹 Reply HTML received:', {
                                    hasMedia: hasMedia,
                                    mediaPath: replyHtml.find('.comment-media').data('media-path'),
                                    mediaUrl: replyHtml.find('.comment-media').data('media-url')
                                });
                            }
                            
                            form.trigger('reset');
                            form.find('.comment-media-preview').addClass('d-none').empty();
                            // Reset file input
                            if (fileInput) {
                                fileInput.value = '';
                            }
                            $('.commentBox').css('height', '');

                            var repliesContainer = form.closest('.parentComment').find(
                                '.reply-wrapper').first();

                            if (repliesContainer.length) {
                                repliesContainer.append(response.data.reply);
                                console.log('✅ Reply displayed successfully');
                            }

                            $('.commentCount').text(response.data.comment_count);
                        } else {
                            notify('error', response.message.error);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while submitting the reply';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            if (xhr.responseJSON.message.error) {
                                errorMessage = Array.isArray(xhr.responseJSON.message.error) 
                                    ? xhr.responseJSON.message.error.join(' ') 
                                    : xhr.responseJSON.message.error;
                            } else if (typeof xhr.responseJSON.message === 'string') {
                                errorMessage = xhr.responseJSON.message;
                            } else if (Array.isArray(xhr.responseJSON.message)) {
                                errorMessage = xhr.responseJSON.message.join(' ');
                            }
                        }
                        notify('error', errorMessage);
                    }
                });
            });


            $(document).on('click', '.show-reply', function() {
                var replies = $(this).next('.append-reply');
                if (replies.hasClass('d-none')) {
                    replies.removeClass('d-none').hide().slideDown();
                    $(this).find('.text').text('Hide Replies');
                    $(this).addClass('active');

                } else {
                    replies.slideUp(function() {
                        replies.addClass('d-none').show();
                    });
                    $(this).find('.text').text('Show Replies');
                    $(this).removeClass('active');

                }
            });


            // for reaction
            $(document).on('click', '.commentReaction', function() {
                if (!auth) {
                    $('#existModalCenter').modal('show');
                    return;
                }

                const value = $(this).data('reaction');
                const commentId = $(this).data('comment_id');
                const button = $(this);

                $.ajax({
                    type: "post",
                    url: "{{ route('user.comment.like.dislike') }}/" + commentId,
                    dataType: "json",
                    data: {
                        is_like: value,
                        comment_id: commentId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.remark === 'like') {
                            button.find('.reactionIcon').removeClass('vti-like').addClass(
                                'vti-like-fill');
                            button.siblings('.commentReaction').find('.reactionIcon').removeClass(
                                'vti-dislike-fill').addClass('vti-dislike');
                            button.find('.likeCount').text(response.data.like_count);

                        } else if (response.remark === 'like_remove') {
                            button.find('.reactionIcon').removeClass('vti-like-fill').addClass(
                                'vti-like');
                            button.find('.likeCount').text(response.data.like_count);

                        } else if (response.remark === 'dislike') {
                            button.find('.reactionIcon').removeClass('vti-dislike').addClass(
                                'vti-dislike-fill');
                            button.siblings('.commentReaction').find('.reactionIcon').removeClass(
                                'vti-like-fill').addClass('vti-like');
                            button.siblings('.commentReaction').find('.likeCount').text(response
                                .data.like_count);

                        } else if (response.remark === 'dislike_remove') {
                            button.find('.reactionIcon').removeClass('vti-dislike-fill').addClass(
                                'vti-dislike');

                        } else if (response.remark === 'video_not_found') {
                            notify('error', response.message.error);
                        } else {
                            notify('error', 'Failed to update reaction');
                        }

                    }
                });
            });
            // end comment

            // Handle embed option in share modal
            $(document).on('click', '.share-item.embed', function(e) {
                e.preventDefault();
                const embedCode = $(this).data('embed-code');
                const embedSection = $('.embed-code-section');
                const embedTextarea = $('.embedText');
                
                // Set embed code value
                embedTextarea.val(embedCode);
                embedSection.slideDown();
                
                // Scroll to embed section
                $('html, body').animate({
                    scrollTop: embedSection.offset().top - 100
                }, 300);
            });
            
            // Handle copy embed code button
            $(document).on('click', '.copyEmbedBtn', function() {
                const embedTextarea = $('.embedText');
                embedTextarea.select();
                try {
                    document.execCommand('copy');
                    embedTextarea.blur();
                    notify('success', 'Embed code copied successfully');
                } catch (err) {
                    // Fallback for modern browsers
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(embedTextarea.val()).then(function() {
                            notify('success', 'Embed code copied successfully');
                        });
                    } else {
                        alert('Please press Ctrl/Cmd + C to copy');
                    }
                }
            });
            
            // Reset embed section when share modal is closed
            $('#shareModal').on('hidden.bs.modal', function() {
                $('.embed-code-section').slideUp();
                $('.copyText').val('{{ route('video.play', [$video->id, $video->slug]) }}');
            });
            $('.saveBtn').on('click', function() {
                const modal = $('#addVideoModal');
                modal.find('.modal-title').text('Playlists');
                modal.modal('show')
            });

            if (!auth) {
                $(document).on('click', '.purchase-now', function(e) {
                    $('#existModalCenter').modal('show');
                });

            } else {

                $(document).on('click', '.purchase-now', function(e) {
                    e.preventDefault();
                    const modal = $('#paymentConfirmationModal');
                    const playlist = $(this).data('resource');
                    modal.find('[name=playlist_id]').val(playlist.id);
                    modal.find('[name=video_id]').val(0);
                    modal.find('.modal-title').text('Purchase this playlist to access its content');
                    modal.find('input[name="amount"]').val(parseFloat(playlist.price).toFixed(2)).trigger(
                        'input');
                    modal.find('.item-price').text(`${parseFloat(playlist.price)} {{ gs('cur_text') }}`);
                    modal.find('.item-name').text(`${playlist.title}`);
                    calculation();
                    modal.modal('show');
                });
            }

            var gateway, minAmount, maxAmount;

            $('.amount').on('input', function(e) {
                amount = parseFloat($(this).val());
                if (!amount) {
                    amount = 0;
                }
                calculation();
            });


            $('.gateway-input').on('change', function(e) {
                gatewayChange();
            });

            function gatewayChange() {
                let gatewayElement = $('.gateway-input:checked');
                let methodCode = gatewayElement.val();

                gateway = gatewayElement.data('gateway');
                minAmount = gatewayElement.data('min-amount');
                maxAmount = gatewayElement.data('max-amount');

                let processingFeeInfo =
                    `${parseFloat(gateway?.percent_charge).toFixed(2)}% with ${parseFloat(gateway?.fixed_charge).toFixed(2)} {{ __(gs('cur_text')) }} charge for payment gateway processing fees`
                $(".proccessing-fee-info").attr("data-bs-original-title", processingFeeInfo);
                calculation();
            }

            gatewayChange();

            $(".more-gateway-option").on("click", function(e) {
                let paymentList = $(".gateway-option-list");
                paymentList.find(".gateway-option").removeClass("d-none");
                $(this).addClass('d-none');
                paymentList.animate({
                    scrollTop: (paymentList.height() - 60)
                }, 'slow');
            });



            function calculation() {
                if (!gateway) return;
                $(".gateway-limit").text(minAmount + " - " + maxAmount);

                let percentCharge = 0;
                let fixedCharge = 0;
                let totalPercentCharge = 0;

                if (amount) {
                    percentCharge = parseFloat(gateway?.percent_charge);
                    fixedCharge = parseFloat(gateway?.fixed_charge);
                    totalPercentCharge = parseFloat(amount / 100 * percentCharge);
                }

                let totalCharge = parseFloat(totalPercentCharge + fixedCharge);
                let totalAmount = parseFloat((amount || 0) + totalPercentCharge + fixedCharge);

                $(".final-amount").text(totalAmount.toFixed(2));
                $(".processing-fee").text(totalCharge.toFixed(2));
                $("input[name=currency]").val(gateway.currency);
                $(".gateway-currency").text(gateway.currency);

                if (amount < Number(gateway.min_amount) || amount > Number(gateway.max_amount)) {
                    $(".deposit-form button[type=submit]").attr('disabled', true);
                } else {
                    $(".deposit-form button[type=submit]").removeAttr('disabled');
                }

                if (gateway.currency != "{{ gs('cur_text') }}" && gateway.method.crypto != 1) {
                    $('.deposit-form').addClass('adjust-height')

                    $(".gateway-conversion, .conversion-currency").removeClass('d-none');
                    $(".gateway-conversion").find('.deposit-info__input .text').html(
                        `1 {{ __(gs('cur_text')) }} = <span class="rate">${parseFloat(gateway.rate).toFixed(2)}</span>  <span class="method_currency">${gateway.currency}</span>`
                    );
                    $('.in-currency').text(parseFloat(totalAmount * gateway.rate).toFixed(gateway.method.crypto == 1 ?
                        8 : 2))
                } else {
                    $(".gateway-conversion, .conversion-currency").addClass('d-none');
                    $('.deposit-form').removeClass('adjust-height')
                }

                if (gateway.method.crypto == 1) {
                    $('.crypto-message').removeClass('d-none');
                } else {
                    $('.crypto-message').addClass('d-none');
                }
            }

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            $('.gateway-input').change();

            // Emoji Picker Functionality
            const emojiData = {
                people: ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😵', '🤯', '🤠', '🥳', '😎', '🤓', '🧐', '😕', '😟', '🙁', '☹️', '😮', '😯', '😲', '😳', '🥺', '😦', '😧', '😨', '😰', '😥', '😢', '😭', '😱', '😖', '😣', '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬', '😈', '👿', '💀', '☠️', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾'],
                nature: ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐽', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗', '🐴', '🦄', '🐝', '🐛', '🦋', '🐌', '🐞', '🐜', '🦟', '🦗', '🕷️', '🦂', '🐢', '🐍', '🦎', '🦖', '🦕', '🐙', '🦑', '🦐', '🦞', '🦀', '🐡', '🐠', '🐟', '🐬', '🐳', '🐋', '🦈', '🐊', '🐅', '🐆', '🦓', '🦍', '🦧', '🐘', '🦛', '🦏', '🐪', '🐫', '🦒', '🦘', '🦡', '🐃', '🐂', '🐄', '🐎', '🐖', '🐏', '🐑', '🦙', '🐐', '🦌', '🐕', '🐩', '🐈', '🦮', '🐕‍🦺', '🐓', '🦃', '🦅', '🦆', '🦢', '🦉', '🦚', '🦜', '🐇', '🦝', '🦨', '🦡', '🦦', '🦥', '🐁', '🐀', '🐿️', '🦔', '🌲', '🌳', '🌴', '🌵', '🌶️', '🌷', '🌺', '🌻', '🌼', '🌽', '🌾', '🌿', '🍀', '🍁', '🍂', '🍃', '🌱', '🌾', '🌿', '☘️', '🍀', '🍄', '🌰', '🦀', '🦞', '🦐', '🦑', '🌊', '🌋', '🗻', '🏔️', '⛰️', '🏕️', '🏖️', '🏜️', '🏝️', '🏞️', '🏟️', '🏛️', '🏗️', '🧱', '🏘️', '🏚️', '🏠', '🏡', '🏢', '🏣', '🏤', '🏥', '🏦', '🏨', '🏩', '🏪', '🏫', '🏬', '🏭', '🏯', '🏰', '💒', '🗼', '🗽', '⛪', '🕌', '🛕', '🕍', '⛩️', '🕋', '⛲', '⛺', '🌁', '🌃', '🏙️', '🌄', '🌅', '🌆', '🌇', '🌉', '♨️', '🎠', '🎡', '🎢', '💈', '🎪', '🚂', '🚃', '🚄', '🚅', '🚆', '🚇', '🚈', '🚉', '🚊', '🚝', '🚞', '🚋', '🚌', '🚍', '🚎', '🚐', '🚑', '🚒', '🚓', '🚔', '🚕', '🚖', '🚗', '🚘', '🚙', '🚚', '🚛', '🚜', '🏎️', '🏍️', '🛵', '🦽', '🦼', '🛴', '🚲', '🛺', '🚁', '🛸', '🚀', '🛩️', '✈️', '🛫', '🛬', '🪂', '💺', '🚢', '⛵', '🚤', '🛥️', '🛳️', '⛴️', '🚣', '🚁', '🚟', '🚠', '🚡', '🛰️', '🌠', '🌌', '⛅', '⛈️', '🌤️', '🌥️', '🌦️', '🌧️', '🌨️', '🌩️', '🌪️', '🌫️', '🌬️', '🌀', '🌈', '☂️', '☔', '⛱️', '⚡', '❄️', '☃️', '⛄', '☄️', '🔥', '💧', '🌊'],
                food: ['🍏', '🍎', '🍐', '🍊', '🍋', '🍌', '🍉', '🍇', '🍓', '🍈', '🍒', '🍑', '🥭', '🍍', '🥥', '🥝', '🍅', '🍆', '🥑', '🥦', '🥬', '🥒', '🌶️', '🌽', '🥕', '🥔', '🍠', '🥐', '🥯', '🍞', '🥖', '🥨', '🧀', '🥚', '🍳', '🥞', '🥓', '🥩', '🍗', '🍖', '🦴', '🌭', '🍔', '🍟', '🍕', '🥪', '🥙', '🌮', '🌯', '🥗', '🥘', '🥫', '🍝', '🍜', '🍲', '🍛', '🍣', '🍱', '🥟', '🍤', '🍙', '🍚', '🍘', '🍥', '🥠', '🥮', '🍢', '🍡', '🍧', '🍨', '🍦', '🥧', '🍰', '🎂', '🍮', '🍭', '🍬', '🍫', '🍿', '🍩', '🍪', '🌰', '🥜', '🍯', '🥛', '🍼', '☕', '🍵', '🥃', '🍶', '🍺', '🍻', '🥂', '🍷', '🥴', '🍸', '🍹', '🧃', '🧉', '🧊', '🥤', '🍽️', '🍴', '🥄', '🔪', '🏺'],
                activity: ['⚽', '🏀', '🏈', '⚾', '🥎', '🎾', '🏐', '🏉', '🥏', '🎱', '🏓', '🏸', '🏒', '🏑', '🥍', '🏏', '🥅', '⛳', '🏹', '🎣', '🥊', '🥋', '🎽', '🛹', '🛷', '⛸️', '🥌', '🎿', '⛷️', '🏂', '🏋️‍♀️', '🏋️', '🤼‍♀️', '🤼‍♂️', '🤸‍♀️', '🤸‍♂️', '⛹️‍♀️', '⛹️', '🤺', '🤾‍♀️', '🤾‍♂️', '🏌️‍♀️', '🏌️', '🏇', '🧘‍♀️', '🧘‍♂️', '🏄‍♀️', '🏄', '🏊‍♀️', '🏊', '🤽‍♀️', '🤽‍♂️', '🚣‍♀️', '🚣', '🧗‍♀️', '🧗‍♂️', '🚵‍♀️', '🚵', '🚴‍♀️', '🚴', '🏆', '🥇', '🥈', '🥉', '🏅', '🎖️', '🏵️', '🎗️', '🎫', '🎟️', '🎪', '🤹‍♀️', '🤹‍♂️', '🎭', '🩰', '🎨', '🎬', '🎤', '🎧', '🎼', '🎹', '🥁', '🎷', '🎺', '🎸', '🪕', '🎻', '🎲', '♟️', '🎯', '🎳', '🎮', '🎰', '🧩'],
                travel: ['🚗', '🚕', '🚙', '🚌', '🚎', '🏎️', '🚓', '🚑', '🚒', '🚐', '🚚', '🚛', '🚜', '🛴', '🚲', '🛵', '🏍️', '🛺', '🚨', '🚔', '🚍', '🚘', '🚖', '🚡', '🚠', '🚟', '🚃', '🚋', '🚞', '🚝', '🚄', '🚅', '🚈', '🚂', '🚆', '🚇', '🚊', '🚉', '✈️', '🛫', '🛬', '🛩️', '💺', '🚀', '🚁', '🛸', '🚢', '⛵', '🚤', '🛥️', '🛳️', '⛴️', '🚣', '⚓', '⛽', '🚧', '🚦', '🚥', '🗺️', '🗿', '🗽', '🗼', '🏰', '🏯', '🏟️', '🎡', '🎢', '🎠', '⛲', '⛱️', '🏖️', '🏝️', '🏜️', '🌋', '⛰️', '🏔️', '🗻', '🏕️', '⛺', '🏠', '🏡', '🏘️', '🏚️', '🏗️', '🏭', '🏢', '🏬', '🏣', '🏤', '🏥', '🏦', '🏨', '🏪', '🏫', '🏩', '💒', '🏛️', '⛪', '🕌', '🕍', '🕋', '⛩️', '🛤️', '🛣️', '🗾', '🎑', '🏞️', '🌅', '🌄', '🌠', '🎇', '🎆', '🌇', '🌆', '🏙️', '🌃', '🌌', '🌉', '🌁'],
                objects: ['⌚', '📱', '📲', '💻', '⌨️', '🖥️', '🖨️', '🖱️', '🖲️', '🕹️', '🗜️', '💾', '💿', '📀', '📼', '📷', '📸', '📹', '🎥', '📽️', '🎞️', '📞', '☎️', '📟', '📠', '📺', '📻', '🎙️', '🎚️', '🎛️', '⏱️', '⏲️', '⏰', '🕰️', '⌛', '⏳', '📡', '🔋', '🔌', '💡', '🔦', '🕯️', '🪔', '🧯', '🛢️', '💸', '💵', '💴', '💶', '💷', '💰', '💳', '💎', '⚖️', '🪜', '🧰', '🪛', '🔧', '🔨', '⚒️', '🛠️', '⛏️', '🪚', '🔩', '⚙️', '🪤', '🧱', '⛓️', '🧲', '🔫', '💣', '🧨', '🪓', '🔪', '🗡️', '⚔️', '🛡️', '🚬', '⚰️', '🪦', '⚱️', '🏺', '🔮', '📿', '🧿', '💈', '⚗️', '🔭', '🔬', '🕳️', '🩹', '🩺', '💊', '💉', '🩸', '🧬', '🦠', '🧫', '🧪', '🌡️', '🧹', '🪠', '🧺', '🧻', '🚽', '🚿', '🛁', '🛀', '🧼', '🪥', '🪒', '🧽', '🪣', '🧴', '🛎️', '🔑', '🗝️', '🚪', '🪑', '🛋️', '🛏️', '🛌', '🧸', '🪆', '🖼️', '🪞', '🪟', '🛍️', '🛒', '🎁', '🎈', '🎏', '🎀', '🪄', '🪅', '🎊', '🎉', '🎎', '🏮', '🎐', '🧧', '✉️', '📩', '📨', '📧', '💌', '📥', '📤', '📦', '🏷️', '🪧', '📪', '📫', '📬', '📭', '📮', '📯', '📜', '📃', '📄', '📑', '🧾', '📊', '📈', '📉', '🗒️', '🗓️', '📆', '📅', '🗑️', '📇', '🗃️', '🗳️', '🗄️', '📋', '📁', '📂', '🗂️', '🗞️', '📰', '📓', '📔', '📒', '📕', '📗', '📘', '📙', '📚', '📖', '🔖', '🧷', '🔗', '📎', '🖇️', '📐', '📏', '🧮', '📌', '📍', '✂️', '🖊️', '🖋️', '✒️', '🖌️', '🖍️', '📝', '✏️', '🔍', '🔎', '🔏', '🔐', '🔒', '🔓'],
                symbols: ['❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟', '☮️', '✝️', '☪️', '🕉️', '☸️', '✡️', '🔯', '🕎', '☯️', '☦️', '🛐', '⛎', '♈', '♉', '♊', '♋', '♌', '♍', '♎', '♏', '♐', '♑', '♒', '♓', '🆔', '⚛️', '🉑', '☢️', '☣️', '📴', '📳', '🈶', '🈚', '🈸', '🈺', '🈷️', '✴️', '🆚', '💮', '🉐', '㊙️', '㊗️', '🈴', '🈵', '🈹', '🈲', '🅰️', '🅱️', '🆎', '🆑', '🅾️', '🆘', '❌', '⭕', '🛑', '⛔', '📛', '🚫', '💯', '💢', '♨️', '🚷', '🚯', '🚳', '🚱', '🔞', '📵', '🚭', '❗', '❓', '❕', '❔', '‼️', '⁉️', '🔅', '🔆', '〽️', '⚠️', '🚸', '🔱', '⚜️', '🔰', '♻️', '✅', '🈯', '💹', '❇️', '✳️', '❎', '🌐', '💠', 'Ⓜ️', '🌀', '💤', '🏧', '🚾', '♿', '🅿️', '🈳', '🈂️', '🛂', '🛃', '🛄', '🛅', '🚹', '🚺', '🚼', '🚻', '🚮', '🎦', '📶', '🈁', '🔣', 'ℹ️', '🔤', '🔡', '🔠', '🆖', '🆗', '🆙', '🆒', '🆕', '🆓', '0️⃣', '1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣', '6️⃣', '7️⃣', '8️⃣', '9️⃣', '🔟', '🔢', '#️⃣', '*️⃣', '⏏️', '▶️', '⏸️', '⏯️', '⏹️', '⏺️', '⏭️', '⏮️', '⏩', '⏪', '⏫', '⏬', '◀️', '🔼', '🔽', '➡️', '⬅️', '⬆️', '⬇️', '↗️', '↘️', '↙️', '↖️', '↕️', '↔️', '↪️', '↩️', '⤴️', '⤵️', '🔀', '🔁', '🔂', '🔄', '🔃', '🎵', '🎶', '➕', '➖', '➗', '✖️', '💲', '💱', '™️', '©️', '®️', '〰️', '➰', '➿', '🔚', '🔙', '🔛', '🔜', '🔝', '✔️', '☑️', '🔘', '🔴', '🟠', '🟡', '🟢', '🔵', '🟣', '⚫', '⚪', '🟤', '🔺', '🔻', '🔸', '🔹', '🔶', '🔷', '🔳', '🔲', '▪️', '▫️', '◾', '◽', '◼️', '◻️', '🟥', '🟧', '🟨', '🟩', '🟦', '🟪', '⬛', '⬜', '🟫', '🔈', '🔇', '🔉', '🔊', '🔔', '🔕', '📣', '📢', '👁️‍🗨️', '💬', '💭', '🗯️', '♠️', '♣️', '♥️', '♦️', '🃏', '🎴', '🀄', '🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛', '🕜', '🕝', '🕞', '🕟', '🕠', '🕡', '🕢', '🕣', '🕤', '🕥', '🕦', '🕧']
            };

            const categoryTitles = {
                people: 'PEOPLE',
                nature: 'NATURE',
                food: 'FOOD & DRINK',
                activity: 'ACTIVITY',
                travel: 'TRAVEL & PLACES',
                objects: 'OBJECTS',
                symbols: 'SYMBOLS'
            };

            // Initialize emoji picker
            function initEmojiPicker(container) {
                const pickerContainer = container.find('.emoji-picker-container');
                const emojiGrid = pickerContainer.find('.emoji-grid');
                const category = emojiGrid.data('category') || 'people';
                
                // Populate emojis
                if (emojiGrid.children().length === 0) {
                    emojiData[category].forEach(emoji => {
                        emojiGrid.append(`<div class="emoji-item">${emoji}</div>`);
                    });
                }
            }

            // Show emoji picker
            $(document).on('click', '.emoji-picker-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const form = $(this).closest('.comment-form, .reply-form');
                const pickerContainer = form.find('.emoji-picker-container');
                const textarea = form.find('textarea.commentBox, textarea[name="comment"]');
                
                // Close other pickers
                $('.emoji-picker-container').not(pickerContainer).hide();
                
                // Toggle current picker
                if (pickerContainer.is(':visible')) {
                    pickerContainer.hide();
                } else {
                    pickerContainer.show();
                    initEmojiPicker(form);
                }
            });

            // Category switching
            $(document).on('click', '.emoji-category-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const category = $(this).data('category');
                const picker = $(this).closest('.emoji-picker');
                const emojiGrid = picker.find('.emoji-grid');
                const categoryTitle = picker.find('.emoji-category-title');
                
                // Update active button
                picker.find('.emoji-category-btn').removeClass('active');
                $(this).addClass('active');
                
                // Update title
                categoryTitle.text(categoryTitles[category] || category.toUpperCase());
                
                // Update grid
                emojiGrid.attr('data-category', category);
                emojiGrid.empty();
                emojiData[category].forEach(emoji => {
                    emojiGrid.append(`<div class="emoji-item">${emoji}</div>`);
                });
            });

            // Emoji selection
            $(document).on('click', '.emoji-item', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const emoji = $(this).text();
                const picker = $(this).closest('.emoji-picker-container');
                const form = picker.closest('.comment-form, .reply-form');
                const textarea = form.find('textarea.commentBox, textarea[name="comment"]');
                
                // Insert emoji at cursor position
                const cursorPos = textarea.prop('selectionStart');
                const textBefore = textarea.val().substring(0, cursorPos);
                const textAfter = textarea.val().substring(cursorPos);
                textarea.val(textBefore + emoji + textAfter);
                
                // Set cursor position after emoji
                const newPos = cursorPos + emoji.length;
                textarea[0].setSelectionRange(newPos, newPos);
                textarea.focus();
                
                // Trigger input event for auto-resize
                textarea.trigger('input');
            });

            // Emoji search
            $(document).on('input', '.emoji-search', function() {
                const searchTerm = $(this).val().toLowerCase();
                const picker = $(this).closest('.emoji-picker');
                const emojiGrid = picker.find('.emoji-grid');
                const currentCategory = emojiGrid.attr('data-category') || 'people';
                
                if (searchTerm === '') {
                    // Show current category emojis
                    emojiGrid.empty();
                    emojiData[currentCategory].forEach(emoji => {
                        emojiGrid.append(`<div class="emoji-item">${emoji}</div>`);
                    });
                } else {
                    // Search across all categories
                    emojiGrid.empty();
                    Object.keys(emojiData).forEach(category => {
                        emojiData[category].forEach(emoji => {
                            // Simple search - you can enhance this with emoji names
                            emojiGrid.append(`<div class="emoji-item">${emoji}</div>`);
                        });
                    });
                }
            });

            // Close emoji picker when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.emoji-picker-container, .emoji-picker-btn').length) {
                    $('.emoji-picker-container').hide();
                }
            });

            // Initialize emoji pickers on page load
            $(document).ready(function() {
                $('.comment-form, .reply-form').each(function() {
                    const pickerContainer = $(this).find('.emoji-picker-container');
                    if (pickerContainer.length) {
                        initEmojiPicker($(this));
                    }
                });
            });

            // Transcript functionality for regular videos
            let currentTranscriptData = null;
            let currentVideoId = null;

            // Parse VTT file content
            function parseVTT(vttText) {
                const cues = [];
                const lines = vttText.split('\n');
                let currentCue = null;

                for (let i = 0; i < lines.length; i++) {
                    const line = lines[i].trim();

                    // Skip WEBVTT header and empty lines
                    if (line === 'WEBVTT' || line === '' || line.startsWith('NOTE') || line.startsWith('STYLE')) {
                        continue;
                    }

                    // Check if line is a timestamp (format: 00:00:00.000 --> 00:00:00.000)
                    const timestampRegex = /^(\d{2}):(\d{2}):(\d{2})\.(\d{3})\s*-->\s*(\d{2}):(\d{2}):(\d{2})\.(\d{3})/;
                    const match = line.match(timestampRegex);

                    if (match) {
                        // Save previous cue if exists
                        if (currentCue && currentCue.text) {
                            cues.push(currentCue);
                        }

                        // Create new cue
                        const startTime = parseFloat(match[1]) * 3600 + parseFloat(match[2]) * 60 + parseFloat(match[3]) + parseFloat(match[4]) / 1000;
                        const endTime = parseFloat(match[5]) * 3600 + parseFloat(match[6]) * 60 + parseFloat(match[7]) + parseFloat(match[8]) / 1000;

                        currentCue = {
                            start: startTime,
                            end: endTime,
                            text: ''
                        };
                    } else if (currentCue && line) {
                        // Add text to current cue
                        if (currentCue.text) {
                            currentCue.text += ' ' + line;
                        } else {
                            currentCue.text = line;
                        }
                    }
                }

                // Add last cue
                if (currentCue && currentCue.text) {
                    cues.push(currentCue);
                }

                return cues;
            }

            // Format time for display
            function formatTime(seconds) {
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                const secs = Math.floor(seconds % 60);
                
                if (hours > 0) {
                    return `${hours}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                }
                return `${minutes}:${secs.toString().padStart(2, '0')}`;
            }

            // Load and display transcript
            function loadTranscript(subtitleUrl, languageLabel) {
                $('.transcript-text-content').html('<p style="text-align: center; color: hsl(var(--body-color));">@lang("Loading transcript...")</p>');

                // Check if URL is valid
                if (!subtitleUrl || subtitleUrl === '' || subtitleUrl.includes('default.png') || subtitleUrl.includes('placeholder')) {
                    console.error('Invalid subtitle URL:', subtitleUrl);
                    $('.transcript-text-content').html('<p style="text-align: center; color: hsl(var(--body-color));">@lang("Invalid transcript file URL")</p>');
                    return;
                }

                fetch(subtitleUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'text/vtt, text/plain, */*'
                    },
                    cache: 'no-cache'
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(vttText => {
                        if (!vttText || vttText.trim() === '') {
                            throw new Error('Empty transcript file');
                        }

                        const cues = parseVTT(vttText);
                        currentTranscriptData = cues;

                        if (cues.length === 0) {
                            $('.transcript-text-content').html('<p style="text-align: center; color: hsl(var(--body-color));">@lang("No transcript available")</p>');
                            return;
                        }

                        let html = '';
                        cues.forEach((cue, index) => {
                            html += `<div class="transcript-cue" data-start="${cue.start}" data-index="${index}">
                                <span class="transcript-time">${formatTime(cue.start)}</span>
                                <span class="transcript-text">${cue.text}</span>
                            </div>`;
                        });

                        $('.transcript-text-content').html(html);

                        // Add click handlers to cues
                        $('.transcript-cue').on('click', function() {
                            const startTime = parseFloat($(this).data('start'));
                            
                            // Get player instance from window or DOM
                            const player = window.singleplayer || Plyr.setup('.video-player')[0];
                            
                            if (player) {
                                player.currentTime = startTime;
                                player.play();
                            }

                            // Highlight active cue
                            $('.transcript-cue').removeClass('active');
                            $(this).addClass('active');
                        });

                        // Update active cue based on video time
                        const player = window.singleplayer || Plyr.setup('.video-player')[0];
                        if (player) {
                            const updateActiveCue = () => {
                                const currentTime = player.currentTime;
                                $('.transcript-cue').each(function() {
                                    const start = parseFloat($(this).data('start'));
                                    const nextCue = $(this).next('.transcript-cue');
                                    const end = nextCue.length ? parseFloat(nextCue.data('start')) : parseFloat($(this).data('start')) + 5;
                                    
                                    if (currentTime >= start && currentTime < end) {
                                        $('.transcript-cue').removeClass('active');
                                        $(this).addClass('active');
                                        
                                        // Auto-scroll to active cue
                                        const transcriptContent = $('.transcript-text-content');
                                        const cueTop = $(this).position().top + transcriptContent.scrollTop();
                                        const cueHeight = $(this).outerHeight();
                                        const containerHeight = transcriptContent.height();
                                        
                                        if (cueTop < transcriptContent.scrollTop() || cueTop + cueHeight > transcriptContent.scrollTop() + containerHeight) {
                                            transcriptContent.animate({
                                                scrollTop: cueTop - containerHeight / 2
                                            }, 300);
                                        }
                                    }
                                });
                            };

                            player.on('timeupdate', updateActiveCue);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading transcript:', error);
                        console.error('Subtitle URL:', subtitleUrl);
                        $('.transcript-text-content').html(`<p style="text-align: center; color: hsl(var(--body-color));">@lang("Failed to load transcript")<br><small style="font-size: 11px; opacity: 0.7;">${error.message}</small></p>`);
                    });
            }

            // Open transcript box
            $(document).on('click', '.transcriptBtn', function() {
                const videoId = $(this).data('video_id');
                const subtitles = $(this).data('subtitles');
                
                currentVideoId = videoId;
                
                // Populate language selector
                const languageSelect = $('.transcript-language-select');
                languageSelect.empty();
                languageSelect.append('<option value="">@lang("Select Language")</option>');
                
                subtitles.forEach((subtitle, index) => {
                    const label = subtitle.caption || subtitle.language_code || `Language ${index + 1}`;
                    languageSelect.append(`<option value="${index}" data-url="${subtitle.file_url}">${label}</option>`);
                });

                $('.transcript-box').addClass('show-transcript');
                $('.transcript-text-content').html('<p style="text-align: center; color: hsl(var(--body-color));">@lang("Select a language to view transcript")</p>');
            });

            // Close transcript box
            $('.transcript-box__close-icon').on('click', function() {
                $('.transcript-box').removeClass('show-transcript');
                currentTranscriptData = null;
                currentVideoId = null;
            });

            // Handle language selection
            $(document).on('change', '.transcript-language-select', function() {
                const selectedIndex = $(this).val();
                if (selectedIndex === '') {
                    $('.transcript-text-content').html('<p style="text-align: center; color: hsl(var(--body-color));">@lang("Select a language to view transcript")</p>');
                    return;
                }

                const selectedOption = $(this).find('option:selected');
                const subtitleUrl = selectedOption.data('url');
                
                if (subtitleUrl) {
                    loadTranscript(subtitleUrl, selectedOption.text());
                }
            });

            // Close transcript when clicking outside
            $(document).on('click', function(e) {
                if ($(e.target).closest('.transcript-box, .transcriptBtn').length === 0) {
                    $('.transcript-box').removeClass('show-transcript');
                }
            });
        })(jQuery);
    </script>
@endpush

