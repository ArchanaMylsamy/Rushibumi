@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <div class="short-play-body">
        <div class="short-video-wrapper">
            <div class="shorts_video_sliders slick-slider">
                <!-- Tag Slider -->
                <div class="video-wrapper">
                    <video class="video-player" playsinline preload="metadata" data-video_id="{{ $short->id }}" controls>
                        <source src="{{ route('short.path', encrypt($short->id)) }}" type="video/mp4" />
                        @foreach ($short->subtitles as $subtitle)
                            <track src="{{ getImage(getFilePath('subtitle') . '/' . $subtitle->file) }}"
                                srclang="{{ $subtitle->language_code }}" kind="captions" label="{{ $subtitle->caption }}" />
                        @endforeach
                    </video>
                    <div class="action-container">
                        <div class="cmn-button-item">
                            <button class="like-button  button-item reactionBtn" data-video_id="{{ $short->id }}" data-reaction="1">
                                @if ($short->userReactions()->where('user_id', auth()->id())->where('is_like', Status::YES)->exists())
                                    <i class="vti-like-fill reactionIcon"></i>
                                @else
                                    <i class="vti-like reactionIcon"></i>
                                @endif
                            </button>
                            <span
                                  class="buton-text likeCount">{{ formatNumber($short->userReactions()->like()->count()) }}</span>
                        </div>
                        <div class="cmn-button-item">
                            <button class="dislike-button  button-item reactionBtn" data-video_id="{{ $short->id }}" data-reaction="0">
                                @if ($short->userReactions()->where('user_id', auth()->id())->where('is_like', Status::NO)->exists())
                                    <i class="vti-dislike-fill reactionIcon"></i>
                                @else
                                    <i class="vti-dislike reactionIcon"></i>
                                @endif
                            </button>

                        </div>
                        <div class="cmn-button-item comment">
                            <button class="button-item cmn-btn" data-video_id="{{ $short->id }}">
                                <i class="fa-solid fa-message"></i>
                            </button>
                        </div>
                        <div class="cmn-button-item">
                            <button class="button-item shareBtn" data-video="{{ $short }}">
                                <i class="fa-solid fa-share"></i>
                            </button>
                        </div>
                        @if ($short->subtitles->count() > 0)
                            <div class="cmn-button-item">
                                <button class="button-item transcriptBtn" data-video_id="{{ $short->id }}" data-subtitles="{{ $short->subtitles->map(function($subtitle) { return ['id' => $subtitle->id, 'caption' => $subtitle->caption, 'language_code' => $subtitle->language_code, 'file_url' => asset(getFilePath('subtitle') . '/' . $subtitle->file)]; })->toJson() }}">
                                    <i class="fa-solid fa-closed-captioning"></i>
                                </button>
                            </div>
                        @endif
                        <a class="action-container__thumb" href="{{ route('preview.channel', $short->user->slug) }}">
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . $short->user->image, isAvatar: true) }}" alt="@lang('image')">
                        </a>
                    </div>
                </div>


                @foreach ($relatedVideos as $relatedVideo)
                    <div class="video-wrapper">

                        <video class="video-player" playsinline  data-video_id="{{ $relatedVideo->id }}" controls>
                            <source src="{{ route('short.path', encrypt($relatedVideo->id)) }}" type="video/mp4" />
                            @foreach ($relatedVideo->subtitles as $subtitle)
                                <track src="{{ getImage(getFilePath('subtitle') . '/' . $subtitle->file) }}"
                                    srclang="{{ $subtitle->language_code }}" kind="captions" label="{{ $subtitle->caption }}" />
                            @endforeach
                        </video>

                        <div class="action-container">
                            <div class="cmn-button-item">
                                <button class="like-button  button-item reactionBtn" data-video_id="{{ $relatedVideo->id }}" data-reaction="1">
                                    @if ($relatedVideo->userReactions()->where('user_id', auth()->id())->where('is_like', Status::YES)->exists())
                                        <i class="vti-like-fill reactionIcon"></i>
                                    @else
                                        <i class="vti-like reactionIcon"></i>
                                    @endif
                                </button>
                                <span
                                      class="buton-text likeCount">{{ formatNumber($relatedVideo->userReactions()->like()->count()) }}</span>
                            </div>
                            <div class="cmn-button-item">
                                <button class="dislike-button  button-item reactionBtn" data-video_id="{{ $relatedVideo->id }}" data-reaction="0">
                                    @if ($relatedVideo->userReactions()->where('user_id', auth()->id())->where('is_like', Status::NO)->exists())
                                        <i class="vti-dislike-fill reactionIcon"></i>
                                    @else
                                        <i class="vti-dislike reactionIcon"></i>
                                    @endif
                                </button>

                            </div>
                            <div class="cmn-button-item comment">
                                <button class="button-item cmn-btn" data-video_id="{{ $relatedVideo->id }}">
                                    <i class="fa-solid fa-message"></i>
                                </button>
                            </div>
                            <div class="cmn-button-item">
                                <button class="button-item shareBtn" data-video="{{ $relatedVideo }}">
                                    <i class="fa-solid fa-share"></i>
                                </button>

                            </div>
                            @if ($relatedVideo->subtitles->count() > 0)
                                <div class="cmn-button-item">
                                    <button class="button-item transcriptBtn" data-video_id="{{ $relatedVideo->id }}" data-subtitles="{{ $relatedVideo->subtitles->map(function($subtitle) { return ['id' => $subtitle->id, 'caption' => $subtitle->caption, 'language_code' => $subtitle->language_code, 'file_url' => asset(getFilePath('subtitle') . '/' . $subtitle->file)]; })->toJson() }}">
                                        <i class="fa-solid fa-closed-captioning"></i>
                                    </button>
                                </div>
                            @endif
                            <a class="action-container__thumb" href="{{ route('preview.channel', $relatedVideo->user->slug) }}">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . $relatedVideo->user->image, isAvatar: true) }}" alt="@lang('image')">
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="transcript-box">
                <div class="transcript-box__header">
                    <h5 class="transcript-box__title">@lang('Transcript')</h5>
                    <button class="transcript-box__close-icon">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="transcript-box__content">
                    <div class="transcript-language-selector" style="padding: 15px 20px; border-bottom: 1px solid hsl(var(--white)/.1);">
                        <label style="color: hsl(var(--white)); margin-right: 10px;">@lang('Language'):</label>
                        <select class="form--control transcript-language-select" style="display: inline-block; width: auto; min-width: 150px;">
                            <option value="">@lang('Select Language')</option>
                        </select>
                    </div>
                    <div class="transcript-text-content" style="padding: 20px; overflow-y: auto; flex: 1;">
                        <p style="color: hsl(var(--body-color)); text-align: center;">@lang('Select a language to view transcript')</p>
                    </div>
                </div>
            </div>
            <div class="comment-box">
                <div class="comment-box__header">
                    <h5 class="comment-box__title">@lang('Comments'): (<span class="buton-text commentCount">0</span>)</h5>
                    <button class="comment-box__close-icon">
                        <i class="las la-times"></i>
                    </button>

                </div>
                <div class="comment-box__content">

                </div>

                <form class="commnet-form comment-form">
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
                            <svg class="lucide lucide-send-horizontal" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                      d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z">
                                </path>
                                <path d="M6 12h16"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @include('Template::partials.share')
    @include('Template::partials.login_alert_modal')
@endsection
@push('style')
    <style>
        .spinner {
            text-align: center;
            margin-top: 20px;
        }

        .spinner i {
            font-size: 45px;
            color: hsl(var(--base));
            animation: spin 1s linear infinite;
        }

        .comment-form {
            position: relative;
        }

        .commentBox {
            display: block;
            overflow: hidden;
            resize: none;

        }

        textarea.form--control {
            height: unset;
        }


        .comment-form::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0px;
            height: 1px;
            background-color: hsl(var(--white));
            transition: .1s linear;

        }

        .comment-form:has(.form--control:focus)::after {
            width: 100%;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .short-play-body {
            z-index: 1;
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

        .form-group.position-relative,
        .comment-form {
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

        .comment-form .emoji-picker-btn {
            position: absolute;
            right: 50px;
            bottom: 10px;
        }

        .cmn-button-item {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .action-container__thumb img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        button.reply-form__btn.submit-reply svg {
            height: 16px;
            width: 16px;
        }

        .short-video-wrapper,
        .shorts_video_sliders,
        .short-video-wrapper .slick-list.draggable {
            height: 100% !important;
            border-radius: 8px;
        }

        .commnet-form {
            flex-shrink: 0;
            background: hsl(var(--bg-color));
            width: 100%;
            z-index: 999;
            border-top: 1px solid hsl(var(--white)/.1);
            position: relative;
        }

        .commnet-form .form--control {
            background-color: transparent;
            border: 0;
            border-radius: 0;
        }


        .button-item {
            color: hsl(var(--static-white));
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: hsl(var(--static-black)/.25);
        }

        .reply-form__input-btn {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .reply-form {
            position: relative;
            margin-top: 12px;
        }

        .reply-form::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0px;
            height: 1px;
            background-color: hsl(var(--white));
            transition: .1s linear;
        }

        .reply-form:has(.form--control:focus)::after {
            width: 100%;
        }

        .reply-form__btn {
            color: hsl(var(--white));
            background: transparent;
            font-size: 1rem;
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 40px;
        }

        .short-video-wrapper {
            max-width: 650px;
            width: 100%;
            margin: 0 auto;
            position: relative;
            z-index: 99;
        }

        @media (max-width: 1199px) {
            .short-video-wrapper {
                overflow: hidden;
            }
        }

        .short-video-wrapper .plyr--video {
            max-width: 650px;
            width: 100%;
            border-radius: 6px
        }


        .video-wrapper {
            position: relative;
            z-index: 9991;
        }

        .video-wrapper .video-player {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .action-container {
            position: absolute;
            bottom: 180px;
            right: 20px;
            display: flex;
            flex-direction: column;
            width: 50px;
            gap: 14px;
            z-index: 9999;
            align-items: center;
        }

        .buton-text {
            color: hsl(var(--static-white));
        }

        /* comment box css start here  */
        .comment-box__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 20px;
            padding-bottom: 0;
            flex-shrink: 0
        }

        .reply-form__textarea {
            padding-right: 40px;
        }

        .comment-box__title {
            margin-bottom: 0;
        }

        .comment-box__close-icon {
            color: hsl(var(--white));
        }

        .comment-box {
            position: absolute;
            width: 380px;
            right: 0;
            top: var(--inner-p);
            height: calc(100% - var(--inner-p) * 2);
            background-color: hsl(var(--bg-color));
            visibility: hidden;
            opacity: 0;
            transform: translateX(0);
            transition: .3s linear;
            z-index: -1;
            overflow-y: hidden;
            border: 1px solid hsl(var(--white)/.1);
            border-radius: 6px;
            display: flex;
            flex-direction: column
        }

        .comment-box::-webkit-scrollbar {
            width: 0;
            height: 0;
        }


        @media (max-width:1499px) {
            .comment-box {
                width: 320px;
            }
        }

        .comment-box.show-comment {
            visibility: visible;
            opacity: 1;
            transform: translateX(102%);
        }

        @media (max-width:1199px) {
            .comment-box {
                transform: translateX(120%) !important;
                background: hsl(var(--body-background));
            }

            .comment-box.show-comment {
                visibility: visible;
                opacity: 1;
                transform: translateX(0%) !important;
                z-index: 999;
            }

            .commnet-form {
                width: 320px !important;
            }
        }

        .reply {
            cursor: pointer;
            font-size: 14px;
            color: hsl(var(--white));
        }

        .reply-wrapper {
            margin-top: 10px;
        }

        .reply-form .form--control {
            border: 0;
            padding: 0;
            border-bottom: 1px solid hsl(var(--white)/.2);
            border-radius: 0;
            padding-bottom: 3px;
            background-color: transparent;
            padding-right: 60px;
        }

        .comment-box-item__content {
            width: calc(100% - 40px);
        }

        .comment-box-item__name {
            color: hsl(var(--white));
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;

        }

        .comment-box-item__name .time {
            font-size: 12px;
            color: hsl(var(--body-color));
        }

        .reaction-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 15px;
        }

        .comment-box-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .comment-box-item:last-child {
            margin-bottom: 0;
        }

        .comment-box-item__thumb {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        .comment-box__content {
            overflow-y: scroll;
            flex: 1;
            padding: 30px;

        }

        .comment-box__content::-webkit-scrollbar {
            width: 5px;
        }

        .comment-box__content::-webkit-scrollbar-thumb {
            background: hsl(var(--white) / .2);
            border-radius: 10px;
        }

        .comment-box__content::-webkit-scrollbar-track {
            background: transparent;
        }

        .comment-box-item__thumb img {
            width: 100%;
            height: 100%;
        }

        .slick-arrow.slick-next::after {
            display: none !important;
        }

        .slick-arrow::after {
            display: none !important;
        }

        .short-play-body .slick-arrow {
            position: fixed;
            right: 20px;
            transform: translateY(-50%);
            display: flex;
            gap: 20px;
        }

        .short-play-body .slick-arrow.slick-prev {
            right: 20px;
            left: unset;
            width: 45px;
            height: 45px;
            background: hsl(var(--white) / .1);
            border-radius: 50%;
            font-size: 12px;
            top: 48%;
            border: 1px solid hsl(var(--white) / .2);
            color: hsl(var(--white));
        }


        .slick-next.slick-arrow {
            top: 54%;
            width: 45px;
            height: 45px;
            background: hsl(var(--white) / .1);
            border-radius: 50%;
            font-size: 12px;
            border: 1px solid hsl(var(--white) / .2);
            color: hsl(var(--white));
        }

        .slick-arrow:hover {
            color: hsl(var(--black)) !important;
            border-color: hsl(var(--white)) !important;
            background: hsl(var(--white)) !important;
        }

        .short-play-body .slick-arrow.slick-prev {
            right: 20px;
            left: unset;
        }

        .show-reply {
            cursor: pointer;
        }

        .home-fluid .home__right {
            display: flex;
            flex-direction: column;
        }

        .short-play-body {
            --inner-p: 0px;
            height: calc(100vh - var(--header-h));
        }


        @media (max-width: 575px) {
            .short-play-body {
                --inner-p: 0px;
                height: calc(100vh - (var(--header-h) + 59px));
            }
        }

        @media (max-width: 424px) {
            .short-play-body {
                height: calc(100vh - (var(--header-h) + 50px));
            }
        }

        .short-play-body .slick-slide>div {
            height: 100% !important;
        }

        .short-video-wrapper {
            padding-block: 0;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-wrapper {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .short-video-wrapper .plyr--video {
            max-width: 650px;
            width: 100%;
            border-radius: 6px;
            height: 100%;
            max-height: 100%;
        }

        .slick-vertical .slick-slide {
            height: calc(100vh - var(--header-h)) !important;
        }

        @media (max-width: 575px) {
            .slick-vertical .slick-slide {
                height: calc(100vh - (var(--header-h) + 59px)) !important;
            }
        }

        @media (max-width: 424px) {
            .slick-vertical .slick-slide {
                height: calc(100vh - (var(--header-h) + 50px)) !important;
            }
        }


        .plyr__video-embed iframe,
        .plyr__video-wrapper--fixed-ratio video {
            object-fit: contain;
        }

        .plyr__video-wrapper {
            height: 100% !important;
        }

        .plyr__video-wrapper--fixed-ratio {
            height: 100% !important;
            padding-top: 0 !important;
        }

        .buton-text.commentCount {
            color: hsl(var(--white)) !important;
        }

        /* Transcript box styles */
        .transcript-box {
            position: absolute;
            width: 380px;
            right: 0;
            top: var(--inner-p);
            height: calc(100% - var(--inner-p) * 2);
            background-color: hsl(var(--bg-color));
            visibility: hidden;
            opacity: 0;
            transform: translateX(0);
            transition: .3s linear;
            z-index: -1;
            overflow-y: hidden;
            border: 1px solid hsl(var(--white)/.1);
            border-radius: 6px;
            display: flex;
            flex-direction: column;
        }

        .transcript-box::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        @media (max-width:1499px) {
            .transcript-box {
                width: 320px;
            }
        }

        .transcript-box.show-transcript {
            visibility: visible;
            opacity: 1;
            transform: translateX(102%);
            z-index: 999;
        }

        @media (max-width:1199px) {
            .transcript-box {
                transform: translateX(120%) !important;
                background: hsl(var(--body-background));
            }

            .transcript-box.show-transcript {
                visibility: visible;
                opacity: 1;
                transform: translateX(0%) !important;
                z-index: 999;
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
        }

        .transcript-box__title {
            margin-bottom: 0;
            color: hsl(var(--white));
        }

        .transcript-box__close-icon {
            color: hsl(var(--white));
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 20px;
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
    </style>
@endpush
@push('style-lib')
    <!-- Slick Slider -->
    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/plyr.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <!-- Slick js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>

    <script src="{{ asset('assets/global/js/plyr.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            'use strict';

            $(document).ready(function() {
                const auth = "{{ auth()->user() }}";
                var videoId;

                var shortCurrectPage = 2;
                let shortLastPage = false;
                var itemCount = 0;
                var player = '';

                var slick_2_is_animating = false;

                var slick = $('.shorts_video_sliders').slick({

                    infinite: false,
                    dots: false,

                    vertical: true,
                    verticalSwiping: true,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-up"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-down"></i></button>',
                    responsive: [{
                        breakpoint: 575,
                        settings: {
                            arrows: false,
                        }
                    }]

                });

                slick.on("afterChange", function(index) {

                    slick_2_is_animating = false;

                    playVideo();



                });

                slick.on("beforeChange", function(index) {

                    slick_2_is_animating = true;

                    playVideo();



                });

                slick.on("wheel", function(e) {
                    slick_handle_wheel_event_debounced(e.originalEvent, slick, slick_2_is_animating);
                });




                function debounce(func, wait, immediate) {
                    var timeout;
                    return function() {
                        var context = this,
                            args = arguments;
                        var later = function() {
                            timeout = null;
                            if (!immediate) func.apply(context, args);
                        };
                        var callNow = immediate && !timeout;
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                        if (callNow) func.apply(context, args);
                    };
                };


                function slick_handle_wheel_event(e, slick_instance, slick_is_animating) {

                    if (!slick_is_animating) {

                        var direction =
                            Math.abs(e.deltaX) > Math.abs(e.deltaY) ? e.deltaX : e.deltaY;

                        if (direction > 0) {

                            slick_instance.slick("slickNext");
                            shortCount();
                            viewsCount();

                        } else {

                            slick_instance.slick("slickPrev");
                            playVideo();
                        }
                    }
                }


                var slick_handle_wheel_event_debounced = debounce(
                    slick_handle_wheel_event, 100, true

                );



                $(document).ready(function() {
                    viewsCount();

                });


                function viewsCount() {

                    const videoId = $('.slick-active').find('video').data('video_id');
                    $.ajax({
                        type: "post",
                        url: "{{ route('short.view', '') }}/" + videoId,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.satatus == 'success') {
                                return;
                            }
                        }
                    });
                }



                $(document).on('click', '.slick-next', function() {
                    shortCount();
                    viewsCount();

                });

                function shortCount() {

                    itemCount++;
                    if ($('.video-wrapper').length - itemCount == 1) {

                        loadMoreVideos();
                    }
                }


                function loadMoreVideos() {
                  

                    const route = "{{ route('load.shorts.video') }}";
                    $.ajax({
                        url: `${route}?play_short=false&page=${shortCurrectPage}`,
                        type: 'GET',
                        success: function(response) {

                            if (response.status === 'success') {

                                $('.shorts_video_sliders').slick('slickAdd', response.data.html);

                                $('.shorts_video_sliders').slick('setPosition');

                                initializePlayer();

                                shortCurrectPage++;

                                if (shortCurrectPage >= response.data.last_page) {
                                    shortLastPage = true;
                                }
                            } else {
                                notify('error', response.message.error);
                            }
                        }
                    });
                }



                function initializePlayer() {
                    player = Plyr.setup('.video-player', {
                        controls: ['play', 'mute', 'volume'],
                        autoplay: false,
                        ratio: '9:16',
                    });
                }


                function playVideo() {
                    $('video').each(function() {
                        this.pause();

                    });

                    let player = $('.slick-active').find('video')[0];
                    if (player) {
                        player.play();
                    }
                }


                $(document).on('click', '.plyr__video-wrapper', function() {
                    let player = $('.slick-active').find('video')[0];
                    if (player.paused) {
                        player.play();
                    } else {
                        player.pause();
                    }
                });



                // comment js start here

                // for comment
                let commentCurrentPage = 1;



                let commentLastPage = false;


                $(document).on('click', '.comment', function() {

                    $('.comment-box').addClass('show-comment');
                })
                $('.comment-box__close-icon').on('click', function() {
                    $('.comment-box').removeClass('show-comment');
                    commentLastPage = false;
                    commentCurrentPage = 1;
                })
                // comment js end here


                $(document).ready(function() {
                    $(document).on('input', '.commentBox', function() {
                        $(this).css('height', 'auto');
                        $(this).css('height', this.scrollHeight + 'px');

                    });
                });



                initializePlayer();


                $('.shorts_video_sliders').on('afterChange', function(event, slick, currentSlide) {
                    $('.comment-box__content').empty();
                    $('.comment-box').removeClass('show-comment');
                    commentLastPage = false;
                    commentCurrentPage = 1;
                });


                $(document).on('click', '.cmn-btn', function() {
                    videoId = $(this).data('video_id');

                    loadMoreComments(1, videoId);
                })


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
                    const csrfToken = $('meta[name="csrf-token"]').attr('content') || "{{ csrf_token() }}";
                    
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
                        console.log('Uploading file:', selectedFile.name, 'Size:', selectedFile.size, 'Type:', selectedFile.type);
                        formData.append('comment_media', selectedFile);
                    } else {
                        console.log('No file selected for upload');
                    }

                    $.ajax({
                        type: "post",
                        url: "{{ route('user.comment.submit', '') }}/" + videoId,
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('.commentBox').css('height', '');
                                $('.comment-box__content').prepend(response.data.comment);
                                form.trigger('reset');
                                form.find('.comment-media-preview').addClass('d-none').empty();
                                $('.commentCount').text(response.data.comment_count);

                            } else {
                                notify('error', response.message.error);
                            }
                        },
                        error: function(xhr) {
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


                $(document).ready(function() {

                    $('.comment-box__content').on('scroll', function() {
                        let commentBox = $(this);
                        let scrollTop = commentBox.scrollTop();
                        let boxHeight = commentBox.outerHeight();
                        let contentHeight = commentBox[0].scrollHeight;

                        if (scrollTop + boxHeight >= contentHeight && !commentLastPage) {
                            commentCurrentPage++;
                            loadMoreComments(null, videoId);
                        }
                    });
                });


                function loadMoreComments(changeVideo = null, videoId) {
                    const commentsRoute = "{{ route('user.comment.get', '') }}/" + videoId;
                    $('#loading-spinner').removeClass('d-none');
                    $.ajax({
                        url: `${commentsRoute}?page=${commentCurrentPage}`,
                        type: 'GET',
                        success: function(response) {
                            $('#loading-spinner').addClass('d-none');

                            if (response.status === 'success') {

                                if (changeVideo) {
                                    $('.comment-box__content').empty()
                                }
                                $('.comment-box__content').append(response.data.commentHtml);
                                $('.commentCount').text(response.data.comment_count);


                                if (commentCurrentPage >= response.data.last_page) {
                                    commentLastPage = true;
                                }
                            } else {
                                notify('error', response.message.error);
                            }
                        }
                    });
                }

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


                $(document).on('click', '.reply', function() {
                    const replyForm = $(this).closest('.comment-box-item__content').find('.reply-form')
                        .first();
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
                        console.log('Uploading file:', selectedFile.name, 'Size:', selectedFile.size, 'Type:', selectedFile.type);
                        formData.append('comment_media', selectedFile);
                    } else {
                        console.log('No file selected for upload');
                    }

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
                            if (response.status === 'success') {
                                form.trigger('reset');
                                form.find('.comment-media-preview').addClass('d-none').empty();
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


                // for comment reaction
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
                                button.find('.reactionIcon').removeClass('vti-like')
                                    .addClass('vti-like-fill');
                                button.siblings('.commentReaction').find('.reactionIcon')
                                    .removeClass('vti-dislike-fill').addClass(
                                        'vti-dislike');
                                button.find('.likeCount').text(response.data.like_count);

                            } else if (response.remark === 'like_remove') {
                                button.find('.reactionIcon').removeClass('vti-like-fill')
                                    .addClass('vti-like');
                                button.find('.likeCount').text(response.data.like_count);

                            } else if (response.remark === 'dislike') {
                                button.find('.reactionIcon').removeClass('vti-dislike')
                                    .addClass('vti-dislike-fill');
                                button.siblings('.commentReaction').find('.reactionIcon')
                                    .removeClass('vti-like-fill').addClass('vti-like');
                                button.siblings('.commentReaction').find('.likeCount').text(
                                    response.data.like_count);

                            } else if (response.remark === 'dislike_remove') {
                                button.find('.reactionIcon').removeClass('vti-dislike-fill')
                                    .addClass('vti-dislike');

                            } else if (response.remark === 'video_not_found') {
                                notify('error', response.message.error);
                            } else {
                                notify('error', 'Failed to update reaction');
                            }

                        }
                    });
                });

                //end comment reaction


                // for reaction


                $('.reactionBtn').on('click', function() {
                    if (!auth) {
                        $('#existModalCenter').modal('show');
                        return;
                    }
                    const button = $(this);
                    const value = button.data('reaction');
                    videoId = button.data('video_id');


                    const likeButton = button.closest('.action-container').find('.like-button');
                    const dislikeButton = button.closest('.action-container').find('.dislike-button');
                    const likeCountElem = likeButton.siblings('.likeCount');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.reaction', '') }}/" + videoId,
                        dataType: "json",
                        data: {
                            is_like: value,
                        },
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.remark == 'like') {
                                likeButton.find('.reactionIcon').removeClass('vti-like')
                                    .addClass('vti-like-fill');
                                dislikeButton.find('.reactionIcon').removeClass(
                                    'vti-dislike-fill').addClass('vti-dislike');

                                likeCountElem.text(response.data.like_count);
                            } else if (response.remark == 'like_remove') {

                                likeButton.find('.reactionIcon').removeClass(
                                    'vti-like-fill').addClass('vti-like');
                                likeCountElem.text(response.data.like_count);
                            } else if (response.remark == 'dislike') {
                                dislikeButton.find('.reactionIcon').removeClass(
                                    'vti-dislike').addClass('vti-dislike-fill');
                                likeButton.find('.reactionIcon').removeClass(
                                    'vti-like-fill').addClass('vti-like');

                                likeCountElem.text(response.data.like_count);
                            } else if (response.remark == 'dislike_remove') {

                                dislikeButton.find('.reactionIcon').removeClass(
                                    'vti-dislike-fill').addClass('vti-dislike');
                            } else if (response.status == 'error') {
                                notify('error', response.message.error);
                            } else {
                                notify('error', 'Failed to update reaction');
                            }
                        },
                        error: function() {
                            notify('error',
                                'An error occurred while processing the request');
                        }
                    });
                });
                // end reacrtion


                $(document).ready(function() {
                    $(document).on('click', '.shareBtn', function() {
                        const video = $(this).data('video');


                        const baseUrl = "{{ route('short.play', '') }}";
                        const videoUrl = `${baseUrl}/${video.id}/${encodeURIComponent(video.slug)}`;
                        const videoTitle = encodeURIComponent(video.title);

                        const url = `
            <a class="share-item whatsapp" href="https://api.whatsapp.com/send?text=${encodeURIComponent(videoUrl)}" target="_blank">
                <i class="lab la-whatsapp"></i>
            </a>
            <a class="share-item facebook" href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(videoUrl)}" target="_blank">
                <i class="lab la-facebook-f"></i>
            </a>
            <a class="share-item twitter" href="https://twitter.com/intent/tweet?url=${encodeURIComponent(videoUrl)}&text=${videoTitle}" target="_blank">
                <i class="fa-brands fa-x-twitter"></i>
            </a>
            <a class="share-item envelope" href="mailto:?subject=${videoTitle}&body=${encodeURIComponent(videoUrl)}">
                <i class="las la-envelope"></i>
            </a>
        `;
                        $('.share-items').html(url);
                        $('.copyText').val(videoUrl)

                        $('#shareModal').modal('show');
                    });
                });

                // Transcript functionality
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

                    fetch(subtitleUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to load transcript');
                            }
                            return response.text();
                        })
                        .then(vttText => {
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
                                const video = $('.slick-active').find('video')[0];
                                
                                if (video) {
                                    video.currentTime = startTime;
                                    video.play();
                                }

                                // Highlight active cue
                                $('.transcript-cue').removeClass('active');
                                $(this).addClass('active');
                            });

                            // Update active cue based on video time
                            const video = $('.slick-active').find('video')[0];
                            if (video) {
                                const updateActiveCue = () => {
                                    const currentTime = video.currentTime;
                                    $('.transcript-cue').each(function() {
                                        const start = parseFloat($(this).data('start'));
                                        const end = parseFloat($(this).next('.transcript-cue').data('start')) || parseFloat($(this).data('start')) + 5;
                                        
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

                                video.addEventListener('timeupdate', updateActiveCue);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading transcript:', error);
                            $('.transcript-text-content').html('<p style="text-align: center; color: hsl(var(--body-color));">@lang("Failed to load transcript")</p>');
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

                // Close transcript when video changes
                $('.shorts_video_sliders').on('afterChange', function(event, slick, currentSlide) {
                    $('.transcript-box').removeClass('show-transcript');
                    currentTranscriptData = null;
                    currentVideoId = null;
                });
            });
        })(jQuery);
    </script>
@endpush
