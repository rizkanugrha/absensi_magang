<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard-user'); // Pastikan file ini ada di resources/views/dashboard-user.blade.php
    }
}
