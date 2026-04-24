@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- GREETING --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Selamat datang, {{ $warga->nama_lengkap ?? auth()->user()->name }}! 👋
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-error-50 dark:bg-error-500/10 mb-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-error-500">
                    <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $tagihan }}</h3>
            <p class="text-xs text-gray-400 mt-1">IPL Belum Dibayar</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10 mb-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-warning-500">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $iuranBelumBayar }}</h3>
            <p class="text-xs text-gray-400 mt-1">Iuran Belum Dibayar</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10 mb-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-brand-500">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $keluhanSaya->count() }}</h3>
            <p class="text-xs text-gray-400 mt-1">Keluhan Saya</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10 mb-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-success-500">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $suratSaya->count() }}</h3>
            <p class="text-xs text-gray-400 mt-1">Permohonan Surat</p>
        </div>

    </div>

    {{-- QUICK ACTION --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Akses Cepat</h3>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <a href="{{ route('warga.keluhan.create') }}"
                class="flex flex-col items-center gap-2 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-white/[0.03] transition text-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-warning-500">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Buat Keluhan</span>
            </a>
            <a href="{{ route('warga.surat.create') }}"
                class="flex flex-col items-center gap-2 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-white/[0.03] transition text-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-brand-500">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Ajukan Surat</span>
            </a>
            <a href="{{ route('warga.keluarga') }}"
                class="flex flex-col items-center gap-2 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-white/[0.03] transition text-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-success-500">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Data Keluarga</span>
            </a>
            <a href="{{ route('profile') }}"
                class="flex flex-col items-center gap-2 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:bg-gray-50 dark:hover:bg-white/[0.03] transition text-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-gray-500">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Profil Saya</span>
            </a>
        </div>
    </div>

    {{-- PENGUMUMAN & JADWAL --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">📢 Pengumuman</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($pengumuman as $p)
                <div class="px-5 py-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $p->judul }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 line-clamp-2">{{ $p->isi }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ optional($p->published_at)->format('d M Y') }}</p>
                        </div>
                        @php
                            $pColor = match($p->prioritas) {
                                'high'   => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400',
                                'medium' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400',
                                'low'    => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                default  => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $pColor }} capitalize">{{ $p->prioritas }}</span>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">📅 Jadwal Kegiatan</h3>
                <a href="{{ route('warga.jadwal.index') }}" class="text-xs text-brand-500 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($jadwal as $j)
                <div class="px-5 py-4 flex items-start gap-4">
                    @php
                        $jadwalBg   = match($j->color) { 'primary' => 'bg-brand-50 dark:bg-brand-500/10', 'success' => 'bg-success-50 dark:bg-success-500/10', 'danger' => 'bg-error-50 dark:bg-error-500/10', 'warning' => 'bg-warning-50 dark:bg-warning-500/10', default => 'bg-gray-100 dark:bg-gray-700' };
                        $jadwalText = match($j->color) { 'primary' => 'text-brand-600 dark:text-brand-400', 'success' => 'text-success-600 dark:text-success-400', 'danger' => 'text-error-600 dark:text-error-400', 'warning' => 'text-warning-600 dark:text-warning-400', default => 'text-gray-600' };
                    @endphp
                    <div class="shrink-0 flex flex-col items-center justify-center w-12 h-12 rounded-xl {{ $jadwalBg }}">
                        <span class="text-lg font-bold leading-none {{ $jadwalText }}">{{ optional($j->tanggal_mulai)->format('d') }}</span>
                        <span class="text-xs {{ $jadwalText }}">{{ optional($j->tanggal_mulai)->format('M') }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $j->judul }}</p>
                        @if($j->deskripsi)
                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $j->deskripsi }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">
                            {{ optional($j->tanggal_mulai)->format('d M Y') }}
                            @if($j->tanggal_mulai != $j->tanggal_selesai)
                                — {{ optional($j->tanggal_selesai)->format('d M Y') }}
                            @endif
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Tidak ada jadwal mendatang.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- RECENT --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Keluhan Saya</h3>
                <a href="{{ route('warga.keluhan.index') }}" class="text-xs text-brand-500 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($keluhanSaya as $k)
                <a href="{{ route('warga.keluhan.show', $k->id) }}" class="flex items-start gap-3 px-5 py-3.5 hover:bg-gray-50 dark:hover:bg-white/[0.02] transition">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $k->judul }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $k->created_at->diffForHumans() }}</p>
                    </div>
                    @php
                        $kColor = match($k->status) { 'menunggu' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400', 'diproses' => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400', 'selesai' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400', 'ditolak' => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400', default => 'bg-gray-100 text-gray-600' };
                    @endphp
                    <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $kColor }} capitalize">{{ $k->status }}</span>
                </a>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada keluhan.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Permohonan Surat Saya</h3>
                <a href="{{ route('warga.surat.index') }}" class="text-xs text-brand-500 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($suratSaya as $s)
                <a href="{{ route('warga.surat.show', $s->id) }}" class="flex items-start gap-3 px-5 py-3.5 hover:bg-gray-50 dark:hover:bg-white/[0.02] transition">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-white truncate capitalize">{{ str_replace('_', ' ', $s->jenis_surat) }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $s->created_at->diffForHumans() }}</p>
                    </div>
                    @php
                        $sColor = match($s->status) { 'menunggu' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400', 'diproses' => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400', 'selesai' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400', 'ditolak' => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400', default => 'bg-gray-100 text-gray-600' };
                    @endphp
                    <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $sColor }} capitalize">{{ $s->status }}</span>
                </a>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada permohonan surat.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection