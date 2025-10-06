<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:admin,peserta'],
        ];
    }

    // Old
/*
        $credentials = $this->only('user_id', 'password');

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
*/

    // ✅ FIX: Include 'role' in the credentials to enforce an exact match during authentication.
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('user_id', 'password', 'role');

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'user_id' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }


    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'user_id' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        // ✅ gunakan input(), bukan string()
        return Str::transliterate(Str::lower($this->input('user_id')) . '|' . $this->ip());
    }
}
