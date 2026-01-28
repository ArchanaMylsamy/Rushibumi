@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between align-items-center flex-wrap gap-2">
                        <h4>@lang('Feed Ads Management')</h4>
                        <a href="{{ route('admin.feed_ads.create') }}" class="btn btn--primary">
                            <i class="las la-plus"></i> @lang('Add New Ad')
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Position')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Clicks')</th>
                                    <th>@lang('Impressions')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedAds as $feedAd)
                                    <tr>
                                        <td>
                                            @if($feedAd->image)
                                                <img src="{{ getImage(getFilePath('thumbnail') . '/thumb_' . $feedAd->image) }}" 
                                                     alt="{{ $feedAd->title }}" 
                                                     style="width: 80px; height: 45px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">--</span>
                                            @endif
                                        </td>
                                        <td>{{ __($feedAd->title) }}</td>
                                        <td>
                                            @if($feedAd->ad_type == 1)
                                                <span class="badge badge--info">@lang('Image')</span>
                                            @elseif($feedAd->ad_type == 2)
                                                <span class="badge badge--success">@lang('GIF')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('Video')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($feedAd->position == 1)
                                                <span class="badge badge--primary">@lang('Feed')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('Top')</span>
                                            @endif
                                        </td>
                                        <td>{{ $feedAd->priority }}</td>
                                        <td>{{ formatNumber($feedAd->clicks) }}</td>
                                        <td>{{ formatNumber($feedAd->impressions) }}</td>
                                        <td>
                                            @if($feedAd->status == Status::ENABLE)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.feed_ads.edit', $feedAd->id) }}">
                                                    <i class="las la-pencil-alt"></i> @lang('Edit')
                                                </a>
                                                <button class="btn btn-sm btn-outline--{{ $feedAd->status == Status::ENABLE ? 'danger' : 'success' }} confirmationBtn" 
                                                        data-action="{{ route('admin.feed_ads.status', $feedAd->id) }}" 
                                                        data-question="@lang('Are you sure you want to change the status?')">
                                                    <i class="las la-{{ $feedAd->status == Status::ENABLE ? 'ban' : 'check' }}"></i> 
                                                    @lang($feedAd->status == Status::ENABLE ? 'Deactivate' : 'Activate')
                                                </button>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" 
                                                        data-action="{{ route('admin.feed_ads.delete', $feedAd->id) }}" 
                                                        data-question="@lang('Are you sure you want to delete this ad?')">
                                                    <i class="las la-trash"></i> @lang('Delete')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? 'No feed ads found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($feedAds->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($feedAds) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection
