<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(20);

        Auth::user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    public function show(string $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $tipe   = $notification->data['tipe'] ?? null;
        $ref_id = $notification->data['ref_id'] ?? null;
        $role   = Auth::user()->role;

        $url = match(true) {
            $tipe === 'ipl'     && $role === 'admin'  => route('admin.ipl.index'),
            $tipe === 'ipl'     && $role === 'warga'  => route('warga.tagihan.index'),
            $tipe === 'iuran'   && $role === 'admin'  => route('admin.iuran.index'),
            $tipe === 'iuran'   && $role === 'warga'  => route('warga.tagihan.index'),

            // Keluhan — coba ref_id dulu, fallback ke url lama
            $tipe === 'keluhan' && $role === 'admin' && $ref_id  => route('admin.keluhan.show', ['keluhan' => $ref_id]),
            $tipe === 'keluhan' && $role === 'warga' && $ref_id  => route('warga.keluhan.show', ['keluhan' => $ref_id]),

            // Surat — coba ref_id dulu, fallback ke url lama
            $tipe === 'surat'   && $role === 'admin' && $ref_id  => route('admin.surat.show', ['permohonanSurat' => $ref_id]),
            $tipe === 'surat'   && $role === 'warga' && $ref_id  => route('warga.surat.show', ['permohonanSurat' => $ref_id]),

            // Fallback: pakai url yang disimpan langsung di data notifikasi lama
            !empty($notification->data['url']) => $notification->data['url'],

            default => route('notifications.index'),
        };

        return redirect($url);
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }
}