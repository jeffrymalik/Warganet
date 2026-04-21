@extends('layouts.main')

@section('title', 'Riwayat Pembayaran IPL')

@section('content')

<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Riwayat Pembayaran IPL</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">Semua transaksi IPL yang berhasil</p>
</div>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">KK / Kepala Keluarga</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Periode</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Jumlah</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Metode</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Tanggal Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($pembayaran as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 dark:text-white/90">
                            {{ $item->tagihan->kk->kepalaKeluarga->nama ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-400">No. KK: {{ $item->tagihan->kk->no_kk ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                        {{ $item->tagihan->nama_bulan }} {{ $item->tagihan->tahun }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white/90">
                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                            {{ $item->metode_bayar === 'tunai' ? 'Tunai' : ucfirst($item->metode_bayar ?? '-') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $item->paid_at?->format('d M Y, H:i') ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        Belum ada riwayat pembayaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pembayaran->hasPages())
    <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
        {{ $pembayaran->links() }}
    </div>
    @endif
</div>

@endsection