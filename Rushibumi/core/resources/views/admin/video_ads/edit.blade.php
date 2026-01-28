@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">@lang('Edit Video Ad')</h5>
                    <form action="{{ route('admin.video_ads.update', $videoAd->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Title') <span class="text--danger">*</span></label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $videoAd->title) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Ad Type') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="ad_type" required>
                                        <option value="1" {{ old('ad_type', $videoAd->ad_type) == 1 ? 'selected' : '' }}>@lang('Pre-Roll') (Before Video)</option>
                                        <option value="2" {{ old('ad_type', $videoAd->ad_type) == 2 ? 'selected' : '' }}>@lang('Mid-Roll') (During Video)</option>
                                        <option value="3" {{ old('ad_type', $videoAd->ad_type) == 3 ? 'selected' : '' }}>@lang('Post-Roll') (After Video)</option>
                                    </select>
                                    <small class="form-text text-muted">@lang('When the ad should play during video playback')</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Skip After (seconds)')</label>
                                    <input type="number" class="form-control" name="skip_after" value="{{ old('skip_after', $videoAd->skip_after) }}" min="0" max="30">
                                    <small class="form-text text-muted">@lang('Seconds before skip button appears (0 = no skip)')</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Video File')</label>
                                    @if($videoAd->video)
                                        <div class="mb-2">
                                            <small class="text-muted">@lang('Current Video'): {{ $videoAd->video }}</small>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" name="video" accept="video/*">
                                    <small class="form-text text-muted">@lang('Upload a new video file to replace current one (optional)')</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Thumbnail (Optional)')</label>
                                    <x-image-uploader class="w-100" name="thumbnail" 
                                                      type="thumbnail"
                                                      :imagePath="$videoAd->thumbnail ? getImage(getFilePath('thumbnail') . '/thumb_' . $videoAd->thumbnail) : null" 
                                                      :required="false" />
                                    <small class="form-text text-muted">@lang('Upload a thumbnail image for the video (optional)')</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Click URL')</label>
                                    <input type="url" class="form-control" name="url" value="{{ old('url', $videoAd->url) }}" placeholder="https://example.com">
                                    <small class="form-text text-muted">@lang('URL to redirect when ad is clicked (optional)')</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Status') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="status" required>
                                        <option value="1" {{ old('status', $videoAd->status) == 1 ? 'selected' : '' }}>@lang('Active')</option>
                                        <option value="0" {{ old('status', $videoAd->status) == 0 ? 'selected' : '' }}>@lang('Inactive')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <strong>@lang('Statistics:')</strong><br>
                                    @lang('Plays'): {{ formatNumber($videoAd->plays) }}<br>
                                    @lang('Clicks'): {{ formatNumber($videoAd->clicks) }}<br>
                                    @lang('Impressions'): {{ formatNumber($videoAd->impressions) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn--primary w-100">@lang('Update Video Ad')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
