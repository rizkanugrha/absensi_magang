<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Peserta\AttendanceController;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Peserta\PesertaDashboard;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
});

// Route khusus peserta
Route::middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/peserta/dashboard', [PesertaDashboard::class, 'index'])->name('peserta.dashboard');

    // Absensi hanya untuk peserta
    Route::get('/peserta/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/peserta/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/peserta/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    Route::get('/peserta/attendance/rekap', [AttendanceController::class, 'rekap'])->name('attendance.rekap');
    Route::get('/peserta/attendance/rekap', [AttendanceController::class, 'rekap'])->name('rekap');

});

// Profil user (boleh diakses semua yang login)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


// Import route auth bawaan Breeze/Fortify
require __DIR__ . '/auth.php';
