<?php

namespace App\Observers;

use App\Models\IuranTagihan;
use App\Notifications\IuranBaruNotification;

class IuranTagihanObserver
{
    public function created(IuranTagihan $tagihan): void
    {
        $kepala = $tagihan->kartuKeluarga->kepalaKeluarga;
        if ($kepala?->user) {
            $kepala->user->notify(new IuranBaruNotification($tagihan->iuranWarga));
        }
    }
}