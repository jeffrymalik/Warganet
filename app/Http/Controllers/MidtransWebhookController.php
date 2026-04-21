<?php

namespace App\Http\Controllers;

use App\Models\IplPembayaran;
use App\Models\IplTagihan;
use App\Models\IuranTagihan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $notif     = new Notification();
        $orderId   = $notif->order_id;
        $status    = $notif->transaction_status;
        $tipe      = $notif->payment_type;
        $fraudStatus = $notif->fraud_status ?? null;

        // Tentukan status akhir
        $statusAkhir = match(true) {
            $status === 'capture' && $fraudStatus === 'accept' => 'success',
            $status === 'settlement'                           => 'success',
            in_array($status, ['cancel', 'deny', 'expire'])   => 'failed',
            $status === 'pending'                              => 'pending',
            default                                            => 'pending',
        };

        // Handle IPL
        if (str_starts_with($orderId, 'IPL-')) {
            $pembayaran = IplPembayaran::where('order_id', $orderId)->first();
            if ($pembayaran) {
                $pembayaran->update([
                    'status'       => $statusAkhir,
                    'metode_bayar' => $tipe,
                    'paid_at'      => $statusAkhir === 'success' ? now() : null,
                ]);

                if ($statusAkhir === 'success') {
                    $pembayaran->tagihan->update(['status' => 'lunas']);
                }
            }
        }

        // Handle Iuran Warga
        if (str_starts_with($orderId, 'IURAN-')) {
            $tagihan = IuranTagihan::where('order_id', $orderId)->first();
            if ($tagihan) {
                $tagihan->update([
                    'status'       => $statusAkhir === 'success' ? 'lunas' : $tagihan->status,
                    'metode_bayar' => $tipe,
                    'paid_at'      => $statusAkhir === 'success' ? now() : null,
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}