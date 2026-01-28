@foreach ($comments as $comment)
    <div class="comment-box-item comment-item @if ($comment->parent_id == 0) parentComment @endif">
        <div class="comment-box-item__thumb">
            <img src="{{ getImage(getFilePath('userProfile') . '/' . $comment->user->image, isAvatar: true) }}" alt="User Image">
        </div>
        <div class="comment-box-item__content">
            <p class="comment-box-item__name">{{$comment->user->channel_name ? $comment->user->channel_name : $comment->user->fullname }}
                <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
            </p>
            <p class="comment-box-item__text">
                {{ $comment->comment }}
            </p>
            @if ($comment->media_path)
                <div class="comment-media mt-2">
                    @if ($comment->media_type === 'video')
                        @php
                            $extension = pathinfo($comment->media_path, PATHINFO_EXTENSION);
                            $mimeTypes = [
                                'mp4' => 'video/mp4',
                                'webm' => 'video/webm',
                                'ogg' => 'video/ogg',
                                'avi' => 'video/x-msvideo',
                                'mov' => 'video/quicktime',
                                'wmv' => 'video/x-ms-wmv',
                                'flv' => 'video/x-flv'
                            ];
                            $mimeType = $mimeTypes[strtolower($extension)] ?? 'video/mp4';
                        @endphp
                        <video controls autoplay loop muted playsinline style="max-width: 100%; max-height: 300px; border-radius: 8px;" preload="auto">
                            <source src="{{ asset('assets/comments/' . $comment->media_path) }}" type="{{ $mimeType }}">
                            Your browser does not support the video tag.
                        </video>
                    @elseif ($comment->media_type === 'gif')
                        <img src="{{ asset('assets/comments/' . $comment->media_path) }}" alt="GIF" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                    @endif
                </div>
            @endif

            <div class="reaction-btn">
                <div class="reaction-btn-inner">
                    @include('Template::partials.comment_reaction')
                </div>
                <div class="reaction-btn__reply">
                    <button class="reply">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="lucide lucide-message-square-quote">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                <path d="M8 12a2 2 0 0 0 2-2V8H8" />
                                <path d="M14 12a2 2 0 0 0 2-2V8h-2" />
                            </svg>
                        </span>
                        @lang('Reply')
                    </button>
                </div>
            </div>

            @if ($comment->parent_id == 0)
                <div class="reply-wrapper">
            @endif
            <form class="reply-form d-none mb-3">
                <input name="reply_to" type="hidden" value="{{ $comment->id }}" />

                <textarea class="form--control reply-form__textarea commentBox" name="comment" placeholder="Add a comment"></textarea>
                
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

                <div class="reply-form__input-btn">
                    <button class="reply-form__btn submit-reply" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-send-horizontal">
                            <path
                                  d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z">
                            </path>
                            <path d="M6 12h16"></path>
                        </svg>
                    </button>
                </div>
            </form>
            @if (!blank($comment->replies))
                <span class="show-reply">
                    <span class="icon">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                    <span class="text">@lang('Show Reply')</span>
                </span>
            @endif
            <div class="append-reply d-none">
                @foreach ($comment->replies ?? [] as $reply)
                    @include($activeTemplate . 'partials.video.comment', ['comment' => $reply])
                @endforeach
            </div>
            @if ($comment->parent_id == 0)
        </div>
@endif
</div>
</div>
@endforeach

<div class="text-center d-none spinner mt-4" id="loading-spinner">
    <i class="las la-spinner"></i>
</div>
