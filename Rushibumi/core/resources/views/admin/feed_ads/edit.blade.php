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
                                        @lang('Leave empty to keep current image')<br>
                                        <strong id="top-banner-requirement-edit" style="display: none; color: #dc3545;">
                                            @lang('⚠️ REQUIRED for Top Banner:') 728x90px (Standard Leaderboard Banner Size)
                                        </strong>
                                        <span id="feed-banner-note-edit">@lang('Recommended: 728x90px for banners, or square/rectangular for feed ads')</span>
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
                                    <label>@lang('Position') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="position" id="position_edit" required>
                                        <option value="1" {{ old('position', $feedAd->position) == 1 ? 'selected' : '' }}>@lang('Feed')</option>
                                        <option value="2" {{ old('position', $feedAd->position) == 2 ? 'selected' : '' }}>@lang('Top')</option>
                                    </select>
                                    <small class="form-text text-muted">
                                        @lang('Feed: appears in video feed | Top: appears at top banner (728x90px required)')
                                    </small>
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

@push('script')
<script>
    // Show/hide top banner requirement based on position
    function toggleTopBannerRequirement() {
        const position = document.getElementById('position_edit').value;
        const requirement = document.getElementById('top-banner-requirement-edit');
        const feedNote = document.getElementById('feed-banner-note-edit');
        
        if (position == '2') {
            // Top banner selected
            if (requirement) requirement.style.display = 'block';
            if (feedNote) feedNote.style.display = 'none';
        } else {
            // Feed selected
            if (requirement) requirement.style.display = 'none';
            if (feedNote) feedNote.style.display = 'inline';
        }
    }
    
    // Check image dimensions when file is selected
    function validateImageDimensions(input) {
        if (!input.files || !input.files[0]) return;
        
        const position = document.getElementById('position_edit').value;
        if (position != '2') return; // Only validate for top banner
        
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const width = img.width;
                const height = img.height;
                
                if (width !== 728 || height !== 90) {
                    alert('⚠️ Top Banner requires exactly 728x90px!\n\nYour image is: ' + width + 'x' + height + 'px\n\nPlease resize your image to 728x90px before uploading.');
                    input.value = ''; // Clear the input
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
    
    $(document).ready(function() {
        // Initial check
        toggleTopBannerRequirement();
        
        // Watch for position changes
        $('#position_edit').on('change', function() {
            toggleTopBannerRequirement();
        });
        
        // Watch for image file selection
        $(document).on('change', 'input[name="image"]', function() {
            validateImageDimensions(this);
        });
    });
</script>
@endpush

