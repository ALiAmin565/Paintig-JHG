@extends('layouts.app')

@section('title', 'Paintings')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">Paintings</h1>
            <p class="text-sm text-gray-500 mt-1" data-paintings-count>{{ $paintings->total() }} {{ Str::plural('record', $paintings->total()) }} in catalog</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <a href="{{ route('paintings.print-all', request()->query()) }}"
                target="_blank"
                rel="noopener"
                data-print-all-link
                class="btn btn-secondary btn-block-sm">
                Print / Export PDF
            </a>
            <a href="{{ route('paintings.create') }}" class="btn btn-primary btn-block-sm">
                Add Painting
            </a>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form action="{{ route('paintings.index') }}" method="GET" data-live-painting-filter-form>
            <div class="paintings-filter-bar">
                <div class="paintings-filter-bar__field paintings-filter-bar__field--search">
                    <label for="search" class="paintings-filter-bar__label">Search</label>
                    <input type="text" name="search" id="search" placeholder="Title, painter, media..."
                        value="{{ request('search') }}"
                        data-live-search-trigger
                        autocomplete="off"
                        class="form-input paintings-filter-bar__input">
                </div>

                <div class="paintings-filter-bar__field paintings-filter-bar__field--select">
                    <label for="location_type" class="paintings-filter-bar__label">Location Type</label>
                    <select name="location_type" id="location_type" data-live-search-trigger class="form-select paintings-filter-bar__input">
                        <option value="">All Types</option>
                        <option value="hotel" @selected(request('location_type') === 'hotel')>Hotel</option>
                        <option value="location" @selected(request('location_type') === 'location')>Other Location</option>
                        <option value="none" @selected(request('location_type') === 'none')>N/A</option>
                    </select>
                </div>

                <div class="paintings-filter-bar__field paintings-filter-bar__field--select">
                    <label for="sort" class="paintings-filter-bar__label">Sort</label>
                    <select name="sort" id="sort" data-live-search-trigger class="form-select paintings-filter-bar__input">
                        <option value="created_desc" @selected(request('sort', 'created_desc') === 'created_desc')>Recent</option>
                        <option value="year_desc" @selected(request('sort') === 'year_desc')>Year ↓</option>
                        <option value="year_asc" @selected(request('sort') === 'year_asc')>Year ↑</option>
                        <option value="title_asc" @selected(request('sort') === 'title_asc')>Title A–Z</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Price ↓</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Price ↑</option>
                    </select>
                </div>

                <div class="paintings-filter-bar__field paintings-filter-bar__field--picker">
                    <label class="paintings-filter-bar__label">Hotel</label>
                    @php
                        $filterHotelId = request('hotel_id');
                        $filterHotelLabel = $filterHotelId ? $hotels->firstWhere('id', (int) $filterHotelId)?->name : null;
                    @endphp
                    <x-searchable-hotel-select
                        name="hotel_id"
                        :selected-id="$filterHotelId"
                        :selected-label="$filterHotelLabel"
                        :required="false"
                        :live-filter="true"
                        :compact="true"
                        placeholder="Hotel..."
                    />
                </div>

                <div class="paintings-filter-bar__field paintings-filter-bar__field--picker">
                    <label class="paintings-filter-bar__label">Location</label>
                    @php
                        $filterLocationId = request('location_id');
                        $filterLocationLabel = $filterLocationId ? $locations->firstWhere('id', (int) $filterLocationId)?->name : null;
                    @endphp
                    <x-searchable-location-select
                        name="location_id"
                        :selected-id="$filterLocationId"
                        :selected-label="$filterLocationLabel"
                        :required="false"
                        :live-filter="true"
                        :compact="true"
                        :allow-create="false"
                        placeholder="Location..."
                    />
                </div>

                <div class="paintings-filter-bar__field paintings-filter-bar__field--clear">
                    <span class="paintings-filter-bar__label paintings-filter-bar__label--spacer">&nbsp;</span>
                    <a href="{{ route('paintings.index') }}"
                        data-clear-filters
                        @class([
                            'paintings-filter-bar__clear',
                            'hidden' => !(
                                request()->filled('search')
                                || request()->filled('hotel_id')
                                || request()->filled('location_id')
                                || request()->filled('location_type')
                                || (request('sort') && request('sort') !== 'created_desc')
                            ),
                        ])>
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div data-live-painting-results class="transition-opacity duration-200">
        @include('paintings._index-results', ['paintings' => $paintings])
    </div>
@endsection
