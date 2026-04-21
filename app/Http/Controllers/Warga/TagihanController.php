<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\IplTagihan;
use App\Models\IuranTagihan;

class TagihanController extends Controller
{
    // Halaman utama tagihan warga
    public function index()
    {
        $kk = auth()->user()->kk;

        abort_if(!$kk, 403, 'Akun Anda belum terhubung ke data KK.');

        $tagihanIpl = IplTagihan::with('pembayaran')
            ->where('kk_id', $kk->id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(6, ['*'], 'ipl');

        $tagihanIuran = IuranTagihan::with('iuran')
            ->where('kk_id', $kk->id)
            ->latest()
            ->paginate(6, ['*'], 'iuran');

        return view('pages.warga.tagihan.index', compact('tagihanIpl', 'tagihanIuran', 'kk'));
    }
}