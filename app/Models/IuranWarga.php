<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IuranWarga extends Model
{
    protected $table = 'iuran_warga';

    protected $fillable = [
        'nama', 'deskripsi', 'nominal', 'due_date', 'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function tagihan()
    {
        return $this->hasMany(IuranTagihan::class, 'iuran_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Berapa KK sudah lunas
    public function getTotalLunasAttribute(): int
    {
        return $this->tagihan()->where('status', 'lunas')->count();
    }

    // Berapa KK belum bayar
    public function getTotalBelumBayarAttribute(): int
    {
        return $this->tagihan()->where('status', '!=', 'lunas')->count();
    }

        public function kk()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kk_id');
    }
}