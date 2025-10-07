<?php
use App\Models\User;
?>
<x-app-layout>
    {{-- Menggunakan variabel $filters untuk mempertahankan input filter --}}
    @php
        // Ambil filter dari request untuk ditampilkan
        $startDate = $filters['start_date'] ?? 'N/A';
        $endDate = $filters['end_date'] ?? 'N/A';

        // Melakukan pencarian user untuk ditampilkan di info filter
        $userName = $filters['user_id']
            ? User::find($filters['user_id'])?->name ?? 'Tidak Ditemukan'
            : 'Semua Peserta';
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Rekapitulasi Absensi') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-50">
        <x-admin-aside />
        <main class="flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto space-y-6">

                {{-- Tombol Kembali ke Filter Form --}}
                <a href="{{ route('admin.rekap.form') }}"
                    class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    &larr; Kembali ke Filter
                </a>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        {{-- Informasi Filter yang Sedang Aktif --}}
                        <div class="mb-6 border-b pb-4">
                            <p class="text-md font-semibold text-gray-700">
                                Periode:
                                <span class="font-normal">{{ $startDate }}</span> hingga
                                <span class="font-normal">{{ $endDate }}</span>
                            </p>
                            <p class="text-md font-semibold text-gray-700">
                                Peserta:
                                <span class="font-normal">{{ $userName }}</span>
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            {{-- ID Tabel DIGANTI menjadi rekapTable --}}
                            <table class="min-w-full divide-y divide-gray-200 display" id="rekapTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        {{-- TOTAL 8 KOLOM --}}
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Peserta
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Check In
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Check Out
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Laporan Harian
                                        </th>


                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($rekapData as $attendance)
                                        <tr class="hover:bg-gray-50">
                                            {{-- Kolom 0: Nama Peserta --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $attendance->user?->name ?? 'User Dihapus' }}
                                            </td>
                                            {{-- Kolom 1: Tanggal --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                            </td>
                                            {{-- Kolom 2: Check In --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $attendance->check_in ?? '-' }}
                                            </td>
                                            {{-- Kolom 3: Check Out --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $attendance->check_out ?? '-' }}
                                            </td>
                                            {{-- Kolom 4: Laporan Harian --}}
                                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs overflow-hidden truncate">
                                                {{ $attendance->daily_report ?? '-' }}
                                            </td>


                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Tidak ada data absensi yang ditemukan sesuai filter.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- DataTables JavaScript Initialization --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                if (typeof DataTable !== 'undefined' && document.getElementById('rekapTable')) {
                                    new DataTable('#rekapTable', {
                                        dom: 'lBfrtip',
                                        buttons: [
                                            'copy', 'csv', 'excel', 'pdf', 'print'
                                        ],
                                        // Konfigurasi Kolom untuk menghindari error "Requested unknown parameter"
                                        "columnDefs": [
                                            { "orderable": false, "targets": [4] }
                                        ],
                                        "order": [] // Nonaktifkan sorting default agar DataTables tidak crash di awal
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>