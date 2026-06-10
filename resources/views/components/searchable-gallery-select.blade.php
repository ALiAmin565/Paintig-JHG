@props([
    'name' => 'gallery_id',
    'selectedId' => null,
    'selectedLabel' => null,
    'required' => true,
    'placeholder' => 'Search gallery by name...',
    'allowCreate' => true,
])

@php
    $selectedId = old($name, $selectedId);
@endphp

<div
    class="searchable-gallery-select relative"
    data-searchable-gallery-select
    data-api-url="{{ route('api.galleries') }}"
    data-create-url="{{ route('api.galleries.store') }}"
    data-allow-create="{{ $allowCreate ? 'true' : 'false' }}"
>
    <input
        type="hidden"
        name="{{ $name }}"
        value="{{ $selectedId }}"
        @if($required) required @endif
        data-gallery-id-input
    >

    <input
        type="hidden"
        name="new_gallery_name"
        value="{{ old('new_gallery_name') }}"
        data-new-gallery-name-input
    >

    <input
        type="text"
        value="{{ $selectedLabel }}"
        placeholder="{{ $placeholder }}"
        autocomplete="off"
        class="form-input"
        data-gallery-search-input
    >

    <ul
        class="absolute z-20 left-0 right-0 mt-1 max-h-60 overflow-y-auto bg-white border-2 border-gray-200 rounded-lg shadow-lg hidden"
        data-gallery-search-results
    ></ul>

    <p class="text-xs text-gray-500 mt-1">Type to search galleries. Create a new one if not found.</p>
</div>
