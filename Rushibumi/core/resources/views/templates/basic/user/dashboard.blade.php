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
    /* Red & Black Theme Styling */
    .dashboard-content {
        background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #000000 100%);
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        padding: 20px;
    }

    /* Animated Background Effects */
    .dashboard-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(220, 20, 60, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(139, 0, 0, 0.2) 0%, transparent 50%),
            radial-gradient(circle at 40% 20%, rgba(178, 34, 34, 0.1) 0%, transparent 50%);
        animation: pulse-glow 8s ease-in-out infinite;
        z-index: 0;
    }

    @keyframes pulse-glow {
        0%, 100% {
            opacity: 0.5;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }

    /* Floating Particles */
    .dashboard-content::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-image: 
            radial-gradient(2px 2px at 20% 30%, rgba(220, 20, 60, 0.3), transparent),
            radial-gradient(2px 2px at 60% 70%, rgba(139, 0, 0, 0.3), transparent),
            radial-gradient(1px 1px at 50% 50%, rgba(255, 0, 0, 0.2), transparent),
            radial-gradient(1px 1px at 80% 10%, rgba(220, 20, 60, 0.2), transparent),
            radial-gradient(2px 2px at 40% 80%, rgba(139, 0, 0, 0.3), transparent);
        background-size: 200% 200%;
        animation: particle-move 20s linear infinite;
        z-index: 0;
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

    /* Dashboard Cards */
    .dashboard-card {
        background: rgba(0, 0, 0, 0.85) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(220, 20, 60, 0.1),
            inset 0 0 60px rgba(220, 20, 60, 0.05) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
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
        background: radial-gradient(circle, rgba(220, 20, 60, 0.1) 0%, transparent 70%);
        animation: rotate-glow 10s linear infinite;
        pointer-events: none;
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
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .dashboard-card__number {
        background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        text-shadow: 0 0 30px rgba(220, 20, 60, 0.5);
        animation: text-shimmer 3s ease-in-out infinite;
    }

    @keyframes text-shimmer {
        0%, 100% {
            filter: brightness(1);
        }
        50% {
            filter: brightness(1.3);
        }
    }

    /* Chart Box */
    .chart-box {
        background: rgba(0, 0, 0, 0.85) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(220, 20, 60, 0.1),
            inset 0 0 60px rgba(220, 20, 60, 0.05) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .chart-box__title {
        background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .chart-title-text {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        color: #ffffff !important;
        transition: all 0.3s ease !important;
    }

    .chart-title-text:hover {
        border-color: #dc143c !important;
        box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.2) !important;
    }

    /* Video Analytics */
    .video-analytics {
        background: rgba(0, 0, 0, 0.85) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(220, 20, 60, 0.1),
            inset 0 0 60px rgba(220, 20, 60, 0.05) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .video-analytics__title {
        background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    /* Alerts */
    .alert {
        background: rgba(0, 0, 0, 0.85) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .alert__message {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .link-color {
        color: rgba(220, 20, 60, 0.9) !important;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .link-color:hover {
        color: #ff1744 !important;
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
        box-shadow: 0 6px 25px rgba(220, 20, 60, 0.6) !important;
        background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
    }
</style>
@endpush
