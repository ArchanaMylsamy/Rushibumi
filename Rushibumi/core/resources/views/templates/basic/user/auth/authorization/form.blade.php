@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $user = auth()->user();

        $auth = getContent('auth_page.content', true);

    @endphp

    <div class="setting-content">
        <h3 class="setting-content__title mb-0">{{ __($pageTitle) }}</h3>
        <div class="varification">
            <p class="varification__desc">
                {{ __(@$auth->data_values->verification_page_title) }}
            </p>
            <div class="varification__form">
                <div class="form-group">
                    <label class="form--label d-block" for="">@lang('Email Verification')</label>
                    <div class="input-group">
                        <input class="form-control form--control" type="text" value="{{ $user->email }}" readonly placeholder="Enter your email">
                        <button class="btn input-group-text @if ($user->ev) btn--success @else btn--base @endif sendVerifyCode emailBtn" data-type="email" type="button" @if ($user->ev) disabled @endif>
                            @if ($user->ev)
                                @lang('Verified')
                            @else
                                @lang('Send Code')
                            @endif
                        </button>
                    </div>
                    <span class="note-text">
                        <span> <i class="fas fa-info-circle"></i> </span>
                        @lang('Ensures account authenticity and enhances security')
                    </span>
                </div>

                <div class="verification-code-wrapper email-varification d-none">
                    <div class="verification-area">
                        <div class="verification-code">
                            <input class="emailCode overflow-hidden" id="code" name="code" type="text">
                            <div class="boxes">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <span class="note-text">
                        <span> <i class="fas fa-info-circle"></i> </span>
                        @lang('Enter Code') (@Lang('Code sent to ') {{ $user->email }})
                    </span>
                    <button class="btn btn--base btn--sm emailVerify mt-3" type="submit">@lang('Confirm')</button>

                </div>
                <div class="form-group">
                    <label class="form--label d-block" for="">@lang('Phone Verification')</label>

                    <div class="input-group">
                        <input class="form--control form-control phone sms" type="text" value="{{ $user->mobile ?? $user->phone_number }}" placeholder="Enter your number" readonly>
                        <div class="country_code" readonly>
                            <div class="country_code__caption">
                                <span class="text">+{{ $user->dial_code ?? '1' }}</span>
                            </div>

                        </div>
                        <button class="btn input-group-text @if ($user->sv) btn--success @else btn--base @endif  smsBtn sendVerifyCode" data-type="sms" type="submit" @if ($user->sv) disabled @endif>
                            @if ($user->sv)
                                @lang('Verified')
                            @else
                                @lang('Send Code')
                            @endif
                        </button>
                    </div>

                    <span class="note-text">
                        <span> <i class="fas fa-info-circle"></i> </span>
                        @lang('Verifies user identity and adds an extra layer of account security')
                    </span>
                </div>

                <div class="verification-code-wrapper sms-varification d-none">
                    <div class="verification-area">
                        <div class="verification-code">
                            <input class="form--control smsCode overflow-hidden" id="code" name="code" type="text">
                            <div class="boxes">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>

                    <span class="note-text">
                        <span> <i class="fas fa-info-circle"></i> </span>
                        @lang('Enter Code') (@Lang('Code sent to')<span>{{ $user->mobileNumber }}</span>)
                    </span>

                    <button class="btn btn--base btn--sm smsVerify mt-3" type="submit">@lang('Confirm')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.sendVerifyCode').on('click', function() {
                const type = $(this).data('type');

                if ((type == 'sms' && @json($user->sv) == 1) || (type == 'email' &&
                        @json($user->ev) == 1)) {
                    notify('info', '@lang('You are already verified ')');
                    return;
                }

                const url = `{{ route('user.send.verify.code', ':type') }}`.replace(':type', type);
                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 'success') {
                            notify('success', response.notify);

                            $('.' + type + '-varification').removeClass('d-none');
                        } else {

                            notify('error', response.notify);
                        }
                    }
                });

            });



            $('.emailVerify').on('click', function() {
                const code = $('.emailCode').val();
                if (!code) {
                    notify('error', 'Verification code is required')
                    return;
                }
                const $this = $(this);
                $this.html(`<i class="las la-spinner"></i>@lang('Verifying')`);

                $.ajax({
                    type: "POST",
                    url: "{{ route('user.verify.email') }}",
                    data: {
                        code: code,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            $('.email-varification').addClass('d-none');
                            $('.emailBtn').text('Verified');
                            $('.emailBtn').removeClass('btn--base').addClass('btn--success').prop('disabled', true);
                            notify('success', response.notify);
                        } else {
                            $this.html(`@lang('Try Again')`);
                            $('[name="code"]').val('');
                            notify('error', response.notify);

                        }
                    }
                });
            });


            $('.smsVerify').on('click', function() {
                const code = $('.smsCode').val();
                if (!code) {
                    notify('error', 'Verification code is required')
                    return;
                }
                const $this = $(this);
                $this.html(`<i class="las la-spinner"></i>@lang('Verifying')`);

                $.ajax({
                    type: "POST",
                    url: "{{ route('user.verify.mobile') }}",
                    data: {
                        code: code,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            $('.sms-varification').addClass('d-none');
                            $('.smsBtn').text('Verified');
                            $('.smsBtn').removeClass('btn--base').addClass('btn--success').prop('disabled', true);
                            notify('success', response.notify);
                        } else {
                            $this.html(`@lang('Try Again')`);
                            $('[name="code"]').val('');
                            notify('error', response.notify);

                        }
                    }
                });
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        /* Red & Black Theme Styling - Colors Only */
        .setting-content__title {
            background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .varification {
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

        .varification::before {
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

        .varification > * {
            position: relative;
            z-index: 1;
        }

        .varification__desc {
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

        .input-group-text {
            background-color: rgba(0, 0, 0, 0.6) !important;
            border-color: rgba(220, 20, 60, 0.3) !important;
            color: #ffffff !important;
        }

        .btn--base {
            background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%) !important;
            border-color: transparent !important;
            color: #ffffff !important;
        }

        .btn--base:hover {
            background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
        }

        .note-text {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .country_code__caption {
            background-color: rgba(0, 0, 0, 0.6) !important;
            border-color: rgba(220, 20, 60, 0.3) !important;
            color: #ffffff !important;
        }

        .varification-wrapper.email-varification {
            margin-bottom: 1rem;
        }

        /* verification */

        .verification-code-wrapper {
            width: 300px;
            background-color: rgba(0, 0, 0, 0.6) !important;
            margin-bottom: 1rem;
            border: 2px solid rgba(220, 20, 60, 0.3) !important;
            border-radius: 8px;
            padding: 15px;
        }

        .verification-area {
            width: 100%;
        }

        .verification-code {
            display: flex;
            position: relative;
            z-index: 1;
            height: 40px;
            width: 100%;
        }

        .country_code[readonly] {
            opacity: .4;
        }

        .verification-code::after {
            position: absolute;
            content: '';
            right: -30px;
            width: 28px;
            height: 40px;
            background-color: rgba(0, 0, 0, 0.6) !important;
            z-index: 2;
        }

        .verification-code input {
            position: absolute;
            height: 40px;
            width: calc(100% + 60px);
            left: 0;
            background: transparent;
            border: none;
            font-size: 20px !important;
            font-weight: 800;
            letter-spacing: 38px;
            text-indent: 1px;
            border: none;
            z-index: 1;
            padding-left: 20px;
            color: #ffffff !important;
        }

        .verification-code input:focus {
            outline: none;
            cursor: pointer;
            box-shadow: none;
            background-color: transparent;
        }

        .boxes {
            position: absolute;
            top: 0;
            height: 100%;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            z-index: -1;
        }

        .verification-code span {
            height: 40px;
            width: calc((100% / 6) - 3px);
            text-align: center;
            line-height: 40px;
            background: rgba(220, 20, 60, 0.1) !important;
            border-color: rgba(220, 20, 60, 0.3) !important;
            color: #ffffff !important;
            border-radius: 4px;
        }

        @media (max-width: 575px) {
            .verification-code-wrapper {
                width: 280px;
            }

            .verification-code input {
                width: calc(100% + 30px);
                padding-left: 15px;
                letter-spacing: 35px;
            }

            .verification-text {
                font-size: 0.9rem;
            }

            .verification-code::after {
                right: -25px;
                width: 25px;
            }
        }

        @media (max-width: 450px) {
            .verification-code-wrapper {
                width: 260px;
            }

            .verification-code input {
                width: calc(100% + 35px);
                padding-left: 12px;
                letter-spacing: 32px;
            }
        }

        @media (max-width: 400px) {
            .verification-code {
                height: 35px;
            }

            .verification-code-wrapper {
                width: 240px;
            }

            .verification-code input {
                width: calc(100% + 30px);
                padding-left: 10px;
                letter-spacing: 30px;
                height: 35px;
                font-size: 18px !important;
            }

            .verification-code span {
                height: 35px;
                line-height: 35px;
            }

            .verification-code::after {
                height: 35px;
            }
        }
    </style>
@endpush
