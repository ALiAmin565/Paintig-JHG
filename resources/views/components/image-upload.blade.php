@props([
    'name' => 'photo',
    'id' => 'photo',
    'currentImage' => null,
    'required' => false,
    'maxSize' => '5MB',
    'accept' => 'image/jpeg,image/png,image/webp'
])

<div class="image-upload" data-image-upload>
    <!-- Hidden File Input -->
    <input 
        type="file" 
        name="{{ $name }}" 
        id="{{ $id }}" 
        accept="{{ $accept }}"
        class="image-upload__input"
        @if($required) required @endif
        data-image-input
        style="display: none;"
    >

    <!-- Upload Area -->
    <div class="image-upload__dropzone" data-dropzone>
        <div class="image-upload__content" data-upload-content>
            <div class="image-upload__icon">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <div class="image-upload__text">
                <p class="image-upload__primary-text">
                    Drop an image here or 
                    <button type="button" class="image-upload__browse-btn" data-browse-btn>browse</button>
                </p>
                <p class="image-upload__secondary-text">
                    You can also paste an image from clipboard (Ctrl+V)
                </p>
                <p class="image-upload__info">
                    JPEG, PNG, or WebP — max {{ $maxSize }}
                </p>
            </div>
        </div>

        <!-- Preview Area (Initially Hidden) -->
        <div class="image-upload__preview hidden" data-preview-area>
            <div class="image-upload__preview-container">
                <img src="" alt="Preview" class="image-upload__preview-image" data-preview-image>
                <div class="image-upload__preview-overlay">
                    <div class="image-upload__preview-actions">
                        <button type="button" class="image-upload__action-btn image-upload__action-btn--change" 
                                data-change-btn title="Change Image">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                </path>
                            </svg>
                        </button>
                        <button type="button" class="image-upload__action-btn image-upload__action-btn--delete" 
                                data-delete-btn title="Remove Image">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="image-upload__preview-info">
                <p class="image-upload__preview-filename" data-preview-filename></p>
                <p class="image-upload__preview-size" data-preview-size></p>
            </div>
        </div>
    </div>

    <!-- Error Message -->
    @error($name)
        <p class="image-upload__error">{{ $message }}</p>
    @enderror

    <!-- Loading State -->
    <div class="image-upload__loading hidden" data-loading>
        <div class="image-upload__spinner"></div>
        <p class="image-upload__loading-text">Processing image...</p>
    </div>
</div>

@if($currentImage)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadComponent = document.querySelector('[data-image-upload]');
            if (uploadComponent) {
                // Show existing image
                const previewImage = uploadComponent.querySelector('[data-preview-image]');
                const previewArea = uploadComponent.querySelector('[data-preview-area]');
                const uploadContent = uploadComponent.querySelector('[data-upload-content]');
                
                if (previewImage && previewArea && uploadContent) {
                    previewImage.src = '{{ $currentImage }}';
                    previewArea.classList.remove('hidden');
                    uploadContent.classList.add('hidden');
                }
            }
        });
    </script>
@endif