@extends('layouts.main')

@section('title', 'Detail Keluhan')

@section('content')

<div x-data="{ pageName: `Detail Keluhan`}">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="rounded-xl border border-success-500 bg-success-50 p-4 dark:border-success-500/30 dark:bg-success-500/15">
        <p class="text-sm font-medium text-success-700 dark:text-success-400">✅ {{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- KIRI --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- BOX INFO KELUHAN --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $keluhan->judul }}</h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $keluhan->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
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
                        class="rounded-xl max-h-64 object-cover cursor-pointer"
                        onclick="bukaFoto(this.src)"
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
                            {{-- Pesan Admin (kanan) --}}
                            <div class="flex justify-end">
                                <div class="max-w-[75%]">
                                    <p class="text-xs text-gray-400 text-right mb-1">Admin · {{ $pesan->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                                    <div class="rounded-2xl rounded-tr-sm bg-brand-500 px-4 py-3">
                                        <p class="text-sm text-white">{{ $pesan->pesan }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Pesan Warga (kiri) --}}
                            <div class="flex justify-start">
                                <div class="max-w-[75%]">
                                    <p class="text-xs text-gray-400 mb-1">{{ $pesan->user->name }} · {{ $pesan->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                                    <div class="rounded-2xl rounded-tl-sm bg-gray-100 dark:bg-white/[0.05] px-4 py-3">
                                        <p class="text-sm text-gray-800 dark:text-white">{{ $pesan->pesan }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-sm text-gray-400 text-center py-6">Belum ada percakapan.</p>
                    @endforelse
                </div>

                {{-- Form Kirim Pesan --}}
@if(in_array($keluhan->status, ['selesai', 'ditolak']))
    <div class="rounded-xl bg-gray-100 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-700 px-4 py-3 text-center">
        <p class="text-sm text-gray-400 dark:text-gray-500">
            @if($keluhan->status === 'selesai')
                ✅ Keluhan ini telah selesai, percakapan ditutup.
            @else
                ❌ Keluhan ini telah ditolak, percakapan ditutup.
            @endif
        </p>
    </div>
                @else
                    <form action="{{ route('admin.keluhan.pesan', $keluhan->id) }}" method="POST">
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
                @endif
            </div>

        </div>

        {{-- KANAN --}}
        <div class="space-y-6">

            {{-- BOX UPDATE STATUS --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Update Status</h3>

                <form action="{{ route('admin.keluhan.update', $keluhan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select
                        name="status"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                        <option value="menunggu" {{ $keluhan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $keluhan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai"  {{ $keluhan->status == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak"  {{ $keluhan->status == 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <button type="submit"
                        class="mt-3 w-full rounded-lg bg-brand-500 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                        Simpan Status
                    </button>
                </form>
            </div>

            {{-- BOX INFO WARGA --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Data Pelapor</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Nama</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $keluhan->warga->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">NIK</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $keluhan->warga->nik }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">No KK</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $keluhan->warga->kartuKeluarga->no_kk ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">No Telepon</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $keluhan->warga->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Alamat</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $keluhan->warga->kartuKeluarga->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('admin.keluhan.index') }}"
                class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                ← Kembali
            </a>

        </div>
    </div>
</div>

{{-- POPUP FOTO --}}
<div id="modal-foto" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div onclick="tutupFoto()" class="absolute inset-0 bg-black/80"></div>
    <div class="relative">
        <img id="modal-foto-img" src="" alt="Foto" class="max-h-[85vh] max-w-full rounded-xl object-contain"/>
        <button onclick="tutupFoto()"
            class="absolute -top-3 -right-3 flex items-center justify-center w-8 h-8 rounded-full bg-white text-gray-800 shadow font-bold text-sm">
            ✕
        </button>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function bukaFoto(src) {
        document.getElementById('modal-foto-img').src = src;
        document.getElementById('modal-foto').classList.remove('hidden');
        document.getElementById('modal-foto').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupFoto() {
        document.getElementById('modal-foto').classList.add('hidden');
        document.getElementById('modal-foto').classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Auto scroll chat ke bawah
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection