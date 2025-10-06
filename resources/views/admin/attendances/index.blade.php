<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Semua Absensi Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                &larr; Kembali ke Dashboard
            </a>
            {{-- Status Messages --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-200 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Daftar Semua Catatan Absensi</h3>

                <div class="overflow-x-auto">
                    {{-- Tabel Data Absensi --}}
                    <table id="attendanceTable" class="w-full text-sm text-left text-gray-500 min-w-full">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Peserta
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Check In
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Check Out
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Laporan Harian
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Foto In/Out
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            {{-- Memastikan $attendances adalah variabel yang dikirim dari controller --}}
                            @forelse ($attendances as $attendance)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{-- Menggunakan null safe operator (?->) untuk mencegah error jika user dihapus
                                        --}}
                                        {{ $attendance->user?->name ?? 'User Dihapus' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $attendance->date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $attendance->check_in ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $attendance->check_out ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 max-w-xs truncate">
                                        {{ $attendance->daily_report ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 flex flex-col space-y-1">
                                        @if ($attendance->check_in_photo)
                                            <a href="{{ asset('storage/' . $attendance->check_in_photo) }}" target="_blank"
                                                class="text-xs text-blue-600 hover:underline">Lihat Foto Check In</a>
                                        @else
                                            <span class="text-xs text-gray-400">N/A</span>
                                        @endif
                                        @if ($attendance->check_out_photo)
                                            <a href="{{ asset('storage/' . $attendance->check_out_photo) }}" target="_blank"
                                                class="text-xs text-blue-600 hover:underline">Lihat Foto Check Out</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada catatan absensi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Script DataTables --}}
    {{-- Asumsi jQuery dan DataTables JS/CSS sudah dimuat di layouts/app.blade.php --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('attendanceTable')) {
                // Inisialisasi DataTables
                new DataTable('#attendanceTable', {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    // Menonaktifkan ordering pada kolom foto dan aksi
                    "columnDefs": [
                        { "orderable": false, "targets": [5] }
                    ]
                });
            }
        });
    </script>
</x-app-layout>