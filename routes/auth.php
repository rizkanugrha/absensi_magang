<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
// ... (use statements lainnya)
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

});

Route::middleware('auth')->group(function () {

    /*
Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
->name('password.confirm');

Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

Route::put('password', [PasswordController::class, 'update'])->name('password.update');
*/
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});