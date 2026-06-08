@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">Dashboard</h1>
        <p class="text-gray-600 mt-2 text-sm sm:text-base">Welcome back, {{ auth()->user()->full_name }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Hotels</p>
            <p class="text-2xl sm:text-3xl font-bold text-amber-900">{{ $hotelsCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Paintings</p>
            <p class="text-2xl sm:text-3xl font-bold text-amber-900">{{ $paintingsCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 flex flex-col justify-center gap-3 sm:col-span-2 lg:col-span-1">
            <a href="{{ route('paintings.create') }}" class="btn btn-primary btn-block-sm">Add Painting</a>
            <a href="{{ route('paintings.index') }}" class="btn btn-secondary btn-block-sm">View All Paintings</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Recent Paintings</h2>
            <a href="{{ route('hotels.index') }}" class="text-sm text-amber-900 hover:text-amber-950 font-medium">Browse Hotels</a>
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
                            <th class="text-left font-semibold text-gray-700 hidden md:table-cell">Media</th>
                            <th class="text-left font-semibold text-gray-700">Year</th>
                            <th class="text-left font-semibold text-gray-700 hidden lg:table-cell">Location</th>
                            <th class="text-left font-semibold text-gray-700 hidden sm:table-cell">Owned By</th>
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
                                <td class="text-gray-700 hidden md:table-cell">{{ $painting->media }}</td>
                                <td class="text-gray-700">{{ $painting->production_year }}</td>
                                <td class="text-gray-700 hidden lg:table-cell max-w-[140px] truncate">{{ $painting->hotel->name }}</td>
                                <td class="text-gray-700 hidden sm:table-cell max-w-[120px] truncate">{{ $painting->owned_by }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
