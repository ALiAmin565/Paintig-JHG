@extends('layouts.app')

@section('title', 'Edit Painting')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('paintings.show', $painting) }}" class="text-sm text-amber-900 hover:text-amber-950 font-medium">&larr; Back to Painting</a>
        </div>

        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900 -tracking-wide mb-6">Edit Painting</h1>

        <form action="{{ route('paintings.update', $painting) }}" method="POST" enctype="multipart/form-data" data-painting-form class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 lg:p-8">
            @csrf
            @method('PUT')
            @include('paintings._form', ['painting' => $painting, 'hotels' => $hotels])

            <div class="painting-form__actions mt-6">
                <button type="submit" class="btn btn-primary btn-block-sm">Update Painting</button>
                <a href="{{ route('paintings.show', $painting) }}" class="btn btn-secondary btn-block-sm">Cancel</a>
            </div>
        </form>
    </div>
@endsection
