<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-50">

        <x-admin-aside />

        <main class="flex-1 py-12 px-6">
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
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                        </td>
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