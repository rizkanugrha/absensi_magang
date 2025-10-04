<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 gap-6">
            <a href="{{ route('admin.users.index') }}" class="p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                <h3 class="text-lg font-bold">Kelola Peserta</h3>
                <p class="text-sm text-gray-600">Tambah, edit, dan hapus peserta.</p>
            </a>
            <a href="{{ route('admin.attendances.index') }}" class="p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                <h3 class="text-lg font-bold">Kelola Absensi Peserta</h3>
                <p class="text-sm text-gray-600">Lihat dan kelola data absensi peserta.</p>
            </a>
        </div>
    </div>
</x-app-layout>