@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">@lang('Edit Feed Ad')</h5>
                    <form action="{{ route('admin.feed_ads.update', $feedAd->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Title') <span class="text--danger">*</span></label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $feedAd->title) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Ad Type') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="ad_type" id="ad_type" required>
                                        <option value="1" {{ old('ad_type', $feedAd->ad_type) == 1 ? 'selected' : '' }}>@lang('Image')</option>
                                        <option value="2" {{ old('ad_type', $feedAd->ad_type) == 2 ? 'selected' : '' }}>@lang('GIF')</option>
                                    </select>
                                    <small class="form-text text-muted">@lang('Note: Video ads are managed separately in Video Ads section')</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Ad Image/GIF')</label>
                                    <x-image-uploader class="w-100" name="image" 
                                                      type="thumbnail"
                                                      :imagePath="getImage(getFilePath('thumbnail') . '/thumb_' . $feedAd->image)" 
                                                      :required="false" />
                                    <small class="form-text text-muted">
                                        @lang('Leave empty to keep current image')
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Click URL')</label>
                                    <input type="url" class="form-control" name="url" value="{{ old('url', $feedAd->url) }}" placeholder="https://example.com">
                                    <small class="form-text text-muted">@lang('URL to redirect when ad is clicked (optional)')</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Status') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="status" required>
                                        <option value="1" {{ old('status', $feedAd->status) == 1 ? 'selected' : '' }}>@lang('Active')</option>
                                        <option value="0" {{ old('status', $feedAd->status) == 0 ? 'selected' : '' }}>@lang('Inactive')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <strong>@lang('Statistics:')</strong><br>
                                    @lang('Clicks'): {{ formatNumber($feedAd->clicks) }}<br>
                                    @lang('Impressions'): {{ formatNumber($feedAd->impressions) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn--primary w-100">@lang('Update Ad')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

