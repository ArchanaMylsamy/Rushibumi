@extends($activeTemplate . 'layouts.app')
@section('app')
    <div class="home-fluid">
        <div class="home__inner">
            @include($activeTemplate . 'partials.sidebar')
            <div class="home__right">
                @include($activeTemplate . 'partials.header')
                @if (!request()->routeIs(['user.setting.*', 'user.authorization']))
                    <div class="home-body dashboard-body">
                        <div class="dashboard-wrapper">
                            @if (request()->routeIs(['user.advertiser.*']) || @$advertisement)
                                @include($activeTemplate . 'partials.advertiser_sidebar')
                            @else
                                @include($activeTemplate . 'partials.user_sidebar')
                            @endif
                            @yield('content')
                        </div>
                    </div>
                @else
                    <div class="home-body setting-body">
                        <div class="setting-wrapper">
                            @include($activeTemplate . 'partials.setting_menu')
                            @yield('content')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .daterangepicker td.active,
        .daterangepicker td.active:hover,
        .daterangepicker .ranges li.active {
            background-color: hsl(var(--base)) !important;
        }

        /* Theme-aware Dashboard Menu Sidebar */
        .dashboard-menu {
            background: hsl(var(--card-bg)) !important;
            border-right-color: hsl(var(--border-color)) !important;
        }

        .dashboard-menu__link {
            color: hsl(var(--body-color)) !important;
        }

        .dashboard-menu__link:hover {
            background-color: hsla(var(--base), 0.1) !important;
            color: hsl(var(--base)) !important;
        }

        .dashboard-menu__link.active,
        .dashboard-menu__item.active .dashboard-menu__link {
            background-color: hsla(var(--base), 0.15) !important;
            color: hsl(var(--base)) !important;
        }

        .dashboard-menu__link .icon {
            color: inherit;
        }

        /* Sidebar Submenu - Theme Aware */
        .sidebar-submenu {
            background-color: hsl(var(--card-bg)) !important;
            border-left-color: hsl(var(--border-color)) !important;
        }

        .sidebar-submenu-list__link {
            color: hsl(var(--body-color)) !important;
        }

        .sidebar-submenu-list__link:hover {
            background-color: hsla(var(--base), 0.1) !important;
            color: hsl(var(--base)) !important;
        }

        .sidebar-submenu-list__item.active .sidebar-submenu-list__link {
            background-color: hsla(var(--base), 0.15) !important;
            color: hsl(var(--base)) !important;
        }

        /* Setting Menu Sidebar - Theme Aware */
        .setting-menu {
            background: hsl(var(--card-bg)) !important;
            border-right-color: hsl(var(--border-color)) !important;
        }

        .setting-menu__title {
            color: hsl(var(--heading-color)) !important;
            border-bottom-color: hsl(var(--border-color));
        }

        .setting-menu__link {
            color: hsl(var(--body-color)) !important;
        }

        .setting-menu__link:hover {
            background-color: hsla(var(--base), 0.1) !important;
            color: hsl(var(--base)) !important;
        }

        .setting-menu__link.active,
        .setting-menu__item.active .setting-menu__link {
            background-color: hsla(var(--base), 0.15) !important;
            color: hsl(var(--base)) !important;
        }

        .setting-menu__link .icon {
            color: inherit;
        }

        /* Dashboard Menu Button - Theme Aware */
        .dashboard-menu-btn,
        .setting-menu-btn {
            background: hsl(var(--base)) !important;
            border-color: transparent !important;
            color: #ffffff !important;
        }

        .dashboard-menu-btn:hover,
        .setting-menu-btn:hover {
            opacity: 0.9;
        }

        /* Menu Close Button - Theme Aware */
        .dashboard-menu__close,
        .setting-menu__close {
            color: hsl(var(--body-color)) !important;
        }

        .dashboard-menu__close:hover,
        .setting-menu__close:hover {
            color: hsl(var(--base)) !important;
        }

        /* Sidebar Styling - Theme Aware */
        .sidebar-menu {
            background: hsl(var(--card-bg)) !important;
            border-right: 1px solid hsl(var(--border-color)) !important;
            box-shadow: var(--box-shadow) !important;
        }

        .sidebar-menu::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, transparent, hsla(var(--base), 0.03), transparent);
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
            opacity: 0.8;
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
            color: hsl(var(--body-color)) !important;
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
            background: hsl(var(--base));
            border-radius: 0 4px 4px 0;
            transition: height 0.3s ease;
        }

        .sidebar-menu-list__link:hover {
            background: hsla(var(--base), 0.1) !important;
            color: hsl(var(--base)) !important;
            transform: translateX(5px);
        }

        .sidebar-menu-list__link:hover::before {
            height: 60%;
        }

        .sidebar-menu-list__item.active .sidebar-menu-list__link,
        .sidebar-menu-list__link.active {
            background: hsla(var(--base), 0.15) !important;
            color: hsl(var(--base)) !important;
            font-weight: 600;
        }

        .sidebar-menu-list__item.active .sidebar-menu-list__link::before,
        .sidebar-menu-list__link.active::before {
            height: 80%;
        }

        .sidebar-menu-list__link .icon {
            color: hsl(var(--body-color));
            transition: all 0.3s ease;
        }

        .sidebar-menu-list__link:hover .icon,
        .sidebar-menu-list__item.active .sidebar-menu-list__link .icon {
            color: hsl(var(--base));
            transform: scale(1.1);
        }

        .separate-border {
            border-top: 1px solid hsl(var(--border-color));
            margin: 16px 0;
        }

        /* Header Styling - Theme Aware */
        .home-header {
            background: hsl(var(--bg-color)) !important;
            border-bottom: 1px solid hsl(var(--border-color)) !important;
            box-shadow: var(--box-shadow) !important;
        }

        .home-header__inner {
            padding: 12px 20px;
        }

        /* Search Form - Theme Aware */
        .search-form .form--control {
            background: hsl(var(--card-bg)) !important;
            border: 1px solid hsl(var(--border-color)) !important;
            color: hsl(var(--body-color)) !important;
            border-radius: 24px !important;
            padding: 10px 50px 10px 20px !important;
        }

        .search-form .form--control:focus {
            border-color: hsl(var(--base)) !important;
            box-shadow: 0 0 0 3px hsla(var(--base), 0.1) !important;
            outline: none !important;
        }

        .search-form-btn {
            color: hsl(var(--body-color));
            transition: color 0.3s ease;
        }

        .search-form-btn:hover {
            color: hsl(var(--base));
        }

        /* Menu Button - Theme Aware */
        .menu-button {
            border: none !important;
            background: transparent;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .menu-button:hover {
            background: hsla(var(--base), 0.1);
        }

        .menu-button-line {
            background: hsl(var(--body-color));
        }

        /* Buttons - Theme Aware */
        .btn--base {
            background: hsl(var(--base)) !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .btn--base:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        /* Notification - Theme Aware */
        .notification__btn {
            color: hsl(var(--body-color));
            transition: all 0.3s ease;
        }

        .notification__btn:hover {
            color: hsl(var(--base));
        }

        .countDown {
            background: hsl(var(--base)) !important;
            color: #ffffff !important;
        }

        /* User Info - Theme Aware */
        .user-info__button {
            border: none !important;
            transition: all 0.3s ease;
            background: transparent;
        }

        .user-info__button:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }

        .user-info__thumb {
            border: none !important;
        }

        .user-info__thumb img {
            border: none !important;
        }

        /* Close Icons - Theme Aware */
        .close-icon,
        .search-close,
        .comment-box__close-icon {
            border: none !important;
            background: transparent !important;
        }

        .close-icon:hover,
        .search-close:hover,
        .comment-box__close-icon:hover {
            background: hsla(var(--base), 0.1) !important;
        }

        /* Logo - Theme Aware */
        .sidebar-logo__link,
        .sidebar-logo__link img {
            border: none !important;
        }

        /* Tag Sliders - Theme Aware */
        .tag-item {
            background: hsl(var(--card-bg)) !important;
            border: 1px solid hsl(var(--border-color)) !important;
            color: hsl(var(--body-color)) !important;
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

        .home-header__left-mic {
            color: hsl(var(--body-color));
            transition: all 0.3s ease;
        }

        .home-header__left-mic:hover {
            color: hsl(var(--base));
        }

        .sm-bottom-nav__link {
            color: hsl(var(--body-color));
            transition: all 0.3s ease;
        }

        .sm-bottom-nav__link:hover {
            color: hsl(var(--base));
        }

        .create__btn {
            background: hsl(var(--base)) !important;
            border: none !important;
            color: #ffffff !important;
        }

        .create__btn:hover {
            opacity: 0.9;
        }

        .create__list {
            background: hsl(var(--card-bg)) !important;
            border: 1px solid hsl(var(--border-color)) !important;
        }

        .create__list-link {
            color: hsl(var(--body-color)) !important;
        }

        .create__list-link:hover {
            background: hsla(var(--base), 0.1) !important;
            color: hsl(var(--base)) !important;
        }

        .notification__list {
            background: hsl(var(--card-bg)) !important;
            border: 1px solid hsl(var(--border-color)) !important;
        }

        .notification__list-header {
            border-bottom: 1px solid hsl(var(--border-color)) !important;
            color: hsl(var(--heading-color)) !important;
        }

        .notification__list-link {
            color: hsl(var(--body-color)) !important;
        }

        .notification__list-link:hover {
            background: hsla(var(--base), 0.1) !important;
        }

        .user-info-list {
            background: hsl(var(--card-bg)) !important;
            border: 1px solid hsl(var(--border-color)) !important;
        }

        .list__link {
            color: hsl(var(--body-color)) !important;
        }

        .list__link:hover {
            background: hsla(var(--base), 0.1) !important;
            color: hsl(var(--base)) !important;
        }

        .user-info-submenu {
            background: hsl(var(--card-bg)) !important;
            border: 1px solid hsl(var(--border-color)) !important;
        }

        .user-info-submenu__link {
            color: hsl(var(--body-color)) !important;
        }

        .user-info-submenu__link:hover {
            background: hsla(var(--base), 0.1) !important;
            color: hsl(var(--base)) !important;
        }

        .sidebar-menu-list__title {
            color: hsl(var(--heading-color)) !important;
        }
    </style>
@endpush

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/owl.carousel.filter.js') }}"></script>
@endpush
