<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    // Menampilkan formulir filter periode rekap
    public function showRekapForm()
    {
        // Ambil daftar user untuk dropdown filter
        $users = User::where('role', 'peserta')->get();
        return view('admin.rekap.form', compact('users'));
    }

    // Logika untuk menghasilkan rekap berdasarkan filter
    public function generateRekap(Request $request)
    {
        $query = Attendance::query()->with('user');

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $userId = $request->input('user_id');

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $rekapData = $query->latest('date')->paginate(30);

        return view('admin.rekap.results', [
            'rekapData' => $rekapData,
            'filters' => $request->all(),
        ]);
    }
}
