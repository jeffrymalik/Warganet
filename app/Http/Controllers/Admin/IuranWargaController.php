<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IuranWarga;
use App\Models\IuranTagihan;
use App\Models\Kk;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class IuranWargaController extends Controller
{
public function __construct(protected MidtransService $midtrans) {}

public function index()
{
    $iuran = IuranWarga::withCount([
        'tagihan',
        'tagihan as lunas_count'      => fn($q) => $q->where('status', 'lunas'),
        'tagihan as belum_bayar_count' => fn($q) => $q->where('status', '!=', 'lunas'),
    ])->latest()->paginate(10);

    return view('pages.admin.iuran.index', compact('iuran'));
}

public function store(Request $request)
{
    $request->validate([
        'nama'     => 'required|string|max:255',
        'deskripsi'=> 'nullable|string',
        'nominal'  => 'required|integer|min:1000',
        'due_date' => 'nullable|date',
    ]);

    $iuran = IuranWarga::create([
        ...$request->only('nama', 'deskripsi', 'nominal', 'due_date'),
        'created_by' => auth()->id(),
    ]);

    // Otomatis buat tagihan untuk semua KK
    $semuaKk = KartuKeluarga::all();
    foreach ($semuaKk as $kk) {
        IuranTagihan::create([
            'iuran_id' => $iuran->id,
            'kk_id'    => $kk->id,
            'status'   => 'belum_bayar',
        ]);
    }

    return back()->with('sukses', "Iuran berhasil dibuat dan ditagihkan ke {$semuaKk->count()} KK.");
}

public function destroy(IuranWarga $iuran)
{
    $iuran->delete();
    return back()->with('sukses', 'Iuran berhasil dihapus.');
}

// Admin tandai lunas manual
public function tandaiLunas(IuranTagihan $tagihan)
{
    $tagihan->update([
        'status'       => 'lunas',
        'metode_bayar' => 'tunai',
        'paid_at'      => now(),
    ]);

    return back()->with('sukses', 'Tagihan iuran berhasil ditandai lunas.');
}

// Detail iuran: lihat per KK siapa yang sudah/belum bayar
public function detail(IuranWarga $iuran)
{
    $tagihan = $iuran->tagihan()->with('kk.kepalaKeluarga')->paginate(15);
    return view('pages.admin.iuran.detail', compact('iuran', 'tagihan'));
}

// Warga: bayar via Midtrans
public function bayar(IuranTagihan $tagihan)
{
    $kkWarga = auth()->user()->kk;
    abort_if($tagihan->kk_id !== $kkWarga?->id, 403);

    $orderId   = 'IURAN-' . $tagihan->id . '-' . time();
    $snapToken = $this->midtrans->buatSnapToken([
        'transaction_details' => [
            'order_id'     => $orderId,
            'gross_amount' => $tagihan->iuran->nominal,
        ],
        'customer_details' => [
            'first_name' => auth()->user()->name,
            'email'      => auth()->user()->email,
        ],
        'item_details' => [[
            'id'       => 'IURAN-' . $tagihan->iuran_id,
            'price'    => $tagihan->iuran->nominal,
            'quantity' => 1,
            'name'     => $tagihan->iuran->nama,
        ]],
    ]);

    $tagihan->update([
        'order_id'   => $orderId,
        'snap_token' => $snapToken,
        'status'     => 'menunggu',
    ]);

    return response()->json(['snap_token' => $snapToken]);
}
}