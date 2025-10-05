<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Validasi role dari DB vs role input
        if (Auth::user()->role !== $request->role) {
            Auth::logout();
            return back()->withErrors([
                'role' => 'Role tidak sesuai dengan akun ini.',
            ]);
        }

        // Redirect sesuai role
        return match (Auth::user()->role) {
            'admin' => redirect()->intended('/admin/dashboard'),
            'peserta' => redirect()->intended('/peserta/dashboard'),
            default => redirect('/'),
        };
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
