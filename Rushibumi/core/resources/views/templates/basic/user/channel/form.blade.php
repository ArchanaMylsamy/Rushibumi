@extends($activeTemplate . 'layouts.app')
@section('app')
    @php
        $authImage = getContent('auth_page.content', true);
    @endphp

    <section class="account-section">

        @include('Template::partials.auth_header')

        <div class="account-section__body">
            <div class="container">
                <div class="account-form style-lg">
                    <div class="account-form__heading">
                        <h3 class="account-form__title">{{ __($pageTitle) }}</h3>
                    </div>
                    <div class="account-form__body">
                        <form method="POST" action="{{ route('user.channel.data.submit') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Profile Picture Upload -->
                            <div class="profile-upload-wrapper">
                                <div class="profile-picture-upload">
                                    <div class="profile-picture-preview">
                                        <img id="profilePreview" src="{{ getImage(getFilePath('userProfile') . '/' . (auth()->user()->image ?? 'default.png'), null, true) }}" alt="Profile Picture">
                                    </div>
                                    <label for="profile_image" class="btn-select-picture">
                                        @lang('Select picture')
                                        <input type="file" id="profile_image" name="image" accept=".png, .jpg, .jpeg" hidden>
                                    </label>
                                </div>
                            </div>

                            <!-- Name and Handle Fields -->
                            <div class="channel-form-fields">
                                <div class="form-group">
                                    <label class="form-label">@lang('Name')</label>
                                    <input type="text" class="form-control form--control" required name="channel_name"
                                        value="{{ old('channel_name', auth()->user()->display_name ?? auth()->user()->firstname ?? '') }}" 
                                        placeholder="@lang('Enter channel name')">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">@lang('Handle')</label>
                                    <div class="handle-input-wrapper">
                                        <span class="handle-prefix">@</span>
                                        <input type="text" class="form-control form--control checkUser" required name="username"
                                            value="{{ old('username') }}" 
                                            placeholder="@lang('username')" 
                                            id="handleInput">
                                    </div>
                                    <small class="text--danger usernameExist"></small>
                                </div>
                            </div>
                    
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn--base">
                                    @lang('Create Channel')
                                </button>
                            </div>
                        
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
    </section>
@endsection



@push('style')
    <style>
        .profile-upload-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .profile-picture-upload {
            text-align: center;
        }

        .profile-picture-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 1rem;
            background: hsl(var(--bg-color));
            border: 2px solid hsl(var(--white) / 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-picture-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-select-picture {
            display: inline-block;
            padding: 10px 24px;
            background: hsl(var(--base));
            color: hsl(var(--white));
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-select-picture:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .channel-form-fields {
            max-width: 500px;
            margin: 0 auto;
        }

        .handle-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .handle-prefix {
            position: absolute;
            left: 15px;
            color: hsl(var(--text-color));
            font-weight: 500;
            z-index: 1;
            pointer-events: none;
        }

        .handle-input-wrapper .form--control {
            padding-left: 35px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: hsl(var(--text-color));
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {

            // Profile picture preview
            $('#profile_image').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profilePreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Username validation
            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            // Auto-lowercase and validate username format
            $('#handleInput').on('input', function() {
                var value = $(this).val().toLowerCase().replace(/[^a-z0-9_]/g, '');
                $(this).val(value);
            });

            function checkUser(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                    
                    $.post(url, data, function(response) {
                        if (response.data != false) {
                            $(`.${response.type}Exist`).text(`${response.field} already exist`);
                        } else {
                            $(`.${response.type}Exist`).text('');
                        }
                    });
                }
            }
        })(jQuery);
    </script>
@endpush

