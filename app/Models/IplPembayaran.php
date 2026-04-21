<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IplPembayaran extends Model
{
    protected $table = 'ipl_pembayaran';

    protected $fillable = [
        'tagihan_id', 'order_id', 'snap_token',
        'jumlah', 'status', 'metode_bayar', 'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function tagihan()
    {
        return $this->belongsTo(IplTagihan::class, 'tagihan_id');
    }
}