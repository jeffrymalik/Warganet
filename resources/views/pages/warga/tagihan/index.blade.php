@extends('layouts.main')

@section('title', 'Tagihan Saya')

@section('content')

{{-- Header --}}
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Tagihan Saya</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        KK: {{ $kk->no_kk ?? '-' }} · Kepala Keluarga: {{ $kk->kepalaKeluarga->nama_lengkap ?? '-' }}
    </p>
</div>

{{-- ══════════════════════════════════ --}}
{{-- SECTION: IPL                       --}}
{{-- ══════════════════════════════════ --}}
<div class="mb-8">
    <h3 class="mb-4 text-base font-semibold text-gray-700 dark:text-gray-300">
        IPL (Iuran Pengelolaan)
    </h3>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($tagihanIpl as $item)
        <div class="rounded-2xl border bg-white p-5 dark:bg-white/[0.03]
            {{ $item->status === 'lunas' ? 'border-green-200 dark:border-green-800' : ($item->status === 'menunggu' ? 'border-yellow-200 dark:border-yellow-800' : 'border-gray-200 dark:border-gray-800') }}">

            {{-- Periode & Status --}}
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white/90">
                        {{ $item->nama_bulan }} {{ $item->tahun }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Jatuh tempo: {{ $item->due_date?->format('d M Y') ?? '-' }}
                    </p>
                </div>
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
            </div>

            {{-- Nominal --}}
            <p class="text-2xl font-bold text-gray-800 dark:text-white/90 mb-4">
                Rp {{ number_format($item->nominal, 0, ',', '.') }}
            </p>

            {{-- Aksi --}}
            @if($item->status === 'lunas')
                <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    Dibayar {{ $item->pembayaran?->paid_at?->format('d M Y') ?? '' }}
                    via {{ ucfirst($item->pembayaran?->metode_bayar ?? '-') }}
                </div>
            @elseif($item->status === 'menunggu')
                <button
                    onclick="lanjutBayarIpl({{ $item->id }}, '{{ $item->pembayaran?->snap_token }}')"
                    class="w-full rounded-lg bg-yellow-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-yellow-600">
                    Lanjutkan Pembayaran
                </button>
            @else
                <button
                    onclick="bayarIpl({{ $item->id }})"
                    class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                    Bayar Sekarang
                </button>
            @endif
        </div>
        @empty
        <div class="col-span-3 rounded-2xl border border-gray-200 bg-white p-10 text-center dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-gray-400">Belum ada tagihan IPL untuk KK Anda.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination IPL --}}
    @if($tagihanIpl->hasPages())
    <div class="mt-4">{{ $tagihanIpl->links() }}</div>
    @endif
</div>

{{-- ══════════════════════════════════ --}}
{{-- SECTION: Iuran Warga               --}}
{{-- ══════════════════════════════════ --}}
<div>
    <h3 class="mb-4 text-base font-semibold text-gray-700 dark:text-gray-300">
        Iuran Warga
    </h3>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($tagihanIuran as $item)
        <div class="rounded-2xl border bg-white p-5 dark:bg-white/[0.03]
            {{ $item->status === 'lunas' ? 'border-green-200 dark:border-green-800' : ($item->status === 'menunggu' ? 'border-yellow-200 dark:border-yellow-800' : 'border-gray-200 dark:border-gray-800') }}">

            {{-- Nama Iuran & Status --}}
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white/90">
                        {{ $item->iuran->nama }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Jatuh tempo: {{ $item->iuran->due_date?->format('d M Y') ?? '-' }}
                    </p>
                </div>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badge[$item->status] }}">
                    {{ $label[$item->status] }}
                </span>
            </div>

            {{-- Deskripsi --}}
            @if($item->iuran->deskripsi)
            <p class="text-xs text-gray-400 mb-3 line-clamp-2">{{ $item->iuran->deskripsi }}</p>
            @endif

            {{-- Nominal --}}
            <p class="text-2xl font-bold text-gray-800 dark:text-white/90 mb-4">
                Rp {{ number_format($item->iuran->nominal, 0, ',', '.') }}
            </p>

            {{-- Aksi --}}
            @if($item->status === 'lunas')
                <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    Dibayar {{ $item->paid_at?->format('d M Y') ?? '' }}
                    via {{ ucfirst($item->metode_bayar ?? '-') }}
                </div>
            @elseif($item->status === 'menunggu')
                <button
                    onclick="lanjutBayarIuran({{ $item->id }}, '{{ $item->snap_token }}')"
                    class="w-full rounded-lg bg-yellow-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-yellow-600">
                    Lanjutkan Pembayaran
                </button>
            @else
                <button
                    onclick="bayarIuran({{ $item->id }})"
                    class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                    Bayar Sekarang
                </button>
            @endif
        </div>
        @empty
        <div class="col-span-3 rounded-2xl border border-gray-200 bg-white p-10 text-center dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-gray-400">Belum ada tagihan iuran untuk KK Anda.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination Iuran --}}
    @if($tagihanIuran->hasPages())
    <div class="mt-4">{{ $tagihanIuran->links() }}</div>
    @endif
</div>

{{-- Loading Overlay saat proses pembayaran --}}
<div id="loadingOverlay" class="fixed inset-0 z-[99998] hidden items-center justify-center bg-gray-900/50 backdrop-blur-sm">
    <div class="rounded-2xl bg-white p-8 text-center dark:bg-gray-900">
        <svg class="mx-auto mb-3 h-10 w-10 animate-spin text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Memproses pembayaran...</p>
    </div>
</div>

@endsection

@push('scripts')
{{-- Midtrans Snap JS --}}
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    const csrfToken = '{{ csrf_token() }}';

    function tampilkanLoading(show) {
        const el = document.getElementById('loadingOverlay');
        show ? el.classList.replace('hidden', 'flex') : el.classList.replace('flex', 'hidden');
    }

    function tampilkanToast(pesan, tipe = 'success') {
        const toast = document.createElement('div');
        toast.className = [
            'fixed bottom-6 right-6 z-[99999] px-5 py-3 rounded-xl',
            'text-white text-sm shadow-lg transition-all duration-300',
            tipe === 'success' ? 'bg-green-500' : 'bg-red-500'
        ].join(' ');
        toast.textContent = pesan;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    // ── Buka Snap Midtrans ─────────────────────────────────────────────
    function bukaSnap(snapToken, onSuccess) {
        window.snap.pay(snapToken, {
            onSuccess(result) {
                console.log('Pembayaran sukses:', result);
                tampilkanToast('Pembayaran berhasil! Halaman akan diperbarui...');
                setTimeout(() => location.reload(), 2000);
            },
            onPending(result) {
                console.log('Pembayaran pending:', result);
                tampilkanToast('Pembayaran sedang diproses.', 'warning');
                setTimeout(() => location.reload(), 2000);
            },
            onError(result) {
                console.error('Pembayaran gagal:', result);
                tampilkanToast('Pembayaran gagal, silakan coba lagi.', 'error');
            },
            onClose() {
                tampilkanToast('Pembayaran dibatalkan.', 'error');
            }
        });
    }

    // ── Bayar IPL (request snap token baru) ───────────────────────────
    async function bayarIpl(tagihanId) {
        tampilkanLoading(true);
        try {
            const res = await fetch(`/warga/ipl/${tagihanId}/bayar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                }
            });
            const data = await res.json();
            tampilkanLoading(false);

            if (data.snap_token) {
                bukaSnap(data.snap_token);
            } else {
                tampilkanToast('Gagal mendapatkan token pembayaran.', 'error');
            }
        } catch (err) {
            tampilkanLoading(false);
            tampilkanToast('Terjadi kesalahan, coba lagi.', 'error');
            console.error(err);
        }
    }

    // ── Lanjut Bayar IPL (pakai snap token lama) ──────────────────────
    function lanjutBayarIpl(tagihanId, snapToken) {
        if (snapToken) {
            bukaSnap(snapToken);
        } else {
            // Token sudah expired, minta yang baru
            bayarIpl(tagihanId);
        }
    }

    // ── Bayar Iuran Warga ──────────────────────────────────────────────
    async function bayarIuran(tagihanId) {
        tampilkanLoading(true);
        try {
            const res = await fetch(`/warga/iuran/tagihan/${tagihanId}/bayar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                }
            });
            const data = await res.json();
            tampilkanLoading(false);

            if (data.snap_token) {
                bukaSnap(data.snap_token);
            } else {
                tampilkanToast('Gagal mendapatkan token pembayaran.', 'error');
            }
        } catch (err) {
            tampilkanLoading(false);
            tampilkanToast('Terjadi kesalahan, coba lagi.', 'error');
            console.error(err);
        }
    }

    // ── Lanjut Bayar Iuran ─────────────────────────────────────────────
    function lanjutBayarIuran(tagihanId, snapToken) {
        if (snapToken) {
            bukaSnap(snapToken);
        } else {
            bayarIuran(tagihanId);
        }
    }
</script>
@endpush