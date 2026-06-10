@extends('layouts.app')

@section('title', 'Add Painting')

@section('content')
    <div class="mb-6">
        <a href="{{ route('paintings.index') }}" class="text-sm text-amber-900 hover:text-amber-950 font-medium">&larr; Back to Paintings</a>
    </div>

    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900 -tracking-wide mb-6">Add Painting</h1>

    <form action="{{ route('paintings.store') }}" method="POST" enctype="multipart/form-data" data-painting-form class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
        @csrf
        @include('paintings._form', ['hotels' => $hotels, 'selectedHotelId' => $selectedHotelId])

        <div class="flex flex-col sm:flex-row gap-3 mt-6">
            <button type="submit" class="btn btn-primary btn-block-sm">Save Painting</button>
            <a href="{{ route('paintings.index') }}" class="btn btn-secondary btn-block-sm">Cancel</a>
        </div>
    </form>
@endsection
