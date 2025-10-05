@php
    // File: resources/views/admin/dashboard.blade.php
    // Contoh sederhana untuk menampilkan data dari controller

    // Pastikan Anda menggunakan layout yang sesuai
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Hari Ini</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="p-4 bg-blue-100 rounded-lg shadow">
                        <p class="text-sm font-medium text-blue-600">Total Peserta Magang</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $totalPeserta }}</p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-lg shadow">
                        <p class="text-sm font-medium text-green-600">Absensi Masuk Hari Ini</p>
                        <p class="text-3xl font-bold text-green-900">{{ $todayAttendanceCount }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-medium text-gray-900 mb-4">5 Absensi Terakhir</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Peserta</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Check In</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Check Out</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($latestAttendances as $attendance)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->user->name ?? 'User Dihapus' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_in ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_out ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>