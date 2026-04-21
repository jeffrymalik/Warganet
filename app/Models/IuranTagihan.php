<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IuranTagihan extends Model
{
    protected $table = 'iuran_tagihan';

    protected $fillable = [
        'iuran_id', 'kk_id', 'order_id', 'snap_token',
        'status', 'metode_bayar', 'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function iuran()
    {
        return $this->belongsTo(IuranWarga::class, 'iuran_id');
    }

    public function kk()
    {
        return $this->belongsTo(Kk::class, 'kk_id');
    }
}