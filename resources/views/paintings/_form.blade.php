@props(['painting' => null, 'hotels', 'selectedHotelId' => null])

@php
    $locationType = old('location_type', $painting?->location_type ?? 'none');
    $certificateType = old('certificate_type', $painting?->certificate_type ?? 'text');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
    <div class="md:col-span-2">
        <label for="photo" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Photo of the Painting</label>
        @if($painting?->photoUrl())
            <div class="mb-3">
                <img src="{{ $painting->photoUrl() }}" alt="{{ $painting->title }}" class="h-32 sm:h-40 w-auto max-w-full rounded-lg border border-gray-200">
            </div>
        @endif
        <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/webp"
            class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-50 file:text-amber-900 file:font-medium"
            @if(!$painting) required @endif>
        @error('photo')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="title" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $painting?->title) }}"
            class="form-input" required>
        @error('title')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="painter_name" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Painter Name</label>
        <input type="text" name="painter_name" id="painter_name" value="{{ old('painter_name', $painting?->painter_name) }}"
            class="form-input" required>
        @error('painter_name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="price" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Price</label>
        <input type="number" name="price" id="price" step="0.01" min="0"
            value="{{ old('price', $painting?->price) }}"
            class="form-input" required>
        @error('price')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="currency" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Currency</label>
        <select name="currency" id="currency" class="form-select" required>
            @foreach(\App\Http\Requests\PaintingRequestRules::CURRENCIES as $currency)
                <option value="{{ $currency }}" @selected(old('currency', $painting?->currency ?? 'USD') === $currency)>{{ $currency }}</option>
            @endforeach
        </select>
        @error('currency')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="media" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Media</label>
        <input type="text" name="media" id="media" value="{{ old('media', $painting?->media) }}"
            placeholder="e.g. Oil on canvas"
            class="form-input" required>
        @error('media')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="production_year" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Production Year</label>
        <input type="number" name="production_year" id="production_year" min="1000" max="{{ date('Y') }}"
            value="{{ old('production_year', $painting?->production_year) }}"
            class="form-input" required>
        @error('production_year')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Dimensions With Frame (cm)</label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="width_with_frame" class="block text-xs font-medium text-gray-600 mb-1">Width</label>
                <input type="number" name="width_with_frame" id="width_with_frame" step="0.01" min="0" max="999999.99"
                    value="{{ old('width_with_frame', $painting?->width_with_frame) }}"
                    class="form-input" required>
                @error('width_with_frame')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="height_with_frame" class="block text-xs font-medium text-gray-600 mb-1">Height</label>
                <input type="number" name="height_with_frame" id="height_with_frame" step="0.01" min="0" max="999999.99"
                    value="{{ old('height_with_frame', $painting?->height_with_frame) }}"
                    class="form-input" required>
                @error('height_with_frame')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="md:col-span-2">
        <label class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Dimensions Without Frame (cm)</label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="width_without_frame" class="block text-xs font-medium text-gray-600 mb-1">Width</label>
                <input type="number" name="width_without_frame" id="width_without_frame" step="0.01" min="0" max="999999.99"
                    value="{{ old('width_without_frame', $painting?->width_without_frame) }}"
                    class="form-input" required>
                @error('width_without_frame')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="height_without_frame" class="block text-xs font-medium text-gray-600 mb-1">Height</label>
                <input type="number" name="height_without_frame" id="height_without_frame" step="0.01" min="0" max="999999.99"
                    value="{{ old('height_without_frame', $painting?->height_without_frame) }}"
                    class="form-input" required>
                @error('height_without_frame')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="md:col-span-2">
        <label class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Location</label>
        <div class="flex flex-wrap gap-3 mb-4">
            @foreach(['hotel' => 'Hotel', 'location' => 'Other Location', 'none' => 'N/A'] as $value => $label)
                <label class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border-2 cursor-pointer transition-colors {{ $locationType === $value ? 'border-amber-900 bg-amber-50 text-amber-900' : 'border-gray-200 text-gray-700 hover:border-amber-200' }}">
                    <input type="radio" name="location_type" value="{{ $value }}" data-location-type
                        @checked($locationType === $value) class="sr-only">
                    <span class="text-sm font-medium">{{ $label }}</span>
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
    </div>

    <div>
        <label for="owned_by" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Owned By</label>
        <input type="text" name="owned_by" id="owned_by" value="{{ old('owned_by', $painting?->owned_by) }}"
            class="form-input" required>
        @error('owned_by')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="purchased_by" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Purchased By</label>
        <input type="text" name="purchased_by" id="purchased_by" value="{{ old('purchased_by', $painting?->purchased_by) }}"
            class="form-input" required>
        @error('purchased_by')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="purchased_from" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Purchased From</label>
        <input type="text" name="purchased_from" id="purchased_from" value="{{ old('purchased_from', $painting?->purchased_from) }}"
            class="form-input" required>
        @error('purchased_from')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="paid_by" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Paid By</label>
        <input type="text" name="paid_by" id="paid_by" value="{{ old('paid_by', $painting?->paid_by) }}"
            class="form-input" required>
        @error('paid_by')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Certificate of Authenticity</label>
        <div class="flex flex-wrap gap-3 mb-4">
            @foreach(['text' => 'Text', 'file' => 'File Upload'] as $value => $label)
                <label class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border-2 cursor-pointer transition-colors {{ $certificateType === $value ? 'border-amber-900 bg-amber-50 text-amber-900' : 'border-gray-200 text-gray-700 hover:border-amber-200' }}">
                    <input type="radio" name="certificate_type" value="{{ $value }}" data-certificate-type
                        @checked($certificateType === $value) class="sr-only">
                    <span class="text-sm font-medium">{{ $label }}</span>
                </label>
            @endforeach
        </div>
        @error('certificate_type')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror

        <div data-certificate-section="text" @class(['hidden' => $certificateType !== 'text'])>
            <textarea name="certificate_text" id="certificate_text" rows="3" class="form-input"
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
                class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-50 file:text-amber-900 file:font-medium">
            @error('certificate_file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
