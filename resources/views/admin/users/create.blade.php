<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pengguna Baru') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-50">
        <x-admin-aside />
        <main class="flex-1 py-12 px-6">
            <div class="max-w-xl mx-auto">
                <a href="{{ route('admin.users.index') }}"
                    class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mb-4 inline-block">
                    &larr; Kembali ke Daftar Pengguna
                </a>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Data Pengguna') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Masukkan detail untuk membuat akun pengguna baru. Default role adalah Peserta Magang.") }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 space-y-6">
                        @csrf

                        {{-- Nama --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- ID Peserta (User ID) --}}
                        <div>
                            <x-input-label for="user_id" :value="__('ID Peserta (NIP/NIM/Stambuk)')" />
                            <x-text-input id="user_id" name="user_id" type="text" class="mt-1 block w-full"
                                :value="old('user_id')" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>

                        {{-- Email (Opsional) --}}
                        <div>
                            <x-input-label for="email" :value="__('Email (Opsional)')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email')" autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        {{-- Role --}}
                        <div>
                            <x-input-label for="role" :value="__('Role / Peran')" />
                            <select id="role" name="role"
                                class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                                required>
                                <option value="peserta" {{ (old('role') == 'peserta') ? 'selected' : '' }}>Peserta Magang
                                </option>
                                <option value="admin" {{ (old('role') == 'admin') ? 'selected' : '' }}>Administrator
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 block w-full" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>

                        {{-- Jurusan --}}
                        <div>
                            <x-input-label for="jurusan" :value="__('Jurusan')" />
                            <x-text-input id="jurusan" name="jurusan" type="text" class="mt-1 block w-full"
                                :value="old('jurusan')" required autofocus autocomplete="jurusan" />
                            <x-input-error class="mt-2" :messages="$errors->get('jurusan')" />
                        </div>

                        {{-- Instansi --}}
                        <div>
                            <x-input-label for="instansi" :value="__('Instansi')" />
                            <x-text-input id="instansi" name="instansi" type="text" class="mt-1 block w-full"
                                :value="old('instansi')" required autofocus autocomplete="instansi" />
                            <x-input-error class="mt-2" :messages="$errors->get('instansi')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-primary-button>{{ __('Buat Akun') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </main>
    </div>
</x-app-layout>