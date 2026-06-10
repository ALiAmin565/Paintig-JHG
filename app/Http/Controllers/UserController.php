<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->orderBy('full_name');

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('full_name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->trim()->toString()) {
            $query->where('status', $status);
        }

        if ($role = $request->string('role')->trim()->toString()) {
            $query->where('role', $role);
        }

        $users = $query->paginate(15)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->safe()->except('password');

        if ($request->filled('password')) {
            $data['password'] = $request->validated('password');
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->update(['status' => 'inactive']);

        return redirect()
            ->route('users.index')
            ->with('success', 'User deactivated successfully.');
    }
}
