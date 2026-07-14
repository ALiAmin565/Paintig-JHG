@extends('layouts.app')

@section('title', $hotel->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('hotels.index') }}" class="text-sm text-amber-900 hover:text-amber-950 font-medium">&larr; Back to Hotels</a>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">{{ $hotel->name }}</h1>
            <p class="text-gray-600 mt-2">
                PMS Code: {{ $hotel->pms_code }} &middot; 
                <x-badge :variant="$hotel->status === 'active' ? 'active' : 'inactive'">{{ ucfirst($hotel->status) }}</x-badge>
                &middot; {{ $hotel->paintings_count }} paintings
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <a href="{{ route('paintings.create', ['hotel_id' => $hotel->id]) }}" class="btn btn-primary btn-block-sm">
                Add Painting
            </a>
            
            @can('update', $hotel)
                <a href="{{ route('hotels.edit', $hotel) }}" class="btn btn-secondary btn-block-sm">
                    Edit Hotel
                </a>
            @endcan
            
            @can('delete', $hotel)
                <form action="{{ route('hotels.destroy', $hotel) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this hotel? This will permanently delete the hotel and cannot be undone.')" 
                      class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block-sm w-full">Delete Hotel</button>
                </form>
            @endcan
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($paintings->isEmpty())
            <div class="p-8 text-center text-gray-500">
                No paintings at this location yet.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 p-4 sm:p-6">
                @foreach($paintings as $painting)
                    <a href="{{ route('paintings.show', $painting) }}" class="group block bg-gray-50 rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="aspect-[4/3] bg-gray-200 overflow-hidden">
                            @if($painting->photoUrl())
                                <img src="{{ $painting->photoUrl() }}" alt="{{ $painting->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No photo</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 group-hover:text-amber-900">{{ $painting->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $painting->media }} &middot; {{ $painting->production_year }}</p>
                            <p class="text-sm text-gray-500 mt-2">Owned by {{ $painting->owned_by }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($paintings->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $paintings->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
