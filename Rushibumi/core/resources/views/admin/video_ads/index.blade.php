@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between align-items-center flex-wrap gap-2">
                        <h4>@lang('Video Ads Management')</h4>
                        <a href="{{ route('admin.video_ads.create') }}" class="btn btn--primary">
                            <i class="las la-plus"></i> @lang('Add New Video Ad')
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Thumbnail')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Ad Type')</th>
                                    <th>@lang('Skip After')</th>
                                    <th>@lang('Plays')</th>
                                    <th>@lang('Clicks')</th>
                                    <th>@lang('Impressions')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($videoAds as $videoAd)
                                    <tr>
                                        <td>
                                            @if($videoAd->thumbnail)
                                                <img src="{{ getImage(getFilePath('thumbnail') . '/thumb_' . $videoAd->thumbnail) }}" 
                                                     alt="{{ $videoAd->title }}" 
                                                     style="width: 80px; height: 45px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">--</span>
                                            @endif
                                        </td>
                                        <td>{{ __($videoAd->title) }}</td>
                                        <td>
                                            @if($videoAd->ad_type == 1)
                                                <span class="badge badge--info">@lang('Pre-Roll')</span>
                                            @elseif($videoAd->ad_type == 2)
                                                <span class="badge badge--warning">@lang('Mid-Roll')</span>
                                            @else
                                                <span class="badge badge--success">@lang('Post-Roll')</span>
                                            @endif
                                        </td>
                                        <td>{{ $videoAd->skip_after }}s</td>
                                        <td>{{ formatNumber($videoAd->plays) }}</td>
                                        <td>{{ formatNumber($videoAd->clicks) }}</td>
                                        <td>{{ formatNumber($videoAd->impressions) }}</td>
                                        <td>
                                            @if($videoAd->status == Status::ENABLE)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.video_ads.edit', $videoAd->id) }}">
                                                    <i class="las la-pencil-alt"></i> @lang('Edit')
                                                </a>
                                                <button class="btn btn-sm btn-outline--{{ $videoAd->status == Status::ENABLE ? 'danger' : 'success' }} confirmationBtn" 
                                                        data-action="{{ route('admin.video_ads.status', $videoAd->id) }}" 
                                                        data-question="@lang('Are you sure you want to change the status?')">
                                                    <i class="las la-{{ $videoAd->status == Status::ENABLE ? 'ban' : 'check' }}"></i> 
                                                    @lang($videoAd->status == Status::ENABLE ? 'Deactivate' : 'Activate')
                                                </button>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" 
                                                        data-action="{{ route('admin.video_ads.delete', $videoAd->id) }}" 
                                                        data-question="@lang('Are you sure you want to delete this ad?')">
                                                    <i class="las la-trash"></i> @lang('Delete')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? 'No video ads found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($videoAds->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($videoAds) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection
