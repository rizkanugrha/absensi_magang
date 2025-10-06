<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengguna') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.users.index') }}"
                class="text-indigo-600 hover:text-indigo-900 text-sm mb-4 inline-block">
                &larr; Kembali ke Daftar Pengguna
            </a>

            {{-- 1. Update Informasi Pengguna (Nama, ID, Email, Role) --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Menggunakan partial khusus admin --}}
                    @include('admin.users.partials.update-user-information-form')
                </div>
            </div>

            {{-- 2. Reset Kata Sandi Pengguna (Oleh Admin) --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Menggunakan partial khusus admin --}}
                    @include('admin.users.partials.reset-user-password-form')
                </div>
            </div>

            {{-- 3. Hapus Akun Pengguna --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Menggunakan partial khusus admin --}}
                    @include('admin.users.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>