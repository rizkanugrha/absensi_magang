<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">

        <!-- Sidebar Admin (Menu Manajemen) -->
        <aside class="w-64 bg-white border-r shadow-lg">
            <div class="p-6 flex items-center space-x-2 border-b">
                <span class="text-xl font-extrabold text-blue-800">Admin Management</span>
            </div>
            <nav class="mt-6">
                {{-- Dashboard Aktif --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-3 text-white bg-blue-600 font-bold border-l-4 border-yellow-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2.586l3.293 3.293a1 1 0 001.414-1.414L10.707 2.293z" />
                    </svg>
                    Dashboard
                </a>

                {{-- Manajemen User --}}
                <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Manajemen User</h4>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                    Data Peserta
                </a>

                {{-- Manajemen Absensi --}}
                <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Manajemen Absensi</h4>

                {{-- 1. Kelola Absensi Peserta (Lihat Semua Absensi) --}}
                <a href="{{ route('admin.attendances.index') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Kelola Absensi
                </a>

                {{-- 2. Rekap Absensi (Per-Periode) --}}
                <a href="{{ route('admin.rekap.form') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Rekap Periode
                </a>
            </nav>
        </aside>

        <!-- Main Content Dashboard -->
        <main class="flex-1 py-12 px-6">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
            </x-slot>

            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Hari Ini</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        {{-- Total Peserta --}}
                        <div class="p-4 bg-blue-100 rounded-lg shadow border border-blue-200">
                            <p class="text-sm font-medium text-blue-600">Total Peserta Magang</p>
                            <p class="text-3xl font-bold text-blue-900">{{ $totalPeserta }}</p>
                        </div>
                        {{-- Absensi Hari Ini --}}
                        <div class="p-4 bg-green-100 rounded-lg shadow border border-green-200">
                            <p class="text-sm font-medium text-green-600">Absensi Masuk Hari Ini</p>
                            <p class="text-3xl font-bold text-green-900">{{ $todayAttendanceCount }}</p>
                        </div>
                        {{-- Link ke Manajemen User --}}
                        <a href="{{ route('admin.users.index') }}"
                            class="p-4 bg-yellow-100 rounded-lg shadow border border-yellow-200 hover:bg-yellow-200 transition duration-150">
                            <p class="text-sm font-medium text-yellow-600">Manajemen</p>
                            <p class="text-xl font-bold text-yellow-900 mt-1">Kelola Peserta &raquo;</p>
                        </a>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $countLatestAttendances }} Absensi Terakhir
                    </h3>
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
                                @forelse ($latestAttendances as $attendance)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- ✅ FIX: Menggunakan operator Null Safe (?->) --}}
                                            {{ $attendance->user?->name ?? 'User Dihapus' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_in ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_out ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                            Belum ada data absensi terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </main>
    </div>
</x-app-layout>