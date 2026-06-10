@props(['user' => null])

<div class="grid grid-cols-1 gap-4 sm:gap-6">
    <div>
        <label for="full_name" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Full Name</label>
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user?->full_name) }}" class="form-input" required>
        @error('full_name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="username" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Username</label>
        <input type="text" name="username" id="username" value="{{ old('username', $user?->username) }}" class="form-input" required>
        @error('username')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="email" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user?->email) }}" class="form-input" required>
        @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="password" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">
            Password @if($user)<span class="text-gray-500 font-normal">(leave blank to keep current)</span>@endif
        </label>
        <input type="password" name="password" id="password" class="form-input" @if(!$user) required @endif>
        @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
    </div>

    <div>
        <label for="role" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Role</label>
        <select name="role" id="role" class="form-select" required>
            <option value="user" @selected(old('role', $user?->role) === 'user')>User</option>
            <option value="admin" @selected(old('role', $user?->role) === 'admin')>Admin</option>
        </select>
        @error('role')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="status" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base">Status</label>
        <select name="status" id="status" class="form-select" required>
            <option value="active" @selected(old('status', $user?->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $user?->status) === 'inactive')>Inactive</option>
        </select>
        @error('status')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
</div>
