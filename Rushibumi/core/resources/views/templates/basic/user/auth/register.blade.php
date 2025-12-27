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
                                    <h5 class="text-center mb-4 section-title">@lang('Personal Information')</h5>
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
                                    <h5 class="text-center mb-4 section-title">@lang('Contact Information')</h5>
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
                                    <h5 class="text-center mb-4 section-title">@lang('Government ID Verification')</h5>
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

        /* Section Titles */
        .section-title {
            color: #dc143c !important;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #dc143c, transparent);
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

        /* Select Dropdown Enhancement */
        select.form--control {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23dc143c' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
        }

        select.form--control:focus {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ff1744' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
        }

        /* Textarea Enhancement */
        textarea.form--control {
            resize: vertical;
            min-height: 100px;
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

        [data-theme="light"] .section-title {
            color: #dc143c !important;
        }

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
        .select2-dropdown {
            background-color: hsl(var(--bg-color)) !important;
            border: 1px solid hsl(var(--white) / 0.1) !important;
        }

        .select2-container--default .select2-results__option {
            background-color: hsl(var(--bg-color)) !important;
            color: hsl(var(--text-color)) !important;
        }

        /* Regular select dropdown styling for Government ID Type */
        select.form-control.form--control {
            background-color: hsl(var(--bg-color)) !important;
            color: hsl(var(--text-color)) !important;
            border: 1px solid hsl(var(--white) / 0.1) !important;
        }

        select.form-control.form--control option {
            background-color: hsl(var(--bg-color)) !important;
            color: hsl(var(--text-color)) !important;
        }

        /* For browsers that support styling option elements */
        select.form-control.form--control:focus {
            background-color: hsl(var(--bg-color)) !important;
            color: hsl(var(--text-color)) !important;
        }

        /* Additional styling for better cross-browser support */
        select.form-control.form--control::-ms-expand {
            display: none;
        }

        /* Custom dropdown arrow */
        select.form-control.form--control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 35px;
        }
    </style>
@endpush

@push('script')
<script>
$(document).ready(function() {
    // Initialize Select2 for Government ID Type dropdown
    $('select[name="government_id_type"]').select2({
        theme: 'default',
        width: '100%',
        placeholder: 'Select ID Type'
    });
});
</script>
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
