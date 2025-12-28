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

                    <video class="video-player" data-amount="{{ $video->price }}" muted playsinline
                        data-poster="{{ getImage(getFilePath('thumbnail') . '/' . $video->thumb_image) }}" controls>
                        @if ($purchasedTrue)
                            @foreach ($video->videoFiles as $file)
                              <source src="{{ route('video.path', encrypt($file->id)) }}" type="video/mp4"
                                    size="{{ $file->quality }}" />

                                    
                            @endforeach

                            @foreach ($video->subtitles as $subtitle)
                                <track src="{{ getImage(getFilePath('subtitle') . '/' . $subtitle->file) }}"
                                    srclang="{{ $subtitle->language_code }}" kind="captions"
                                    label="{{ $subtitle->caption }}" default />
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
                        'settings',
                        'fullscreen',
                        'pip',
                    ];
                }

                const singleplayer = new Plyr('.video-player', {
                    controls,
                    ratio: '16:9',
                    autoplay: true,
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


                const loader = document.getElementById('loader');


                $(document).ready(function() {
                    singleplayer.muted = false;

                });


                $(document).ready(function() {
                    singleplayer.muted = false;
                    const palyPlaylist = @json(!blank($palyPlaylist));
                    const relatedVideo = @json(@$relatedVideos[0]);

                    singleplayer.once('ended', function() {
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
                                        "?list={{ @$palyPlaylist->slug }}&index=" + (index +
                                        1);
                                }


                            }
                        } else {
                            if (relatedVideo && Array(relatedVideo).length > 0) {
                                window.location.href = "{{ route('video.play', ['', '']) }}/" +
                                    relatedVideo?.id + "/" + relatedVideo?.slug;
                            }
                        }
                    });


                });


                let adPlayer = ''

                function adVideoPlayer() {
                    adPlayer = new Plyr('.ad-player', {
                        controls: [

                        ],
                        ratio: '16:9',
                    });
                }

                $(document).ready(function() {
                    let adTriggers = @json($adsDurations).map(Number);
                    let currentAdIndex = 0;
                    let adPlaying = false;

                    let requestPending = false;
                    let adVideo = $('.adVideo');
                    let slug = "{{ $video->slug }}"

                    function playAd(response) {
                        const adId = response.data.ad_id;
                        const encryptedVideoId = "{{ encrypt(@$video->id) }}";
                        adPlaying = true;
                        singleplayer.pause();
                        $('.mainVideo').addClass('d-none');

                        adVideo.html(`
                                <video class="ad-player" playsinline  controls>
                                    <source src="${response.data.ad_video_src}" type="video/mp4" />
                                </video>
                                    ${(response.data.ad_type == 2 || response.data.ad_type == 3) ?
                                    `<div class="ad-info"><div class="ad-info__thumb"><img src="${response.data.ad_logo}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div><div class="ad-info__content"><p>${response.data.ad_url}</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="{{ route('redirect.ad', ['', '']) }}/${adId}/${encryptedVideoId}" class="text-white" target="_blank" >${response.data.button_label}</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div></div>` : ''}
                                <button class="skip-btn btn btn--base btn--sm ad-btn" type="button"></button>`);

                        adVideo.removeClass('d-none');
                        adVideoPlayer();
                        adPlayer.play();
                        adPlayer.on('timeupdate', function() {
                            const adDuration = 5;
                            const currentAdTime = Math.floor(adPlayer.currentTime);
                            let remainingTime = adDuration - currentAdTime;
                            if (remainingTime > 0) {
                                $('.skip-btn').attr('disabled', true).removeClass('d-none');
                                $('.skip-btn').text(`Skip in ${remainingTime} seconds`)
                                    .removeClass('btn--base');
                            } else {
                                $('.skip-btn').attr('disabled', false).addClass('skipAd')
                                    .addClass('btn--base');
                                $('.skip-btn').text('Skip');
                            }
                        });

                        adPlayer.once('ended', function() {
                            adPlayer.pause();
                            adVideo.addClass('d-none');
                            adVideo.empty();
                            $('.mainVideo').removeClass('d-none');
                            singleplayer.play();
                            adPlaying = false;
                        });
                    }

                    function requestAd() {
                        requestPending = true;
                        $.ajax({
                            type: "get",
                            url: "{{ route('fetch.ad') }}",
                            data: {
                                video_id: "{{ encrypt($video->id) }}"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 'success') {
                                    playAd(response);
                                }
                            },
                            complete: function() {
                                requestPending = false;
                            }
                        });
                    }

                    function checkAdTrigger() {
                        const currentTime = Math.floor(singleplayer.currentTime);
                        if (!adPlaying && !requestPending && adTriggers.includes(currentTime)) {
                            requestAd();
                            adTriggers.splice(adTriggers.indexOf(currentTime), 1);
                        }
                    }

                    let debounceTimer;
                    singleplayer.on('timeupdate', function() {

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


                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(checkAdTrigger, 100);

                    });

                    $(document).on('click', '.skipAd', function() {
                        adPlayer.pause();
                        $('.adVideo').addClass('d-none');
                        $('.primary_ad_player').empty();
                        $('.mainVideo').removeClass('d-none');
                        singleplayer.play();
                        adPlaying = false;
                    })
                });

                const players = Plyr.setup('.related-video-player', {
                    controls: [],
                    ratio: '16:9',
                    muted: true,
                });








                const audience = "{{ $video->audience }}"
                if (audience == 0) {
                    if (purchasedTrue || authVideo) {
                        singleplayer.play();
                    }

                }

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

            $('.comment-form').on('submit', function(e) {
                e.preventDefault();

                if (!auth) {
                    $('#existModalCenter').modal('show');
                    return;
                }

                $.ajax({
                    type: "post",
                    url: "{{ route('user.comment.submit', $video->id) }}",
                    data: $(this).serialize(),
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('.commentBox').css('height', '');
                            $('.comment-box__content').prepend(response.data.comment);
                            $('.comment-form').trigger('reset');
                            $('.commentCount').text(response.data.comment_count);

                        } else {
                            notify('error', response.message.error);
                        }
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

                $.ajax({
                    type: "post",
                    url: "{{ route('user.comment.reply') }}",
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            form.trigger('reset');
                            $('.commentBox').css('height', '');

                            var repliesContainer = form.closest('.parentComment').find(
                                '.reply-wrapper').first();

                            if (repliesContainer.length) {
                                repliesContainer.append(response.data.reply);
                            }

                            $('.commentCount').text(response.data.comment_count);
                        } else {
                            notify('error', response.message.error);
                        }
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
        })(jQuery);
    </script>
@endpush

