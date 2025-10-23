@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <form method="POST">
            @csrf
            <div class="col-lg-12 col-md-12 mb-30">


                <div class="row">
                    <div class="col-md-4">



                        <div class="card mt-30">
                            <div class="card-header">
                                <h5>@lang('Ads Shows')</h5>
                            </div>
                            <div class="card-body">

                                <div class="form-group ">
                                    <label> @lang('Minute')</label> <span title="@lang('Ad view in every minute')"><i class="las la-info-circle"></i></span>
                                    <div class="input-group">
                                        <input class="form-control" name="per_minute" type="number"  value="{{ gs('ad_config')->per_minute }}" required>
                                        <span class="input-group-text"><i class="las la-clock"></i></span>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label> @lang('Ad Views')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="ad_views" type="number" step="any" value="{{ gs('ad_config')->ad_views }}" required>
                                        <span class="input-group-text"><i class="las la-eye"></i></span>
                                    </div>

                                </div>
                            </div>
                        </div>


                    
                    </div>
                    <div class="col-md-4">
                        <div class="card mt-30">
                            <div class="card-header">
                                <h5>@lang('Ads Pricing')</h5>
                            </div>

                            <div class="card-body">
                            
                                <div class="form-group ">
                                    <label> @lang('Spent Per Click')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('Per Click')</span>
                                        <input class="form-control" name="per_click_spent" type="number" step="any" value="{{ getAmount(gs('per_click_spent')) }}" required>
                                        <span class="input-group-text">{{__(gs('cur_text'))}}</span>
                                    </div>
                                </div>

                                    <div class="form-group ">
                                    <label> @lang('Spent Per Impression')</label>
                                        <div class="input-group">
                                        <span class="input-group-text">@lang('Per Impression')</span>
                                            <input class="form-control" name="per_impression_spent" type="number" step="any" value="{{ getAmount(gs('per_impression_spent')) }}" required>
                                            <span class="input-group-text">{{__(gs('cur_text'))}}</span>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mt-30">
                            <div class="card-header">
                                <h5>@lang('Earn form Ads')</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group ">
                                    <label> @lang('Earn Per Click')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@lang('Per Click')</span>
                                        <input class="form-control" name="per_click_earn" type="number" step="any" value="{{ getAmount(gs('per_click_spent')) }}" required>
                                        <span class="input-group-text">{{__(gs('cur_text'))}}</span>
                                    </div>
                                </div>

                                    <div class="form-group ">
                                        <label> @lang('Earn Per Impression')</label>
                                        <div class="input-group">
                                        <span class="input-group-text">@lang('Per Impression')</span>
                                            <input class="form-control" name="per_impression_earn" type="number" step="any" value="{{ getAmount(gs('per_impression_spent')) }}" required>
                                            <span class="input-group-text">{{__(gs('cur_text'))}}</span>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="form-group mt-3">
                    <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                </div>
        </form>
    </div>
@endsection


@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/spectrum.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";


            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });
        })(jQuery);
    </script>
@endpush
