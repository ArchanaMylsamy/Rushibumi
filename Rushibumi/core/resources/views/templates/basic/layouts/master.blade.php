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

        /* Red & Black Theme for Dashboard Menu Sidebar - Colors Only */
        .dashboard-menu {
            background: rgba(0, 0, 0, 0.95) !important;
            border-right-color: rgba(220, 20, 60, 0.3) !important;
        }

        .dashboard-menu__link {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .dashboard-menu__link:hover {
            background-color: rgba(220, 20, 60, 0.1) !important;
            color: #dc143c !important;
        }

        .dashboard-menu__link.active,
        .dashboard-menu__item.active .dashboard-menu__link {
            background-color: rgba(220, 20, 60, 0.2) !important;
            color: #dc143c !important;
        }

        .dashboard-menu__link .icon {
            color: inherit;
        }

        /* Sidebar Submenu - Colors Only */
        .sidebar-submenu {
            background-color: rgba(0, 0, 0, 0.6) !important;
            border-left-color: rgba(220, 20, 60, 0.3) !important;
        }

        .sidebar-submenu-list__link {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .sidebar-submenu-list__link:hover {
            background-color: rgba(220, 20, 60, 0.15) !important;
            color: #dc143c !important;
        }

        .sidebar-submenu-list__item.active .sidebar-submenu-list__link {
            background-color: rgba(220, 20, 60, 0.2) !important;
            color: #dc143c !important;
        }

        /* Setting Menu Sidebar - Colors Only */
        .setting-menu {
            background: rgba(0, 0, 0, 0.95) !important;
            border-right-color: rgba(220, 20, 60, 0.3) !important;
        }

        .setting-menu__title {
            background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            border-bottom-color: rgba(220, 20, 60, 0.3);
        }

        .setting-menu__link {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .setting-menu__link:hover {
            background-color: rgba(220, 20, 60, 0.1) !important;
            color: #dc143c !important;
        }

        .setting-menu__link.active,
        .setting-menu__item.active .setting-menu__link {
            background-color: rgba(220, 20, 60, 0.2) !important;
            color: #dc143c !important;
        }

        .setting-menu__link .icon {
            color: inherit;
        }

        /* Dashboard Menu Button - Colors Only */
        .dashboard-menu-btn,
        .setting-menu-btn {
            background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%) !important;
            border-color: transparent !important;
            color: #ffffff !important;
        }

        .dashboard-menu-btn:hover,
        .setting-menu-btn:hover {
            background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
        }

        /* Menu Close Button - Colors Only */
        .dashboard-menu__close,
        .setting-menu__close {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .dashboard-menu__close:hover,
        .setting-menu__close:hover {
            color: #dc143c !important;
        }

        /* Sidebar Styling - Same as Main Page */
        .sidebar-menu {
            background: rgba(0, 0, 0, 0.95) !important;
            border-right: 2px solid rgba(220, 20, 60, 0.3) !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(220, 20, 60, 0.1) !important;
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
            border-bottom: 1px solid rgba(220, 20, 60, 0.2);
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
            border-top: 1px solid rgba(220, 20, 60, 0.2);
            margin: 16px 0;
        }

        /* Header Styling - Same as Main Page */
        .home-header {
            background: rgba(0, 0, 0, 0.9) !important;
            border-bottom: 2px solid rgba(220, 20, 60, 0.3) !important;
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
            border: 2px solid rgba(220, 20, 60, 0.3) !important;
            color: #ffffff !important;
            border-radius: 24px !important;
            padding: 10px 50px 10px 20px !important;
        }

        .search-form .form--control:focus {
            border-color: #dc143c !important;
            box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.2) !important;
            outline: none !important;
        }

        .search-form-btn {
            color: rgba(220, 20, 60, 0.8);
            transition: color 0.3s ease;
        }

        .search-form-btn:hover {
            color: #dc143c;
        }

        /* Menu Button */
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

        /* User Info */
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

        /* Close Icons */
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

        /* Logo */
        .sidebar-logo__link,
        .sidebar-logo__link img {
            border: none !important;
        }

        /* Tag Sliders */
        .tag-item {
            background: rgba(0, 0, 0, 0.6) !important;
            border: 2px solid rgba(220, 20, 60, 0.3) !important;
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 20px !important;
            padding: 8px 16px !important;
            transition: all 0.3s ease !important;
            font-weight: 500;
        }

        .tag-item:hover,
        .tag-item.active {
            background: rgba(220, 20, 60, 0.2) !important;
            border-color: #dc143c !important;
            color: #dc143c !important;
            transform: translateY(-2px);
        }

        .home-header__left-mic {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .home-header__left-mic:hover {
            color: #dc143c;
        }

        .sm-bottom-nav__link {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .sm-bottom-nav__link:hover {
            color: #dc143c;
        }

        .create__btn {
            background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%) !important;
            border: none !important;
            color: #ffffff !important;
        }

        .create__btn:hover {
            background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
        }

        .create__list {
            background: rgba(0, 0, 0, 0.95) !important;
            border: 1px solid rgba(220, 20, 60, 0.3) !important;
        }

        .create__list-link {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .create__list-link:hover {
            background: rgba(220, 20, 60, 0.1) !important;
            color: #dc143c !important;
        }

        .notification__list {
            background: rgba(0, 0, 0, 0.95) !important;
            border: 1px solid rgba(220, 20, 60, 0.3) !important;
        }

        .notification__list-header {
            border-bottom: 1px solid rgba(220, 20, 60, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .notification__list-link {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .notification__list-link:hover {
            background: rgba(220, 20, 60, 0.1) !important;
        }

        .user-info-list {
            background: rgba(0, 0, 0, 0.95) !important;
            border: 1px solid rgba(220, 20, 60, 0.3) !important;
        }

        .list__link {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .list__link:hover {
            background: rgba(220, 20, 60, 0.1) !important;
            color: #dc143c !important;
        }

        .user-info-submenu {
            background: rgba(0, 0, 0, 0.9) !important;
            border: 1px solid rgba(220, 20, 60, 0.3) !important;
        }

        .user-info-submenu__link {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .user-info-submenu__link:hover {
            background: rgba(220, 20, 60, 0.1) !important;
            color: #dc143c !important;
        }

        .sidebar-menu-list__title {
            color: rgba(255, 255, 255, 0.9) !important;
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
