<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])] 
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Helper method cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }
    public function warga()
    {
        return $this->hasOne(\App\Models\Warga::class, 'user_id');
    }
    // app/Models/User.php
    public function kk()
    {
        return $this->hasOneThrough(
            \App\Models\KartuKeluarga::class, // target
            \App\Models\Warga::class,          // perantara
            'user_id',           // FK di tabel warga → users
            'id',                // PK di tabel kartu_keluarga
            'id',                // PK di tabel users
            'kartu_keluarga_id'  // FK di tabel warga → kartu_keluarga
        );
    }
}