<?php

namespace App\Http\Controllers\Peserta;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;


class AttendanceController extends Controller
{
    protected $tz;

    public function __construct()
    {
        // pastikan .env APP_TIMEZONE=Asia/Jakarta
        $this->tz = config('app.timezone') ?: 'Asia/Jakarta';

        // jika route belum dilindungi auth, aktifkan middleware:
        // $this->middleware('auth');
    }

    public function index()
    {
        $attendances = Attendance::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        return view('peserta.attendance.index', compact('attendances'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'photo' => 'required|string',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }

        $photoData = $request->input('photo');

        if ($photoData) {
            $folder = 'check_in_photos';
            $path = $this->savePhoto($photoData, $folder);

            Attendance::updateOrCreate(
                ['user_id' => $userId, 'date' => now($this->tz)->toDateString()],
                [
                    'check_in' => now($this->tz)->format('H:i:s'),
                    'check_in_photo' => $path,
                ]
            );

            return back()->with('success', 'Absen masuk berhasil!');
        }

        return back()->with('error', 'Foto gagal diambil.');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'photo' => 'required|string',
            'daily_report' => 'required|string',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }

        $photoData = $request->input('photo');

        if ($photoData) {
            $folder = 'check_out_photos';
            $path = $this->savePhoto($photoData, $folder);

            // Old Code snippet around line 82:
/*
            if ($attendance) {
                $attendance->update([
                    'check_out' => now($this->tz)->format('H:i:s'),
                    'check_out_photo' => $path,
                    'daily_report' => $request->daily_report,
                ]);
            } else {
                // Kalau tidak ada record checkin, bisa juga create (opsional)
                Attendance::create([
                    'user_id' => $userId,
                    'date' => now($this->tz)->toDateString(),
                    'check_out' => now($this->tz)->format('H:i:s'),
                    'check_out_photo' => $path,
                    'daily_report' => $request->daily_report,
                ]);
            }

            return back()->with('success', 'Absen keluar berhasil!');
*/

            // ✅ FIX: Enforce check-in must exist and check-out must not exist yet.
            $attendance = Attendance::where('user_id', $userId)
                ->where('date', now($this->tz)->toDateString())
                ->first();

            if (!$attendance) {
                return back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
            }

            if ($attendance->check_out) {
                return back()->with('error', 'Anda sudah melakukan absen keluar hari ini.');
            }

            if (!$attendance->check_in) {
                // Should not happen if checkIn uses updateOrCreate correctly, but good fail-safe
                return back()->with('error', 'Terjadi kesalahan: Absen masuk belum tercatat dengan benar.');
            }

            // Proceed with update since check-in exists and check-out is null
            $attendance->update([
                'check_out' => now($this->tz)->format('H:i:s'),
                'check_out_photo' => $path,
                'daily_report' => $request->daily_report,
            ]);

            return back()->with('success', 'Absen keluar berhasil!');
        }

        return back()->with('error', 'Foto gagal diambil.');
    } // ... rest of the file

    /**
     * Simpan data URI base64 sebagai file di storage/public/<folder>
     * Return path relatif seperti: check_in_photos/xxxx.jpg
     */
    private function savePhoto(string $photoData, string $folder): string
    {
        // deteksi header data URI jika ada
        if (Str::startsWith($photoData, 'data:')) {
            [$meta, $data] = explode(',', $photoData, 2);
            if (preg_match('/^data:image\/(\w+);base64$/', $meta, $m)) {
                $ext = $m[1];
                if ($ext === 'jpeg')
                    $ext = 'jpg';
            } else {
                $ext = 'jpg';
            }
        } else {
            // kalau tidak ada header, anggap jpg
            $data = $photoData;
            $ext = 'jpg';
        }

        $data = str_replace(' ', '+', $data);
        $fileName = uniqid('img_') . '.' . $ext;
        $relativePath = $folder . '/' . $fileName;

        Storage::disk('public')->put($relativePath, base64_decode($data));

        return $relativePath;
    }

    public function rekap(Request $request)
    {
        // 1. Dapatkan ID pengguna yang sedang login
        $userId = Auth::id();

        // 2. Inisialisasi query dan filter berdasarkan user_id
        $query = Attendance::where('user_id', $userId);

        // Filter berdasarkan search (daily_report / date)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('daily_report', 'like', '%' . $request->search . '%')
                    ->orWhere('date', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($request->start_date && $request->end_date) {
            // Pastikan format tanggal sudah benar (default Laravel sudah benar)
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        return view('peserta.attendance.rekap', compact('attendances'));
    }
}
