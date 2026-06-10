@props([
    'name' => 'location_id',
    'selectedId' => null,
    'selectedLabel' => null,
    'required' => true,
    'autoSubmit' => false,
    'liveFilter' => false,
    'compact' => false,
    'placeholder' => 'Search location by name...',
    'allowCreate' => true,
])

@php
    $selectedId = old($name, $selectedId);
@endphp

<div
    class="searchable-location-select relative"
    data-searchable-location-select
    data-api-url="{{ route('api.locations') }}"
    data-create-url="{{ route('api.locations.store') }}"
    data-auto-submit="{{ $autoSubmit ? 'true' : 'false' }}"
    data-live-filter="{{ $liveFilter ? 'true' : 'false' }}"
    data-allow-create="{{ $allowCreate ? 'true' : 'false' }}"
>
    <input
        type="hidden"
        name="{{ $name }}"
        value="{{ $selectedId }}"
        @if($required) required @endif
        data-location-id-input
    >

    <input
        type="hidden"
        name="new_location_name"
        value="{{ old('new_location_name') }}"
        data-new-location-name-input
    >

    <input
        type="text"
        value="{{ $selectedLabel }}"
        placeholder="{{ $placeholder }}"
        autocomplete="off"
        class="form-input"
        data-location-search-input
    >

    <ul
        class="absolute z-20 left-0 right-0 mt-1 max-h-60 overflow-y-auto bg-white border-2 border-gray-200 rounded-lg shadow-lg hidden"
        data-location-search-results
    ></ul>

    @unless($compact)
        <p class="text-xs text-gray-500 mt-1">Type to search locations. Create a new one if not found.</p>
    @endunless
</div>
