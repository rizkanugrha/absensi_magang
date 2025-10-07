
<x-app-layout>
    {{-- FIX 2: Logic PHP untuk menentukan status saat ini --}}
    @php
        $hasCheckedIn = $todayAttendance && $todayAttendance->check_in;
        $hasCheckedOut = $todayAttendance && $todayAttendance->check_out;
        $canCheckIn = !$hasCheckedIn;
        $canCheckOut = $hasCheckedIn && !$hasCheckedOut;

        $statusText = $canCheckIn ? 'Belum Absen' : ($canCheckOut ? 'Sudah Check In' : ($hasCheckedOut ? 'Selesai Absen' : 'Status Tidak Diketahui'));
        $statusColor = $canCheckIn ? 'text-red-600' : ($canCheckOut ? 'text-green-600' : ($hasCheckedOut ? 'text-blue-600' : 'text-gray-600'));
    @endphp

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
                <a href="{{ route('peserta.dashboard') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('attendance.index') }}"
                    class="flex items-center px-6 py-3 text-blue-600 bg-blue-50 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Attendance
                </a>
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

        <div class="py-6 w-full">
            {{-- FIX 3: Tambahkan pesan status --}}
            @if (session('success'))
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kolom Kiri: Camera --}}
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Camera Preview</h3>
                        <div id="my_camera" class="w-full h-64 border rounded mb-4"></div>
                        <div id="webcam_status" class="text-xs text-red-500 mb-2"></div>

                        {{-- FIX 4: Tombol Take Photo hanya aktif jika Check In/Out masih mungkin --}}
                        <button type="button" onclick="take_snapshot()"
                            class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded {{ (!$canCheckIn && !$canCheckOut) ? 'disabled:opacity-50 disabled:cursor-not-allowed' : '' }}"
                            {{ (!$canCheckIn && !$canCheckOut) ? 'disabled' : '' }}>
                            📸 Take Photo
                        </button>

                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Preview:</p>
                            <img id="preview_photo" src="" alt="Preview"
                                class="border rounded w-full max-h-64 object-contain">
                        </div>
                    </div>

                    {{-- Kolom Kanan: Status & Check-in/out --}}
                    <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Status & Action</h3>
                            {{-- FIX 5: Tampilan Status Dinamis --}}
                            <p class="mb-4">
                                Current Status:
                                <span class="font-medium {{ $statusColor }}">{{ $statusText }}</span>
                            </p>

                            {{-- Form Check In --}}
                            <form id="checkinForm" action="{{ route('attendance.checkin') }}" method="POST"
                                class="mb-6">
                                @csrf
                                <input type="hidden" name="photo" id="photo_checkin">
                                {{-- FIX 6: Disable Check In jika sudah Check In atau sudah Check Out --}}
                                <button id="btnCheckIn" type="submit"
                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ !$canCheckIn ? 'disabled' : '' }}>
                                    ✅ Check In
                                </button>
                            </form>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Check Out</h3>

                            {{-- Form Check Out --}}
                            <form id="checkoutForm" action="{{ route('attendance.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="photo" id="photo_checkout">

                                <div class="mb-3">
                                    <label for="daily_report" class="block mb-1 font-medium text-gray-700">
                                        Daily Report
                                    </label>
                                    {{-- FIX 7: Disable report/button jika Check Out belum memungkinkan --}}
                                    <textarea name="daily_report" id="daily_report" rows="3"
                                        class="w-full border rounded p-2" required
                                        {{ !$canCheckOut ? 'disabled' : '' }}>{{ $canCheckOut ? ($todayAttendance->daily_report ?? '') : 'Sudah Check Out / Belum Check In' }}</textarea>
                                </div>

                                <button id="btnCheckOut" type="submit"
                                    class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ !$canCheckOut ? 'disabled' : '' }}>
                                    ⏹️ Check Out
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Script WebcamJS --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
        <script>
            // FIX 8: Store initial status from server to manage client-side logic
            const CAN_CHECK_IN = @json($canCheckIn);
            const CAN_CHECK_OUT = @json($canCheckOut);

            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90,
                constraints: {
                    width: 1280,
                    height: 720,
                    facingMode: "user"
                }
            });

            Webcam.attach('#my_camera');

            Webcam.on('error', function (err) {
                document.getElementById('webcam_status').innerHTML = 'Gagal mengakses kamera. Mohon pastikan kamera tidak digunakan aplikasi lain dan berikan izin di browser Anda. Detail Error: ' + err.name;
            });

            let lastPhoto = '';

            function take_snapshot() {
                Webcam.snap(function (data_uri) {
                    lastPhoto = data_uri;

                    document.getElementById('photo_checkin').value = data_uri;
                    document.getElementById('photo_checkout').value = data_uri;
                    document.getElementById('preview_photo').src = data_uri;

                    // FIX 9: Hanya aktifkan tombol yang relevan setelah mengambil foto
                    if (CAN_CHECK_IN) {
                        document.getElementById('btnCheckIn').disabled = false;
                    }
                    if (CAN_CHECK_OUT) {
                        document.getElementById('btnCheckOut').disabled = false;
                    }
                });
            }

            document.getElementById('checkinForm').addEventListener('submit', function (e) {
                if (!CAN_CHECK_IN) {
                    e.preventDefault();
                }
                if (!lastPhoto && CAN_CHECK_IN) {
                    e.preventDefault();
                    console.error('Validation Error: Please take a photo before check-in!');
                }
            });

            document.getElementById('checkoutForm').addEventListener('submit', function (e) {
                if (!CAN_CHECK_OUT) {
                    e.preventDefault();
                    return;
                }

                if (!lastPhoto) {
                    e.preventDefault();
                    console.error('Validation Error: Please take a photo before check-out!');
                    return;
                }
                if (!document.getElementById('daily_report').value.trim()) {
                    e.preventDefault();
                    console.error('Validation Error: Please fill in the daily report before check-out!');
                }
            });
        </script>
</x-app-layout>