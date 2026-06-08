<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return auth()->check()
            ? redirect()->route('paintings.index')
            : view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (! Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            return back()
                ->withErrors(['username' => 'Invalid credentials'])
                ->onlyInput('username');
        }

        if (! auth()->user()->isActive()) {
            Auth::logout();

            return back()->withErrors([
                'username' => 'Your account is not active.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('paintings.index'));
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
