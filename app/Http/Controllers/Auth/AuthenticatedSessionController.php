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

        // ✅ FIX: Gunakan autentikasi yang sudah memasukkan role.
        // Jika Auth::attempt di LoginRequest berhasil, role sudah sesuai.

        // Redirect sesuai role
        return match (Auth::user()->role) {
            // Mengganti intended('/admin/dashboard') menjadi redirect()->route('admin.dashboard')
            'admin' => redirect()->route('admin.dashboard'),

            // Mengganti intended('/dashboard') menjadi redirect()->route('peserta.dashboard')
            'peserta' => redirect()->route('peserta.dashboard'),

            default => redirect('/'),
        };
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
