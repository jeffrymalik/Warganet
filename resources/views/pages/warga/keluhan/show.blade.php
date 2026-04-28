@extends('layouts.main')

@section('title', 'Detail Keluhan')

@section('content')

<div x-data="{ pageName: `Detail Keluhan`}">
    @include('partials.breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="rounded-xl border border-success-500 bg-success-50 p-4 dark:border-success-500/30 dark:bg-success-500/15">
        <p class="text-sm font-medium text-success-700 dark:text-success-400">✅ {{ session('success') }}</p>
    </div>
    @endif

    {{-- BOX INFO KELUHAN --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $keluhan->judul }}</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $keluhan->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $keluhan->badge_kategori }}">
                    {{ $keluhan->label_kategori }}
                </span>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $keluhan->badge_status }}">
                    {{ $keluhan->label_status }}
                </span>
            </div>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $keluhan->deskripsi }}</p>

        @if($keluhan->foto)
        <div class="mt-4">
            <p class="text-xs text-gray-400 mb-2">Foto Pendukung</p>
            <img
                src="{{ asset('storage/' . $keluhan->foto) }}"
                alt="Foto Keluhan"
                class="rounded-xl max-h-64 object-cover"
            />
        </div>
        @endif
    </div>

    {{-- BOX PERCAKAPAN --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Percakapan</h3>

        {{-- Daftar Pesan --}}
        <div class="space-y-4 mb-6 max-h-96 overflow-y-auto" id="chat-box">
            @forelse($keluhan->pesans as $pesan)
                @if($pesan->is_admin)
                    {{-- Pesan Admin (kiri) --}}
                    <div class="flex justify-start">
                        <div class="max-w-[75%]">
                            <p class="text-xs text-gray-400 mb-1">Admin ·{{ $pesan->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                            <div class="rounded-2xl rounded-tl-sm bg-gray-100 dark:bg-white/[0.05] px-4 py-3">
                                <p class="text-sm text-gray-800 dark:text-white">{{ $pesan->pesan }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Pesan Warga (kanan) --}}
                    <div class="flex justify-end">
                        <div class="max-w-[75%]">
                            <p class="text-xs text-gray-400 text-right mb-1">Saya · {{ $pesan->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                            <div class="rounded-2xl rounded-tr-sm bg-brand-500 px-4 py-3">
                                <p class="text-sm text-white">{{ $pesan->pesan }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada percakapan.</p>
            @endforelse
        </div>

        {{-- Form Kirim Pesan --}}
        @if($keluhan->status !== 'selesai' && $keluhan->status !== 'ditolak')
        <form action="{{ route('warga.keluhan.pesan', $keluhan->id) }}" method="POST">
            @csrf
            <div class="flex gap-3">
                <textarea
                    name="pesan"
                    rows="2"
                    placeholder="Tulis pesan..."
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                ></textarea>
                <button
                    type="submit"
                    class="shrink-0 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600"
                >
                    Kirim
                </button>
            </div>
        </form>
        @else
            <p class="text-sm text-gray-400 text-center py-3 border-t border-gray-100 dark:border-gray-800">
                Keluhan ini sudah {{ $keluhan->label_status }}, tidak bisa mengirim pesan.
            </p>
        @endif
    </div>

    {{-- TOMBOL KEMBALI --}}
    <div class="flex justify-start">
        <a href="{{ route('warga.keluhan.index') }}"
            class="flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
            ← Kembali
        </a>
    </div>

</div>

@endsection

@section('scripts')
<script>
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection