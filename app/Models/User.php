<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',   // ID unik login
        'password',
        'role',      // peserta / admin
        'jurusan',
        'instansi',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi (JSON, API, dll).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // otomatis hash saat diset
        ];
    }

    /**
     * Override username yang digunakan untuk autentikasi.
     */
    public function username(): string
    {
        return 'user_id';
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Pastikan App\Models\User sudah di-import
    }



}
