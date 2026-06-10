@extends('layouts.app')

@section('title', 'Locations')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">Locations</h1>
        <a href="{{ route('locations.create') }}" class="btn btn-primary btn-block-sm">Add Location</a>
    </div>

    @if(session('success'))
        <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert type="error" dismissible>{{ session('error') }}</x-alert>
    @endif

    <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form action="{{ route('locations.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" placeholder="Search locations..." value="{{ request('search') }}" class="form-input flex-1">
            <button type="submit" class="btn btn-primary">Search</button>
            @if(request('search'))
                <a href="{{ route('locations.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="table-responsive">
            <table class="data-table">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left font-semibold text-gray-700">Name</th>
                        <th class="text-left font-semibold text-gray-700 hidden md:table-cell">Description</th>
                        <th class="text-left font-semibold text-gray-700">Paintings</th>
                        <th class="text-left font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($locations as $location)
                        <tr class="hover:bg-gray-50">
                            <td class="font-medium text-gray-900">{{ $location->name }}</td>
                            <td class="text-gray-700 hidden md:table-cell max-w-xs truncate">{{ $location->description ?? '—' }}</td>
                            <td class="text-gray-700">{{ $location->paintings_count }}</td>
                            <td>
                                <div class="flex gap-3">
                                    <a href="{{ route('locations.edit', $location) }}" class="text-amber-900 hover:text-amber-950 font-medium text-sm">Edit</a>
                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('locations.destroy', $location) }}" method="POST" onsubmit="return confirm('Delete this location?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-8">No locations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($locations->hasPages())
            <div class="border-t border-gray-200 pagination-nav">{{ $locations->links() }}</div>
        @endif
    </div>
@endsection
