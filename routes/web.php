<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Peserta\AttendanceController;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Peserta\PesertaDashboard;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\UserManagement;
use App\Http\Controllers\Admin\AttendanceAdminController;
use App\Http\Controllers\Admin\RekapController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//  Redirect root '/' ke halaman login jika belum login
Route::get('/', function () {
    return redirect()->route('login');
});

// --- ROUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // MANAJEMEN PENGGUNA (CRUD)
    Route::resource('/admin/users', UserManagement::class, [
        'names' => 'admin.users',
    ]);
    Route::patch('/users/{user}/password', [UserManagement::class, 'updatePassword'])->name('admin.users.updatePassword');

    // MANAJEMEN ABSENSI (CRUD)
    Route::resource('/admin/attendances', AttendanceAdminController::class, [
        'names' => 'admin.attendances',
    ]);
    // Rute CRUD Agenda
    Route::resource('/admin/agenda', AgendaController::class, ['names' => 'admin.agenda']);

    //  REKAP ABSENSI PERIODE
    Route::get('/admin/rekap', [RekapController::class, 'showRekapForm'])->name('admin.rekap.form');
    Route::get('/admin/rekap/generate', [RekapController::class, 'generateRekap'])->name('admin.rekap.generate');
});


// --- ROUTE KHUSUS PESERTA ---
Route::middleware(['auth', 'role:peserta'])->group(function () {
    // Dashboard Peserta
    Route::get('/peserta/dashboard', [PesertaDashboard::class, 'index'])->name('peserta.dashboard');

    // Absensi (Tanpa Prefix 'peserta.' pada nama rute)
    Route::get('/peserta/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/peserta/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/peserta/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');

    // Rekap Peserta
    Route::get('/peserta/attendance/rekap', [AttendanceController::class, 'rekap'])->name('attendance.rekap');
    Route::get('/peserta/rekap', [AttendanceController::class, 'rekap'])->name('rekap');
});

// --- ROUTE UMUM (Profile) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Import route auth bawaan Breeze/Fortify
require __DIR__ . '/auth.php';
