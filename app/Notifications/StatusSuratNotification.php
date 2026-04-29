<?php

namespace App\Notifications;

use App\Models\PermohonanSurat;
use Illuminate\Notifications\Notification;

class StatusSuratNotification extends Notification
{
    public function __construct(public PermohonanSurat $surat) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $label = match($this->keluhan->status) {
            'diproses' => 'sedang diproses',
            'selesai'  => 'telah selesai',
            'ditolak'  => 'ditolak',
            default    => $this->keluhan->status,
        };

        return [
            'judul'  => 'Status Keluhan Diperbarui',
            'pesan'  => "Keluhan \"{$this->keluhan->judul}\" {$label}.",
            'ref_id' => $this->keluhan->id, // ← tambah ini
            'tipe'   => 'keluhan',
            'icon'   => 'info',
        ];
    }
}