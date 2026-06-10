@props(['location' => null])

<p class="form-required-note"><x-required-mark /> Required field</p>

<div class="grid grid-cols-1 gap-4 sm:gap-6">
    <div>
        <label for="name" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Name <x-required-mark /></label>
        <input type="text" name="name" id="name" value="{{ old('name', $location?->name) }}" class="form-input" required>
        @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="description" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Description</label>
        <textarea name="description" id="description" rows="4" class="form-input">{{ old('description', $location?->description) }}</textarea>
        @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
</div>
