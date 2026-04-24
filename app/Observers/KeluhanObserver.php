<?php

namespace App\Observers;

use App\Models\Keluhan;
use App\Models\User;
use App\Notifications\KeluhanBaruNotification;
use App\Notifications\StatusKeluhanNotification;

class KeluhanObserver
{
    public function created(Keluhan $keluhan): void
    {
        // Notif ke semua admin
        User::where('role', 'admin')->each(function ($admin) use ($keluhan) {
            $admin->notify(new KeluhanBaruNotification($keluhan));
        });
    }

    public function updated(Keluhan $keluhan): void
    {
        // Notif ke warga jika status berubah
        if ($keluhan->isDirty('status') && $keluhan->status !== 'menunggu') {
            $user = $keluhan->warga->user;
            if ($user) {
                $user->notify(new StatusKeluhanNotification($keluhan));
            }
        }
    }
}