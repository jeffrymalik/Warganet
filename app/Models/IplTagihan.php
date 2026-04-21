<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IplTagihan extends Model
{
    protected $table = 'ipl_tagihan';

    protected $fillable = [
        'kk_id', 'bulan', 'tahun', 'nominal', 'status', 'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Nama bulan dalam bahasa Indonesia
    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        return $bulan[$this->bulan] ?? '-';
    }

    public function kk()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kk_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(IplPembayaran::class, 'tagihan_id');
    }
}