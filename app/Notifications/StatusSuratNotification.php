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
        $label = match($this->surat->status) {
            'diproses' => 'sedang diproses',
            'selesai'  => 'telah selesai',
            'ditolak'  => 'ditolak',
            default    => $this->surat->status,
        };

        return [
            'judul' => 'Status Surat Diperbarui',
            'pesan' => "Permohonan surat ".str_replace('_', ' ', $this->surat->jenis_surat)." {$label}.",
            'url'   => route('warga.surat.show', $this->surat->id),
            'tipe'  => 'surat',
            'icon'  => 'info',
        ];
    }
}