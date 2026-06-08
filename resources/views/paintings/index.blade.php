@extends('layouts.app')

@section('title', 'Paintings')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">Paintings</h1>
        <a href="{{ route('paintings.create') }}" class="btn btn-primary btn-block-sm">
            Add Painting
        </a>
    </div>

    @if(session('success'))
        <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form action="{{ route('paintings.index') }}" method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-12 gap-3 xl:gap-4 xl:items-end">
                <div class="sm:col-span-2 xl:col-span-4">
                    <label for="search" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Search</label>
                    <input type="text" name="search" id="search" placeholder="Title, media, or owner..."
                        value="{{ request('search') }}"
                        class="form-input py-2.5 sm:py-3">
                </div>

                <div class="sm:col-span-1 xl:col-span-4">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Location</label>
                    @php
                        $filterHotelId = request('hotel_id');
                        $filterHotelLabel = $filterHotelId ? $hotels->firstWhere('id', (int) $filterHotelId)?->name : null;
                    @endphp
                    <x-searchable-hotel-select
                        name="hotel_id"
                        :selected-id="$filterHotelId"
                        :selected-label="$filterHotelLabel"
                        :required="false"
                        :auto-submit="true"
                        :compact="true"
                        placeholder="Filter by hotel..."
                    />
                </div>

                <div class="sm:col-span-1 xl:col-span-2">
                    <label for="sort" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Sort</label>
                    <select name="sort" id="sort" class="form-select py-2.5 sm:py-3">
                        <option value="created_desc" @selected(request('sort', 'created_desc') === 'created_desc')>Recent</option>
                        <option value="year_desc" @selected(request('sort') === 'year_desc')>Year ↓</option>
                        <option value="year_asc" @selected(request('sort') === 'year_asc')>Year ↑</option>
                        <option value="title_asc" @selected(request('sort') === 'title_asc')>Title A-Z</option>
                    </select>
                </div>

                <div class="sm:col-span-2 xl:col-span-2 flex flex-col sm:flex-row xl:flex-col gap-2">
                    <button type="submit" class="btn btn-primary w-full py-2.5 sm:py-3 text-sm">Filter</button>
                    @if(request()->hasAny(['search', 'hotel_id', 'sort']))
                        <a href="{{ route('paintings.index') }}" class="btn btn-secondary w-full py-2.5 sm:py-3 text-sm text-center">Clear</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="table-responsive">
            <table class="data-table">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left font-semibold text-gray-700">Photo</th>
                        <th class="text-left font-semibold text-gray-700">Title</th>
                        <th class="text-left font-semibold text-gray-700 hidden md:table-cell">Media</th>
                        <th class="text-left font-semibold text-gray-700">Year</th>
                        <th class="text-left font-semibold text-gray-700 hidden lg:table-cell">Location</th>
                        <th class="text-left font-semibold text-gray-700 hidden xl:table-cell">Owned By</th>
                        <th class="text-left font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($paintings as $painting)
                        <tr class="hover:bg-gray-50">
                            <td>
                                @if($painting->photoUrl())
                                    <img src="{{ $painting->photoUrl() }}" alt="{{ $painting->title }}" class="h-10 w-10 sm:h-12 sm:w-12 object-cover rounded-lg ring-1 ring-gray-200">
                                @else
                                    <div class="h-10 w-10 sm:h-12 sm:w-12 bg-gray-200 rounded-lg flex items-center justify-center text-xs text-gray-400">N/A</div>
                                @endif
                            </td>
                            <td class="font-medium text-gray-900 max-w-[160px] sm:max-w-none truncate">{{ $painting->title }}</td>
                            <td class="text-gray-700 hidden md:table-cell">{{ $painting->media }}</td>
                            <td class="text-gray-700">{{ $painting->production_year }}</td>
                            <td class="text-gray-700 hidden lg:table-cell max-w-[140px] truncate">{{ $painting->hotel->name }}</td>
                            <td class="text-gray-700 hidden xl:table-cell max-w-[120px] truncate">{{ $painting->owned_by }}</td>
                            <td>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-3">
                                    <a href="{{ route('paintings.show', $painting) }}" class="text-amber-900 hover:text-amber-950 font-medium text-sm">View</a>
                                    <a href="{{ route('paintings.edit', $painting) }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-8">No paintings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($paintings->hasPages())
            <div class="border-t border-gray-200 pagination-nav">
                {{ $paintings->links() }}
            </div>
        @endif
    </div>
@endsection
