<?php

namespace App\Observers;

use App\Models\PermohonanSurat;
use App\Models\User;
use App\Notifications\SuratBaruNotification;
use App\Notifications\StatusSuratNotification;

class PermohonanSuratObserver
{
    public function created(PermohonanSurat $surat): void
    {
        User::where('role', 'admin')->each(function ($admin) use ($surat) {
            $admin->notify(new SuratBaruNotification($surat));
        });
    }

    public function updated(PermohonanSurat $surat): void
    {
        if ($surat->isDirty('status') && $surat->status !== 'menunggu') {
            $user = $surat->warga->user;
            if ($user) {
                $user->notify(new StatusSuratNotification($surat));
            }
        }
    }
}