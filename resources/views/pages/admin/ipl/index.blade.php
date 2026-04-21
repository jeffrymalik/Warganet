@extends('layouts.main')

@section('title', 'Kelola IPL')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">IPL (Iuran Pengelolaan)</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola tagihan IPL bulanan per KK</p>
    </div>
    <button
        onclick="bukaModalGenerate()"
        class="flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 1a.5.5 0 0 1 .5.5v6h6a.5.5 0 0 1 0 1h-6v6a.5.5 0 0 1-1 0v-6h-6a.5.5 0 0 1 0-1h6v-6A.5.5 0 0 1 8 1"/>
        </svg>
        Generate Tagihan
    </button>
</div>

{{-- Notifikasi --}}
@if(session('sukses'))
<div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
    {{ session('sukses') }}
</div>
@endif

{{-- Statistik --}}
<div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-3">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-sm text-gray-500 dark:text-gray-400">Total Tagihan</p>
        <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white/90">{{ $tagihan->total() }}</p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-sm text-gray-500 dark:text-gray-400">Sudah Lunas</p>
        <p class="mt-1 text-2xl font-semibold text-green-600">{{ $tagihan->getCollection()->where('status', 'lunas')->count() }}</p>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-sm text-gray-500 dark:text-gray-400">Belum Bayar</p>
        <p class="mt-1 text-2xl font-semibold text-red-500">{{ $tagihan->getCollection()->where('status', 'belum_bayar')->count() }}</p>
    </div>
</div>

{{-- Tabel --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">KK / Kepala Keluarga</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Periode</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Nominal</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Jatuh Tempo</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($tagihan as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                    {{-- KK --}}
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 dark:text-white/90">
                            {{ $item->kk->kepalaKeluarga->nama_lengkap ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-400">No. KK: {{ $item->kk->no_kk ?? '-' }}</p>
                    </td>

                    {{-- Periode --}}
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                        {{ $item->nama_bulan }} {{ $item->tahun }}
                    </td>

                    {{-- Nominal --}}
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>

                    {{-- Jatuh Tempo --}}
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $item->due_date?->format('d M Y') ?? '-' }}
                    </td>

                    {{-- Status --}}
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

                    {{-- Aksi --}}
                    <td class="px-6 py-4">
                        @if($item->status !== 'lunas')
                        <form action="{{ route('admin.ipl.lunas', $item) }}" method="POST"
                            onsubmit="return confirm('Tandai lunas (bayar tunai)?')">
                            @csrf
                            <button type="submit"
                                class="rounded-lg border border-green-300 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-50 dark:border-green-700 dark:text-green-400 dark:hover:bg-green-500/10">
                                Tandai Lunas
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-gray-400">
                            {{ $item->pembayaran?->paid_at?->format('d M Y') ?? '-' }}
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <svg class="mx-auto mb-3 h-10 w-10 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Belum ada tagihan. Klik "Generate Tagihan" untuk membuat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tagihan->hasPages())
    <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
        {{ $tagihan->links() }}
    </div>
    @endif
</div>

{{-- Modal Generate Tagihan --}}
<div id="modalGenerate" class="fixed inset-0 z-99999 hidden items-center justify-center p-5">
    <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-[32px]" onclick="tutupModalGenerate()"></div>
    <div class="relative w-full max-w-[500px] rounded-3xl bg-white p-8 dark:bg-gray-900">

        <button onclick="tutupModalGenerate()" class="absolute right-5 top-5 flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-white/[0.05]">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"/>
            </svg>
        </button>

        <h5 class="mb-1 text-xl font-semibold text-gray-800 dark:text-white/90">Generate Tagihan IPL</h5>
        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Buat tagihan IPL untuk semua KK sekaligus</p>

        <form action="{{ route('admin.ipl.generate') }}" method="POST">
            @csrf

            {{-- Bulan & Tahun --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Bulan</label>
                    <select name="bulan" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                        <option value="{{ $i + 1 }}" {{ now()->month == $i + 1 ? 'selected' : '' }}>{{ $bln }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tahun</label>
                    <select name="tahun" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        @for($y = now()->year; $y >= now()->year - 2; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Nominal --}}
            <div class="mb-4">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nominal (Rp)</label>
                <input type="number" name="nominal" placeholder="Contoh: 50000"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
            </div>

            {{-- Jatuh Tempo --}}
            <div class="mb-6">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jatuh Tempo</label>
                <input type="date" name="due_date" onclick="this.showPicker()"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="tutupModalGenerate()"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    Batal
                </button>
                <button type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                    Generate Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function bukaModalGenerate() {
        const modal = document.getElementById('modalGenerate');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function tutupModalGenerate() {
        const modal = document.getElementById('modalGenerate');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush