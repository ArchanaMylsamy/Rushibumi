@extends('admin.layouts.app')
@section('panel')
@push('topBar')
  @include('admin.notification.top_bar')
@endpush
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Sms Send Method')</label>
                            <select name="sms_method" class="select2 form-control"  data-minimum-results-for-search="-1">
                                @php
                                    $smsConfig = gs('sms_config');
                                    $currentMethod = is_object($smsConfig) && isset($smsConfig->name) ? $smsConfig->name : 'clickatell';
                                @endphp
                                <option value="clickatell" @if($currentMethod == 'clickatell') selected @endif>@lang('Clickatell')</option>
                                <option value="infobip" @if($currentMethod == 'infobip') selected @endif>@lang('Infobip')</option>
                                <option value="messageBird" @if($currentMethod == 'messageBird') selected @endif>@lang('Message Bird')</option>
                                <option value="nexmo" @if($currentMethod == 'nexmo') selected @endif>@lang('Nexmo')</option>
                                <option value="smsBroadcast" @if($currentMethod == 'smsBroadcast') selected @endif>@lang('Sms Broadcast')</option>
                                <option value="twilio" @if($currentMethod == 'twilio') selected @endif>@lang('Twilio')</option>
                                <option value="textMagic" @if($currentMethod == 'textMagic') selected @endif>@lang('Text Magic')</option>
                                <option value="custom" @if($currentMethod == 'custom') selected @endif>@lang('Custom API')</option>
                            </select>
                        </div>
                        <div class="row mt-4 d-none configForm" id="clickatell">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Clickatell Configuration')</h6>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('API Key') </label>
                                    <input type="text" class="form-control" placeholder="@lang('API Key')" name="clickatell_api_key" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->clickatell) && isset(gs('sms_config')->clickatell->api_key) ? gs('sms_config')->clickatell->api_key : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="infobip">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Infobip Configuration')</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Username') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Username')" name="infobip_username" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->infobip) && isset(gs('sms_config')->infobip->username) ? gs('sms_config')->infobip->username : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Password') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Password')" name="infobip_password" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->infobip) && isset(gs('sms_config')->infobip->password) ? gs('sms_config')->infobip->password : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="messageBird">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Message Bird Configuration')</h6>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('API Key') </label>
                                    <input type="text" class="form-control" placeholder="@lang('API Key')" name="message_bird_api_key" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->message_bird) && isset(gs('sms_config')->message_bird->api_key) ? gs('sms_config')->message_bird->api_key : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="nexmo">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Nexmo Configuration')</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('API Key') </label>
                                    <input type="text" class="form-control" placeholder="@lang('API Key')" name="nexmo_api_key" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->nexmo) && isset(gs('sms_config')->nexmo->api_key) ? gs('sms_config')->nexmo->api_key : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('API Secret') </label>
                                    <input type="text" class="form-control" placeholder="@lang('API Secret')" name="nexmo_api_secret" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->nexmo) && isset(gs('sms_config')->nexmo->api_secret) ? gs('sms_config')->nexmo->api_secret : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="smsBroadcast">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Sms Broadcast Configuration')</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Username') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Username')" name="sms_broadcast_username" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->sms_broadcast) && isset(gs('sms_config')->sms_broadcast->username) ? gs('sms_config')->sms_broadcast->username : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Password') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Password')" name="sms_broadcast_password" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->sms_broadcast) && isset(gs('sms_config')->sms_broadcast->password) ? gs('sms_config')->sms_broadcast->password : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="twilio">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Twilio Configuration')</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Account SID') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Account SID')" name="account_sid" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->twilio) && isset(gs('sms_config')->twilio->account_sid) ? gs('sms_config')->twilio->account_sid : '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Auth Token') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Auth Token')" name="auth_token" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->twilio) && isset(gs('sms_config')->twilio->auth_token) ? gs('sms_config')->twilio->auth_token : '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('From Number') </label>
                                    <input type="text" class="form-control" placeholder="@lang('From Number')" name="from" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->twilio) && isset(gs('sms_config')->twilio->from) ? gs('sms_config')->twilio->from : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="textMagic">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Text Magic Configuration')</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Username') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Username')" name="text_magic_username" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->text_magic) && isset(gs('sms_config')->text_magic->username) ? gs('sms_config')->text_magic->username : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Apiv2 Key') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Apiv2 Key')" name="apiv2_key" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->text_magic) && isset(gs('sms_config')->text_magic->apiv2_key) ? gs('sms_config')->text_magic->apiv2_key : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="custom">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Custom API')</h6>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('API URL') </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <select name="custom_api_method" class="method-select">
                                                <option value="get">@lang('GET')</option>
                                                <option value="post">@lang('POST')</option>
                                            </select>
                                        </span>
                                        <input type="text" class="form-control" name="custom_api_url" value="{{ is_object(gs('sms_config')) && isset(gs('sms_config')->custom) && isset(gs('sms_config')->custom->url) ? gs('sms_config')->custom->url : '' }}" placeholder="@lang('API URL')">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-responsive--sm mb-3">
                                        <table class=" table align-items-center table--light">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Short Code') </th>
                                                    <th>@lang('Description')</th>
                                                </tr>
                                            </thead>
                                            {{-- blade-formatter-disable --}}
                                            <tbody class="list">
                                                <tr>
                                                    <td><span class="short-codes">@{{message}}</span></td>
                                                    <td>@lang('Message')</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="short-codes">@{{number}}</span></td>
                                                    <td>@lang('Number')</td>
                                                </tr>
                                            </tbody>
                                            {{-- blade-formatter-enable --}}
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border--dark mb-3">
                                        <div class="card-header bg--dark d-flex justify-content-between">
                                            <h5 class="text-white">@lang('Headers')</h5>
                                            <button type="button" class="btn btn-sm btn-outline-light float-right addHeader"><i class="la la-fw la-plus"></i>@lang('Add') </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="headerFields">
                                                @php
                                                    $smsConfig = gs('sms_config');
                                                    $headerNames = [];
                                                    $headerValues = [];
                                                    
                                                    if (is_object($smsConfig) && isset($smsConfig->custom) && isset($smsConfig->custom->headers)) {
                                                        $headers = $smsConfig->custom->headers;
                                                        if (isset($headers->name) && is_array($headers->name)) {
                                                            $headerNames = $headers->name;
                                                        }
                                                        if (isset($headers->value) && is_array($headers->value)) {
                                                            $headerValues = $headers->value;
                                                        }
                                                    }
                                                    
                                                    $headerCount = max(count($headerNames), count($headerValues));
                                                @endphp
                                                @for($i = 0; $i < $headerCount; $i++)
                                                    <div class="row mt-3">
                                                        <div class="col-md-5">
                                                            <input type="text" name="custom_header_name[]" class="form-control" value="{{ isset($headerNames[$i]) ? $headerNames[$i] : '' }}" placeholder="@lang('Headers Name')">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" name="custom_header_value[]" class="form-control" value="{{ isset($headerValues[$i]) ? $headerValues[$i] : '' }}" placeholder="@lang('Headers Value')">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn--danger btn-block removeHeader h-100"><i class="las la-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border--dark mb-3">
                                        <div class="card-header bg--dark d-flex justify-content-between">
                                            <h5 class="text-white">@lang('Body')</h5>
                                            <button type="button" class="btn btn-sm btn-outline-light float-right addBody"><i class="la la-fw la-plus"></i>@lang('Add') </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="bodyFields">
                                                @php
                                                    $smsConfig = gs('sms_config');
                                                    $bodyNames = [];
                                                    $bodyValues = [];
                                                    
                                                    if (is_object($smsConfig) && isset($smsConfig->custom) && isset($smsConfig->custom->body)) {
                                                        $body = $smsConfig->custom->body;
                                                        if (isset($body->name) && is_array($body->name)) {
                                                            $bodyNames = $body->name;
                                                        }
                                                        if (isset($body->value) && is_array($body->value)) {
                                                            $bodyValues = $body->value;
                                                        }
                                                    }
                                                    
                                                    $bodyCount = max(count($bodyNames), count($bodyValues));
                                                @endphp
                                                @for($i = 0; $i < $bodyCount; $i++)
                                                    <div class="row mt-3">
                                                        <div class="col-md-5">
                                                            <input type="text" name="custom_body_name[]" class="form-control" value="{{ isset($bodyNames[$i]) ? $bodyNames[$i] : '' }}" placeholder="@lang('Body Name')">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" name="custom_body_value[]" value="{{ isset($bodyValues[$i]) ? $bodyValues[$i] : '' }}" class="form-control" placeholder="@lang('Body Value')">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn--danger btn-block removeBody h-100"><i class="las la-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn w-100 h-45 btn--primary">@lang('Submit')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>


    </div>


    {{-- TEST MAIL MODAL --}}
    <div id="testSMSModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Test SMS Setup')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.setting.notification.sms.test') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Sent to') </label>
                                    <input type="text" name="mobile" class="form-control" placeholder="@lang('Mobile')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <button type="button" data-bs-target="#testSMSModal" data-bs-toggle="modal" class="btn btn-outline--primary btn-sm"> <i class="las la-paper-plane"></i> @lang('Send Test SMS')</button>
@endpush


@push('style')
<style>
    .method-select{
        padding: 2px 7px;
    }
</style>
@endpush


@push('script')
    <script>
        (function ($) {
            "use strict";



            @php
                $smsConfig = gs('sms_config');
                $method = is_object($smsConfig) && isset($smsConfig->name) ? $smsConfig->name : 'clickatell';
            @endphp
            var method = '{{ $method }}';

            if (!method) {
                method = 'clickatell';
            }

            smsMethod(method);
            $('select[name=sms_method]').on('change', function() {
                var method = $(this).val();
                smsMethod(method);
            });

            function smsMethod(method){
                $('.configForm').addClass('d-none');
                if(method != 'php') {
                    $(`#${method}`).removeClass('d-none');
                }
            }

            $('.addHeader').on('click',function(){
                var html = `
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <input type="text" name="custom_header_name[]" class="form-control" placeholder="@lang('Headers Name')">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="custom_header_value[]" class="form-control" placeholder="@lang('Headers Value')">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn--danger btn-block removeHeader h-100"><i class="las la-times"></i></button>
                        </div>
                    </div>
                `;
                $('.headerFields').append(html);

            })
            $(document).on('click','.removeHeader',function(){
                $(this).closest('.row').remove();
            })

            $('.addBody').on('click',function(){
                var html = `
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <input type="text" name="custom_body_name[]" class="form-control" placeholder="@lang('Body Name')">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="custom_body_value[]" class="form-control" placeholder="@lang('Body Value')">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn--danger btn-block removeBody h-100"><i class="las la-times"></i></button>
                        </div>
                    </div>
                `;
                $('.bodyFields').append(html);

            })
            $(document).on('click','.removeBody',function(){
                $(this).closest('.row').remove();
            })

            @php
                $smsConfig = gs('sms_config');
                $customMethod = '';
                if (is_object($smsConfig) && isset($smsConfig->custom) && isset($smsConfig->custom->method)) {
                    $customMethod = $smsConfig->custom->method;
                }
            @endphp
            $('select[name=custom_api_method]').val('{{ $customMethod }}');

        })(jQuery);

    </script>
@endpush
