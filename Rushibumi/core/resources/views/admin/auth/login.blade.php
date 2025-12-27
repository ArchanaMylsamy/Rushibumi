@extends('admin.layouts.master')
@section('content')
    <div class="login-main" style="background-image: url('{{ asset('assets/admin/images/login.jpg') }}')">
        <div class="container custom-container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-8 col-sm-11">
                    <div class="login-area">
                        <div class="login-wrapper">
                            <div class="login-wrapper__top">
                                <h3 class="title text-white">@lang('Welcome to') <strong>{{ __(gs('site_name')) }}</strong>
                                </h3>
                                <p class="text-white">{{ __($pageTitle) }} @lang('to') {{ __(gs('site_name')) }}
                                    @lang('Dashboard')</p>
                            </div>
                            <div class="login-wrapper__body">
                                <form action="{{ route('admin.login') }}" method="POST"
                                    class="cmn-form mt-30 verify-gcaptcha login-form">
                                    @csrf
                                    <div class="form-group">
                                        <label>@lang('Username')</label>
                                        <input type="text" class="form-control" value="{{ old('username') }}"
                                            name="username" autocomplete="username" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label>@lang('Password')</label>
                                            <a href="{{ route('admin.password.reset') }}"
                                                class="forget-text">@lang('Forgot Password?')</a>
                                        </div>
                                        <input type="password" class="form-control" name="password" autocomplete="current-password" required>
                                    </div>
                                    <x-captcha />
                                    <button type="submit" class="btn cmn-btn w-100">@lang('LOGIN')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    /* AGGRESSIVE: Remove ALL white backgrounds - highest priority */
    .login-main input[type="text"],
    .login-main input[type="password"],
    .login-main input,
    .login-main .form-control,
    .login-form input[type="text"],
    .login-form input[type="password"],
    .login-form input,
    .login-form .form-control {
        background-color: rgba(255, 255, 255, 0.1) !important;
        background: rgba(255, 255, 255, 0.1) !important;
        background-image: none !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        -webkit-appearance: none !important;
        appearance: none !important;
    }

    /* AGGRESSIVE: Remove white background on focus/click - ALL possible selectors */
    .login-main input[type="text"]:focus,
    .login-main input[type="text"]:active,
    .login-main input[type="text"]:focus-visible,
    .login-main input[type="password"]:focus,
    .login-main input[type="password"]:active,
    .login-main input[type="password"]:focus-visible,
    .login-main input:focus,
    .login-main input:active,
    .login-main input:focus-visible,
    .login-main .form-control:focus,
    .login-main .form-control:active,
    .login-main .form-control:focus-visible,
    .login-main .form-control:focus-within,
    .login-form input[type="text"]:focus,
    .login-form input[type="text"]:active,
    .login-form input[type="password"]:focus,
    .login-form input[type="password"]:active,
    .login-form input:focus,
    .login-form input:active,
    .login-form .form-control:focus,
    .login-form .form-control:active,
    .login-form .form-control:focus-within {
        background-color: rgba(255, 255, 255, 0.15) !important;
        background: rgba(255, 255, 255, 0.15) !important;
        background-image: none !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.4) !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1) !important;
        outline: none !important;
        -webkit-box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1) !important;
    }

    /* Remove white background on hover */
    .login-main input[type="text"]:hover,
    .login-main input[type="password"]:hover,
    .login-main input:hover,
    .login-main .form-control:hover,
    .login-form input:hover,
    .login-form .form-control:hover {
        background-color: rgba(255, 255, 255, 0.12) !important;
        background: rgba(255, 255, 255, 0.12) !important;
        background-image: none !important;
    }

    /* Style browser autofill to match dark theme */
    .login-main input:-webkit-autofill,
    .login-main input:-webkit-autofill:hover,
    .login-main input:-webkit-autofill:focus,
    .login-main input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.1) inset !important;
        -webkit-text-fill-color: #fff !important;
        background-color: rgba(255, 255, 255, 0.1) !important;
        background: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        transition: background-color 5000s ease-in-out 0s !important;
    }

    /* Override browser default autocomplete styling */
    .login-main input[type="text"]:-webkit-autofill,
    .login-main input[type="password"]:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.1) inset !important;
        -webkit-text-fill-color: #fff !important;
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* Placeholder styling */
    .login-main .form-control::placeholder,
    .login-main input::placeholder {
        color: rgba(255, 255, 255, 0.6) !important;
        opacity: 1 !important;
    }

    /* Label styling */
    .login-wrapper__body label {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Remove any white backgrounds from browser autocomplete dropdown */
    .login-main input::-webkit-contacts-auto-fill-button {
        background-color: rgba(255, 255, 255, 0.1) !important;
        filter: brightness(0) invert(1);
    }

    /* Ensure no white flash on any state */
    .login-main input[type="text"],
    .login-main input[type="password"] {
        caret-color: #fff !important;
    }

    /* Remove default browser styling completely */
    .login-main input {
        -webkit-appearance: none !important;
        appearance: none !important;
        background-image: none !important;
    }

    /* Force dark background - prevent white on any interaction */
    .login-main input[type="text"]:not(:-webkit-autofill),
    .login-main input[type="password"]:not(:-webkit-autofill) {
        background-color: rgba(255, 255, 255, 0.1) !important;
        background: rgba(255, 255, 255, 0.1) !important;
    }

    /* Prevent white background on click/select */
    .login-main input[type="text"]::selection,
    .login-main input[type="password"]::selection {
        background-color: rgba(255, 255, 255, 0.3) !important;
        color: #fff !important;
    }

    /* Remove any white background from form group */
    .login-main .form-group {
        background-color: transparent !important;
        background: transparent !important;
    }

    /* Ensure login wrapper body has no white background */
    .login-wrapper__body {
        background-color: transparent !important;
        background: transparent !important;
    }

    /* Override any Bootstrap default white backgrounds */
    .login-main .form-control:not(:-webkit-autofill) {
        background-color: rgba(255, 255, 255, 0.1) !important;
        background: rgba(255, 255, 255, 0.1) !important;
    }

    /* Force dark theme on all pseudo-states */
    .login-main input[type="text"]:enabled,
    .login-main input[type="password"]:enabled {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* Override app.css focus styles - app.css sets background-color: transparent which shows white */
    .login-form .form-control:focus,
    .login-form .form-control:active,
    .login-form .form-control:focus-within,
    .login-form input:focus,
    .login-form input:active {
        background-color: rgba(255, 255, 255, 0.15) !important;
        background: rgba(255, 255, 255, 0.15) !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.4) !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1) !important;
        outline: none !important;
    }

    /* Remove any white/transparent background from Bootstrap form-control */
    .login-main .form-control,
    .login-main .form-control:focus,
    .login-main .form-control:active,
    .login-main .form-control:hover,
    .login-main .form-control:focus-within {
        background-color: rgba(255, 255, 255, 0.1) !important;
        background: rgba(255, 255, 255, 0.1) !important;
    }

    .login-main .form-control:focus,
    .login-main .form-control:active {
        background-color: rgba(255, 255, 255, 0.15) !important;
        background: rgba(255, 255, 255, 0.15) !important;
    }

    /* Override general form-control focus styles from app.css */
    .login-main .form-control:focus,
    .login-main .form-control:active,
    .login-main .form-control:visited,
    .login-main .form-control:focus-within,
    .login-main input:focus,
    .login-main input:active,
    .login-main input:visited,
    .login-main input:focus-within {
        background-color: rgba(255, 255, 255, 0.15) !important;
        background: rgba(255, 255, 255, 0.15) !important;
        color: #fff !important;
    }

    /* Force dark background on ALL possible states - maximum specificity */
    .login-main .login-wrapper__body .login-form .form-group .form-control,
    .login-main .login-wrapper__body .login-form .form-group input[type="text"],
    .login-main .login-wrapper__body .login-form .form-group input[type="password"] {
        background-color: rgba(255, 255, 255, 0.1) !important;
        background: rgba(255, 255, 255, 0.1) !important;
        background-image: none !important;
    }

    .login-main .login-wrapper__body .login-form .form-group .form-control:focus,
    .login-main .login-wrapper__body .login-form .form-group .form-control:active,
    .login-main .login-wrapper__body .login-form .form-group input[type="text"]:focus,
    .login-main .login-wrapper__body .login-form .form-group input[type="text"]:active,
    .login-main .login-wrapper__body .login-form .form-group input[type="password"]:focus,
    .login-main .login-wrapper__body .login-form .form-group input[type="password"]:active {
        background-color: rgba(255, 255, 255, 0.15) !important;
        background: rgba(255, 255, 255, 0.15) !important;
        background-image: none !important;
    }

    /* Force dark background on ALL possible states - maximum specificity */
    .login-main .login-wrapper__body .login-form .form-group .form-control,
    .login-main .login-wrapper__body .login-form .form-group input[type="text"],
    .login-main .login-wrapper__body .login-form .form-group input[type="password"] {
        background-color: rgba(255, 255, 255, 0.1) !important;
        background: rgba(255, 255, 255, 0.1) !important;
        background-image: none !important;
    }

    .login-main .login-wrapper__body .login-form .form-group .form-control:focus,
    .login-main .login-wrapper__body .login-form .form-group .form-control:active,
    .login-main .login-wrapper__body .login-form .form-group input[type="text"]:focus,
    .login-main .login-wrapper__body .login-form .form-group input[type="text"]:active,
    .login-main .login-wrapper__body .login-form .form-group input[type="password"]:focus,
    .login-main .login-wrapper__body .login-form .form-group input[type="password"]:active {
        background-color: rgba(255, 255, 255, 0.15) !important;
        background: rgba(255, 255, 255, 0.15) !important;
        background-image: none !important;
    }
</style>
@endpush

@push('script')
<script>
    (function() {
        'use strict';
        
        function forceDarkBackground(input) {
            if (input) {
                input.style.setProperty('background-color', 'rgba(255, 255, 255, 0.1)', 'important');
                input.style.setProperty('background', 'rgba(255, 255, 255, 0.1)', 'important');
                input.style.setProperty('color', '#fff', 'important');
                input.style.setProperty('background-image', 'none', 'important');
                // Also set via setAttribute to override any CSS
                const currentStyle = input.getAttribute('style') || '';
                input.setAttribute('style', currentStyle + '; background-color: rgba(255, 255, 255, 0.1) !important; background: rgba(255, 255, 255, 0.1) !important;');
            }
        }
        
        function forceDarkBackgroundOnFocus(input) {
            if (input) {
                input.style.setProperty('background-color', 'rgba(255, 255, 255, 0.15)', 'important');
                input.style.setProperty('background', 'rgba(255, 255, 255, 0.15)', 'important');
                input.style.setProperty('color', '#fff', 'important');
                input.style.setProperty('background-image', 'none', 'important');
                // Also set via setAttribute to override any CSS
                const currentStyle = input.getAttribute('style') || '';
                input.setAttribute('style', currentStyle + '; background-color: rgba(255, 255, 255, 0.15) !important; background: rgba(255, 255, 255, 0.15) !important;');
            }
        }
        
        // Force dark background immediately on page load
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.login-main input[type="text"], .login-main input[type="password"], .login-main .form-control');
            
            inputs.forEach(function(input) {
                forceDarkBackground(input);
                
                // Force dark background on focus
                input.addEventListener('focus', function(e) {
                    e.preventDefault();
                    forceDarkBackgroundOnFocus(this);
                }, true);
                
                // Force dark background on click
                input.addEventListener('click', function(e) {
                    forceDarkBackgroundOnFocus(this);
                }, true);
                
                input.addEventListener('mousedown', function(e) {
                    forceDarkBackgroundOnFocus(this);
                }, true);
                
                // Force dark background on blur
                input.addEventListener('blur', function() {
                    forceDarkBackground(this);
                }, true);
                
                // Monitor for any style changes and force dark background
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes') {
                            const bgColor = input.style.backgroundColor;
                            const computedStyle = window.getComputedStyle(input);
                            const computedBg = computedStyle.backgroundColor;
                            
                            if (bgColor && (bgColor.includes('white') || bgColor.includes('#fff') || bgColor.includes('rgb(255, 255, 255)') || bgColor === 'transparent')) {
                                forceDarkBackground(input);
                            }
                            if (computedBg && (
                                computedBg.includes('white') || 
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
                    if (bgColor && (
                        bgColor.includes('white') || 
                        bgColor.includes('rgb(255, 255, 255)') || 
                        bgColor === 'transparent' || 
                        bgColor === 'rgba(0, 0, 0, 0)' ||
                        bgColor.includes('rgba(0, 0, 0, 0)')
                    )) {
                        if (document.activeElement === input) {
                            forceDarkBackgroundOnFocus(input);
                        } else {
                            forceDarkBackground(input);
                        }
                    }
                }, 50); // Check every 50ms for faster response
            });
        });
        
        // Also force on window load
        window.addEventListener('load', function() {
            setTimeout(function() {
                const inputs = document.querySelectorAll('.login-main input[type="text"], .login-main input[type="password"], .login-main .form-control');
                inputs.forEach(function(input) {
                    forceDarkBackground(input);
                });
            }, 100);
        });
    })();
</script>
@endpush

@push('script')
<script>
    (function() {
        'use strict';
        
        // Force dark background immediately on page load
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.login-main input[type="text"], .login-main input[type="password"], .login-main .form-control');
            
            inputs.forEach(function(input) {
                // Set dark background immediately
                input.style.setProperty('background-color', 'rgba(255, 255, 255, 0.1)', 'important');
                input.style.setProperty('background', 'rgba(255, 255, 255, 0.1)', 'important');
                input.style.setProperty('color', '#fff', 'important');
                
                // Force dark background on focus
                input.addEventListener('focus', function() {
                    this.style.setProperty('background-color', 'rgba(255, 255, 255, 0.15)', 'important');
                    this.style.setProperty('background', 'rgba(255, 255, 255, 0.15)', 'important');
                    this.style.setProperty('color', '#fff', 'important');
                }, true);
                
                // Force dark background on click
                input.addEventListener('click', function() {
                    this.style.setProperty('background-color', 'rgba(255, 255, 255, 0.15)', 'important');
                    this.style.setProperty('background', 'rgba(255, 255, 255, 0.15)', 'important');
                    this.style.setProperty('color', '#fff', 'important');
                }, true);
                
                // Force dark background on blur (when clicking away)
                input.addEventListener('blur', function() {
                    this.style.setProperty('background-color', 'rgba(255, 255, 255, 0.1)', 'important');
                    this.style.setProperty('background', 'rgba(255, 255, 255, 0.1)', 'important');
                }, true);
                
                // Monitor for any style changes and force dark background
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                            const bgColor = input.style.backgroundColor;
                            if (bgColor && (bgColor.includes('white') || bgColor.includes('#fff') || bgColor.includes('rgb(255'))) {
                                input.style.setProperty('background-color', 'rgba(255, 255, 255, 0.1)', 'important');
                                input.style.setProperty('background', 'rgba(255, 255, 255, 0.1)', 'important');
                            }
                        }
                    });
                });
                
                observer.observe(input, {
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
            });
        });
        
        // Also force on window load (in case DOMContentLoaded already fired)
        window.addEventListener('load', function() {
            setTimeout(function() {
                const inputs = document.querySelectorAll('.login-main input[type="text"], .login-main input[type="password"], .login-main .form-control');
                inputs.forEach(function(input) {
                    input.style.setProperty('background-color', 'rgba(255, 255, 255, 0.1)', 'important');
                    input.style.setProperty('background', 'rgba(255, 255, 255, 0.1)', 'important');
                    input.style.setProperty('color', '#fff', 'important');
                });
            }, 100);
        });
    })();
</script>
@endpush
