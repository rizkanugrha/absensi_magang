<?php
namespace App\Http\Controllers\Peserta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Agenda; // Tambahkan model Agenda
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Tambahkan Auth

class PesertaDashboard extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $today = now()->toDateString();

        // 1. Data Ringkasan Absensi User
        $totalAttendance = Attendance::where('user_id', $user->id)
            ->whereNotNull('check_in') // Menghitung hanya yang check in
            ->count();

        // 2. Cek status absensi hari ini
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // 3. Agenda Hari Ini (atau beberapa hari ke depan)
        $todayAgendas = Agenda::whereDate('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->limit(5)
            ->get();

        // 4. Data untuk Chart (contoh 30 hari terakhir)
        $chartData = Attendance::where('user_id', $user->id)
            ->selectRaw('SUM(CASE WHEN check_in IS NOT NULL THEN 1 ELSE 0 END) as hadir')
            ->selectRaw('SUM(CASE WHEN check_in IS NULL THEN 1 ELSE 0 END) as alpha')
            ->first(); // Cukup ambil ringkasan total

        return view('peserta.dashboard', [
            'user' => $user,
            'todayAttendance' => $todayAttendance,
            'totalAttendance' => $totalAttendance,
            'todayAgendas' => $todayAgendas,
            'chartData' => $chartData,
        ]);
    }
}