@extends($activeTemplate . 'layouts.app')

@section('app')
    @php
        $auth = getContent('auth_page.content', true);
    @endphp

    <div class="account-section">
        @include('Template::partials.auth_header')

        <div class="account-section__body">
            <div class="container">
                <div class="account-form">
                    <div class="account-form__heading">
                        <h3 class="account-form__title">{{ __($pageTitle) }}</h3>
                        <p class="account-form__text">{{ __(@$auth->data_values->login_page_title) }}</p>
                    </div>
                    <div class="account-form__body">
                        @include($activeTemplate . 'partials.social_login')
                        <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                            @csrf
                            <div class="form-group">
                                <label class="form--label">@lang('Username or Email')</label>
                                <input type="text" name="username" value="{{ old('username') }}"
                                       class="form-control form--control" required>
                            </div>

                            <div class="form-group">
                                <label class="form--label ">@lang('Password')</label>
                                <input type="password" class="form-control form--control" name="password" required>
                            </div>

                            @php
                                $hasLevel = true;
                            @endphp

                            <x-captcha :hasLevel='$hasLevel' />

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="form-group form--check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        @lang('Remember Me')
                                    </label>
                                </div>

                                <div class="form-group">
                                    <a class="forgot-pass" href="{{ route('user.password.request') }}">
                                        @lang('Forgot your password?')
                                    </a>
                                </div>
                            </div>

                            <button type="submit" id="recaptcha" class="btn btn--base w-100">
                                @lang('Login')
                            </button>

                            @if (gs('registration'))
                                <p class="text-center other-login mt-3">@lang('Don\'t have any account?')
                                    <a class="text--base mb-0 " href="{{ route('user.register') }}">@lang('Register')</a>
                                </p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="account-section__footer">
            <div class="container">
                <p>© {{ now()->year }} {{ __(gs('site_name')) }}. @lang('All rights reserved.')</p>
            </div>
        </div>
    </div>

    @push('style')
    <style>
        /* Red & Black Theme Styling */
        .account-section {
            background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #000000 100%);
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        /* Animated Background Effects */
        .account-section::before {
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
        .account-section::after {
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

        .account-section__body,
        .account-section__header,
        .account-section__footer {
            position: relative;
            z-index: 1;
        }

        /* Enhanced Form Card */
        .account-form {
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

        .account-form::before {
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

        /* Form Heading */
        .account-form__heading {
            position: relative;
            z-index: 2;
        }

        .account-form__title {
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

        .account-form__text {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Enhanced Input Fields */
        .form--control {
            background: rgba(0, 0, 0, 0.6) !important;
            border: 2px solid rgba(220, 20, 60, 0.3) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            padding: 12px 16px !important;
            transition: all 0.3s ease !important;
        }

        .form--control:focus {
            background: rgba(0, 0, 0, 0.8) !important;
            border-color: #dc143c !important;
            box-shadow: 
                0 0 0 3px rgba(220, 20, 60, 0.2),
                0 0 20px rgba(220, 20, 60, 0.3) !important;
            outline: none !important;
        }

        .form--control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form--label {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin-bottom: 8px;
        }

        /* Enhanced Button */
        .btn--base {
            background: linear-gradient(135deg, #dc143c 0%, #8b0000 100%) !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 14px 24px !important;
            border-radius: 8px !important;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.4) !important;
        }

        .btn--base::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn--base:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn--base:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(220, 20, 60, 0.6) !important;
            background: linear-gradient(135deg, #ff1744 0%, #dc143c 100%) !important;
        }

        .btn--base:active {
            transform: translateY(0);
        }

        /* Checkbox Enhancement */
        .form-check-input {
            border: 2px solid rgba(220, 20, 60, 0.5) !important;
            background: rgba(0, 0, 0, 0.6) !important;
        }

        .form-check-input:checked {
            background-color: #dc143c !important;
            border-color: #dc143c !important;
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        /* Links */
        .forgot-pass {
            color: rgba(220, 20, 60, 0.9) !important;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-pass::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #dc143c;
            transition: width 0.3s ease;
        }

        .forgot-pass:hover {
            color: #ff1744 !important;
        }

        .forgot-pass:hover::after {
            width: 100%;
        }

        .text--base {
            color: #dc143c !important;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .text--base::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #dc143c;
            transition: width 0.3s ease;
        }

        .text--base:hover {
            color: #ff1744 !important;
        }

        .text--base:hover::after {
            width: 100%;
        }

        /* Social Login Buttons */
        .social-login-btn {
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 10px !important;
        }

        .social-login-btn:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.4);
            filter: drop-shadow(0 0 8px rgba(220, 20, 60, 0.6));
        }

        /* Header/Navbar Styling */
        .account-section__header {
            background: rgba(0, 0, 0, 0.9) !important;
            border-bottom: 2px solid rgba(220, 20, 60, 0.3) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(220, 20, 60, 0.1) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            position: relative;
            z-index: 10;
        }

        .account-section__header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(220, 20, 60, 0.1), transparent);
            animation: header-shimmer 3s ease-in-out infinite;
        }

        @keyframes header-shimmer {
            0%, 100% {
                transform: translateX(-100%);
            }
            50% {
                transform: translateX(100%);
            }
        }

        .account-section__logo {
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
            display: inline-block;
            padding: 8px;
            border-radius: 8px;
        }

        .account-section__logo:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 0 10px rgba(220, 20, 60, 0.6));
        }

        .account-section__logo img {
            transition: all 0.3s ease;
            filter: brightness(1.1);
        }

        .account-section__logo:hover img {
            filter: brightness(1.2) drop-shadow(0 0 8px rgba(220, 20, 60, 0.5));
        }

        /* Footer */
        .account-section__footer p {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .account-section__footer {
            border-top: 1px solid rgba(220, 20, 60, 0.2);
            background: rgba(0, 0, 0, 0.5);
        }

        /* Responsive */
        @media (max-width: 575px) {
            .account-form {
                padding: 24px !important;
            }
        }

        /* Light Theme Override */
        [data-theme="light"] .account-section {
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 50%, #ffffff 100%);
        }

        [data-theme="light"] .account-section::before {
            background: 
                radial-gradient(circle at 20% 50%, rgba(220, 20, 60, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 0, 0, 0.1) 0%, transparent 50%);
        }

        [data-theme="light"] .account-form {
            background: rgba(255, 255, 255, 0.95) !important;
            border: 2px solid rgba(220, 20, 60, 0.2) !important;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(220, 20, 60, 0.1) !important;
        }

        [data-theme="light"] .form--control {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 2px solid rgba(220, 20, 60, 0.2) !important;
            color: #000000 !important;
        }

        [data-theme="light"] .form--control:focus {
            background: rgba(255, 255, 255, 1) !important;
        }

        [data-theme="light"] .form--label {
            color: rgba(0, 0, 0, 0.8) !important;
        }

        [data-theme="light"] .form-check-label {
            color: rgba(0, 0, 0, 0.8) !important;
        }

        [data-theme="light"] .account-form__text {
            color: rgba(0, 0, 0, 0.6);
        }
    </style>
    @endpush
@endsection
