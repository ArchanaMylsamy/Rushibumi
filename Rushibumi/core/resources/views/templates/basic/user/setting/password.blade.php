@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="setting-content">
        <div class="change-password">
            <a href="{{ route('user.setting.security') }}" class="change-password__back"><i class="vti-left-long"></i></a>
            <h5 class="title">{{ __($pageTitle) }}</h5>

            <form method="post">
                @csrf
                <div class="form-group">
                    <label class="form--label">@lang('Current Password')</label>
                    <input type="password" class=" form--control" name="current_password" required
                           placeholder="Current password">
                </div>
                <div class="form-group">
                    <label class="form--label">@lang('Password')</label>
                    <input type="password" class="form--control @if (gs('secure_password')) secure-password @endif"
                           name="password" required placeholder="New password">
                </div>
                <div class="form-group">
                    <label class="form--label">@lang('Confirm Password')</label>
                    <input type="password" class=" form--control" name="password_confirmation" required
                           placeholder="Confirm password">
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn--base btn--lg">@lang('Submit')</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('style')
<style>
    .hover-input-popup .input-popup {
        bottom: 73%;
    }

    /* Red & Black Theme Styling - Colors Only */
    .setting-content {
        background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #000000 100%);
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        padding: 20px;
    }

    .setting-content::before {
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

    .setting-content > * {
        position: relative;
        z-index: 1;
    }

    .change-password {
        background: rgba(0, 0, 0, 0.85) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(220, 20, 60, 0.1),
            inset 0 0 60px rgba(220, 20, 60, 0.05) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 8px;
        padding: 30px;
    }

    .change-password__back {
        color: #dc143c !important;
    }

    .change-password__back:hover {
        color: #ff1744 !important;
    }

    .change-password .title {
        background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
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

    .form--control::placeholder {
        color: rgba(255, 255, 255, 0.4);
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