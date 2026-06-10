@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <div class="mb-6">
        <a href="{{ route('users.index') }}" class="text-sm text-amber-900 hover:text-amber-950 font-medium">&larr; Back to Users</a>
    </div>

    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900 -tracking-wide mb-6">Add User</h1>

    <form action="{{ route('users.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 max-w-2xl">
        @csrf
        @include('users._form')

        <div class="flex flex-col sm:flex-row gap-3 mt-6">
            <button type="submit" class="btn btn-primary btn-block-sm">Create User</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-block-sm">Cancel</a>
        </div>
    </form>
@endsection
