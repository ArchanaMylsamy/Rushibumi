<div class="comment-box-item comment-item @if ($comment->parent_id == 0) parentComment @endif ">
    <div class="comment-box-item__thumb">
        <img src="{{ getImage(getFilePath('userProfile') . '/' . @$comment->user->image, isAvatar: true) }}" alt="User Image">
    </div>
    <div class="comment-box-item__content">
        <p class="comment-box-item__name">{{ @$comment->user->channel_name ? @$comment->user->channel_name : @$comment->user->fullname  }}
            <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
        </p>
        <p class="comment-box-item__text">
            @if ($comment->parent_id)
                <span class="comment-box-item__person"><span>@</span>{{ @$comment->replierUser->channel_name ? @$comment->replierUser->channel_name : @$comment->replierUser->fullname }}</span>
            @endif
            <span> {{ $comment->comment }}</span>
        </p>
        <div class="reaction-btn">
            @include('Template::partials.comment_reaction')
            <div class="reaction-btn__reply">
                <button class="reply">@lang('Reply')</button>
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
        @if ($comment->parent_id == 0)
    </div>
    @endif
</div>
</div>
