<div class="upload-visibility">
                <form class="upload-visibility__form" action="{{ route('user.' . $action . '.visibility.submit', $video->id) }}"
          method="post">
        @csrf
        <div class="form-group select2-parent">
            <label class="form--label">@lang('Category')</label>
            <select class="select form--control select2-basic" name="category" id="video_category" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($video->category_id == $category->id ?? request()->category == $category->id) selected @endif>
                        {{ __($category->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group select2-parent">
            <label class="form--label">@lang('Tags') <small class="text-muted">(@lang('Subject-based sequential tags will be suggested'))</small></label>
            <select class="form--control select2-auto-tokenize" name="tags[]" id="video_tags" required multiple>
                @foreach (old('tags', $video->tags) ?? [] as $videoTag)
                    <option value="{{ $videoTag->tag }}" selected>{{ $videoTag->tag }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">@lang('Tags are suggested based on your previous videos and category subject')</small>
        </div>
        <div class="form-group">
            <label class="form--label">@lang('Visibility')</label>
            <div class="check-type-wrapper">
                <label for="public" class="check-type check-type-primary">
                    <input class="check-type-input" type="radio" value="0" name="visibility" id="public"
                           @if ($video->visibility == 0 ?? request()->visibility == 0) checked @endif>

                    <span class="check-type-icon">
                        <svg class="check-circle" width="13" height="10" viewBox="0 0 13 10" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 5L4.5 8.5L12.5 0.5" stroke="currentColor" stroke-linecap="round" class="check">
                            </path>
                        </svg>
                    </span>
                    <span class="check-type-label">@lang('Public')</span>
                </label>

                <label for="private" class="check-type check-type-success">
                    <input class="check-type-input" type="radio" value="1" name="visibility" id="private"
                           @if ($video->visibility == 1 ?? request()->visibility == 1) checked @endif>

                    <span class="check-type-icon">
                        <svg class="check-circle" width="13" height="10" viewBox="0 0 13 10" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 5L4.5 8.5L12.5 0.5" stroke="currentColor" stroke-linecap="round" class="check">
                            </path>
                        </svg>
                    </span>
                    <span class="check-type-label">@lang('Private')</span>
                </label>
            </div>

        </div>
        <div class="form-group upload-buttons mb-0">
            @if (@$video->is_shorts_video)
                <a class="btn btn--dark" href="{{ route('user.shorts.details.form', @$video->id) }}">@lang('Previous') </a>
            @else
                <a class="btn btn--dark" href="{{ route('user.video.elements.form', @$video->id) }}">@lang('Previous')</a>
            @endif
            <button class="btn btn--base" type="submit">@lang('Publish')</button>
        </div>
    </form>
</div>

@push('style')
    <style>
        .select2-container .select2-selection--single {
            line-height: 28px !important;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable:first-child {
            border-radius: 5px 5px 0 0 !important;
        }

        .select2-results {
            border-radius: 5px;
            overflow: hidden;
        }
        .select2-container--default .select2-selection--multiple {
            min-height: 41px !important;
            height: unset !important;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            const tagsField = $('#video_tags');
            const categoryField = $('#video_category');
            const videoId = {{ $video->id ?? 0 }};
            
            // Initialize Select2 for tags
            tagsField.select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: '@lang('Enter tags based on content subject...')',
                ajax: {
                    url: "{{ route('user.video.fatch.tags') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page,
                            rows: 20,
                            category_id: categoryField.val(), // Pass category for subject-based suggestions
                            video_id: videoId
                        };
                    },
                    processResults: function(response, params) {
                        params.page = params.page || 1;
                        
                        // Format results with type indicators
                        const formattedResults = response.map(function(item) {
                            let text = item.text;
                            // Add indicator for sequential tags
                            if (item.type === 'user_sequential') {
                                text += ' (Your frequent)';
                            } else if (item.type === 'category_based') {
                                text += ' (Category-based)';
                            }
                            return {
                                id: item.id,
                                text: text,
                                subject: item.subject || ''
                            };
                        });
                        
                        return {
                            results: formattedResults,
                            pagination: {
                                more: params.page < response.length
                            }
                        };
                    },
                    cache: false
                },
                dropdownParent: tagsField.parent(),
                closeOnSelect: false, // Allow multiple selections
                minimumInputLength: 0 // Show suggestions even without typing
            });
            
            // When category changes, refresh tag suggestions
            categoryField.on('change', function() {
                // Trigger tag field to reload suggestions
                tagsField.val(null).trigger('change');
            });
            
            // Show suggestions on focus
            tagsField.on('select2:open', function() {
                // Trigger search with empty term to show all suggestions
                $(this).data('select2').dropdown.$search.val('').trigger('input');
            });
        });
    </script>
@endpush
