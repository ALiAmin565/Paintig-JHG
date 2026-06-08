@props([
    'name' => 'hotel_id',
    'selectedId' => null,
    'selectedLabel' => null,
    'required' => true,
    'autoSubmit' => false,
    'compact' => false,
    'placeholder' => 'Search hotel by name or PMS code...',
])

@php
    $selectedId = old($name, $selectedId);
@endphp

<div
    class="searchable-hotel-select relative"
    data-searchable-hotel-select
    data-api-url="{{ route('api.hotels') }}"
    data-auto-submit="{{ $autoSubmit ? 'true' : 'false' }}"
>
    <input
        type="hidden"
        name="{{ $name }}"
        value="{{ $selectedId }}"
        @if($required) required @endif
        data-hotel-id-input
    >

    <input
        type="text"
        value="{{ $selectedLabel }}"
        placeholder="{{ $placeholder }}"
        autocomplete="off"
        class="form-input"
        data-hotel-search-input
    >

    <ul
        class="absolute z-20 left-0 right-0 mt-1 max-h-60 overflow-y-auto bg-white border-2 border-gray-200 rounded-lg shadow-lg hidden"
        data-hotel-search-results
    ></ul>

    @unless($compact)
        <p class="text-xs text-gray-500 mt-1">Type to search hotels in real time</p>
    @endunless
</div>
