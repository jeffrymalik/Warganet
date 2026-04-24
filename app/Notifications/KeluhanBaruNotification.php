<?php

namespace App\Notifications;

use App\Models\Keluhan;
use Illuminate\Notifications\Notification;

class KeluhanBaruNotification extends Notification
{
    public function __construct(public Keluhan $keluhan) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'judul'   => 'Keluhan Baru',
            'pesan'   => "Keluhan baru dari {$this->keluhan->warga->nama_lengkap}: {$this->keluhan->judul}",
            'url'     => route('admin.keluhan.show', $this->keluhan->id),
            'tipe'    => 'keluhan',
            'icon'    => 'warning',
        ];
    }
}