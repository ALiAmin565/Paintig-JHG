@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-gray-900 -tracking-wide">Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-block-sm">Add User</a>
    </div>

    @if(session('success'))
        <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert type="error" dismissible>{{ session('error') }}</x-alert>
    @endif

    <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form action="{{ route('users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <input type="text" name="search" placeholder="Search name, username, email..."
                value="{{ request('search') }}" class="form-input">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                <option value="user" @selected(request('role') === 'user')>User</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">Filter</button>
                @if(request()->hasAny(['search', 'status', 'role']))
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="table-responsive">
            <table class="data-table">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left font-semibold text-gray-700">User</th>
                        <th class="text-left font-semibold text-gray-700 hidden md:table-cell">Email</th>
                        <th class="text-left font-semibold text-gray-700">Role</th>
                        <th class="text-left font-semibold text-gray-700">Status</th>
                        <th class="text-left font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td>
                                <div class="font-medium text-gray-900">{{ $user->full_name }}</div>
                                <div class="text-sm text-gray-500">@{{ $user->username }}</div>
                            </td>
                            <td class="text-gray-700 hidden md:table-cell">{{ $user->email }}</td>
                            <td>
                                <x-badge variant="{{ $user->role === 'admin' ? 'primary' : 'default' }}">{{ ucfirst($user->role) }}</x-badge>
                            </td>
                            <td>
                                <x-badge variant="{{ $user->status === 'active' ? 'active' : 'inactive' }}">{{ ucfirst($user->status) }}</x-badge>
                            </td>
                            <td>
                                <div class="flex gap-3">
                                    <a href="{{ route('users.edit', $user) }}" class="text-amber-900 hover:text-amber-950 font-medium text-sm">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Deactivate this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Deactivate</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-8">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="border-t border-gray-200 pagination-nav">{{ $users->links() }}</div>
        @endif
    </div>
@endsection
