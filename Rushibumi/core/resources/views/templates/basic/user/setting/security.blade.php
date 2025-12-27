@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $user = auth()->user();
        $auth = getContent('auth_page.content', true);

    @endphp
    <div class="setting-content">
        <div class="security-setting">
            @if (!$user->ts)
                <div class="alert alert--warning">
                    <span class="alert__icon"><i class="las la-info-circle"></i></span>
                    <p class="alert__message">
                    {{__($auth->data_values->security_page_alert_message)}}
                        <a class="text--warning text-decoration-underline fw-medium d-block" href="{{ route('user.setting.twofactor') }}">{{__($auth->data_values->security_page_link_text)}}</a>
                    </p>
                </div>
            @endif
            <h3 class="security-setting__title">{{ __($pageTitle) }}</h3>
            <div class="security-setting__item">
                <div class="left">
                    <h5 class="title"><a href="{{ route('user.setting.change.password') }}">#@lang('Change password')</a></h5>
                    <span class="desc">@lang('Update your account password to strengthen security and protect your account').</span>
                </div>

                <a href="{{ route('user.setting.change.password') }}" class="btn-link">
                    @lang('Change Now')
                </a>
            </div>
            <div class="security-setting__item">
                <div class="left">
                    <h5 class="title">@lang('Two step verification')</h5>
                    @if (!$user->ts)
                        <span class="desc">@lang('Enabled two-step verification to secure your account').</span>
                    @else
                        <span class="desc"> @lang('Two-step verification is enabled. Your account is more secure now').</span>
                    @endif
                </div>
                <a class="btn @if (!$user->ts) btn--base @else btn--success @endif" href="{{ route('user.setting.twofactor') }}">
                    @if (!$user->ts)
                        @lang('Turn on')
                    @else
                        @lang('Turn off')
                    @endif
                </a>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    /* Red & Black Theme Styling - Colors Only */
    .security-setting {
        background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #000000 100%) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(220, 20, 60, 0.1),
            inset 0 0 60px rgba(220, 20, 60, 0.05) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 8px;
        padding: 30px;
        position: relative;
        overflow: hidden;
    }

    .security-setting::before {
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
        pointer-events: none;
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

    .security-setting > * {
        position: relative;
        z-index: 1;
    }

    .security-setting__title {
        background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .security-setting__item {
        background-color: rgba(0, 0, 0, 0.6) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
    }

    .security-setting__item .title {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .security-setting__item .title a {
        color: rgba(255, 255, 255, 0.9) !important;
        text-decoration: none;
    }

    .security-setting__item .title a:hover {
        color: #dc143c !important;
    }

    .security-setting__item .desc {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .btn-link {
        color: #dc143c !important;
        text-decoration: none;
    }

    .btn-link:hover {
        color: #ff1744 !important;
    }

    .btn--base {
        background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%) !important;
        border-color: transparent !important;
        color: #ffffff !important;
    }

    .btn--base:hover {
        background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
    }

    .alert {
        background-color: rgba(0, 0, 0, 0.85) !important;
        border-color: rgba(220, 20, 60, 0.3) !important;
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .alert__message {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .text--warning {
        color: #dc143c !important;
    }

    .text--warning:hover {
        color: #ff1744 !important;
    }
</style>
@endpush
