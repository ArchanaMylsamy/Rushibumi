@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="setting-content">
        <form method="post" enctype="multipart/form-data">
            <h3 class="setting-content__title">@lang('Account Information')</h3>
            <div class="edit-profile">
                <div class="edit-profile__photo">
                    <div class="cover-photo upload-image">
                        <div class="cover-preview h-100 w-100">
                            <div class="coverPhotoPreview upload-image__thumb h-100 w-100">
                                <img class="fit-image" src="{{ getImage(getFilePath('cover') . '/' . $user->cover_image, getFileSize('cover')) }}"
                                     alt="@lang('cover_image')">
                            </div>
                        </div>
                        <div class="cover-edit">
                            <label for="coverImage">
                                <span class="icon text--base"><i class="vti-add-photo"></i> </span>
                                <span class="text--base fs-14">@lang('Add/change cover image')</span>
                                <input type="file" hidden name="cover_image" class="coverPhotoUpload upload-image__btn"
                                       id="coverImage" accept=".png, .jpg, .jpeg">
                            </label>
                        </div>
                    </div>
                    <div class="profile-picture upload-image">
                        <div class="profile-picture__inner bg-img upload-image__thumb">
                            <img class="fit-image" src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                                 alt="image">
                            <div class="profile-picture__edit">
                                <label for="image">
                                    <input type="file" class="upload-image__btn" hidden name="image"
                                           accept=".png, .jpg, .jpeg" id="image">
                                    <span class="icon"><i class="fas fa-camera"></i> </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf

                <div class="edit-profile__form row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Channel Name')</label>
                            <input type="text" class="form--control" name="channel_name"
                                   value="{{ __(old('channel_name', $user->channel_name)) }}" placeholder="User Channel">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Channel Description')</label>
                            <textarea class="form--control nicEdit" name="channel_description" cols="20" rows="10"> {{ $user->channel_description }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group text-end mb-0">
                            <button type="submit" class="btn btn--base">@lang('Save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('style')
    <style>
        .nicEdit-main {
            outline: none !important;
            width: 100% !important;
        }

        .nicEdit-custom-main {
            border-right-color: #cacaca73 !important;
            border-bottom-color: #cacaca73 !important;
            border-left-color: #cacaca73 !important;
            border-radius: 0 0 5px 5px !important;
            width: 100% !important;
        }

        .nicEdit-panelContain {
            border-color: #cacaca73 !important;
            border-radius: 5px 5px 0 0 !important;
            background-color: #fff !important
        }

        .nicEdit-buttonContain div {
            background-color: #fff !important;
            border: 0 !important;
        }

        .nicedit-textarea>div {
            width: 100% !important;
        }

        .edit-profile__photo .cover-photo .cover-edit label {
            border: 1px dashed hsl(var(--static-black));

        }
    </style>
@endpush


@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/nicEdit.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            'use strict';

            bkLib.onDomLoaded(function() {
                $(".nicEdit").each(function(index) {
                    $(this).attr("id", "nicEditor" + index);
                    new nicEditor({
                        fullPanel: true
                    }).panelInstance('nicEditor' + index, {
                        hasPanel: true
                    });
                });
            });

        })(jQuery)
    </script>
@endpush

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
    .setting-content form {
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

    .setting-content form::before {
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

    /* Edit Profile */
    .edit-profile {
        position: relative;
        z-index: 2;
    }

    .edit-profile__photo {
        position: relative;
        z-index: 2;
    }

    .cover-photo {
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        border-radius: 8px;
        overflow: hidden;
    }

    .cover-edit label {
        background: rgba(0, 0, 0, 0.8) !important;
        border: 2px dashed rgba(220, 20, 60, 0.5) !important;
        color: rgba(255, 255, 255, 0.9) !important;
        transition: all 0.3s ease;
    }

    .cover-edit label:hover {
        border-color: #dc143c !important;
        background: rgba(220, 20, 60, 0.2) !important;
    }

    .text--base {
        color: #dc143c !important;
    }

    .profile-picture {
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        border-radius: 50%;
    }

    .profile-picture__edit {
        background: rgba(0, 0, 0, 0.8) !important;
        border: 2px solid rgba(220, 20, 60, 0.5) !important;
    }

    .profile-picture__edit:hover {
        background: rgba(220, 20, 60, 0.3) !important;
        border-color: #dc143c !important;
    }

    .edit-profile__form {
        position: relative;
        z-index: 2;
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

    /* NicEdit Editor */
    .nicEdit-main {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 2px solid rgba(220, 20, 60, 0.3) !important;
        color: #ffffff !important;
    }

    .nicEdit-custom-main {
        border-color: rgba(220, 20, 60, 0.3) !important;
        background: rgba(0, 0, 0, 0.6) !important;
    }

    .nicEdit-panelContain {
        border-color: rgba(220, 20, 60, 0.3) !important;
        background-color: rgba(0, 0, 0, 0.9) !important;
    }

    .nicEdit-buttonContain div {
        background-color: rgba(0, 0, 0, 0.8) !important;
        border: 1px solid rgba(220, 20, 60, 0.3) !important;
    }
</style>
@endpush
