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
                                       class="form-control form--control" autocomplete="username" required>
                            </div>

                            <div class="form-group">
                                <label class="form--label ">@lang('Password')</label>
                                <input type="password" class="form-control form--control" name="password" autocomplete="current-password" required>
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

        /* Enhanced Input Fields - AGGRESSIVE: Remove ALL white backgrounds - MAXIMUM SPECIFICITY */
        .account-section .account-form .account-form__body .form-group .form--control,
        .account-section .account-form .account-form__body .form-group input[type="text"],
        .account-section .account-form .account-form__body .form-group input[type="password"],
        .account-section .account-form .account-form__body .form-group .form-control,
        .form--control,
        .account-form input[type="text"],
        .account-form input[type="password"],
        .account-form .form-control {
            background: rgba(0, 0, 0, 0.6) !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
            background-image: none !important;
            border: 2px solid rgba(220, 20, 60, 0.3) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            padding: 12px 16px !important;
            transition: all 0.3s ease !important;
            -webkit-appearance: none !important;
            appearance: none !important;
        }

        /* AGGRESSIVE: Remove white background on focus/click - ALL states - MAXIMUM SPECIFICITY */
        .account-section .account-form .account-form__body .form-group .form--control:focus,
        .account-section .account-form .account-form__body .form-group .form--control:active,
        .account-section .account-form .account-form__body .form-group .form--control:focus-visible,
        .account-section .account-form .account-form__body .form-group .form--control:focus-within,
        .account-section .account-form .account-form__body .form-group input[type="text"]:focus,
        .account-section .account-form .account-form__body .form-group input[type="text"]:active,
        .account-section .account-form .account-form__body .form-group input[type="text"]:focus-visible,
        .account-section .account-form .account-form__body .form-group input[type="password"]:focus,
        .account-section .account-form .account-form__body .form-group input[type="password"]:active,
        .account-section .account-form .account-form__body .form-group input[type="password"]:focus-visible,
        .account-section .account-form .account-form__body .form-group .form-control:focus,
        .account-section .account-form .account-form__body .form-group .form-control:active,
        .account-section .account-form .account-form__body .form-group .form-control:focus-visible,
        .account-section .account-form .account-form__body .form-group .form-control:focus-within,
        .form--control:focus,
        .form--control:active,
        .form--control:focus-visible,
        .form--control:focus-within,
        .account-form input[type="text"]:focus,
        .account-form input[type="text"]:active,
        .account-form input[type="text"]:focus-visible,
        .account-form input[type="password"]:focus,
        .account-form input[type="password"]:active,
        .account-form input[type="password"]:focus-visible,
        .account-form .form-control:focus,
        .account-form .form-control:active,
        .account-form .form-control:focus-visible,
        .account-form .form-control:focus-within {
            background: rgba(0, 0, 0, 0.8) !important;
            background-color: rgba(0, 0, 0, 0.8) !important;
            background-image: none !important;
            border-color: #dc143c !important;
            color: #ffffff !important;
            box-shadow: 
                0 0 0 3px rgba(220, 20, 60, 0.2),
                0 0 20px rgba(220, 20, 60, 0.3) !important;
            outline: none !important;
        }

        /* Remove white background on hover */
        .form--control:hover,
        .account-form input[type="text"]:hover,
        .account-form input[type="password"]:hover,
        .account-form .form-control:hover {
            background: rgba(0, 0, 0, 0.7) !important;
            background-color: rgba(0, 0, 0, 0.7) !important;
            background-image: none !important;
        }

        /* Style browser autofill to match dark theme - MAXIMUM SPECIFICITY */
        .account-section .account-form .account-form__body .form-group input:-webkit-autofill,
        .account-section .account-form .account-form__body .form-group input:-webkit-autofill:hover,
        .account-section .account-form .account-form__body .form-group input:-webkit-autofill:focus,
        .account-section .account-form .account-form__body .form-group input:-webkit-autofill:active,
        .account-section .account-form .account-form__body .form-group .form--control:-webkit-autofill,
        .account-section .account-form .account-form__body .form-group .form--control:-webkit-autofill:hover,
        .account-section .account-form .account-form__body .form-group .form--control:-webkit-autofill:focus,
        .account-section .account-form .account-form__body .form-group .form--control:-webkit-autofill:active,
        .account-form input:-webkit-autofill,
        .account-form input:-webkit-autofill:hover,
        .account-form input:-webkit-autofill:focus,
        .account-form input:-webkit-autofill:active,
        .form--control:-webkit-autofill,
        .form--control:-webkit-autofill:hover,
        .form--control:-webkit-autofill:focus,
        .form--control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.6) inset !important;
            box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.6) inset !important;
            -webkit-text-fill-color: #ffffff !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
            background: rgba(0, 0, 0, 0.6) !important;
            color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s !important;
        }

        /* Override browser default autocomplete styling - MAXIMUM SPECIFICITY */
        .account-section .account-form .account-form__body .form-group input[type="text"]:-webkit-autofill,
        .account-section .account-form .account-form__body .form-group input[type="password"]:-webkit-autofill,
        .account-section .account-form .account-form__body .form-group .form--control:-webkit-autofill,
        .account-form input[type="text"]:-webkit-autofill,
        .account-form input[type="password"]:-webkit-autofill,
        .form--control:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.6) inset !important;
            box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.6) inset !important;
            -webkit-text-fill-color: #ffffff !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
            background: rgba(0, 0, 0, 0.6) !important;
        }

        /* When autofilled input is focused/clicked */
        .account-section .account-form .account-form__body .form-group input:-webkit-autofill:focus,
        .account-section .account-form .account-form__body .form-group input:-webkit-autofill:active,
        .account-section .account-form .account-form__body .form-group .form--control:-webkit-autofill:focus,
        .account-section .account-form .account-form__body .form-group .form--control:-webkit-autofill:active,
        .account-form input:-webkit-autofill:focus,
        .account-form input:-webkit-autofill:active,
        .form--control:-webkit-autofill:focus,
        .form--control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.8) inset !important;
            box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.8) inset !important;
            background-color: rgba(0, 0, 0, 0.8) !important;
            background: rgba(0, 0, 0, 0.8) !important;
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

        /* Force dark background on ALL possible states - maximum specificity */
        .account-section .account-form .account-form__body .form-group .form--control,
        .account-section .account-form .account-form__body .form-group input[type="text"],
        .account-section .account-form .account-form__body .form-group input[type="password"] {
            background-color: rgba(0, 0, 0, 0.6) !important;
            background: rgba(0, 0, 0, 0.6) !important;
            background-image: none !important;
        }

        .account-section .account-form .account-form__body .form-group .form--control:focus,
        .account-section .account-form .account-form__body .form-group .form--control:active,
        .account-section .account-form .account-form__body .form-group input[type="text"]:focus,
        .account-section .account-form .account-form__body .form-group input[type="text"]:active,
        .account-section .account-form .account-form__body .form-group input[type="password"]:focus,
        .account-section .account-form .account-form__body .form-group input[type="password"]:active {
            background-color: rgba(0, 0, 0, 0.8) !important;
            background: rgba(0, 0, 0, 0.8) !important;
            background-image: none !important;
        }

        /* Ensure no white/transparent backgrounds */
        .account-form .form-group {
            background-color: transparent !important;
            background: transparent !important;
        }

        /* Remove any Bootstrap/Browser default white backgrounds */
        .account-form input[type="text"]:not(:-webkit-autofill),
        .account-form input[type="password"]:not(:-webkit-autofill),
        .account-form .form-control:not(:-webkit-autofill) {
            background-color: rgba(0, 0, 0, 0.6) !important;
            background: rgba(0, 0, 0, 0.6) !important;
        }

        /* Force dark on all enabled states */
        .account-form input[type="text"]:enabled,
        .account-form input[type="password"]:enabled {
            background-color: rgba(0, 0, 0, 0.6) !important;
        }

        /* Text selection styling */
        .account-form input[type="text"]::selection,
        .account-form input[type="password"]::selection {
            background-color: rgba(220, 20, 60, 0.5) !important;
            color: #fff !important;
        }

        /* Caret color */
        .account-form input[type="text"],
        .account-form input[type="password"] {
            caret-color: #dc143c !important;
        }
    </style>
    @endpush

    @push('script')
    <script>
        (function() {
            'use strict';
            
            function forceDarkBackground(input) {
                if (input) {
                    input.style.setProperty('background-color', 'rgba(0, 0, 0, 0.6)', 'important');
                    input.style.setProperty('background', 'rgba(0, 0, 0, 0.6)', 'important');
                    input.style.setProperty('color', '#ffffff', 'important');
                    input.style.setProperty('background-image', 'none', 'important');
                    // Also set via setAttribute to override any CSS
                    input.setAttribute('style', input.getAttribute('style') + '; background-color: rgba(0, 0, 0, 0.6) !important; background: rgba(0, 0, 0, 0.6) !important;');
                }
            }
            
            function forceDarkBackgroundOnFocus(input) {
                if (input) {
                    input.style.setProperty('background-color', 'rgba(0, 0, 0, 0.8)', 'important');
                    input.style.setProperty('background', 'rgba(0, 0, 0, 0.8)', 'important');
                    input.style.setProperty('color', '#ffffff', 'important');
                    input.style.setProperty('background-image', 'none', 'important');
                    // Also set via setAttribute to override any CSS
                    input.setAttribute('style', input.getAttribute('style') + '; background-color: rgba(0, 0, 0, 0.8) !important; background: rgba(0, 0, 0, 0.8) !important;');
                }
            }
            
            // Check if input is autofilled
            function isAutofilled(input) {
                return input.matches(':-webkit-autofill') || 
                       window.getComputedStyle(input).backgroundColor !== 'rgba(0, 0, 0, 0)' &&
                       (input.value && input.value.length > 0);
            }
            
            // Force dark background immediately on page load
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('.account-form input[type="text"], .account-form input[type="password"], .account-form .form--control, .account-form .form-control');
                
                inputs.forEach(function(input) {
                    forceDarkBackground(input);
                    
                    // Special handling for autofilled inputs
                    function handleAutofill() {
                        if (isAutofilled(input)) {
                            // Force dark background immediately for autofilled inputs
                            input.style.setProperty('-webkit-box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.6) inset', 'important');
                            input.style.setProperty('box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.6) inset', 'important');
                            input.style.setProperty('-webkit-text-fill-color', '#ffffff', 'important');
                            forceDarkBackground(input);
                        }
                    }
                    
                    // Check for autofill immediately
                    setTimeout(handleAutofill, 100);
                    setTimeout(handleAutofill, 300);
                    setTimeout(handleAutofill, 500);
                    
                    // Force dark background on focus
                    input.addEventListener('focus', function(e) {
                        e.preventDefault();
                        forceDarkBackgroundOnFocus(this);
                        // Special handling for autofilled
                        if (isAutofilled(this)) {
                            this.style.setProperty('-webkit-box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.8) inset', 'important');
                            this.style.setProperty('box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.8) inset', 'important');
                        }
                    }, true);
                    
                    // Force dark background on click
                    input.addEventListener('click', function(e) {
                        forceDarkBackgroundOnFocus(this);
                        // Special handling for autofilled
                        if (isAutofilled(this)) {
                            this.style.setProperty('-webkit-box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.8) inset', 'important');
                            this.style.setProperty('box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.8) inset', 'important');
                        }
                    }, true);
                    
                    input.addEventListener('mousedown', function(e) {
                        forceDarkBackgroundOnFocus(this);
                        // Special handling for autofilled
                        if (isAutofilled(this)) {
                            this.style.setProperty('-webkit-box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.8) inset', 'important');
                            this.style.setProperty('box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.8) inset', 'important');
                        }
                    }, true);
                    
                    // Force dark background on blur
                    input.addEventListener('blur', function() {
                        forceDarkBackground(this);
                        // Special handling for autofilled
                        if (isAutofilled(this)) {
                            this.style.setProperty('-webkit-box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.6) inset', 'important');
                            this.style.setProperty('box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.6) inset', 'important');
                        }
                    }, true);
                    
                    // Watch for autofill animation/transition events
                    input.addEventListener('animationstart', handleAutofill, true);
                    input.addEventListener('transitionstart', handleAutofill, true);
                    
                    // Monitor for any style changes and force dark background
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.type === 'attributes') {
                                const computedStyle = window.getComputedStyle(input);
                                const computedBg = computedStyle.backgroundColor;
                                
                                // Check for white, transparent, or rgba(0,0,0,0) backgrounds
                                if (computedBg && (
                                    computedBg.includes('white') || 
                                    computedBg.includes('#fff') || 
                                    computedBg.includes('rgb(255, 255, 255)') || 
                                    computedBg === 'transparent' || 
                                    computedBg === 'rgba(0, 0, 0, 0)' ||
                                    computedBg.includes('rgba(0, 0, 0, 0)')
                                )) {
                                    if (document.activeElement === input) {
                                        forceDarkBackgroundOnFocus(input);
                                    } else {
                                        forceDarkBackground(input);
                                    }
                                }
                            }
                        });
                    });
                    
                    observer.observe(input, {
                        attributes: true,
                        attributeFilter: ['style', 'class']
                    });
                    
                    // Also check periodically for white/transparent backgrounds - more frequent
                    setInterval(function() {
                        const computedStyle = window.getComputedStyle(input);
                        const bgColor = computedStyle.backgroundColor;
                        const isFocused = document.activeElement === input;
                        
                        // Check for autofill
                        if (isAutofilled(input)) {
                            if (isFocused) {
                                input.style.setProperty('-webkit-box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.8) inset', 'important');
                                input.style.setProperty('box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.8) inset', 'important');
                                forceDarkBackgroundOnFocus(input);
                            } else {
                                input.style.setProperty('-webkit-box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.6) inset', 'important');
                                input.style.setProperty('box-shadow', '0 0 0 1000px rgba(0, 0, 0, 0.6) inset', 'important');
                                forceDarkBackground(input);
                            }
                        }
                        
                        if (bgColor && (
                            bgColor.includes('white') || 
                            bgColor.includes('rgb(255, 255, 255)') || 
                            bgColor === 'transparent' || 
                            bgColor === 'rgba(0, 0, 0, 0)' ||
                            bgColor.includes('rgba(0, 0, 0, 0)')
                        )) {
                            if (isFocused) {
                                forceDarkBackgroundOnFocus(input);
                            } else {
                                forceDarkBackground(input);
                            }
                        }
                    }, 30); // Check every 30ms for faster response, especially for autofill
                });
            });
            
            // Also force on window load
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const inputs = document.querySelectorAll('.account-form input[type="text"], .account-form input[type="password"], .account-form .form--control, .account-form .form-control');
                    inputs.forEach(function(input) {
                        forceDarkBackground(input);
                    });
                }, 100);
            });
        })();
    </script>
    @endpush
@endsection
