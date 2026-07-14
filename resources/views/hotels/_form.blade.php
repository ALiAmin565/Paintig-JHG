@props(['hotel' => null])

<p class="form-required-note"><x-required-mark /> Required field</p>

<div class="grid grid-cols-1 gap-4 sm:gap-6">
    <div>
        <label for="name" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Hotel Name <x-required-mark /></label>
        <input type="text" name="name" id="name" value="{{ old('name', $hotel?->name) }}" class="form-input" required>
        @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="pms_code" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">PMS Code <x-required-mark /></label>
        <input type="text" name="pms_code" id="pms_code" value="{{ old('pms_code', $hotel?->pms_code) }}" class="form-input" required>
        <p class="text-sm text-gray-600 mt-1">Unique identifier for the hotel in the PMS system</p>
        @error('pms_code')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="status" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Status <x-required-mark /></label>
        <select name="status" id="status" class="form-select" required>
            <option value="active" @selected(old('status', $hotel?->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $hotel?->status) === 'inactive')>Inactive</option>
        </select>
        @error('status')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
</div>