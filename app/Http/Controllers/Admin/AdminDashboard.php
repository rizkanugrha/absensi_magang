<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\View\View;

class AdminDashboard extends Controller
{
    /**
     * Menampilkan dashboard admin dengan ringkasan data.
     */
    public function index(): View
    {
        // 1. Ambil total peserta (user dengan role 'peserta')
        $totalPeserta = User::where('role', 'peserta')->count();

        // 2. Ambil total absensi masuk hari ini
        // Kita asumsikan zona waktu sudah diatur dengan benar (misal di config/app.php)
        $todayAttendanceCount = Attendance::whereDate('date', now()->toDateString())
            ->whereNotNull('check_in')
            ->count();

        // 3. Ambil data absensi terbaru (misalnya 5 data terakhir)
        $latestAttendances = Attendance::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'totalPeserta' => $totalPeserta,
            'todayAttendanceCount' => $todayAttendanceCount,
            'latestAttendances' => $latestAttendances,
        ]);
    }
}