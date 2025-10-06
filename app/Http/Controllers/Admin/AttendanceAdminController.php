<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceAdminController extends Controller
{
    // Tampilkan semua absensi dengan pagination
    public function index()
    {
        $attendances = Attendance::with('user')->latest()->paginate(20);
        return view('admin.attendances.index', compact('attendances'));
    }

    // Show, Edit, Update, Destroy untuk absensi spesifik
    // ... (logic CRUD/manajemen absensi)
}
