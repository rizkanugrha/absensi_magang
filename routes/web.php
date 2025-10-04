<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    //Route::resource('/admin/users', \App\Http\Controllers\Admin\UserController::class);
    //Route::resource('/admin/attendances', \App\Http\Controllers\Admin\AttendanceController::class);
});

// Route khusus peserta
Route::middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Absensi hanya untuk peserta
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    Route::get('/attendance/rekap', [AttendanceController::class, 'rekap'])->name('attendance.rekap');
    Route::get('/rekap', [AttendanceController::class, 'rekap'])->name('rekap');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Profil user (boleh diakses semua yang login)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


// Import route auth bawaan Breeze/Fortify
require __DIR__ . '/auth.php';
