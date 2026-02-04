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
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- YouTube-style persistent PiP: draggable, split-screen multi-video, "Back to tab" + Close -->
    <div id="persistent-pip" class="persistent-pip" aria-hidden="true">
        <div class="persistent-pip__drag-handle" title="Drag to move" aria-label="Drag to move"></div>
        <div class="persistent-pip__inner">
            <div id="persistent-pip__slots" class="persistent-pip__slots"></div>
            <button type="button" class="persistent-pip__back-to-tab" title="Back to tab" aria-label="Back to tab">
                <svg class="persistent-pip__back-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
                <span class="persistent-pip__back-text">Back to tab</span>
            </button>
            <button type="button" class="persistent-pip__close" title="Close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
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

    /* PiP: draggable, rounded frame, "Back to tab" top-left, Close top-right */
    .persistent-pip {
        display: none;
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 99999;
        width: 480px;
        max-width: calc(100vw - 48px);
        border-radius: 10px;
        overflow: visible;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.06);
        background: #000;
        user-select: none;
    }
    .persistent-pip.is-active {
        display: block;
    }
    .persistent-pip.is-split {
        width: 720px;
        max-width: calc(100vw - 48px);
    }
    .persistent-pip__drag-handle {
        position: absolute;
        top: 0;
        left: 90px;
        right: 90px;
        height: 36px;
        cursor: move;
        z-index: 12;
        border-radius: 10px 10px 0 0;
    }
    .persistent-pip__drag-handle::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 12px;
        transform: translateX(-50%);
        width: 40px;
        height: 4px;
        border-radius: 2px;
        background: rgba(255, 255, 255, 0.4);
    }
    .persistent-pip__inner {
        position: relative;
        width: 100%;
        border-radius: 0 0 10px 10px;
        overflow: hidden;
        background: #000;
    }
    /* Slots container: 1 col single, 2 cols split */
    .persistent-pip__slots {
        display: grid;
        grid-template-columns: 1fr;
        gap: 4px;
        width: 100%;
    }
    .persistent-pip__slots.has-2 {
        grid-template-columns: repeat(2, 1fr);
    }
    .persistent-pip__slots.has-3 {
        grid-template-columns: repeat(3, 1fr);
    }
    .persistent-pip__slots.has-4 {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(2, 1fr);
    }
    .persistent-pip__slot {
        position: relative;
        background: #000;
        overflow: hidden;
    }
    .persistent-pip__slot-close {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 28px;
        height: 28px;
        border: none;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 0;
        transition: background 0.2s;
    }
    /* Hide the container's close button when there are slots (use slot's close button instead) */
    .persistent-pip.is-active .persistent-pip__close {
        display: none !important;
    }
    /* Show container's close button only when there are no slots */
    .persistent-pip:not(.is-active) .persistent-pip__close,
    .persistent-pip.is-active:not(:has(.persistent-pip__slot)) .persistent-pip__close {
        display: block;
    }
    .persistent-pip__slot-close:hover {
        background: rgba(0, 0, 0, 0.9);
    }
    .persistent-pip__slot-close svg {
        width: 14px;
        height: 14px;
    }
    /* Video area: 16:9, no compression */
    .persistent-pip__video-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        background: #000;
        overflow: hidden;
    }
    .persistent-pip__video-wrap video {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
        display: block;
    }
    .persistent-pip__video-wrap .plyr,
    .persistent-pip__video-wrap .primary__videoPlayer {
        position: absolute !important;
        inset: 0 !important;
        width: 100% !important;
        height: 100% !important;
        min-height: 0 !important;
    }
    .persistent-pip__video-wrap .plyr__video-wrapper,
    .persistent-pip__video-wrap .plyr video {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
    }
    .persistent-pip__video-wrap .primary__videoPlayer {
        display: flex;
        flex-direction: column;
    }
    .persistent-pip__video-wrap .primary__videoPlayer .hidden-content,
    .persistent-pip__video-wrap .primary__videoPlayer .premium-stock {
        display: none !important;
    }
    /* "Back to tab" – top-left, icon + text (reference style) */
    .persistent-pip__back-to-tab {
        position: absolute;
        top: 10px;
        left: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        z-index: 10;
        transition: background 0.2s;
    }
    .persistent-pip__back-to-tab:hover {
        background: rgba(0, 0, 0, 0.85);
    }
    .persistent-pip__back-icon {
        flex-shrink: 0;
        opacity: 0.95;
    }
    .persistent-pip__back-text {
        white-space: nowrap;
    }
    /* Close – top-right, circular X (reference style) */
    .persistent-pip__close {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: background 0.2s;
    }
    .persistent-pip__close:hover {
        background: rgba(0, 0, 0, 0.85);
    }
    /* Bottom control bar: dark semi-transparent strip so white icons stand out (reference) */
    .persistent-pip__video-wrap .plyr__controls {
        background: linear-gradient(transparent 0%, rgba(0, 0, 0, 0.6) 30%, rgba(0, 0, 0, 0.9) 100%);
        padding: 8px 10px 10px;
    }
    .persistent-pip__video-wrap .plyr__progress,
    .persistent-pip__video-wrap .plyr__controls .plyr__control {
        color: #fff;
    }
    .persistent-pip__video-wrap .plyr--full-ui .plyr__control[data-plyr="pip"],
    .persistent-pip__slot .plyr__control[data-plyr="pip"] {
        display: none;
    }
    /* Hide ALL close buttons within PIP video wrap - only show the slot's close button */
    .persistent-pip__video-wrap .plyr__control[data-plyr="close"],
    .persistent-pip__video-wrap .plyr__control[aria-label*="close" i],
    .persistent-pip__video-wrap .plyr__control[aria-label*="Close" i],
    .persistent-pip__video-wrap button[aria-label*="close" i],
    .persistent-pip__video-wrap button[aria-label*="Close" i],
    .persistent-pip__video-wrap .close:not(.persistent-pip__slot-close),
    .persistent-pip__video-wrap .close-btn:not(.persistent-pip__slot-close),
    .persistent-pip__video-wrap [class*="close"]:not(.persistent-pip__slot-close),
    .persistent-pip__video-wrap .plyr__controls .plyr__control:last-child[data-plyr="close"],
    .persistent-pip__video-wrap .plyr__controls button[title*="close" i],
    .persistent-pip__video-wrap .plyr__controls button[title*="Close" i],
    /* Hide any button in top-right corner of video wrap */
    .persistent-pip__video-wrap .primary__videoPlayer button[style*="right"],
    .persistent-pip__video-wrap .primary__videoPlayer button[style*="top"],
    .persistent-pip__video-wrap .plyr button[style*="right"],
    .persistent-pip__video-wrap .plyr button[style*="top"],
    /* Hide any button with X icon or close icon */
    .persistent-pip__video-wrap button svg[viewBox*="18 6"],
    .persistent-pip__video-wrap button svg path[d*="M18 6"],
    .persistent-pip__video-wrap button:has(svg path[d*="M18 6"]):not(.persistent-pip__slot-close),
    /* Hide any absolute positioned button in top-right */
    .persistent-pip__video-wrap .primary__videoPlayer > button,
    .persistent-pip__video-wrap .plyr > button,
    .persistent-pip__video-wrap .plyr__video-wrapper > button,
    /* Hide buttons with specific classes that might be close buttons */
    .persistent-pip__video-wrap button[class*="close"]:not(.persistent-pip__slot-close),
    .persistent-pip__video-wrap button[class*="Close"]:not(.persistent-pip__slot-close),
    .persistent-pip__video-wrap .plyr__control[class*="close"]:not(.persistent-pip__slot-close) {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
        position: absolute !important;
        left: -9999px !important;
    }
    /* Ensure the slot's close button is always visible and on top */
    .persistent-pip__slot-close {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        z-index: 9999 !important;
        pointer-events: auto !important;
    }
    /* Keep PIP control visible on main (full) video player */
    .main-content .primary__videoPlayer .plyr__control[data-plyr="pip"] {
        display: flex !important;
    }
</style>
@endpush

@push('script')
<script>
(function() {
    'use strict';
    window.__pipActive = false;
    window.__pipVideoUrl = null;
    window.__pipSlots = [];

    var pipContainer = document.getElementById('persistent-pip');
    var pipSlotsEl = document.getElementById('persistent-pip__slots');
    var mainContent = document.querySelector('.main-content');

    function updateSlotsClass() {
        if (!pipSlotsEl) return;
        var n = window.__pipSlots.length;
        pipSlotsEl.classList.remove('has-2', 'has-3', 'has-4');
        if (n >= 2) pipSlotsEl.classList.add('has-' + Math.min(n, 4));
        if (pipContainer) {
            if (n >= 2) pipContainer.classList.add('is-split');
            else pipContainer.classList.remove('is-split');
        }
    }

    function pipClose() {
        window.__pipActive = false;
        window.__pipVideoUrl = null;
        window.__pipSlots = [];
        if (pipSlotsEl) pipSlotsEl.innerHTML = '';
        if (pipContainer) {
            pipContainer.classList.remove('is-active', 'is-split');
            pipContainer.setAttribute('aria-hidden', 'true');
            pipContainer.style.left = '';
            pipContainer.style.top = '';
            pipContainer.style.right = '';
            pipContainer.style.bottom = '';
        }
    }

    function pipRemoveSlot(index) {
        var slots = window.__pipSlots;
        if (index < 0 || index >= slots.length) return;
        var item = slots[index];
        slots.splice(index, 1);
        
        // Clean up observer if it exists
        if (item.wrapper && item.wrapper._pipCloseObserver) {
            item.wrapper._pipCloseObserver.disconnect();
            item.wrapper._pipCloseObserver = null;
        }
        
        if (item.wrapper && item.wrapper.parentNode) item.wrapper.parentNode.removeChild(item.wrapper);
        if (slots.length === 0) pipClose();
        else updateSlotsClass();
    }

    window.__pipAddSlot = function(playerNode, url) {
        if (!pipSlotsEl || !playerNode) return;
        
        // Remove all existing PIP slots - only allow one PIP at a time
        if (window.__pipSlots && window.__pipSlots.length > 0) {
            // Remove all existing slots
            while (window.__pipSlots.length > 0) {
                var existingSlot = window.__pipSlots[0];
                if (existingSlot.wrapper && existingSlot.wrapper.parentNode) {
                    existingSlot.wrapper.parentNode.removeChild(existingSlot.wrapper);
                }
                window.__pipSlots.shift();
            }
            // Clear the slots container
            if (pipSlotsEl) {
                pipSlotsEl.innerHTML = '';
            }
        }
        
        var slot = document.createElement('div');
        slot.className = 'persistent-pip__slot';
        var wrap = document.createElement('div');
        wrap.className = 'persistent-pip__video-wrap';
        wrap.appendChild(playerNode);
        var closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'persistent-pip__slot-close';
        closeBtn.title = 'Close';
        closeBtn.setAttribute('aria-label', 'Close');
        closeBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>';
        closeBtn.addEventListener('click', function() {
            var i = Array.prototype.indexOf.call(pipSlotsEl.querySelectorAll('.persistent-pip__slot'), slot);
            if (i !== -1) pipRemoveSlot(i);
        });
        slot.appendChild(wrap);
        slot.appendChild(closeBtn);
        pipSlotsEl.appendChild(slot);
        window.__pipSlots.push({ node: playerNode, url: url, wrapper: slot });
        window.__pipActive = true;
        window.__pipVideoUrl = url;
        updateSlotsClass();
        if (pipContainer) { pipContainer.classList.add('is-active'); pipContainer.setAttribute('aria-hidden', 'false'); }
        
        // Hide any close buttons within the video player that might appear
        function hideDuplicateCloseButtons() {
            var videoWrap = slot.querySelector('.persistent-pip__video-wrap');
            if (videoWrap) {
                // Find ALL buttons in the video wrap
                var allButtons = videoWrap.querySelectorAll('button');
                allButtons.forEach(function(btn) {
                    // Skip the slot's own close button
                    if (btn === closeBtn || btn.closest('.persistent-pip__slot-close')) {
                        return;
                    }
                    
                    // Check if button is a close button by various indicators
                    var isCloseButton = false;
                    
                    // Check aria-label
                    var ariaLabel = btn.getAttribute('aria-label') || '';
                    if (ariaLabel.toLowerCase().includes('close')) {
                        isCloseButton = true;
                    }
                    
                    // Check title
                    var title = btn.getAttribute('title') || '';
                    if (title.toLowerCase().includes('close')) {
                        isCloseButton = true;
                    }
                    
                    // Check data attribute
                    if (btn.getAttribute('data-plyr') === 'close') {
                        isCloseButton = true;
                    }
                    
                    // Check if button contains X icon (close icon)
                    var svg = btn.querySelector('svg');
                    if (svg) {
                        var path = svg.querySelector('path');
                        if (path) {
                            var pathD = path.getAttribute('d') || '';
                            // Common close icon paths
                            if (pathD.includes('M18 6') || pathD.includes('M6 6') || pathD.includes('M18 18')) {
                                isCloseButton = true;
                            }
                        }
                    }
                    
                    // Check class names
                    var className = btn.className || '';
                    if (className.toLowerCase().includes('close') && !className.includes('persistent-pip__slot-close')) {
                        isCloseButton = true;
                    }
                    
                    // Check if button is positioned in top-right (likely a close button)
                    var rect = btn.getBoundingClientRect();
                    var wrapRect = videoWrap.getBoundingClientRect();
                    var isTopRight = rect.top < wrapRect.top + 50 && rect.right > wrapRect.right - 50;
                    
                    // Also check computed styles for absolute positioning in top-right
                    var computedStyle = window.getComputedStyle(btn);
                    var isAbsoluteTopRight = computedStyle.position === 'absolute' && 
                                           (computedStyle.top === '0px' || parseInt(computedStyle.top) < 50) &&
                                           (computedStyle.right === '0px' || parseInt(computedStyle.right) < 50);
                    
                    // Check if button has X icon (even if not detected by other means)
                    var hasXIcon = false;
                    var svgInBtn = btn.querySelector('svg');
                    if (svgInBtn) {
                        var paths = svgInBtn.querySelectorAll('path');
                        paths.forEach(function(p) {
                            var d = p.getAttribute('d') || '';
                            // X icon typically has two diagonal lines crossing
                            if ((d.includes('M18 6') && d.includes('6 18')) || 
                                (d.includes('M6 6') && d.includes('l12 12')) ||
                                (d.includes('18 6') && d.includes('6 18'))) {
                                hasXIcon = true;
                            }
                        });
                    }
                    
                    if (isCloseButton || hasXIcon || isTopRight || isAbsoluteTopRight) {
                        btn.style.display = 'none';
                        btn.style.visibility = 'hidden';
                        btn.style.opacity = '0';
                        btn.style.pointerEvents = 'none';
                        btn.style.position = 'absolute';
                        btn.style.left = '-9999px';
                        btn.style.width = '0';
                        btn.style.height = '0';
                        btn.setAttribute('data-pip-hidden', 'true');
                    }
                });
            }
        }
        
        // Hide immediately
        hideDuplicateCloseButtons();
        
        // Hide after a delay (in case buttons are added dynamically)
        setTimeout(hideDuplicateCloseButtons, 100);
        setTimeout(hideDuplicateCloseButtons, 500);
        
        // Watch for dynamically added close buttons
        if (slot.querySelector('.persistent-pip__video-wrap')) {
            var observer = new MutationObserver(function(mutations) {
                hideDuplicateCloseButtons();
            });
            observer.observe(slot, {
                childList: true,
                subtree: true,
                attributes: false
            });
            
            // Store observer on slot for cleanup if needed
            slot._pipCloseObserver = observer;
        }
    };

    function pipExpand() {
        var slots = window.__pipSlots;
        if (slots.length === 0) { pipClose(); return; }
        var first = slots[0];
        var url = first.url;
        var playerNode = first.node;
        if (!url || !mainContent) { if (url) window.location.href = url; return; }
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
            .then(function(r) { return r.text(); })
            .then(function(html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var newMain = doc.querySelector('.main-content');
                if (!newMain) { window.location.href = url; return; }
                mainContent.innerHTML = newMain.innerHTML;
                var slot = mainContent.querySelector('.primary__videoPlayer');
                if (slot && playerNode.parentNode) {
                    slot.parentNode.replaceChild(playerNode, slot);
                }
                pipRemoveSlot(0);
                if (window.__pipSlots.length === 0) {
                    pipContainer.classList.remove('is-active');
                    pipContainer.setAttribute('aria-hidden', 'true');
                    window.__pipActive = false;
                    window.__pipVideoUrl = null;
                } else {
                    window.__pipVideoUrl = window.__pipSlots[0].url;
                    updateSlotsClass();
                }
                window.history.pushState({}, '', url);
                var titleEl = doc.querySelector('title');
                if (titleEl) document.title = titleEl.textContent;
            })
            .catch(function() { window.location.href = url; });
    }

    if (pipContainer) {
        var closeBtn = pipContainer.querySelector('.persistent-pip__close');
        var backBtn = pipContainer.querySelector('.persistent-pip__back-to-tab');
        if (closeBtn) closeBtn.addEventListener('click', pipClose);
        if (backBtn) backBtn.addEventListener('click', pipExpand);
    }

    (function initPipDrag() {
        var handle = pipContainer && pipContainer.querySelector('.persistent-pip__drag-handle');
        if (!handle) return;
        var dragging = false;
        var startX, startY, startLeft, startTop;

        function getRect() {
            var r = pipContainer.getBoundingClientRect();
            var br = document.documentElement.getBoundingClientRect();
            return { left: r.left, top: r.top, right: br.right - r.right, bottom: br.bottom - r.bottom };
        }

        function applyPosition(left, top) {
            pipContainer.style.left = left + 'px';
            pipContainer.style.top = top + 'px';
            pipContainer.style.right = 'auto';
            pipContainer.style.bottom = 'auto';
        }

        handle.addEventListener('mousedown', function(e) {
            if (e.button !== 0) return;
            e.preventDefault();
            var r = getRect();
            startX = e.clientX;
            startY = e.clientY;
            startLeft = r.left;
            startTop = r.top;
            dragging = true;
            applyPosition(startLeft, startTop);
        });

        document.addEventListener('mousemove', function(e) {
            if (!dragging) return;
            e.preventDefault();
            var dx = e.clientX - startX;
            var dy = e.clientY - startY;
            var left = Math.max(0, Math.min(window.innerWidth - pipContainer.offsetWidth, startLeft + dx));
            var top = Math.max(0, Math.min(window.innerHeight - pipContainer.offsetHeight, startTop + dy));
            applyPosition(left, top);
        });

        document.addEventListener('mouseup', function() {
            dragging = false;
        });
    })();

    function initMainContentPlayer() {
        if (!mainContent || typeof Plyr === 'undefined') return;
        var playerContainer = mainContent.querySelector('.primary__videoPlayer');
        var videoEl = mainContent.querySelector('.primary__videoPlayer .video-player');
        if (!playerContainer || !videoEl) return;
        if (videoEl.plyr) return;
        var player = new Plyr(videoEl, {
            controls: ['rewind', 'play', 'fast-forward', 'progress', 'current-time', 'duration', 'mute', 'volume', 'settings', 'fullscreen', 'pip'],
            ratio: '16:9',
            hideControls: false
        });
        player.on('ready', function() {
            var pipBtn = mainContent.querySelector('.plyr__control[data-plyr="pip"]');
            if (pipBtn && !pipBtn.hasAttribute('data-persistent-pip-bound')) {
                pipBtn.setAttribute('data-persistent-pip-bound', '1');
                pipBtn.addEventListener('click', function(ev) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    if (window.__pipAddSlot) window.__pipAddSlot(playerContainer, window.location.href);
                });
            }
        });
    }

    document.addEventListener('click', function(e) {
        if (!window.__pipActive || !mainContent) return;
        var a = e.target.closest('a');
        if (!a || !a.href || a.target === '_blank' || a.getAttribute('data-no-ajax')) return;
        try {
            var url = new URL(a.href);
            if (url.origin !== window.location.origin) return;
        } catch (err) { return; }
        var href = a.href;
        e.preventDefault();
        e.stopPropagation();
        fetch(href, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
            .then(function(r) { return r.text(); })
            .then(function(html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var newMain = doc.querySelector('.main-content');
                if (newMain) {
                    mainContent.innerHTML = newMain.innerHTML;
                    window.history.pushState({ pip: true }, '', href);
                    var titleEl = doc.querySelector('title');
                    if (titleEl) document.title = titleEl.textContent;
                    setTimeout(initMainContentPlayer, 100);
                } else {
                    window.location.href = href;
                }
            })
            .catch(function() { window.location.href = href; });
    }, true);

    window.addEventListener('popstate', function() {
        if (!mainContent) { window.location.reload(); return; }
        if (window.__pipActive) {
            var href = window.location.href;
            fetch(href, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
                .then(function(r) { return r.text(); })
                .then(function(html) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');
                    var newMain = doc.querySelector('.main-content');
                    if (newMain) {
                        mainContent.innerHTML = newMain.innerHTML;
                        setTimeout(initMainContentPlayer, 100);
                    }
                    var titleEl = doc.querySelector('title');
                    if (titleEl) document.title = titleEl.textContent;
                });
        } else {
            window.location.reload();
        }
    });
})();
</script>
@endpush


