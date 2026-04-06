<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials, true)) {
            return back()->withErrors([
                'email' => 'ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = $request->user();

        if (! $user->isSystemAdmin() && ! $user->company?->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Your company account is pending system admin approval.',
            ])->onlyInput('email');
        }

        return redirect()->intended(
            $user->isSystemAdmin() ? route('system-admin.companies') : route('dashboard')
        );
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
