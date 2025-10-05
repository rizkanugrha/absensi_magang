<?php
namespace App\Http\Controllers\Peserta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\View\View;

class PesertaDashboard extends Controller
{
    public function index()
    {
        return view('peserta.dashboard-user'); // Pastikan file ini ada di resources/views/dashboard-user.blade.php
    }
}
