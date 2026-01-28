@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-content">

        <div class="notice"></div>

        @php
            $kyc = getContent('kyc.content', true);
            $user = auth()->user();
        @endphp

        @if ($user->kv == Status::KYC_UNVERIFIED && $user->kyc_rejection_reason)
            <div class="alert alert--danger" role="alert">
                <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                <p class="alert__message">
                    <span class="fw-bold">@lang('KYC Documents Rejected')</span><br>
                    <small><i>{{ __(@$kyc->data_values->reject) }}
                            <a href="javascript::void(0)" class="link-color" data-bs-toggle="modal"
                                data-bs-target="#kycRejectionReason">@lang('Click here')</a> @lang('to show the reason').

                            <a href="{{ route('user.kyc.form') }}" class="link-color">@lang('Click Here')</a>
                            @lang('to Re-submit Documents'). <br>
                            <a href="{{ route('user.kyc.data') }}" class="link-color">@lang('See KYC Data')</a>
                        </i></small>
                </p>
            </div>
        @elseif ($user->kv == Status::KYC_UNVERIFIED)
            <div class="alert alert--info" role="alert">
                <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                <p class="alert__message">
                    <span class="fw-bold">@lang('KYC Verification Required')</span><br>
                    <small><i>{{ __(@$kyc->data_values->required) }}
                            <a href="{{ route('user.kyc.form') }}" class="link-color">@lang('Click here')</a>
                            @lang('to submit KYC information').</i></small>
                </p>
            </div>
        @elseif($user->kv == Status::KYC_PENDING)
            <div class="alert alert--warning" role="alert">
                <div class="alert__icon"><i class="fas fa-user-check"></i></div>
                <p class="alert__message">
                    <span class="fw-bold">@lang('KYC Verification Pending')</span><br>
                    <small><i>{{ __(@$kyc->data_values->pending) }} <a href="{{ route('user.kyc.data') }}"
                                class="link-color">@lang('Click here')</a> @lang('to see your submitted information')</i></small>
                </p>
            </div>
        @endif

        <div class="dashboard-card-wrapper">
            <div class="dashboard-card">
                <h5 class="dashboard-card__title">@lang('Total views')</h5>
                <h3 class="dashboard-card__number">{{ formatNumber($totalViews) }}</h3>
                <span class="dashboard-card__icon"><img src="{{ asset($activeTemplateTrue . 'images/icon-img/7.png') }}"
                        alt="image"></span>
            </div>
            <div class="dashboard-card info">
                <h5 class="dashboard-card__title">@lang('Subscribers')</h5>
                <h3 class="dashboard-card__number">{{ formatNumber($totalFollowers) }}</h3>
                <span class="dashboard-card__icon"><img src="{{ asset($activeTemplateTrue . 'images/icon-img/8.png') }}"
                        alt="image"></span>
            </div>
            <div class="dashboard-card purple">
                <h5 class="dashboard-card__title">@lang('Total Earning')</h5>
                <h3 class="dashboard-card__number">{{ showAmount($totalEarning) }}</h3>
                <span class="dashboard-card__icon"><img
                        src="{{ asset($activeTemplateTrue . 'images/icon-img/9.png') }}"alt="image"></span>
            </div>
        </div>
        <div class="chart-box">
            <div class="chart-box__top">
                <h5 class="chart-box__title">@lang('Video impression')</h5>

                <div class="border p-1 cursor-pointer rounded chart-title-text" id="impressionDatePicker">
                    <i class="la la-calendar"></i>&nbsp;
                    <span></span> <i class="la la-caret-down"></i>
                </div>

            </div>
            <div id="videoImpression"></div>
        </div>
        <div class="video-analytics">
            <div class="video-analytics__top">
                <h3 class="video-analytics__title">@lang('Video Analytics')</h3>

            </div>
            <div class="dashboard-card-wrapper sm">
                <div class="dashboard-card sm">
                    <h6 class="dashboard-card__title">@lang('Total views')</h6>
                    <h3 class="dashboard-card__number">{{ formatNumber($totalViews) }}</h3>
                </div>
                <div class="dashboard-card sm">
                    <h6 class="dashboard-card__title">@lang('Average views')</h6>
                    <h3 class="dashboard-card__number">{{ formatNumber(number_format($averageViews)) }}</h3>
                </div>
                <div class="dashboard-card sm">
                    <h6 class="dashboard-card__title">@lang('Total Like Video')</h6>
                    <h3 class="dashboard-card__number">{{ formatNumber($totalLike) }}</h3>
                </div>
                <div class="dashboard-card sm">
                    <div class="d-flex justify-content-between">

                        <h6 class="dashboard-card__title">@lang('New Subscribers (Last 7 Days)')</h6>
                        <h6 class="dashboard-card__title"></h6>
                    </div>
                    <h3 class="dashboard-card__number">{{ formatNumber($newFollowers) }}</h3>
                </div>
            </div>
        </div>
    </div>



    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="custom--modal scale-style modal fade" id="kycRejectionReason">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection



@push('script-lib')
    <script src="{{ asset('assets/global/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/charts.js') }}"></script>
@endpush

@push('style-lib')
    <link type="text/css" href="{{ asset('assets/global/css/daterangepicker.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script>
        "use strict";

        const start = moment().subtract(14, 'days');
        const end = moment();

        const dateRangeOptions = {
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')],
                'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
            },
            maxDate: moment()
        }

        const changeDatePickerText = (element, startDate, endDate) => {
            $(element).html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
        }

        let trxChart = lineChart(
            document.querySelector("#videoImpression"),
            [{
                name: "Total Impressions",
                data: []
            }],
            []
        );



        const impressionChart = (startDate, endDate) => {
            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }
            const url = @json(route('user.chart.impression'));
            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        trxChart.updateSeries(data.data);
                        trxChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            },
                            colors: ['#fa8500'],
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 0,
                                    opacityFrom: 0.2,
                                    opacityTo: 0.1,
                                    stops: [0, 90, 100]
                                }
                            },
                        });
                    }
                }
            );
        }


        $('#impressionDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText(
            '#impressionDatePicker span', start, end));


        changeDatePickerText('#impressionDatePicker span', start, end);

        impressionChart(start, end);


        $('#impressionDatePicker').on('apply.daterangepicker', (event, picker) => impressionChart(picker.startDate, picker
            .endDate));
    </script>
@endpush

@push('style')
<style>
    /* Theme-aware Dashboard Styling */
    .dashboard-content {
        background: hsl(var(--body-background));
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        padding: 20px;
    }

    /* Animated Background Effects - Theme Aware */
    .dashboard-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(220, 20, 60, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(139, 0, 0, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 20%, rgba(178, 34, 34, 0.05) 0%, transparent 50%);
        animation: pulse-glow 8s ease-in-out infinite;
        z-index: 0;
        opacity: 0.3;
    }

    [data-theme="light"] .dashboard-content::before {
        opacity: 0.15;
    }

    @keyframes pulse-glow {
        0%, 100% {
            opacity: 0.3;
            transform: scale(1);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.1);
        }
    }

    [data-theme="light"] .dashboard-content::before {
        opacity: 0.15;
    }

    /* Floating Particles - Theme Aware */
    .dashboard-content::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-image: 
            radial-gradient(2px 2px at 20% 30%, rgba(220, 20, 60, 0.15), transparent),
            radial-gradient(2px 2px at 60% 70%, rgba(139, 0, 0, 0.15), transparent),
            radial-gradient(1px 1px at 50% 50%, rgba(255, 0, 0, 0.1), transparent),
            radial-gradient(1px 1px at 80% 10%, rgba(220, 20, 60, 0.1), transparent),
            radial-gradient(2px 2px at 40% 80%, rgba(139, 0, 0, 0.15), transparent);
        background-size: 200% 200%;
        animation: particle-move 20s linear infinite;
        z-index: 0;
        opacity: 0.5;
    }

    [data-theme="light"] .dashboard-content::after {
        opacity: 0.2;
    }

    @keyframes particle-move {
        0% {
            background-position: 0% 0%;
        }
        100% {
            background-position: 100% 100%;
        }
    }

    .dashboard-content > * {
        position: relative;
        z-index: 1;
    }

    /* Dashboard Cards - Theme Aware */
    .dashboard-card {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        box-shadow: var(--box-shadow) !important;
        animation: slideInUp 0.6s ease-out;
        position: relative;
        overflow: hidden;
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(220, 20, 60, 0.05) 0%, transparent 70%);
        animation: rotate-glow 10s linear infinite;
        pointer-events: none;
    }

    [data-theme="light"] .dashboard-card::before {
        background: radial-gradient(circle, rgba(220, 20, 60, 0.02) 0%, transparent 70%);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes rotate-glow {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .dashboard-card__title {
        color: hsl(var(--heading-color)) !important;
    }

    .dashboard-card__number {
        color: hsl(var(--base)) !important;
        font-weight: 700;
    }

    /* Chart Box - Theme Aware */
    .chart-box {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        box-shadow: var(--box-shadow) !important;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .chart-box__title {
        color: hsl(var(--heading-color)) !important;
        font-weight: 700;
    }

    .chart-title-text {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        color: hsl(var(--body-color)) !important;
        transition: all 0.3s ease !important;
    }

    .chart-title-text:hover {
        border-color: hsl(var(--base)) !important;
        box-shadow: 0 0 0 3px hsla(var(--base), 0.1) !important;
    }

    /* Video Analytics - Theme Aware */
    .video-analytics {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        box-shadow: var(--box-shadow) !important;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .video-analytics__title {
        color: hsl(var(--heading-color)) !important;
        font-weight: 700;
    }

    /* Alerts - Theme Aware */
    .alert {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        color: hsl(var(--body-color)) !important;
    }

    .alert__message {
        color: hsl(var(--body-color)) !important;
    }

    .link-color {
        color: hsl(var(--base)) !important;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .link-color:hover {
        opacity: 0.8;
    }

    /* Header Styling - Same as Home Page */
    .home-header {
        background: rgba(0, 0, 0, 0.9) !important;
        border-bottom: 1px solid hsl(var(--border-color)) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        position: relative !important;
        z-index: 100 !important;
    }

    .home-header__inner {
        padding: 12px 20px;
        position: relative !important;
        z-index: 100 !important;
    }

    /* Search Form Wrapper - Ensure it's visible */
    .home-fluid .home-header__left .search-form-wrapper {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        justify-content: flex-start !important;
        position: relative !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Search Form - Make it visible and properly sized */
    .home-fluid .home-header__left .search-form {
        width: 500px !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
    }

    @media screen and (max-width: 1499px) {
        .home-fluid .home-header__left .search-form {
            width: 440px !important;
        }
    }

    @media screen and (max-width: 991px) {
        .home-fluid .home-header__left .search-form {
            width: 260px !important;
        }
    }

    /* Override mobile styles to keep search form visible on desktop */
    @media screen and (min-width: 768px) {
        .home-fluid .home-header__left .search-form {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            background-color: transparent !important;
            height: auto !important;
            right: auto !important;
            top: auto !important;
            left: auto !important;
            transform: none !important;
        }
    }

    /* Ensure form group is properly styled */
    .home-fluid .home-header__left .search-form .form-group {
        position: relative !important;
        margin-bottom: 0 !important;
        width: 100% !important;
        display: block !important;
    }

    /* Search Form Input - Same as Home Page */
    .home-fluid .home-header__left .search-form .form-group .form--control {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        color: #ffffff !important;
        border-radius: 24px !important;
        padding: 10px 80px 10px 45px !important;
        width: 100% !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Search Clear Button - Same as Home Page */
    .home-fluid .home-header__left .search-form .form-group .search-clear-btn {
        position: absolute !important;
        right: 50px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        background: transparent !important;
        border: none !important;
        color: rgba(255, 255, 255, 0.7) !important;
        cursor: pointer !important;
        padding: 5px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 10 !important;
        transition: color 0.2s ease !important;
    }

    .home-fluid .home-header__left .search-form .form-group .search-clear-btn:hover {
        color: #ffffff !important;
    }

    .home-fluid .home-header__left .search-form .form-group .form--control:focus {
        border-color: hsl(var(--base)) !important;
        box-shadow: 0 0 0 3px hsla(var(--base), 0.1) !important;
        outline: none !important;
    }

    .home-fluid .home-header__left .search-form .form-group .search-form-btn {
        color: rgba(255, 255, 255, 0.8) !important;
        transition: color 0.3s ease !important;
        position: absolute !important;
        left: 15px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        z-index: 10 !important;
    }

    .home-fluid .home-header__left .search-form .form-group .search-form-btn:hover {
        color: rgba(255, 255, 255, 1) !important;
    }

    /* User Info - Same as Home Page with proper z-index */
    .home-fluid .home-header__right {
        position: relative !important;
        z-index: 1000 !important;
    }

    .home-fluid .home-header__right .user-info {
        position: relative !important;
        z-index: 1001 !important;
    }

    .home-fluid .home-header__right .user-info__button {
        border: none !important;
        transition: all 0.3s ease !important;
        background: transparent !important;
        cursor: pointer !important;
        position: relative !important;
        z-index: 1002 !important;
    }

    .home-fluid .home-header__right .user-info__button:hover {
        box-shadow: 0 0 10px rgba(220, 20, 60, 0.4) !important;
        transform: scale(1.05) !important;
    }

    .home-fluid .home-header__right .user-info__thumb {
        border: none !important;
        position: relative !important;
        z-index: 1002 !important;
    }

    .home-fluid .home-header__right .user-info__thumb img {
        border: none !important;
    }

    .home-fluid .home-header__right .user-info .user-info-list {
        position: absolute !important;
        right: 0 !important;
        top: calc(100% + 12px) !important;
        z-index: 9999 !important;
        background-color: hsl(var(--bg-color)) !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        box-shadow: var(--box-shadow) !important;
    }

    /* Light Theme Styles - Same as Home Page */
    [data-theme="light"] .home-header {
        background: rgba(255, 255, 255, 0.95) !important;
        border-bottom: 1px solid hsl(var(--border-color)) !important;
    }

    [data-theme="light"] .home-fluid .home-header__left .search-form .form-group .form--control {
        background: #ffffff !important;
        border: 1px solid #e0e0e0 !important;
        color: #000000 !important;
        padding: 10px 80px 10px 45px !important;
    }

    [data-theme="light"] .home-fluid .home-header__left .search-form .form-group .search-clear-btn {
        color: rgba(0, 0, 0, 0.5) !important;
    }

    [data-theme="light"] .home-fluid .home-header__left .search-form .form-group .search-clear-btn:hover {
        color: #000000 !important;
    }

    [data-theme="light"] .home-fluid .home-header__left .search-form .form-group .form--control::placeholder {
        color: #808080 !important;
    }

    [data-theme="light"] .home-fluid .home-header__left .search-form .form-group .form--control:focus {
        border-color: #e0e0e0 !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 1px #e0e0e0 !important;
    }

    [data-theme="light"] .home-fluid .home-header__left .search-form .form-group .search-form-btn {
        color: rgba(0, 0, 0, 0.7) !important;
    }

    [data-theme="light"] .home-fluid .home-header__left .search-form .form-group .search-form-btn:hover {
        color: rgba(0, 0, 0, 0.9) !important;
    }

    [data-theme="light"] .home-fluid .home-header__right .user-info__button {
        border: none !important;
    }
</style>
@endpush
