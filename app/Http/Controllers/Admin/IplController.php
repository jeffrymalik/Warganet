<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IplTagihan;
use App\Models\IplPembayaran;
use App\Models\KartuKeluarga;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class IplController extends Controller
{
    public function __construct(protected MidtransService $midtrans) {}

    // Halaman kelola IPL (admin)
    public function index()
    {
        $tagihan = IplTagihan::with('kk.kepalaKeluarga')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(15);

        return view('pages.admin.ipl.index', compact('tagihan'));
    }

    // Generate tagihan IPL untuk semua KK
    public function generate(Request $request)
    {
        $request->validate([
            'bulan'   => 'required|integer|between:1,12',
            'tahun'   => 'required|integer|min:2020',
            'nominal' => 'required|integer|min:1000',
            'due_date'=> 'required|date',
        ]);

        $semuaKk = KartuKeluarga::all();
        $berhasil = 0;
        $sudahAda = 0;

        foreach ($semuaKk as $kk) {
            $sudah = IplTagihan::where('kk_id', $kk->id)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->exists();

            if (!$sudah) {
                IplTagihan::create([
                    'kk_id'    => $kk->id,
                    'bulan'    => $request->bulan,
                    'tahun'    => $request->tahun,
                    'nominal'  => $request->nominal,
                    'due_date' => $request->due_date,
                    'status'   => 'belum_bayar',
                ]);
                $berhasil++;
            } else {
                $sudahAda++;
            }
        }

        return back()->with('sukses', "Berhasil generate {$berhasil} tagihan. {$sudahAda} KK sudah punya tagihan bulan ini.");
    }

    // Admin tandai lunas manual (bayar cash)
    public function tandaiLunas(IplTagihan $tagihan)
    {
        $tagihan->update(['status' => 'lunas']);

        IplPembayaran::updateOrCreate(
            ['tagihan_id' => $tagihan->id],
            [
                'order_id'     => 'MANUAL-' . $tagihan->id . '-' . time(),
                'jumlah'       => $tagihan->nominal,
                'status'       => 'success',
                'metode_bayar' => 'tunai',
                'paid_at'      => now(),
            ]
        );

        return back()->with('sukses', 'Tagihan berhasil ditandai lunas.');
    }

    // Riwayat pembayaran
    public function riwayat()
    {
        $pembayaran = IplPembayaran::with('tagihan.kk.kepalaKeluarga')
            ->where('status', 'success')
            ->latest('paid_at')
            ->paginate(15);

        return view('pages.admin.ipl.riwayat', compact('pembayaran'));
    }

    // Warga: bayar via Midtrans
    public function bayar(IplTagihan $tagihan)
    {
        // Pastikan tagihan milik KK warga yang login
        $kkWarga = auth()->user()->kk;
        abort_if($tagihan->kk_id !== $kkWarga?->id, 403);

        $orderId = 'IPL-' . $tagihan->id . '-' . time();

        $snapToken = $this->midtrans->buatSnapToken([
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $tagihan->nominal,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
            ],
            'item_details' => [[
                'id'       => 'IPL-' . $tagihan->bulan . '-' . $tagihan->tahun,
                'price'    => $tagihan->nominal,
                'quantity' => 1,
                'name'     => "IPL {$tagihan->nama_bulan} {$tagihan->tahun}",
            ]],
        ]);

        // Simpan snap token
        IplPembayaran::updateOrCreate(
            ['tagihan_id' => $tagihan->id],
            [
                'order_id'   => $orderId,
                'snap_token' => $snapToken,
                'jumlah'     => $tagihan->nominal,
                'status'     => 'pending',
            ]
        );

        return response()->json(['snap_token' => $snapToken]);
    }
}