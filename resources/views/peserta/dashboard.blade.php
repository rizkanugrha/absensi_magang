<x-app-layout>

    <div class="flex min-h-screen bg-gray-50">

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
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 
                    {{ request()->routeIs('peserta.dashboard') ? 'text-white bg-blue-600 font-bold border-l-4 border-yellow-400 hover:bg-blue-600 hover:text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16z" />
                    </svg>
                    Dashboard
                </a>
                {{-- Attendance (Check-in/out) --}}
                <a href="{{ route('attendance.index') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 
                    {{ request()->routeIs('attendance.index') ? 'text-white bg-blue-600 font-bold border-l-4 border-yellow-400 hover:bg-blue-600 hover:text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Attendance
                </a>
                {{-- Daily Recap --}}
                <a href="{{ route('attendance.rekap') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 
                    {{ request()->routeIs('attendance.rekap') ? 'text-white bg-blue-600 font-bold border-l-4 border-yellow-400 hover:bg-blue-600 hover:text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h11M9 21V3m12 18V3" />
                    </svg>
                    Daily Recap
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-6">

            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <h3 class="text-lg font-bold">Selamat Datang, {{ $user->name }}!</h3>
                <p class="text-gray-600">Ringkasan absensi dan agenda Anda ditampilkan di sini.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h3 class="text-sm text-gray-500">Total Kehadiran</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalAttendance }}</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h3 class="text-sm text-gray-500">Status Hari Ini</h3>
                    {{-- Menampilkan status hari ini --}}
                    @if ($todayAttendance && $todayAttendance->check_out)
                        <p class="text-2xl font-bold text-green-600">Selesai</p>
                    @elseif ($todayAttendance && $todayAttendance->check_in)
                        <p class="text-2xl font-bold text-yellow-600">Check-In</p>
                    @else
                        <p class="text-2xl font-bold text-red-600">Belum Absen</p>
                    @endif
                </div>
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h3 class="text-sm text-gray-500">Agenda Terdekat</h3>
                    {{-- Menampilkan jumlah agenda terdekat --}}
                    <p class="text-2xl font-bold text-purple-600">{{ $todayAgendas->count() }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white p-6 shadow rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Agenda Terdekat</h3>
                    <ul class="space-y-3 text-sm">
                        @forelse ($todayAgendas as $agenda)
                            <li class="flex justify-between border-b pb-2">
                                <span>{{ $agenda->title }}</span>
                                <span class="text-gray-500">{{ \Carbon\Carbon::parse($agenda->date)->format('d M') }} |
                                    {{ $agenda->start_time }}</span>
                            </li>
                        @empty
                            <li class="text-center text-gray-500">Tidak ada agenda dalam waktu dekat.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white p-6 shadow rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Statistik Absensi (Total)</h3>
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari PHP untuk Chart
        const chartData = {
            hadir: {{ $chartData->hadir ?? 0 }},
            alpha: {{ $chartData->alpha ?? 0 }},
        };

        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('attendanceChart');

            if (ctx) {
                new Chart(ctx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Hadir', 'Alpha (Tidak Absen/Tugas Luar, dll)'],
                        datasets: [{
                            data: [chartData.hadir, chartData.alpha],
                            backgroundColor: ['#16a34a', '#ef4444'] // Hijau untuk hadir, Merah untuk alpha
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
```<ctrl63>