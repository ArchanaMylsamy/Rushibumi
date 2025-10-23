<button class="dashboard-menu-btn btn btn--base d-xl-none d-block"><i class="las la-sliders-h"></i></button>
<div class="dashboard-menu">
    <span class="dashboard-menu__close d-xl-none d-block"><i class="las la-times"></i></span>
    <ul class="dashboard-menu__list">
        <li class="dashboard-menu__item">
            <a href="{{route('user.advertiser.home')}}" class="dashboard-menu__link {{menuActive('user.advertiser.home')}}">
                <span class="icon"><i class="vti-dashboard"></i></span>
                <span class="text">@lang('Dashboard')</span>
            </a>
        </li>    
        <li class="dashboard-menu__item">
            <a href="{{route('user.advertiser.create.ad')}}" class="dashboard-menu__link {{menuActive('user.advertiser.create.ad')}}">
                <span class="icon"><i class="las la-ad"></i></span>
                <span class="text">@lang('Create Ad')</span>
            </a>
        </li>
        <li class="dashboard-menu__item">
            <a href="{{route('user.advertiser.ad.list')}}" class="dashboard-menu__link {{menuActive('user.advertiser.ad.list')}}">
                <span class="icon"><i class="las la-list"></i></span>
                <span class="text">@lang('All Ads')</span>
            </a>
        </li>

        <li class="dashboard-menu__item">
            <a href="{{route('user.advertiser.payment.history')}}" class="dashboard-menu__link {{menuActive('user.advertiser.payment.history')}}">
                <span class="icon"><i class="lab la-telegram-plane"></i></span>
                <span class="text">@lang('Payment History')</span>
            </a>
        </li>
    </ul>
</div>
