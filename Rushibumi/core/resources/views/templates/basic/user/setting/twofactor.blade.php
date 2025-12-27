@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="setting-content">
        <div class="two-fa-wrapper">
            <a href="{{ route('user.setting.security') }}" class="two-fa-wrapper__back"><i class="vti-left-long"></i></a>
            <h5 class="title">{{ __($pageTitle) }}</h5>
            <div class="two-fa">
                <div class="row">
                    @if (!$user->ts)
                        <div class="col-md-6">
                            <h5 class="two-fa__title">1. @lang('Scan QR Code')</h5>
                            <p class="two-fa__desc">
                                @lang('Scan the QR code using a passcode generator app') (e.g., @lang('Google Authenticator or Authy')).
                            </p>
                            <div class="two-fa__qr">
                                <div class="qr">
                                    <img src="{{ $qrCodeUrl }}" alt="image">
                                </div>
                                <p class="note">@lang('If you cannot scan, please enter the following code manually')
                                </p>
                                <div class="copy-form">
                                    <div class="form-group">
                                        <input type="text"value="{{ $secret }}" class="form--control secretCode"
                                            readonly>
                                        <button class="copyCode-btn  copytext copied" id="copyBoard"><i
                                                class="vti-copy"></i></button>
                                    </div>
                                </div>
                                <label><i class="fas fa-info-circle"></i> @lang('Help')</label>
                                <p class="note">@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.') <a class="text--base"
                                        href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                                        target="_blank">@lang('Download')</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="two-fa__title">2. @lang('Confirm OTP Code')</h5>
                            <p class="two-fa__desc">
                                @lang('Confirm your passcode generator app by entering the code below').
                            </p>
                            <form action="{{ route('user.setting.twofactor.enable') }}" method="post"
                                class="row two-fa__form">
                                @csrf
                                <input type="hidden" name="key" value="{{ $secret }}">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form--label">@lang('One Time Passcode') (@lang('From Authentication App'))</label>
                                        <input type="text" name="code" class="form--control" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-0 text-end">
                                        <button type="submit"
                                            class="btn btn--base btn--lg w-100">@lang('Confirm and Enable Two-Factor')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if ($user->ts)
                        <div class="col-md-12">
                            <h5 class="two-fa__title">2. @lang('Confirm OTP Code')</h5>
                            <p class="two-fa__desc">
                                @lang('Confirm your passcode generator app by entering the code below').
                            </p>
                            <form action="{{ route('user.setting.twofactor.disable') }}" method="post"
                                class="row two-fa__form">
                                @csrf
                                <input type="hidden" name="key" value="{{ $secret }}">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form--label">@lang('One Time Passcode') (@lang('From Authentication App'))</label>
                                        <input type="text" name="code" class="form--control" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-0 text-end">
                                        <button type="submit"
                                            class="btn btn--base btn--lg w-100">@lang('Confirm and Disable Two-Factor')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').on('click', function() {
                var copyText = document.getElementsByClassName("secretCode");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();

                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush

@push('style')
<style>
    /* Red & Black Theme Styling - Colors Only */
    .two-fa-wrapper {
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

    .two-fa-wrapper::before {
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

    .two-fa-wrapper > * {
        position: relative;
        z-index: 1;
    }

    .two-fa-wrapper__back {
        color: #dc143c !important;
    }

    .two-fa-wrapper__back:hover {
        color: #ff1744 !important;
    }

    .two-fa-wrapper .title {
        background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .two-fa {
        background-color: rgba(0, 0, 0, 0.6) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        border-radius: 8px;
        padding: 20px;
    }

    .two-fa__title {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .two-fa__desc {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .two-fa__qr {
        background-color: rgba(0, 0, 0, 0.6) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        border-radius: 8px;
        padding: 20px;
    }

    .note {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .form--label {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .form--control {
        background: rgba(0, 0, 0, 0.6) !important;
        border-color: rgba(220, 20, 60, 0.3) !important;
        color: #ffffff !important;
    }

    .form--control:focus {
        background: rgba(0, 0, 0, 0.8) !important;
        border-color: #dc143c !important;
        box-shadow: 
            0 0 0 3px rgba(220, 20, 60, 0.2),
            0 0 20px rgba(220, 20, 60, 0.3) !important;
    }

    .copyCode-btn {
        background-color: rgba(0, 0, 0, 0.6) !important;
        border-color: rgba(220, 20, 60, 0.3) !important;
        color: #dc143c !important;
    }

    .copyCode-btn:hover {
        background-color: rgba(220, 20, 60, 0.2) !important;
        color: #ff1744 !important;
    }

    .text--base {
        color: #dc143c !important;
    }

    .text--base:hover {
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
</style>
@endpush
