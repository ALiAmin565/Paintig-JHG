@extends('layouts.app')

@section('title', 'Hotels')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">Hotels</h1>
    </div>

    @if(session('success'))
        <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form action="{{ route('hotels.index') }}" method="GET" class="space-y-4" data-live-hotel-search-form>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                <div class="lg:col-span-2">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-1.5">Search</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        data-live-search-trigger
                        class="form-input"
                        placeholder="Search by hotel name or PMS code..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                    <select name="status" id="status" data-live-search-trigger class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-xs sm:text-sm text-gray-500">Results update automatically as you type</p>
                @if(request('search') || request('status'))
                    <a href="{{ route('hotels.index') }}" class="btn btn-secondary btn-block-sm sm:min-w-[140px]">
                        Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-opacity duration-200" data-live-hotel-search-results>
        @include('hotels._table', ['hotels' => $hotels])
    </div>
@endsection
