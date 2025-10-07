// File: resources/views/peserta/attendance/rekap.blade.php

<x-app-layout>
    {{-- FIX 1: Wrap dengan Alpine.js data untuk manajemen modal (pop-up) --}}
    <div class="flex min-h-screen bg-gray-50" x-data="{ showModal: false, imageUrl: '' }">

        <aside class="w-64 bg-white border-r">
            <div class="p-6 flex items-center space-x-2">
                <div class="bg-blue-500 text-white p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-800">AttendanceTracker</span>
            </div>
            <nav class="mt-6">
                {{-- Dashboard --}}
                <a href="{{ route('peserta.dashboard') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16z" />
                    </svg>
                    Dashboard
                </a>
                {{-- Attendance (Check-in/out) --}}
                <a href="{{ route('attendance.index') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Attendance
                </a>
                {{-- Daily Recap (Halaman Aktif) --}}
                <a href="{{ route('attendance.rekap') }}"
                    class="flex items-center px-6 py-3 text-blue-600 bg-blue-50 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h11M9 21V3m12 18V3" />
                    </svg>
                    Daily Recap
                </a>
            </nav>
        </aside>

        <main class="flex-1 py-10 px-6">
            {{-- Pesan sukses/error --}}
            @if(session('success'))
                <div class="p-3 mb-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-3 mb-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Rekapitulasi Absensi</h2>

                {{-- Filter --}}
                {{-- FIX 2: Menggunakan route 'attendance.rekap' yang benar --}}
                <form method="GET" action="{{ route('attendance.rekap') }}"
                    class="flex flex-wrap items-center gap-2 mb-4">
                    <input type="text" name="search" placeholder="Search records..." value="{{ request('search') }}"
                        class="border rounded px-3 py-1 text-sm">

                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="border rounded px-3 py-1 text-sm">

                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="border rounded px-3 py-1 text-sm">

                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                        Filter
                    </button>
                </form>

                {{-- Tabel Rekap --}}
                <div class="overflow-x-auto">
                    <table id="myTable" class="w-full border text-left text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50 text-gray-600">
                                <th class="px-3 py-2">Date</th>
                                <th class="px-3 py-2">Check In Photo</th>
                                <th class="px-3 py-2">Time Check In</th>
                                <th class="px-3 py-2">Check Out Photo</th>
                                <th class="px-3 py-2">Time Check Out</th>
                                <th class="px-3 py-2">Daily Report</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances ?? [] as $attendance)
                                <tr class="border-b hover:bg-gray-50">
                                    {{-- Tambahkan kolom tanggal untuk konteks --}}
                                    <td class="px-3 py-2 font-semibold">
                                        {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                    </td>

                                    {{-- FIX 3: Tambahkan fungsi klik untuk Check In Photo (Membuka Modal) --}}
                                    <td class="px-3 py-2">
                                        @if($attendance->check_in_photo)
                                            <a href="#"
                                                @click.prevent="showModal = true; imageUrl = '{{ asset('storage/' . $attendance->check_in_photo) }}'"
                                                class="cursor-pointer hover:opacity-75 transition duration-150 block">
                                                <img src="{{ asset('storage/' . $attendance->check_in_photo) }}"
                                                    class="w-24 h-16 rounded object-cover border" alt="Check In Photo">
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-3 py-2 w-5">
                                        {{ $attendance->check_in }}
                                    </td>

                                    {{-- FIX 4: Tambahkan fungsi klik untuk Check Out Photo (Membuka Modal) --}}
                                    <td class="px-3 py-2">
                                        @if($attendance->check_out_photo)
                                            <a href="#"
                                                @click.prevent="showModal = true; imageUrl = '{{ asset('storage/' . $attendance->check_out_photo) }}'"
                                                class="cursor-pointer hover:opacity-75 transition duration-150 block">
                                                <img src="{{ asset('storage/' . $attendance->check_out_photo) }}"
                                                    class="w-24 h-16 rounded object-cover border" alt="Check Out Photo">
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-3 py-2 w-5">
                                        {{ $attendance->check_out }}
                                    </td>
                                    <td
                                        class="px-3 py-2 text-gray-700 max-w-xs overflow-hidden text-ellipsis whitespace-nowrap">
                                        {{-- Gunakan Str::limit untuk pratinjau, dan title untuk detail --}}
                                        <p title="{{ $attendance->daily_report ?? '-' }}">
                                            {{ \Illuminate\Support\Str::limit($attendance->daily_report, 50) ?? '-' }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-gray-400">
                                        Belum ada data absensi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                {{-- Pagination --}}
                @if(isset($attendances) && method_exists($attendances, 'links'))
                    <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                        <div>
                            Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }}
                            of {{ $attendances->total() }} records
                        </div>
                        <div>
                            {{ $attendances->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </main>

        {{-- FIX 5: Modal (Lightbox) untuk Photo Review (x-data di bagian luar) --}}
        <div x-cloak x-show="showModal"
            class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-75 flex items-center justify-center p-4"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div @click.outside="showModal = false" class="relative max-w-4xl mx-auto p-0 rounded-lg shadow-xl"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">

                <button @click="showModal = false"
                    class="absolute top-[-40px] right-0 text-white hover:text-gray-300 rounded-full p-2 focus:outline-none text-4xl leading-none z-10">
                    &times;
                </button>

                {{-- Image container: uses imageUrl set by the link click --}}
                <img :src="imageUrl" alt="Full size attendance photo"
                    class="max-w-full max-h-[80vh] object-contain rounded-lg">
            </div>
        </div>

    </div>
</x-app-layout>