<?php

namespace App\Observers;

use App\Models\IuranTagihan;
use App\Notifications\IuranBaruNotification;

class IuranTagihanObserver
{
    public function created(IuranTagihan $tagihan): void
    {
        $tagihan->loadMissing('kk.kepalaKeluarga.user', 'iuran');

        $kepala = $tagihan->kk?->kepalaKeluarga;

        if ($kepala?->user && $tagihan->iuran) {
            $kepala->user->notify(new IuranBaruNotification($tagihan->iuran));
        }
    }
}