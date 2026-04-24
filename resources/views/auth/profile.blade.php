@extends('layouts.main')

@section('title', 'Profil Saya')

@section('content')

@php $isWarga = auth()->user()->role === 'warga'; @endphp

<div x-data="{ showEditModal: false, pageName: 'Profil Saya' }">

    @include('../../../partials/breadcrumb')

    <div class="mt-6 space-y-6">

        {{-- BOX PROFIL UTAMA --}}
        <div class="p-5 border border-gray-200 rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex flex-col items-center w-full gap-6 xl:flex-row">

                    {{-- Foto --}}
                    <div class="w-20 h-20 overflow-hidden border border-gray-200 rounded-full dark:border-gray-800 shrink-0">
                        @if(auth()->user()->foto)
                            <img src="{{ Storage::url(auth()->user()->foto) }}" alt="foto" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-brand-100 dark:bg-brand-500/20 flex items-center justify-center">
                                <span class="text-2xl font-bold text-brand-600 dark:text-brand-400">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Nama & Info --}}
                    <div>
                        <h4 class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left">
                            {{ auth()->user()->name }}
                        </h4>
                        @if($isWarga && $warga)
                            <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                                <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">
                                    {{ str_replace('_', ' ', $warga->status_dalam_kk) }}
                                </p>
                                <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
                                <p class="text-sm font-mono text-gray-500 dark:text-gray-400">
                                    NIK: {{ $warga->nik }}
                                </p>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center xl:text-left">
                                Administrator
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Tombol Edit --}}
                <button
                    @click="showEditModal = true"
                    class="flex items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] whitespace-nowrap"
                >
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z" fill=""/>
                    </svg>
                    Edit Profil
                </button>
            </div>
        </div>

        {{-- BOX INFORMASI PERSONAL --}}
        <div class="p-5 border border-gray-200 rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-6">Informasi Personal</h4>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 lg:gap-7">
                <div>
                    <p class="mb-1 text-xs text-gray-400 dark:text-gray-500">Nama Lengkap</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="mb-1 text-xs text-gray-400 dark:text-gray-500">Email</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ auth()->user()->email }}</p>
                </div>

                @if($isWarga && $warga)
                    <div>
                        <p class="mb-1 text-xs text-gray-400 dark:text-gray-500">No. Telepon</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs text-gray-400 dark:text-gray-500">Agama</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90 capitalize">{{ $warga->agama }}</p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs text-gray-400 dark:text-gray-500">Jenis Kelamin</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->label_jenis_kelamin }}</p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs text-gray-400 dark:text-gray-500">Tempat, Tanggal Lahir</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $warga->tempat_lahir }}, {{ optional($warga->tanggal_lahir)->format('d M Y') }}
                        </p>
                    </div>
                @else
                    <div>
                        <p class="mb-1 text-xs text-gray-400 dark:text-gray-500">Role</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">Administrator</p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs text-gray-400 dark:text-gray-500">Akun Dibuat</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ auth()->user()->created_at->format('d M Y') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- BOX DATA KELUARGA (khusus warga) --}}
        @if($isWarga && $kartuKeluarga)
        <div class="p-5 border border-gray-200 rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Data Keluarga</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        No. KK: <span class="font-mono">{{ $kartuKeluarga->no_kk }}</span>
                    </p>
                </div>
                <a
                    href="{{ route('warga.keluarga') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition"
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Lihat Data Keluarga
                </a>
            </div>
        </div>
        @endif

    </div>

    {{-- MODAL EDIT --}}
    <div
        x-show="showEditModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-99999 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div @click="showEditModal = false" class="absolute inset-0 bg-black/60"></div>

        <div class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-xl flex flex-col max-h-[90vh]">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 shrink-0">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Edit Profil</h3>
                <button @click="showEditModal = false" class="flex items-center justify-center w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-white/10">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
                @csrf

                <div class="px-6 py-4 overflow-y-auto flex-1 space-y-4">

                    {{-- Foto --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full overflow-hidden border border-gray-200 dark:border-gray-700 shrink-0">
                                @if(auth()->user()->foto)
                                    <img src="{{ Storage::url(auth()->user()->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-brand-100 flex items-center justify-center">
                                        <span class="text-lg font-bold text-brand-600">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <input type="file" name="foto" accept="image/jpg,image/jpeg,image/png"
                                class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border file:border-gray-300 file:text-xs file:font-medium file:text-gray-700 file:bg-white hover:file:bg-gray-50 dark:file:bg-gray-800 dark:file:border-gray-600 dark:file:text-gray-300">
                        </div>
                        @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- No Telepon (warga only) --}}
                    @if($isWarga && $warga)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">No. Telepon</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $warga->no_telepon) }}"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    @endif

                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">
                            Password Baru
                            <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password" name="password"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    </div>

                </div>

                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 shrink-0 flex gap-3">
                    <button type="button" @click="showEditModal = false"
                        class="flex-1 rounded-lg border border-gray-300 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 rounded-lg bg-brand-500 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- Buka modal otomatis jika ada error validasi --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.dispatchEvent(new CustomEvent('open-edit-modal'));
    });
</script>
@endif

@endsection