@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="setting-content">
        <h3 class="setting-content__title">@lang('Profile settings')</h3>
        <form action="" method="post" class="profile-setting-form row">
            @csrf
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form--label">@lang('First Name')</label>
                    <input type="text" class="form--control" name="firstname" required
                           value="{{ old('firstname', $user->firstname) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form--label">@lang('Last Name')</label>
                    <input type="text" class="form--control" name="lastname" required
                           value="{{ old('lastname', $user->lastname) }}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form--label">@lang('Bio')</label>
                    <textarea class="form--control" name="bio" required>{{ old('bio', $user->bio) }}</textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label class="form--label">@lang('Facebook')</label>
                    <input type="url" class="form--control" name="social_links[facebook]"
                           value="{{ old('social_links[facebook]', @$user->social_links?->facebook) }}" placeholder="URL">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form--label">@lang('X')</label>
                    <input type="url" class="form--control" name="social_links[twitter]"
                           value="{{ old('social_links[twitter]', @$user->social_links?->twitter) }}" placeholder="URL">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form--label">@lang('Instagram')</label>
                    <input type="url" class="form--control" name="social_links[instragram]"
                           value="{{ old('social_links[instragram]', @$user->social_links?->instragram) }}" placeholder="URL">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form--label">@lang('Threads')</label>
                    <input type="url" class="form--control" name="social_links[threads]"
                           value="{{ old('social_links[threads]', @$user->social_links?->threads) }}" placeholder="URL">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form--label">@lang('Descord')</label>
                    <input type="url" class="form--control" name="social_links[descord]"
                           value="{{ old('social_links[descord]', @$user->social_links?->descord) }}" placeholder="URL">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="form--label">@lang('Tiktok')</label>
                    <input type="url" class="form--control" name="social_links[tiktok]"
                           value="{{ old('social_links[tiktok]', @$user->social_links?->tiktok) }}" placeholder="URL">
                </div>
            </div>


            <div class="col-12">
                <div class="form-group text-end mb-0">
                    <button type="submit" class="btn btn--base btn--lg">@lang('Save')</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('style')
<style>
    /* Red & Black Theme Styling */
    .setting-content {
        background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #000000 100%);
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        padding: 20px;
    }

    /* Animated Background Effects */
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

    /* Floating Particles */
    .setting-content::after {
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

    .setting-content > * {
        position: relative;
        z-index: 1;
    }

    /* Form Styling */
    .profile-setting-form {
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
        border-radius: 8px;
        padding: 30px;
    }

    .profile-setting-form::before {
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
    .setting-content__title {
        background: linear-gradient(135deg, #dc143c, #ff1744, #dc143c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        text-shadow: 0 0 30px rgba(220, 20, 60, 0.5);
        animation: text-shimmer 3s ease-in-out infinite;
        position: relative;
        z-index: 2;
    }

    @keyframes text-shimmer {
        0%, 100% {
            filter: brightness(1);
        }
        50% {
            filter: brightness(1.3);
        }
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

    /* Textarea */
    textarea.form--control {
        resize: vertical;
        min-height: 100px;
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
</style>
@endpush
