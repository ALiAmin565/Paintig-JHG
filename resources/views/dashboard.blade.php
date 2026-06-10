@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">Dashboard</h1>
        <p class="text-gray-600 mt-2 text-sm sm:text-base">Welcome back, {{ auth()->user()->full_name }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Paintings</p>
            <p class="text-2xl sm:text-3xl font-bold text-amber-900">{{ $paintingsCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Hotels</p>
            <p class="text-2xl sm:text-3xl font-bold text-amber-900">{{ $hotelsCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Locations</p>
            <p class="text-2xl sm:text-3xl font-bold text-amber-900">{{ $locationsCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <p class="text-sm font-medium text-gray-500 mb-1">Active Users</p>
            <p class="text-2xl sm:text-3xl font-bold text-amber-900">{{ $usersCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 sm:col-span-2 lg:col-span-1 xl:col-span-1">
            <p class="text-sm font-medium text-gray-500 mb-2">Paintings by Location</p>
            <div class="space-y-1 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Hotels</span><span class="font-semibold text-gray-900">{{ $paintingsAtHotels }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Other</span><span class="font-semibold text-gray-900">{{ $paintingsAtLocations }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">N/A</span><span class="font-semibold text-gray-900">{{ $paintingsNoLocation }}</span></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <a href="{{ route('users.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 hover:border-amber-900 transition-colors">
            <p class="text-sm font-medium text-gray-500 mb-1">Manage Users</p>
            <p class="text-amber-900 font-semibold">User administration →</p>
        </a>
        <a href="{{ route('paintings.create') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 hover:border-amber-900 transition-colors">
            <p class="text-sm font-medium text-gray-500 mb-1">Add Painting</p>
            <p class="text-amber-900 font-semibold">Create new record →</p>
        </a>
        <a href="{{ route('locations.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 hover:border-amber-900 transition-colors">
            <p class="text-sm font-medium text-gray-500 mb-1">Manage Locations</p>
            <p class="text-amber-900 font-semibold">Custom locations →</p>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Recent Paintings</h2>
            <a href="{{ route('paintings.index') }}" class="text-sm text-amber-900 hover:text-amber-950 font-medium">View All</a>
        </div>

        @if($recentPaintings->isEmpty())
            <div class="p-6 sm:p-8 text-center text-gray-500 text-sm sm:text-base">
                No paintings yet. <a href="{{ route('paintings.create') }}" class="text-amber-900 hover:underline font-medium">Add the first painting</a>.
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left font-semibold text-gray-700">Title</th>
                            <th class="text-left font-semibold text-gray-700 hidden md:table-cell">Painter</th>
                            <th class="text-left font-semibold text-gray-700">Year</th>
                            <th class="text-left font-semibold text-gray-700 hidden lg:table-cell">Location</th>
                            <th class="text-left font-semibold text-gray-700 hidden sm:table-cell">Price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentPaintings as $painting)
                            <tr class="hover:bg-gray-50">
                                <td>
                                    <a href="{{ route('paintings.show', $painting) }}" class="text-amber-900 hover:text-amber-950 font-medium break-words">
                                        {{ $painting->title }}
                                    </a>
                                </td>
                                <td class="text-gray-700 hidden md:table-cell">{{ $painting->painter_name }}</td>
                                <td class="text-gray-700">{{ $painting->production_year }}</td>
                                <td class="text-gray-700 hidden lg:table-cell max-w-[140px] truncate">{{ $painting->locationLabel() }}</td>
                                <td class="text-gray-700 hidden sm:table-cell">{{ $painting->formattedPrice() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
