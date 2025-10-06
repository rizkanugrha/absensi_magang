<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password; // Digunakan untuk validasi password
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserManagement extends Controller
{
    /**
     * Menampilkan daftar semua peserta.
     */
    public function index(): View
    {
        // Hanya menampilkan user dengan role 'peserta'
        $users = User::where('role', 'peserta')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk buat user baru.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan user baru (implementasi CRUD Create).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'user_id' => ['required', 'string', 'max:255', 'unique:users,user_id'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', Password::defaults()],
            'password_confirmation' => ['required'],
            'role' => ['required', Rule::in(['peserta', 'admin'])],
            'jurusan' => ['required', 'string', 'max:255'],
            'instansi' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'jurusan' => $request->jurusan,
            'instansi' => $request->instansi
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Peserta ' . $request->name . ' berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk edit user.
     */
    public function edit(User $user): View
    {
        // Menggunakan Route Model Binding ($user)
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user (implementasi CRUD Update).
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'min:5', 'max:255'],
            'user_id' => ['sometimes', 'string', 'max:255', Rule::unique('users', 'user_id')->ignore($user->id)],
            'email' => ['sometimes', 'nullable', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['sometimes', Rule::in(['peserta', 'admin'])],
            'jurusan' => ['sometimes', 'string', 'max:255'],
            'instansi' => ['sometimes', 'string', 'max:255'],
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Peserta ' . $user->name . ' berhasil diperbarui!');
    }

    /**
     * ✅Reset Kata Sandi Pengguna (Oleh Admin).
     */
    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        // Validasi, pastikan ada password baru dan konfirmasinya
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
            'password_confirmation' => ['required'],

        ]);

        // Update password pengguna
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect kembali ke halaman edit dengan pesan sukses
        return redirect()->route('admin.users.index', $user)->with('success', 'Kata sandi peserta berhasil diperbarui!');
    }

    /**
     * Hapus user (implementasi CRUD Delete).
     */
    public function destroy(User $user): RedirectResponse
    {
        // Pencegahan: Admin tidak boleh menghapus akunnya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Peserta ' . $name . ' berhasil dihapus!');
    }
}
