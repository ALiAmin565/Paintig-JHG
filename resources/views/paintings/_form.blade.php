@props(['painting' => null, 'hotels', 'selectedHotelId' => null])

@php
    $locationType = old('location_type', $painting?->location_type ?? 'none');
    $certificateType = old('certificate_type', $painting?->certificate_type ?? 'text');
    $purchasedFromType = old('purchased_from_type', $painting?->purchased_from_type ?? 'person');
@endphp

<div class="painting-form">
    <p class="form-required-note"><x-required-mark /> Required field</p>

    {{-- Photo --}}
    <section class="painting-form__section">
        <h2 class="painting-form__section-title">Photo</h2>
        <div class="painting-form__field">
            @if($painting?->photoUrl())
                <img src="{{ $painting->photoUrl() }}" alt="{{ $painting->title }}" class="painting-form__photo-preview">
            @endif
            <label for="photo" class="painting-form__label">Upload Image @if(!$painting)<x-required-mark />@endif</label>
            <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/webp"
                class="painting-form__photo-upload"
                @if(!$painting) required @endif>
            <p class="text-xs text-gray-500 mt-1.5">JPEG, PNG, or WebP — max 5 MB</p>
            @error('photo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </section>

    {{-- Details --}}
    <section class="painting-form__section">
        <h2 class="painting-form__section-title">Details</h2>
        <div class="painting-form__grid">
            <div class="painting-form__field painting-form__field--full">
                <label for="title" class="painting-form__label">Title <x-required-mark /></label>
                <input type="text" name="title" id="title" value="{{ old('title', $painting?->title) }}"
                    class="painting-form__input" required>
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="painting-form__field">
                <label for="painter_name" class="painting-form__label">Painter Name <x-required-mark /></label>
                <input type="text" name="painter_name" id="painter_name" value="{{ old('painter_name', $painting?->painter_name) }}"
                    class="painting-form__input" required>
                @error('painter_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="painting-form__field">
                <label for="media" class="painting-form__label">Media <x-required-mark /></label>
                <input type="text" name="media" id="media" value="{{ old('media', $painting?->media) }}"
                    placeholder="e.g. Oil on canvas"
                    class="painting-form__input" required>
                @error('media')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="painting-form__field">
                <label for="production_year" class="painting-form__label">Production Year <x-required-mark /></label>
                <input type="number" name="production_year" id="production_year" min="1000" max="{{ date('Y') }}"
                    value="{{ old('production_year', $painting?->production_year) }}"
                    class="painting-form__input" required>
                @error('production_year')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="painting-form__price-row">
                <div class="painting-form__field painting-form__field--price">
                    <label for="price" class="painting-form__label">Price <x-required-mark /></label>
                    <input type="number" name="price" id="price" step="0.01" min="0"
                        value="{{ old('price', $painting?->price) }}"
                        class="painting-form__input" required>
                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="painting-form__field painting-form__field--currency">
                    <label for="currency" class="painting-form__label">Currency <x-required-mark /></label>
                    <select name="currency" id="currency" class="painting-form__input" required>
                        @foreach(\App\Http\Requests\PaintingRequestRules::CURRENCIES as $currency)
                            <option value="{{ $currency }}" @selected(old('currency', $painting?->currency ?? 'USD') === $currency)>{{ $currency }}</option>
                        @endforeach
                    </select>
                    @error('currency')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </section>

    {{-- Dimensions --}}
    <section class="painting-form__section">
        <h2 class="painting-form__section-title">Dimensions (cm)</h2>
        <p class="text-xs text-gray-500 mb-4">Optional — fill with frame, without frame, both, or leave blank.</p>
        <div class="painting-form__dimensions">
            <div class="painting-form__dimension-group">
                <p class="painting-form__dimension-title">With Frame</p>
                <div class="painting-form__dimension-fields">
                    <div>
                        <label for="width_with_frame" class="painting-form__label">Width</label>
                        <input type="number" name="width_with_frame" id="width_with_frame" step="0.01" min="0" max="999999.99"
                            value="{{ old('width_with_frame', $painting?->width_with_frame) }}"
                            class="painting-form__input">
                        @error('width_with_frame')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="height_with_frame" class="painting-form__label">Height</label>
                        <input type="number" name="height_with_frame" id="height_with_frame" step="0.01" min="0" max="999999.99"
                            value="{{ old('height_with_frame', $painting?->height_with_frame) }}"
                            class="painting-form__input">
                        @error('height_with_frame')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="painting-form__dimension-group">
                <p class="painting-form__dimension-title">Without Frame</p>
                <div class="painting-form__dimension-fields">
                    <div>
                        <label for="width_without_frame" class="painting-form__label">Width</label>
                        <input type="number" name="width_without_frame" id="width_without_frame" step="0.01" min="0" max="999999.99"
                            value="{{ old('width_without_frame', $painting?->width_without_frame) }}"
                            class="painting-form__input">
                        @error('width_without_frame')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="height_without_frame" class="painting-form__label">Height</label>
                        <input type="number" name="height_without_frame" id="height_without_frame" step="0.01" min="0" max="999999.99"
                            value="{{ old('height_without_frame', $painting?->height_without_frame) }}"
                            class="painting-form__input">
                        @error('height_without_frame')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Location --}}
    <section class="painting-form__section">
        <h2 class="painting-form__section-title">Location <x-required-mark /></h2>
        <div class="painting-form__pills">
            @foreach(['hotel' => 'Hotel', 'location' => 'Other Location', 'none' => 'N/A'] as $value => $label)
                <label @class([
                    'painting-form__pill',
                    'painting-form__pill--active' => $locationType === $value,
                    'painting-form__pill--inactive' => $locationType !== $value,
                ])>
                    <input type="radio" name="location_type" value="{{ $value }}" data-location-type
                        @checked($locationType === $value) class="sr-only">
                    {{ $label }}
                </label>
            @endforeach
        </div>
        @error('location_type')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror

        <div data-location-section="hotel" @class(['hidden' => $locationType !== 'hotel'])>
            @php
                $selectedHotelId = old('hotel_id', $painting?->hotel_id ?? $selectedHotelId);
                $selectedHotelLabel = null;
                if ($selectedHotelId) {
                    $selectedHotel = $hotels->firstWhere('id', (int) $selectedHotelId) ?? $painting?->hotel;
                    $selectedHotelLabel = $selectedHotel ? "{$selectedHotel->name} ({$selectedHotel->pms_code})" : null;
                }
            @endphp
            <label class="painting-form__label mb-2">Hotel <x-required-mark /></label>
            <x-searchable-hotel-select
                :selected-id="$selectedHotelId"
                :selected-label="$selectedHotelLabel"
                :required="$locationType === 'hotel'"
            />
            @error('hotel_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div data-location-section="location" @class(['hidden' => $locationType !== 'location'])>
            @php
                $selectedLocationId = old('location_id', $painting?->location_id);
                $selectedLocationLabel = old('new_location_name') ?: ($painting?->location?->name);
            @endphp
            <label class="painting-form__label mb-2">Other Location <x-required-mark /></label>
            <x-searchable-location-select
                :selected-id="$selectedLocationId"
                :selected-label="$selectedLocationLabel"
                :required="$locationType === 'location'"
            />
            @error('location_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('new_location_name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </section>

    {{-- Ownership & Purchase --}}
    <section class="painting-form__section">
        <h2 class="painting-form__section-title">Ownership & Purchase</h2>
        <div class="painting-form__grid--2">
            <div class="painting-form__field">
                <label for="owned_by" class="painting-form__label">Owned By <x-required-mark /></label>
                <input type="text" name="owned_by" id="owned_by" value="{{ old('owned_by', $painting?->owned_by) }}"
                    class="painting-form__input" required>
                @error('owned_by')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="painting-form__field">
                <label for="purchased_by" class="painting-form__label">Purchased By <x-required-mark /></label>
                <input type="text" name="purchased_by" id="purchased_by" value="{{ old('purchased_by', $painting?->purchased_by) }}"
                    class="painting-form__input" required>
                @error('purchased_by')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="painting-form__field">
                <label for="paid_by" class="painting-form__label">Paid By <x-required-mark /></label>
                <input type="text" name="paid_by" id="paid_by" value="{{ old('paid_by', $painting?->paid_by) }}"
                    class="painting-form__input" required>
                @error('paid_by')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="painting-form__field painting-form__field--span-2 sm:col-span-2">
                <label class="painting-form__label">Purchased From <x-required-mark /></label>
                <div class="painting-form__pills">
                    @foreach(['gallery' => 'Gallery', 'person' => 'Person'] as $value => $label)
                        <label @class([
                            'painting-form__pill',
                            'painting-form__pill--active' => $purchasedFromType === $value,
                            'painting-form__pill--inactive' => $purchasedFromType !== $value,
                        ])>
                            <input type="radio" name="purchased_from_type" value="{{ $value }}" data-purchased-from-type
                                @checked($purchasedFromType === $value) class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                @error('purchased_from_type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div data-purchased-from-section="gallery" @class(['hidden' => $purchasedFromType !== 'gallery'])>
                    @php
                        $selectedGalleryId = old('gallery_id', $painting?->gallery_id);
                        $selectedGalleryLabel = old('new_gallery_name') ?: ($painting?->gallery?->name);
                    @endphp
                    <label class="painting-form__label mb-2">Gallery <x-required-mark /></label>
                    <x-searchable-gallery-select
                        :selected-id="$selectedGalleryId"
                        :selected-label="$selectedGalleryLabel"
                        :required="$purchasedFromType === 'gallery'"
                    />
                    @error('gallery_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('new_gallery_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div data-purchased-from-section="person" @class(['hidden' => $purchasedFromType !== 'person'])>
                    <label for="purchased_from_person" class="painting-form__label">Person Name <x-required-mark /></label>
                    <input type="text" name="purchased_from_person" id="purchased_from_person"
                        value="{{ old('purchased_from_person', $painting?->purchased_from_person) }}"
                        placeholder="Enter person name..."
                        class="painting-form__input" @if($purchasedFromType === 'person') required @endif>
                    @error('purchased_from_person')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </section>

    {{-- Certificate --}}
    <section class="painting-form__section">
        <h2 class="painting-form__section-title">Certificate of Authenticity <x-required-mark /></h2>
        <div class="painting-form__pills">
            @foreach(['text' => 'Text', 'file' => 'File Upload'] as $value => $label)
                <label @class([
                    'painting-form__pill',
                    'painting-form__pill--active' => $certificateType === $value,
                    'painting-form__pill--inactive' => $certificateType !== $value,
                ])>
                    <input type="radio" name="certificate_type" value="{{ $value }}" data-certificate-type
                        @checked($certificateType === $value) class="sr-only">
                    {{ $label }}
                </label>
            @endforeach
        </div>
        @error('certificate_type')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror

        <div data-certificate-section="text" @class(['hidden' => $certificateType !== 'text'])>
            <label for="certificate_text" class="painting-form__label">Certificate Text <x-required-mark /></label>
            <textarea name="certificate_text" id="certificate_text" rows="3" class="painting-form__input"
                placeholder="Enter certificate details...">{{ old('certificate_text', $painting?->certificate_text) }}</textarea>
            @error('certificate_text')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div data-certificate-section="file" @class(['hidden' => $certificateType !== 'file'])>
            @if($painting?->certificate_type === 'file' && $painting->certificateUrl())
                <p class="text-sm text-gray-600 mb-2">Current file: <a href="{{ $painting->certificateUrl() }}" target="_blank" class="text-amber-900 hover:underline">View certificate</a></p>
            @endif
            <input type="file" name="certificate_file" id="certificate_file" accept=".pdf,image/jpeg,image/png,image/webp"
                class="painting-form__input painting-form__input--file">
            @error('certificate_file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </section>
</div>
