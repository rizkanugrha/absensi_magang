<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Reset Kata Sandi Pengguna') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Sebagai Admin, Anda dapat menyetel ulang kata sandi untuk pengguna ini. Kata sandi lama tidak diperlukan.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('admin.users.updatePassword', $user) }}" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        {{-- Password Baru --}}
        <div>
            <x-input-label for="password" :value="__('Kata Sandi Baru')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required
                autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        {{-- Konfirmasi Password Baru --}}
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" required autocomplete="new-password" />

            {{-- Logic ini menampilkan error 'password_confirmation' jika ada (required),
            atau menampilkan error 'password.confirmed' (ketidakcocokan) --}}
            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation') ?? $errors->get('password.confirmed')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Reset Kata Sandi') }}</x-primary-button>
        </div>
    </form>
</section>