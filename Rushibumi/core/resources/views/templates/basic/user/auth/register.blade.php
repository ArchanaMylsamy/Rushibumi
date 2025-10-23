@extends($activeTemplate . 'layouts.app')
@section('app')
    @php
        $authImage = getContent('auth_page.content', true);
    @endphp
    <div class="account-section">
        @include('Template::partials.auth_header')
        <div class="account-section__body">
            @if (!gs('registration'))
                <span class="form-disabled-text">
                    <svg class="" style="enable-background:new 0 0 512 512" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="80" height="80" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                        <g>
                            <path
                                  class="" data-original="#ff7149" d="M255.999 0c-79.044 0-143.352 64.308-143.352 143.353v70.193c0 4.78 3.879 8.656 8.659 8.656h48.057a8.657 8.657 0 0 0 8.656-8.656v-70.193c0-42.998 34.981-77.98 77.979-77.98s77.979 34.982 77.979 77.98v70.193c0 4.78 3.88 8.656 8.661 8.656h48.057a8.657 8.657 0 0 0 8.656-8.656v-70.193C399.352 64.308 335.044 0 255.999 0zM382.04 204.89h-30.748v-61.537c0-52.544-42.748-95.292-95.291-95.292s-95.291 42.748-95.291 95.292v61.537h-30.748v-61.537c0-69.499 56.54-126.04 126.038-126.04 69.499 0 126.04 56.541 126.04 126.04v61.537z" fill="#ff7149" opacity="1"></path>
                            <path
                                  class="" data-original="#ff7149" d="M410.63 204.89H101.371c-20.505 0-37.188 16.683-37.188 37.188v232.734c0 20.505 16.683 37.188 37.188 37.188H410.63c20.505 0 37.187-16.683 37.187-37.189V242.078c0-20.505-16.682-37.188-37.187-37.188zm19.875 269.921c0 10.96-8.916 19.876-19.875 19.876H101.371c-10.96 0-19.876-8.916-19.876-19.876V242.078c0-10.96 8.916-19.876 19.876-19.876H410.63c10.959 0 19.875 8.916 19.875 19.876v232.733z" fill="#ff7149" opacity="1"></path>
                            <path
                                  class="" data-original="#ff7149" d="M285.11 369.781c10.113-8.521 15.998-20.978 15.998-34.365 0-24.873-20.236-45.109-45.109-45.109-24.874 0-45.11 20.236-45.11 45.109 0 13.387 5.885 25.844 16 34.367l-9.731 46.362a8.66 8.66 0 0 0 8.472 10.436h60.738a8.654 8.654 0 0 0 8.47-10.434l-9.728-46.366zm-14.259-10.961a8.658 8.658 0 0 0-3.824 9.081l8.68 41.366h-39.415l8.682-41.363a8.655 8.655 0 0 0-3.824-9.081c-8.108-5.16-12.948-13.911-12.948-23.406 0-15.327 12.469-27.796 27.797-27.796 15.327 0 27.796 12.469 27.796 27.796.002 9.497-4.838 18.246-12.944 23.403z" fill="#ff7149" opacity="1"></path>
                        </g>
                    </svg>
                </span>
            @endif

            <div class="container">
                <div class="account-form style-lg     @if (!gs('registration')) form-disabled @endif">
                    <div class="account-form__heading">
                        <h3 class="account-form__title">{{ __($authImage->data_values->register_page_title) }}</h3>
                        <p class="account-form__text">{{ __($authImage->data_values->register_page_subtitle) }}</p>
                    </div>
                    <div class="account-form__body">
                        @include($activeTemplate . 'partials.social_login')
                        <form class="verify-gcaptcha disableSubmission" action="{{ route('user.register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Name Fields Section -->
                                <div class="col-12">
                                    <h5 class="text-center mb-3">@lang('Personal Information')</h5>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Surname') <span class="text-danger">*</span></label>
                                    <input class="form-control form--control" name="surname" type="text" value="{{ old('surname') }}" required>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('First Name') <span class="text-danger">*</span></label>
                                    <input class="form-control form--control" name="firstname" type="text" value="{{ old('firstname') }}" required>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Middle Name')</label>
                                    <input class="form-control form--control" name="middle_name" type="text" value="{{ old('middle_name') }}">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Family Name')</label>
                                    <input class="form-control form--control" name="family_name" type="text" value="{{ old('family_name') }}">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Last Name') <span class="text-danger">*</span></label>
                                    <input class="form-control form--control" name="lastname" type="text" value="{{ old('lastname') }}" required>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Display Name') <span class="text-danger">*</span></label>
                                    <input class="form-control form--control" name="display_name" type="text" value="{{ old('display_name') }}" required placeholder="@lang('This name will be shown on your channels and profile')">
                                    <small class="form-text text-muted">@lang('This name will be displayed across all your channels and profile')</small>
                                </div>

                                <!-- Contact Information Section -->
                                <div class="col-12 mt-4">
                                    <h5 class="text-center mb-3">@lang('Contact Information')</h5>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form--label">@lang('E-Mail Address') <span class="text-danger">*</span></label>
                                        <input class="form-control form--control checkUser" name="email" type="email" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Phone Number') <span class="text-danger">*</span></label>
                                    <input class="form-control form--control" name="phone_number" type="tel" value="{{ old('phone_number') }}" required placeholder="@lang('Enter your phone number')">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Country') <span class="text-danger">*</span></label>
                                    <select class="form-control form--control" name="country_name" required>
                                        <option value="">@lang('Select Country')</option>
                                        <option value="Afghanistan" {{ old('country_name') == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                        <option value="Albania" {{ old('country_name') == 'Albania' ? 'selected' : '' }}>Albania</option>
                                        <option value="Algeria" {{ old('country_name') == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                                        <option value="Argentina" {{ old('country_name') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                        <option value="Armenia" {{ old('country_name') == 'Armenia' ? 'selected' : '' }}>Armenia</option>
                                        <option value="Australia" {{ old('country_name') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                        <option value="Austria" {{ old('country_name') == 'Austria' ? 'selected' : '' }}>Austria</option>
                                        <option value="Azerbaijan" {{ old('country_name') == 'Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
                                        <option value="Bangladesh" {{ old('country_name') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                        <option value="Belarus" {{ old('country_name') == 'Belarus' ? 'selected' : '' }}>Belarus</option>
                                        <option value="Belgium" {{ old('country_name') == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                                        <option value="Brazil" {{ old('country_name') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                        <option value="Bulgaria" {{ old('country_name') == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                                        <option value="Cambodia" {{ old('country_name') == 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
                                        <option value="Canada" {{ old('country_name') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                        <option value="Chile" {{ old('country_name') == 'Chile' ? 'selected' : '' }}>Chile</option>
                                        <option value="China" {{ old('country_name') == 'China' ? 'selected' : '' }}>China</option>
                                        <option value="Colombia" {{ old('country_name') == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                                        <option value="Croatia" {{ old('country_name') == 'Croatia' ? 'selected' : '' }}>Croatia</option>
                                        <option value="Czech Republic" {{ old('country_name') == 'Czech Republic' ? 'selected' : '' }}>Czech Republic</option>
                                        <option value="Denmark" {{ old('country_name') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                                        <option value="Egypt" {{ old('country_name') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                        <option value="Estonia" {{ old('country_name') == 'Estonia' ? 'selected' : '' }}>Estonia</option>
                                        <option value="Finland" {{ old('country_name') == 'Finland' ? 'selected' : '' }}>Finland</option>
                                        <option value="France" {{ old('country_name') == 'France' ? 'selected' : '' }}>France</option>
                                        <option value="Georgia" {{ old('country_name') == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                                        <option value="Germany" {{ old('country_name') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                        <option value="Ghana" {{ old('country_name') == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                        <option value="Greece" {{ old('country_name') == 'Greece' ? 'selected' : '' }}>Greece</option>
                                        <option value="Hungary" {{ old('country_name') == 'Hungary' ? 'selected' : '' }}>Hungary</option>
                                        <option value="Iceland" {{ old('country_name') == 'Iceland' ? 'selected' : '' }}>Iceland</option>
                                        <option value="India" {{ old('country_name') == 'India' ? 'selected' : '' }}>India</option>
                                        <option value="Indonesia" {{ old('country_name') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                        <option value="Iran" {{ old('country_name') == 'Iran' ? 'selected' : '' }}>Iran</option>
                                        <option value="Iraq" {{ old('country_name') == 'Iraq' ? 'selected' : '' }}>Iraq</option>
                                        <option value="Ireland" {{ old('country_name') == 'Ireland' ? 'selected' : '' }}>Ireland</option>
                                        <option value="Israel" {{ old('country_name') == 'Israel' ? 'selected' : '' }}>Israel</option>
                                        <option value="Italy" {{ old('country_name') == 'Italy' ? 'selected' : '' }}>Italy</option>
                                        <option value="Japan" {{ old('country_name') == 'Japan' ? 'selected' : '' }}>Japan</option>
                                        <option value="Jordan" {{ old('country_name') == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                                        <option value="Kazakhstan" {{ old('country_name') == 'Kazakhstan' ? 'selected' : '' }}>Kazakhstan</option>
                                        <option value="Kenya" {{ old('country_name') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                        <option value="Kuwait" {{ old('country_name') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                        <option value="Latvia" {{ old('country_name') == 'Latvia' ? 'selected' : '' }}>Latvia</option>
                                        <option value="Lebanon" {{ old('country_name') == 'Lebanon' ? 'selected' : '' }}>Lebanon</option>
                                        <option value="Lithuania" {{ old('country_name') == 'Lithuania' ? 'selected' : '' }}>Lithuania</option>
                                        <option value="Luxembourg" {{ old('country_name') == 'Luxembourg' ? 'selected' : '' }}>Luxembourg</option>
                                        <option value="Malaysia" {{ old('country_name') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                        <option value="Mexico" {{ old('country_name') == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                                        <option value="Morocco" {{ old('country_name') == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                                        <option value="Netherlands" {{ old('country_name') == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                        <option value="New Zealand" {{ old('country_name') == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                        <option value="Nigeria" {{ old('country_name') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                        <option value="Norway" {{ old('country_name') == 'Norway' ? 'selected' : '' }}>Norway</option>
                                        <option value="Pakistan" {{ old('country_name') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                        <option value="Peru" {{ old('country_name') == 'Peru' ? 'selected' : '' }}>Peru</option>
                                        <option value="Philippines" {{ old('country_name') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                        <option value="Poland" {{ old('country_name') == 'Poland' ? 'selected' : '' }}>Poland</option>
                                        <option value="Portugal" {{ old('country_name') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                        <option value="Qatar" {{ old('country_name') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                        <option value="Romania" {{ old('country_name') == 'Romania' ? 'selected' : '' }}>Romania</option>
                                        <option value="Russia" {{ old('country_name') == 'Russia' ? 'selected' : '' }}>Russia</option>
                                        <option value="Saudi Arabia" {{ old('country_name') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                        <option value="Singapore" {{ old('country_name') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                        <option value="Slovakia" {{ old('country_name') == 'Slovakia' ? 'selected' : '' }}>Slovakia</option>
                                        <option value="Slovenia" {{ old('country_name') == 'Slovenia' ? 'selected' : '' }}>Slovenia</option>
                                        <option value="South Africa" {{ old('country_name') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                        <option value="South Korea" {{ old('country_name') == 'South Korea' ? 'selected' : '' }}>South Korea</option>
                                        <option value="Spain" {{ old('country_name') == 'Spain' ? 'selected' : '' }}>Spain</option>
                                        <option value="Sri Lanka" {{ old('country_name') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                        <option value="Sweden" {{ old('country_name') == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                                        <option value="Switzerland" {{ old('country_name') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                                        <option value="Thailand" {{ old('country_name') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                        <option value="Turkey" {{ old('country_name') == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                                        <option value="Ukraine" {{ old('country_name') == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                                        <option value="United Arab Emirates" {{ old('country_name') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                        <option value="United Kingdom" {{ old('country_name') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="United States" {{ old('country_name') == 'United States' ? 'selected' : '' }}>United States</option>
                                        <option value="Vietnam" {{ old('country_name') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Address') <span class="text-danger">*</span></label>
                                        <textarea class="form-control form--control" name="address" rows="3" required placeholder="@lang('Enter your complete address')">{{ old('address') }}</textarea>
                                    </div>
                                </div>

                                <!-- Government ID Section -->
                                <div class="col-12 mt-4">
                                    <h5 class="text-center mb-3">@lang('Government ID Verification')</h5>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">Government ID Type <span class="text-danger">*</span></label>
                                    <select class="form-control form--control" name="government_id_type" required>
                                        <option value="">Select ID Type</option>
                                        <option value="Passport" {{ old('government_id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                                        <option value="Driver License" {{ old('government_id_type') == 'Driver License' ? 'selected' : '' }}>Driver License</option>
                                        <option value="National ID" {{ old('government_id_type') == 'National ID' ? 'selected' : '' }}>National ID</option>
                                        <option value="Aadhar Card" {{ old('government_id_type') == 'Aadhar Card' ? 'selected' : '' }}>Aadhar Card</option>
                                        <option value="SSN" {{ old('government_id_type') == 'SSN' ? 'selected' : '' }}>Social Security Number</option>
                                        <option value="Voter ID" {{ old('government_id_type') == 'Voter ID' ? 'selected' : '' }}>Voter ID</option>
                                        <option value="PAN Card" {{ old('government_id_type') == 'PAN Card' ? 'selected' : '' }}>PAN Card</option>
                                        <option value="Other" {{ old('government_id_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Government ID Number') <span class="text-danger">*</span></label>
                                    <input class="form-control form--control" name="government_id" type="text" value="{{ old('government_id') }}" required placeholder="@lang('Enter your government ID number')">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Password')</label>
                                        <input class="form-control form--control @if (gs('secure_password')) secure-password @endif" name="password" type="password" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Confirm Password')</label>
                                        <input class="form-control form--control" name="password_confirmation" type="password" required>
                                    </div>
                                </div>

                                @php
                                    $hasLevel = true;
                                @endphp
                                <x-captcha :hasLevel='$hasLevel' />

                            </div>

                            @if (gs('agree'))
                                @php
                                    $policyPages = getContent('policy_pages.element', false, orderById: true);
                                @endphp
                                <div class="form-group form--check">
                                    <input class="form-check-input" id="agree" name="agree" type="checkbox" @checked(old('agree')) required>
                                    <label class="form-check-label" for="agree">@lang('I agree with') <span>
                                            @foreach ($policyPages as $policy)
                                                <a class="text--white fw-bold text-decoration-underline" href="{{ route('policy.pages', $policy->slug) }}" target="_blank">{{ __($policy->data_values->title) }}</a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </span>
                                    </label>
                                </div>
                            @endif
                            <div class="form-group">
                                <button class="btn btn--base w-100" id="recaptcha" type="submit">
                                    @lang('Register')</button>
                            </div>
                            <p class="other-login text-center">@lang('Already have an account?') <a
                                   href="{{ route('user.login') }}">@lang('Login')</a></p>
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

    <div class="modal scale-style fade custom--modal show" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn--sm btn--white outline" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                    <a class="btn btn--sm btn--white" href="{{ route('user.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('style')
    <style>
        .hover-input-popup .input-popup {
            bottom: 75% !important;
        }

        .form-disabled {
            overflow: hidden;
            position: relative;
        }

        .form-disabled-text svg path {
            fill: hsl(var(--base));
        }

        .form-disabled::after {
            content: "";
            position: absolute;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            top: 0;
            left: 0;
            backdrop-filter: blur(3px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            z-index: 99;
        }

        .form-disabled .account-logo-area {
            z-index: 999;
        }

        .other-login {
            z-index: 99999;
            position: relative;
        }

        .form-disabled-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 991;
            font-size: 24px;
            height: auto;
            width: 100%;
            text-align: center;
            color: hsl(var(--dark-600));
            font-weight: 800;
            line-height: 1.2;
        }

        .register-disable {
            height: 100vh;
            width: 100%;
            background-color: #fff;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-disable-image {
            max-width: 300px;
            width: 100%;
            margin: 0 auto 32px;
        }

        .register-disable-title {
            color: rgb(0 0 0 / 80%);
            font-size: 42px;
            margin-bottom: 18px;
            text-align: center
        }

        .register-disable-icon {
            font-size: 16px;
            background: rgb(255, 15, 15, .07);
            color: rgb(255, 15, 15, .8);
            border-radius: 3px;
            padding: 6px;
            margin-right: 4px;
        }

        .register-disable-desc {
            color: rgb(0 0 0 / 50%);
            font-size: 18px;
            max-width: 565px;
            width: 100%;
            margin: 0 auto 32px;
            text-align: center;
        }

        .register-disable-footer-link {
            color: #fff;
            /* background-color: #5B28FF; */
            padding: 13px 24px;
            border-radius: 6px;
            text-decoration: none
        }

        .register-disable-footer-link:hover {
            /* background-color: #440ef4; */
            color: #fff;
        }
    </style>
@endpush



@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                var data = {
                    email: value,
                    _token: token
                }

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });

            // Phone number validation
            $('input[name="phone_number"]').on('input', function() {
                var phone = $(this).val();
                var phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
                
                if (phone && !phoneRegex.test(phone)) {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback">Please enter a valid phone number</div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            // Government ID validation
            $('input[name="government_id"]').on('input', function() {
                var govId = $(this).val();
                var govIdType = $('select[name="government_id_type"]').val();
                
                if (govId && govIdType) {
                    var isValid = false;
                    
                    switch(govIdType) {
                        case 'Passport':
                            isValid = /^[A-Z]{1}[0-9]{7}$/.test(govId);
                            break;
                        case 'Driver License':
                            isValid = /^[A-Z]{1}[0-9]{8}$/.test(govId);
                            break;
                        case 'Aadhar Card':
                            isValid = /^[0-9]{12}$/.test(govId);
                            break;
                        case 'SSN':
                            isValid = /^[0-9]{3}-[0-9]{2}-[0-9]{4}$/.test(govId);
                            break;
                        default:
                            isValid = govId.length >= 5;
                    }
                    
                    if (!isValid) {
                        $(this).addClass('is-invalid');
                        if (!$(this).next('.invalid-feedback').length) {
                            $(this).after('<div class="invalid-feedback">Please enter a valid ' + govIdType + ' number</div>');
                        }
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    }
                }
            });

            // Auto-generate display name
            $('input[name="firstname"], input[name="lastname"]').on('input', function() {
                var firstname = $('input[name="firstname"]').val();
                var lastname = $('input[name="lastname"]').val();
                
                if (firstname && lastname && !$('input[name="display_name"]').val()) {
                    $('input[name="display_name"]').val(firstname + ' ' + lastname);
                }
            });

        })(jQuery);
    </script>
@endpush
