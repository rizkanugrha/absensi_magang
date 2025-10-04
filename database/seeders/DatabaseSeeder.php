<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Administrator',
            'user_id' => 'admin01',
            'password' => Hash::make('admin123'), // jangan lupa hash password
            'role' => 'admin',
            'jurusan' => null,
            'instansi' => 'Admin WEB Magang',
        ]);

        // Contoh peserta
        User::create([
            'name' => 'Peserta Magang',
            'user_id' => 'MG001',
            'password' => Hash::make('peserta123'),
            'role' => 'peserta',
            'jurusan' => 'Teknik Informatika',
            'instansi' => 'Politeknik Negeri',
        ]);
    }
}
