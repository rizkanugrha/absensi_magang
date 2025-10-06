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
                {{-- ✅ FIX 1: Menggunakan rute dashboard peserta yang benar --}}
                <a href="{{ route('peserta.dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16z" />
                    </svg>
                    Dashboard
                </a>
                {{-- ✅ FIX 2: Menggunakan rute attendance index yang benar dan status aktif --}}
                <a href="{{ route('attendance.index') }}"
                    class="flex items-center px-6 py-3 text-blue-600 bg-blue-50 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Attendance
                </a>
                {{-- ✅ FIX 3: Menggunakan rute rekap yang benar --}}
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kolom Kiri: Camera --}}
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Camera Preview</h3>
                        <div id="my_camera" class="w-full h-64 border rounded mb-4"></div>

                        <button type="button" onclick="take_snapshot()"
                            class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
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
                            <h3 class="text-lg font-semibold mb-4">Check In</h3>
                            <p class="mb-4">
                                Current Status:
                                <span class="font-medium text-green-600">Checked In</span>
                            </p>

                            {{-- Form Check In --}}
                            {{-- ✅ FIX 4: Perbaiki nama rute menjadi 'attendance.checkin' (asumsi) --}}
                            <form id="checkinForm" action="{{ route('attendance.checkin') }}" method="POST"
                                class="mb-6">
                                @csrf
                                <input type="hidden" name="photo" id="photo_checkin">
                                <button id="btnCheckIn" type="submit"
                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                    ✅ Check In
                                </button>
                            </form>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Check Out</h3>

                            {{-- Form Check Out --}}
                            {{-- ✅ FIX 4: Perbaiki nama rute menjadi 'attendance.checkout' (asumsi) --}}
                            <form id="checkoutForm" action="{{ route('attendance.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="photo" id="photo_checkout">

                                <div class="mb-3">
                                    <label for="daily_report" class="block mb-1 font-medium text-gray-700">
                                        Daily Report
                                    </label>
                                    <textarea name="daily_report" id="daily_report" rows="3"
                                        class="w-full border rounded p-2" required></textarea>
                                </div>

                                <button id="btnCheckOut" type="submit"
                                    class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
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
            Webcam.set({
                width: 480,
                height: 360,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');

            let lastPhoto = '';

            function take_snapshot() {
                Webcam.snap(function (data_uri) {
                    lastPhoto = data_uri;

                    document.getElementById('photo_checkin').value = data_uri;
                    document.getElementById('photo_checkout').value = data_uri;
                    document.getElementById('preview_photo').src = data_uri;

                    // Aktifkan tombol setelah ada foto
                    document.getElementById('btnCheckIn').disabled = false;
                    document.getElementById('btnCheckOut').disabled = false;
                });
            }

            document.getElementById('checkinForm').addEventListener('submit', function (e) {
                if (!lastPhoto) {
                    e.preventDefault();
                    // ✅ FIX 5: Ganti alert() menjadi console.error()
                    console.error('Validation Error: Please take a photo before check-in!');
                }
            });

            document.getElementById('checkoutForm').addEventListener('submit', function (e) {
                if (!lastPhoto) {
                    e.preventDefault();
                    // ✅ FIX 5: Ganti alert() menjadi console.error()
                    console.error('Validation Error: Please take a photo before check-out!');
                    return;
                }
                if (!document.getElementById('daily_report').value.trim()) {
                    e.preventDefault();
                    // ✅ FIX 5: Ganti alert() menjadi console.error()
                    console.error('Validation Error: Please fill in the daily report before check-out!');
                }
            });
        </script>
</x-app-layout>
