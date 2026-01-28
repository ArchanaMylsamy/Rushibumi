@extends($activeTemplate . 'layouts.app')
@section('app')
    <!-- ==================== Home Start ==================== -->
    <div class="home-fluid">
        <div class="home__inner">
            <!-- ====================== Sidebar menu Start ========================= -->
            @include($activeTemplate . 'partials.sidebar')
            <!-- ====================== Sidebar menu End ========================= -->
            <div class="home__right">
                <!-- ====================== Header Start ========================= -->
                @include($activeTemplate . 'partials.header')
                <!-- ====================== Header End ========================= -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- ==================== Home End ==================== -->
@endsection

@push('style')
<style>
    /* Red & Black Theme for Main Page */
    body {
        background: #000000 !important;
        color: #ffffff;
    }

    [data-theme="light"] body {
        background: #ffffff !important;
        color: #000000;
    }

    /* Sidebar Styling */
    .sidebar-menu {
        background: rgba(0, 0, 0, 0.95) !important;
        border-right: 1px solid hsl(var(--border-color)) !important;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .sidebar-menu::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, transparent, rgba(220, 20, 60, 0.05), transparent);
        pointer-events: none;
    }

    .sidebar-logo {
        border-bottom: 1px solid hsl(var(--border-color));
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .sidebar-logo__link {
        transition: all 0.3s ease;
        display: inline-block;
    }

    .sidebar-logo__link:hover {
        transform: scale(1.05);
        filter: drop-shadow(0 0 10px rgba(220, 20, 60, 0.6));
    }

    /* Orange R for collapsed sidebar only - hidden by default */
    .side-sm-logo {
        display: none !important;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        width: 32px;
        height: 32px;
    }

    .sidebar-logo-r {
        display: inline-block;
        font-size: 28px;
        font-weight: 700;
        color: #ff6600;
        line-height: 1;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Show orange R only when sidebar is collapsed and center it */
    @media (min-width: 1400px) {
        .sidebar-menu.show-sm .side-sm-logo {
            display: flex !important;
            margin: 0 auto;
        }
        
        .sidebar-menu.show-sm .sidebar-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }
    }

    .sidebar-menu-list__link {
        color: rgba(255, 255, 255, 0.8) !important;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 4px 0;
        padding: 12px 16px !important;
        position: relative;
    }

    .sidebar-menu-list__link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: linear-gradient(180deg, #dc143c, #8b0000);
        border-radius: 0 4px 4px 0;
        transition: height 0.3s ease;
    }

    .sidebar-menu-list__link:hover {
        background: rgba(220, 20, 60, 0.1) !important;
        color: #dc143c !important;
        transform: translateX(5px);
    }

    .sidebar-menu-list__link:hover::before {
        height: 60%;
    }

    .sidebar-menu-list__item.active .sidebar-menu-list__link,
    .sidebar-menu-list__link.active {
        background: rgba(220, 20, 60, 0.15) !important;
        color: #dc143c !important;
        font-weight: 600;
    }

    .sidebar-menu-list__item.active .sidebar-menu-list__link::before,
    .sidebar-menu-list__link.active::before {
        height: 80%;
    }

    .sidebar-menu-list__link .icon {
        color: rgba(220, 20, 60, 0.7);
        transition: all 0.3s ease;
    }

    .sidebar-menu-list__link:hover .icon,
    .sidebar-menu-list__item.active .sidebar-menu-list__link .icon {
        color: #dc143c;
        transform: scale(1.1);
    }

    .separate-border {
        border-top: 1px solid hsl(var(--border-color));
        margin: 16px 0;
    }

    /* Main Content Area */
    .home__right {
        background: #000000;
    }

    [data-theme="light"] .home__right {
        background: #ffffff;
    }

    .home-body {
        background: transparent;
        padding: 20px;
    }

    /* Header Styling */
    .home-header {
        background: rgba(0, 0, 0, 0.9) !important;
        border-bottom: 1px solid hsl(var(--border-color)) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .home-header__inner {
        padding: 12px 20px;
    }

    /* Search Form */
    .search-form .form--control {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        color: #ffffff !important;
        border-radius: 24px !important;
        padding: 10px 80px 10px 45px !important;
    }

    /* Search Clear Button */
    .search-clear-btn {
        position: absolute;
        right: 50px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: color 0.2s ease;
    }

    .search-clear-btn:hover {
        color: #ffffff;
    }

    .search-form .form--control:focus {
        border-color: hsl(var(--base)) !important;
        box-shadow: 0 0 0 3px hsla(var(--base), 0.1) !important;
        outline: none !important;
    }

    .search-form-btn {
        color: rgba(220, 20, 60, 0.8);
        transition: color 0.3s ease;
    }

    .search-form-btn:hover {
        color: #dc143c;
    }

    /* Menu Button - No Border */
    .menu-button {
        border: none !important;
        background: transparent;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .menu-button:hover {
        background: rgba(220, 20, 60, 0.1);
    }

    .menu-button-line {
        background: rgba(220, 20, 60, 0.8);
    }

    /* Buttons */
    .btn--base {
        background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 15px rgba(220, 20, 60, 0.4) !important;
    }

    .btn--base:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 20, 60, 0.6) !important;
        background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
    }

    /* Notification */
    .notification__btn {
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }

    .notification__btn:hover {
        color: #dc143c;
    }

    .countDown {
        background: linear-gradient(135deg, #dc143c, #8b0000) !important;
        color: #ffffff !important;
    }

    /* User Info - No Border */
    .user-info__button {
        border: none !important;
        transition: all 0.3s ease;
        background: transparent;
    }

    .user-info__button:hover {
        box-shadow: 0 0 10px rgba(220, 20, 60, 0.4);
        transform: scale(1.05);
    }

    .user-info__thumb {
        border: none !important;
    }

    .user-info__thumb img {
        border: none !important;
    }

    /* Close Icons - No Border */
    .close-icon,
    .search-close,
    .comment-box__close-icon {
        border: none !important;
        background: transparent !important;
    }

    .close-icon:hover,
    .search-close:hover,
    .comment-box__close-icon:hover {
        background: rgba(220, 20, 60, 0.1) !important;
    }

    /* Logo - No Border */
    .sidebar-logo__link,
    .sidebar-logo__link img {
        border: none !important;
    }

    /* Tag Sliders */
    .tag-item {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        color: rgba(255, 255, 255, 0.8) !important;
        border-radius: 20px !important;
        padding: 8px 16px !important;
        transition: all 0.3s ease !important;
        font-weight: 500;
    }

    .tag-item:hover,
    .tag-item.active {
        background: hsla(var(--base), 0.1) !important;
        border-color: hsl(var(--base)) !important;
        color: hsl(var(--base)) !important;
        transform: translateY(-2px);
    }

    /* ========== LIGHT THEME STYLES ========== */
    
    /* Light Theme - Sidebar */
    [data-theme="light"] .sidebar-menu {
        background: rgba(255, 255, 255, 0.95) !important;
        border-right: 1px solid hsl(var(--border-color)) !important;
    }

    [data-theme="light"] .sidebar-menu-list__link {
        color: rgba(0, 0, 0, 0.8) !important;
    }

    [data-theme="light"] .sidebar-menu-list__link:hover {
        background: rgba(220, 20, 60, 0.08) !important;
        color: #dc143c !important;
    }

    [data-theme="light"] .sidebar-menu-list__item.active .sidebar-menu-list__link,
    [data-theme="light"] .sidebar-menu-list__link.active {
        background: rgba(220, 20, 60, 0.12) !important;
        color: #dc143c !important;
    }

    [data-theme="light"] .sidebar-menu-list__link .icon {
        color: rgba(220, 20, 60, 0.6);
    }

    [data-theme="light"] .sidebar-menu-list__link:hover .icon,
    [data-theme="light"] .sidebar-menu-list__item.active .sidebar-menu-list__link .icon {
        color: #dc143c;
    }

    [data-theme="light"] .separate-border {
        border-top: 1px solid hsl(var(--border-color));
    }

    /* Light Theme - Header */
    [data-theme="light"] .home-header {
        background: rgba(255, 255, 255, 0.95) !important;
        border-bottom: 1px solid hsl(var(--border-color)) !important;
    }

    [data-theme="light"] .search-form .form--control {
        background: #ffffff !important;
        border: 1px solid #e0e0e0 !important;
        color: #000000 !important;
        padding: 10px 80px 10px 45px !important;
    }

    [data-theme="light"] .search-clear-btn {
        color: rgba(0, 0, 0, 0.5) !important;
    }

    [data-theme="light"] .search-clear-btn:hover {
        color: #000000 !important;
    }

    [data-theme="light"] .search-form .form--control::placeholder {
        color: #808080 !important;
    }

    [data-theme="light"] .search-form .form--control:focus {
        border-color: #e0e0e0 !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 1px #e0e0e0 !important;
    }

    [data-theme="light"] .menu-button {
        background: transparent;
        border: none !important;
    }

    [data-theme="light"] .menu-button-line {
        background: rgba(220, 20, 60, 0.7);
    }

    [data-theme="light"] .user-info__button {
        border: none !important;
    }

    [data-theme="light"] .notification__btn {
        color: rgba(0, 0, 0, 0.7);
    }

    [data-theme="light"] .notification__btn:hover {
        color: #dc143c;
    }

    /* Light Theme - Tag Sliders */
    [data-theme="light"] .tag-item {
        background: rgba(255, 255, 255, 0.9) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        color: rgba(0, 0, 0, 0.8) !important;
    }

    [data-theme="light"] .tag-item:hover,
    [data-theme="light"] .tag-item.active {
        background: hsla(var(--base), 0.1) !important;
        border-color: hsl(var(--base)) !important;
        color: hsl(var(--base)) !important;
    }

    /* Light Theme - Video Items */
    [data-theme="light"] .video-item {
        background: transparent !important;
        border: none !important;
    }

    [data-theme="light"] .video-item:hover {
        transform: translateY(-4px);
    }

    [data-theme="light"] .video-item__thumb {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    [data-theme="light"] .video-item:hover .video-item__thumb {
        box-shadow: 0 8px 25px rgba(220, 20, 60, 0.2);
        transform: scale(1.02);
    }

    [data-theme="light"] .video-item__content {
        background: transparent !important;
    }

    [data-theme="light"] .video-item__content .title a {
        color: rgba(0, 0, 0, 0.9) !important;
    }

    [data-theme="light"] .video-item__content .title a:hover {
        color: #dc143c !important;
    }

    [data-theme="light"] .video-item__content .channel {
        color: rgba(0, 0, 0, 0.9) !important;
    }

    [data-theme="light"] .video-item__content .channel:hover {
        color: #dc143c !important;
    }

    [data-theme="light"] .video-item__content .meta {
        color: rgba(0, 0, 0, 0.6) !important;
    }

    [data-theme="light"] .video-item__content .meta .view,
    [data-theme="light"] .video-item__content .meta .date {
        color: rgba(0, 0, 0, 0.5) !important;
    }

    [data-theme="light"] .video-item__channel-author {
        border: 1px solid hsl(var(--border-color)) !important;
    }

    [data-theme="light"] .video-item:hover .video-item__channel-author {
        border-color: hsl(var(--base)) !important;
    }

    /* Light Theme - Section Titles */
    [data-theme="light"] .home-body-title {
        color: #dc143c !important;
    }

    [data-theme="light"] .home-body-title .icon {
        color: #dc143c;
    }

    /* Light Theme - Buttons */
    [data-theme="light"] .btn--base {
        background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%) !important;
        color: #ffffff !important;
    }

    [data-theme="light"] .btn--base:hover {
        background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
    }

    /* Light Theme - Search Button */
    [data-theme="light"] .search-form-btn {
        color: #000000 !important;
    }

    [data-theme="light"] .search-form-btn:hover {
        color: #333333 !important;
    }

    /* Light Theme - Mic Button */
    [data-theme="light"] .home-header__left-mic {
        color: #000000 !important;
    }

    [data-theme="light"] .home-header__left-mic:hover {
        color: #333333 !important;
    }

    /* Light Theme - Create Button Text */
    [data-theme="light"] .create__btn .text,
    [data-theme="light"] .create__btn .icon {
        color: #ffffff !important;
    }

    /* Light Theme - Bottom Nav (Mobile) */
    [data-theme="light"] .sm-bottom-nav__link {
        color: rgba(0, 0, 0, 0.7);
    }

    [data-theme="light"] .sm-bottom-nav__link:hover,
    [data-theme="light"] .sm-bottom-nav__link.active {
        color: #dc143c;
    }

    /* Light Theme - Sidebar Logo */
    [data-theme="light"] .sidebar-logo {
        border-bottom: 1px solid hsl(var(--border-color));
    }

    /* Light Theme - Home Body */
    [data-theme="light"] .home-body {
        background: transparent;
    }

    /* Light Theme - Close Icons */
    [data-theme="light"] .close-icon,
    [data-theme="light"] .search-close,
    [data-theme="light"] .comment-box__close-icon {
        color: rgba(0, 0, 0, 0.7);
    }

    [data-theme="light"] .close-icon:hover,
    [data-theme="light"] .search-close:hover,
    [data-theme="light"] .comment-box__close-icon:hover {
        color: #dc143c;
        background: rgba(220, 20, 60, 0.08) !important;
    }

    /* Light Theme - User Info List */
    [data-theme="light"] .user-info-list__link,
    [data-theme="light"] .list__link {
        color: rgba(0, 0, 0, 0.8);
    }

    [data-theme="light"] .user-info-list__link:hover,
    [data-theme="light"] .list__link:hover {
        color: #dc143c;
    }

    /* Light Theme - Notification List */
    [data-theme="light"] .notification__list {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid hsl(var(--border-color));
    }

    [data-theme="light"] .notification__list-item {
        border-bottom: 1px solid hsl(var(--border-color));
    }

    [data-theme="light"] .notification__list-link {
        color: rgba(0, 0, 0, 0.8);
    }

    [data-theme="light"] .notification__list-link:hover {
        background: rgba(220, 20, 60, 0.08);
    }

    /* Light Theme - Create Dropdown */
    [data-theme="light"] .create__list {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid hsl(var(--border-color));
    }

    [data-theme="light"] .create__list-link {
        color: rgba(0, 0, 0, 0.8);
    }

    [data-theme="light"] .create__list-link:hover {
        background: rgba(220, 20, 60, 0.08);
        color: #dc143c;
    }

    /* Video Grid - 3 per row, bigger size - PROPER LAYOUT */
    .video-item-wrapper,
    .video-wrapper,
    .home-body .video-wrapper,
    .home-body .video-item-wrapper {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 24px !important;
        padding: 20px 0 !important;
        width: 100% !important;
        flex-wrap: nowrap !important;
        justify-content: unset !important;
        align-items: unset !important;
    }

    .video-item,
    .video-wrapper .video-item,
    .video-item-wrapper .video-item,
    .home-body .video-wrapper .video-item,
    .home-body .video-item-wrapper .video-item,
    .feed-ad-item,
    .video-wrapper .feed-ad-item,
    .home-body .video-wrapper .feed-ad-item {
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        background: transparent !important;
        border: none !important;
        border-radius: 0 !important;
        overflow: visible;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: none !important;
        position: relative;
        display: flex !important;
        flex-direction: column;
        cursor: pointer;
        box-sizing: border-box;
        flex: 0 0 auto !important;
    }

    .video-item:hover {
        transform: translateY(-4px);
        background: transparent !important;
    }

    /* Override main.css background - ensure no gray backgrounds */
    .video-item,
    .video-item:hover {
        background: transparent !important;
        background-color: transparent !important;
    }

    .video-item:hover .video-item__thumb,
    .video-item:hover .video-item__content {
        background: transparent !important;
        background-color: transparent !important;
    }

    /* Dark mode specific - remove any dark backgrounds from main.css - HIGHEST SPECIFICITY */
    body:not([data-theme="light"]) .video-item,
    body:not([data-theme="light"]) .video-item:hover,
    html:not([data-theme="light"]) .video-item,
    html:not([data-theme="light"]) .video-item:hover,
    body:not([data-theme="light"]) .home-body .video-item,
    body:not([data-theme="light"]) .home-body .video-item:hover {
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
    }

    body:not([data-theme="light"]) .video-item:hover .video-item__thumb,
    body:not([data-theme="light"]) .video-item:hover .video-item__content,
    body:not([data-theme="light"]) .video-item__thumb,
    body:not([data-theme="light"]) .video-item__content,
    html:not([data-theme="light"]) .video-item:hover .video-item__thumb,
    html:not([data-theme="light"]) .video-item:hover .video-item__content,
    html:not([data-theme="light"]) .video-item__thumb,
    html:not([data-theme="light"]) .video-item__content,
    body:not([data-theme="light"]) .video-item:hover * {
        background: transparent !important;
        background-color: transparent !important;
    }

    /* Force remove any background from main.css in dark mode */
    body:not([data-theme="light"]) .video-item:hover::before,
    body:not([data-theme="light"]) .video-item:hover::after {
        display: none !important;
        content: none !important;
    }

    .video-item:hover .video-item__thumb {
        box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
        transform: scale(1.02);
        background: transparent !important;
        background-color: transparent !important;
    }

    /* Ultimate dark mode override - remove ALL backgrounds */
    body:not([data-theme="light"]) .video-wrapper .video-item:hover,
    body:not([data-theme="light"]) .video-item-wrapper .video-item:hover {
        background: transparent !important;
        background-color: transparent !important;
        background-image: none !important;
    }

    .video-item__thumb,
    .feed-ad-item .video-item__thumb,
    .feed-ad-thumb {
        position: relative;
        display: block;
        overflow: hidden;
        border-radius: 18px;
        width: 100% !important;
        aspect-ratio: 16 / 9 !important;
        height: auto !important;
        background: transparent;
        flex-shrink: 0;
        border: none;
        margin-bottom: 12px;
        box-sizing: border-box;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        transition: box-shadow 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .video-item__thumb img,
    .video-item__thumb video,
    .video-item__thumb .video-player {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: block;
        border-radius: 18px !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box;
        border: none !important;
        outline: none;
        vertical-align: top;
    }
    
    .video-item__thumb .plyr,
    .video-item__thumb .plyr__video-wrapper {
        width: 100% !important;
        height: 100% !important;
        border-radius: 18px !important;
    }

    .video-item:hover .video-item__thumb img,
    .video-item:hover .video-item__thumb video {
        transform: scale(1.1);
    }

    .video-item__content {
        padding: 0 !important;
        background: transparent !important;
        position: relative;
        z-index: 2;
        flex: 1;
        display: flex;
        flex-direction: column;
        border-top: none;
    }

    .video-item:hover .video-item__content {
        background: transparent !important;
    }

    .video-item__content .channel-info {
        order: 1;
    }

    .video-item__content .title {
        margin: 0 0 8px 0 !important;
        padding: 0 !important;
        order: 2;
    }

    .video-item__content .title a {
        color: rgba(255, 255, 255, 0.95) !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        line-height: 1.4 !important;
        transition: color 0.3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0 !important;
    }

    .video-item__content .title a:hover {
        color: #dc143c !important;
    }

    .video-item__channel-author {
        width: 32px !important;
        height: 32px !important;
        border: 1px solid hsl(var(--border-color)) !important;
        border-radius: 50% !important;
        transition: all 0.3s ease;
        margin: 0 8px 0 0 !important;
        display: inline-block;
        vertical-align: middle;
        flex-shrink: 0;
        position: relative !important;
        top: auto !important;
        left: auto !important;
        z-index: auto !important;
    }

    .video-item__channel-author img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .video-item:hover .video-item__channel-author {
        border-color: hsl(var(--base)) !important;
        box-shadow: 0 0 10px hsla(var(--base), 0.3);
    }

    .video-item__content .channel-info {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .video-item__content .channel {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500 !important;
        font-size: 13px !important;
        margin: 0 !important;
        display: inline-block;
        text-decoration: none;
        transition: color 0.3s ease;
        vertical-align: middle;
    }

    .video-item__content .channel:hover {
        color: #ff1744 !important;
    }

    .video-item__content .meta {
        color: rgba(255, 255, 255, 0.7) !important;
        font-size: 12px !important;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 0;
        padding-top: 0;
        order: 3;
    }

    .video-item__content .meta .view,
    .video-item__content .meta .date {
        color: rgba(255, 255, 255, 0.6) !important;
    }

    .video-item__price {
        background: linear-gradient(135deg, #dc143c, #8b0000) !important;
        color: #ffffff !important;
        border-radius: 6px;
        padding: 6px 12px;
        font-weight: 600;
        font-size: 12px;
    }

    .video-item__duration {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(0, 0, 0, 0.8);
        color: #ffffff;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        z-index: 3;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .premium-icon {
        background: hsla(var(--base), 0.2) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        backdrop-filter: blur(5px);
    }

    .premium-icon svg {
        fill: #dc143c !important;
    }

    /* Section Titles */
    .home-body-title {
        color: #dc143c !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 30px 0 24px 0 !important;
        position: relative;
        padding-bottom: 12px;
        font-size: 20px !important;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .home-body-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #dc143c, rgba(220, 20, 60, 0.3));
        border-radius: 2px;
    }

    .home-body-title .icon {
        color: #dc143c;
        font-size: 24px;
    }

    /* Trending Section */
    .trending-section,
    .shorts-section {
        margin-bottom: 40px;
    }

    /* Responsive - 3 columns on desktop, 2 on tablet, 1 on mobile */
    @media (max-width: 1199px) {
        .video-item-wrapper,
        .video-wrapper,
        .home-body .video-wrapper,
        .home-body .video-item-wrapper {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 20px !important;
            flex-wrap: nowrap !important;
            justify-content: unset !important;
        }
    }

    @media (max-width: 991px) {
        .video-item-wrapper,
        .video-wrapper,
        .home-body .video-wrapper,
        .home-body .video-item-wrapper {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 18px !important;
            flex-wrap: nowrap !important;
            justify-content: unset !important;
        }
    }

    @media (max-width: 767px) {
        .video-item-wrapper,
        .video-wrapper,
        .home-body .video-wrapper,
        .home-body .video-item-wrapper {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 16px !important;
            flex-wrap: nowrap !important;
            justify-content: unset !important;
        }

        .video-item__thumb {
            border-radius: 14px;
        }

        .video-item__thumb img,
        .video-item__thumb video,
        .video-item__thumb .video-player {
            border-radius: 14px !important;
        }

        .video-item__content {
            padding: 12px !important;
        }

        .video-item__content .title a {
            font-size: 14px !important;
        }
    }

    @media (max-width: 575px) {
        .video-item-wrapper,
        .video-wrapper,
        .home-body .video-wrapper,
        .home-body .video-item-wrapper {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 16px !important;
            flex-wrap: nowrap !important;
            justify-content: unset !important;
        }

        .video-item__thumb {
            border-radius: 12px;
        }

        .video-item__thumb img,
        .video-item__thumb video,
        .video-item__thumb .video-player {
            border-radius: 12px !important;
        }

        .video-item {
            max-width: 100% !important;
        }
    }

    /* Light Theme Overrides */
    [data-theme="light"] .sidebar-menu {
        background: rgba(255, 255, 255, 0.95) !important;
        border-right: 1px solid hsl(var(--border-color)) !important;
    }

    [data-theme="light"] .sidebar-menu-list__link {
        color: rgba(0, 0, 0, 0.8) !important;
    }

    [data-theme="light"] .sidebar-menu-list__link:hover {
        background: rgba(220, 20, 60, 0.08) !important;
    }

    [data-theme="light"] .video-item {
        background: transparent !important;
        border: none !important;
    }

    [data-theme="light"] .video-item__thumb {
        border-color: hsl(var(--border-color)) !important;
    }

    [data-theme="light"] .video-item__content {
        background: transparent !important;
    }

    [data-theme="light"] .video-item__content .title a {
        color: rgba(0, 0, 0, 0.9) !important;
    }

    [data-theme="light"] .video-item__content .meta {
        color: rgba(0, 0, 0, 0.6);
    }

    [data-theme="light"] .home-header {
        background: rgba(255, 255, 255, 0.95) !important;
        border-bottom: 1px solid hsl(var(--border-color)) !important;
    }

    /* Watch Later & Watch History Video Items - Now using video-item styling */
    .video-item .meta .video-wh-item__action {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .video-item .meta .ellipsis-list__btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
        padding: 0;
        cursor: pointer;
    }

    .video-item .meta .ellipsis-list__btn:hover {
        background: hsla(var(--base), 0.2);
        border-color: hsl(var(--base));
        color: hsl(var(--base));
        transform: scale(1.1);
    }

    .video-item .meta .ellipsis-list__btn svg {
        width: 16px;
        height: 16px;
    }

    [data-theme="light"] .video-item .meta .ellipsis-list__btn {
        background: rgba(0, 0, 0, 0.05);
        border-color: rgba(0, 0, 0, 0.1);
        color: rgba(0, 0, 0, 0.7);
    }

    [data-theme="light"] .video-item .meta .ellipsis-list__btn:hover {
        background: hsla(var(--base), 0.1);
        border-color: hsl(var(--base));
        color: hsl(var(--base));
    }

    /* FINAL DARK MODE OVERRIDE - Remove ALL backgrounds on hover */
    body:not([data-theme="light"]) .home-body .video-wrapper .video-item,
    body:not([data-theme="light"]) .home-body .video-wrapper .video-item:hover,
    body:not([data-theme="light"]) .home-body .video-item-wrapper .video-item,
    body:not([data-theme="light"]) .home-body .video-item-wrapper .video-item:hover,
    body:not([data-theme="light"]) .video-wrapper .video-item:hover,
    body:not([data-theme="light"]) .video-item-wrapper .video-item:hover {
        background: transparent !important;
        background-color: transparent !important;
        background-image: none !important;
    }

    body:not([data-theme="light"]) .home-body .video-wrapper .video-item:hover *,
    body:not([data-theme="light"]) .home-body .video-item-wrapper .video-item:hover *,
    body:not([data-theme="light"]) .video-wrapper .video-item:hover *,
    body:not([data-theme="light"]) .video-item-wrapper .video-item:hover * {
        background-color: transparent !important;
    }

    /* Override CSS variables that might be causing backgrounds */
    body:not([data-theme="light"]) .video-item:hover {
        --bg-color: transparent !important;
        --dark: transparent !important;
    }
</style>
@endpush


