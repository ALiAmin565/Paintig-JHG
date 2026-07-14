@extends('layouts.app')

@section('title', 'Create Hotel')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">Create Hotel</h1>
                <p class="text-sm text-gray-500 mt-1">Add a new hotel to the system</p>
            </div>
            <a href="{{ route('hotels.index') }}" class="btn btn-secondary btn-block-sm">
                Back to Hotels
            </a>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('hotels.store') }}" method="POST" class="space-y-6">
                @csrf
                
                @include('hotels._form')

                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary btn-block-sm">Create Hotel</button>
                    <a href="{{ route('hotels.index') }}" class="btn btn-secondary btn-block-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection