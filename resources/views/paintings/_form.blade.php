@props(['painting' => null, 'hotels', 'selectedHotelId' => null])

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

    <div>
        <label for="dimensions_with_frame" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Dimensions With Frame</label>
        <input type="number" name="dimensions_with_frame" id="dimensions_with_frame" step="0.01" min="0" max="999999.99"
            value="{{ old('dimensions_with_frame', $painting?->dimensions_with_frame) }}"
            class="form-input" required>
        <p class="text-xs text-gray-500 mt-1">Enter size in cm (max 999,999.99)</p>
        @error('dimensions_with_frame')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="dimensions_without_frame" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Dimensions Without Frame</label>
        <input type="number" name="dimensions_without_frame" id="dimensions_without_frame" step="0.01" min="0" max="999999.99"
            value="{{ old('dimensions_without_frame', $painting?->dimensions_without_frame) }}"
            class="form-input" required>
        <p class="text-xs text-gray-500 mt-1">Enter size in cm (max 999,999.99)</p>
        @error('dimensions_without_frame')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Location (Hotel)</label>
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
        />
        @error('hotel_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
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
        <label for="certificate_of_authenticity" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Certificate of Authenticity</label>
        <input type="text" name="certificate_of_authenticity" id="certificate_of_authenticity"
            value="{{ old('certificate_of_authenticity', $painting?->certificate_of_authenticity) }}"
            class="form-input" required>
        @error('certificate_of_authenticity')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
