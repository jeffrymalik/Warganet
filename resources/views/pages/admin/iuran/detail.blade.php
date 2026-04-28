@extends('layouts.main')

@section('title', 'Detail Iuran')

@section('content')

{{-- Header --}}
<div class="mb-6">
    <a href="{{ route('admin.iuran.index') }}"
        class="mb-3 inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-brand-500 dark:text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg>
        Kembali ke Iuran Warga
    </a>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $iuran->nama }}</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $iuran->deskripsi ?? 'Tidak ada deskripsi' }}</p>
</div>

{{-- Notifikasi --}}
@if(session('sukses'))
<div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
    {{ session('sukses') }}
</div>
@endif

{{-- Info Cards --}}
<div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-3">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-sm text-gray-500 dark:text-gray-400">Nominal</p>
        <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white/90">
            Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
        </p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-sm text-gray-500 dark:text-gray-400">Sudah Lunas</p>
        <p class="mt-1 text-2xl font-semibold text-green-600">
            {{ $tagihan->getCollection()->where('status', 'lunas')->count() }}
        </p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-sm text-gray-500 dark:text-gray-400">Belum Bayar</p>
        <p class="mt-1 text-2xl font-semibold text-red-500">
            {{ $tagihan->getCollection()->where('status', 'belum_bayar')->count() }}
        </p>
    </div>
</div>

{{-- Tabel Per KK --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">KK / Kepala Keluarga</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Metode</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Tanggal Bayar</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($tagihan as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 dark:text-white/90">
                            {{ $item->kk->kepalaKeluarga->nama_lengkap ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-400">No. KK: {{ $item->kk->no_kk ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $badge = [
                                'lunas'       => 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400',
                                'menunggu'    => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400',
                                'belum_bayar' => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                            ];
                            $label = [
                                'lunas'       => 'Lunas',
                                'menunggu'    => 'Menunggu',
                                'belum_bayar' => 'Belum Bayar',
                            ];
                        @endphp
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badge[$item->status] }}">
                            {{ $label[$item->status] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $item->metode_bayar ? ucfirst($item->metode_bayar) : '-' }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $item->paid_at?setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($item->status !== 'lunas')
                        <form action="{{ route('admin.iuran.tagihan.lunas', $item) }}" method="POST"
                            onsubmit="return confirm('Tandai lunas (bayar tunai)?')">
                            @csrf
                            <button type="submit"
                                class="rounded-lg border border-green-300 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-50 dark:border-green-700 dark:text-green-400">
                                Tandai Lunas
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-gray-400">Sudah lunas</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($tagihan->hasPages())
    <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
        {{ $tagihan->links() }}
    </div>
    @endif
</div>

@endsection