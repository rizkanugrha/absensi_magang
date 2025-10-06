<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">

        <!-- Sidebar -->
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
                {{-- Dashboard (Aktif) --}}
                <a href="{{ route('peserta.dashboard') }}"
                    class="flex items-center px-6 py-3 text-blue-600 bg-blue-50 font-medium">
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
                {{-- Daily Recap --}}
                <a href="{{ route('attendance.rekap') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h11M9 21V3m12 18V3" />
                    </svg>
                    Daily Recap
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">

            <!-- Welcome -->
            <div class="bg-white p-6 shadow rounded-lg mb-6">
                {{-- ✅ FIX 3: Menggunakan Null Safe Operator untuk Auth::user() --}}
                <h3 class="text-lg font-bold">Selamat Datang, {{ Auth::user()?->name ?? 'User' }}!</h3>
                <p class="text-gray-600">Gunakan dashboard ini untuk melihat ringkasan rapat, agenda, dan kehadiran DPR.
                </p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h3 class="text-sm text-gray-500">Rapat Hari Ini</h3>
                    <p class="text-2xl font-bold text-blue-600">5</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h3 class="text-sm text-gray-500">Anggota Hadir</h3>
                    <p class="text-2xl font-bold text-green-600">120</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h3 class="text-sm text-gray-500">Agenda Minggu Ini</h3>
                    <p class="text-2xl font-bold text-yellow-600">12</p>
                </div>
            </div>

            <!-- Grid Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Agenda List -->
                <div class="bg-white p-6 shadow rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Agenda Terdekat</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between border-b pb-2">
                            <span>Rapat Komisi A</span>
                            <span class="text-gray-500">10:00 WIB</span>
                        </li>
                        <li class="flex justify-between border-b pb-2">
                            <span>Rapat Badan Anggaran</span>
                            <span class="text-gray-500">13:00 WIB</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sidang Paripurna</span>
                            <span class="text-gray-500">15:00 WIB</span>
                        </li>
                    </ul>
                </div>

                <!-- Attendance Chart -->
                <div class="bg-white p-6 shadow rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Statistik Kehadiran</h3>
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pastikan DOM sudah dimuat sebelum menjalankan script chart
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('attendanceChart');

            // Cek jika canvas element ditemukan
            if (ctx) {
                new Chart(ctx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Hadir', 'Izin', 'Alpha'],
                        datasets: [{
                            data: [120, 15, 5],
                            backgroundColor: ['#16a34a', '#facc15', '#ef4444']
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