<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ], [
                'current_password.required' => 'Kata sandi saat ini wajib diisi.',
                'current_password.current_password' => 'Kata sandi saat ini tidak cocok.',
                'password.required' => 'Kata sandi baru wajib diisi.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors(), 'updatePassword');
        }

        // Cek apakah password baru sama dengan yang lama
        if (Hash::check($validated['password'], $request->user()->password)) {
            return redirect()->to(route('profile.edit', [], false) . '#update-password')
                ->withErrors([
                    'password' => ['Kata sandi baru tidak boleh sama dengan kata sandi Anda saat ini.'],
                ], 'updatePassword');
        }

        // Update password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }


    // Metode destroy user akan ditambahkan di sini, jika diperlukan
}
