@extends('layouts.main')

@section('title', 'Keluhan Warga')

@section('content')

<div x-data="{ pageName: `Keluhan Warga`}">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- 4 CARD STATISTIK --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 dark:border-yellow-500/30 dark:bg-yellow-500/10">
            <p class="text-xs font-medium text-yellow-500 mb-1">Menunggu</p>
            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-400">{{ $stats['menunggu'] }}</p>
            <p class="text-xs text-yellow-400 mt-1">Keluhan</p>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-500/30 dark:bg-blue-500/10">
            <p class="text-xs font-medium text-blue-500 mb-1">Diproses</p>
            <p class="text-2xl font-bold text-blue-700 dark:text-blue-400">{{ $stats['diproses'] }}</p>
            <p class="text-xs text-blue-400 mt-1">Keluhan</p>
        </div>
        <div class="rounded-2xl border border-green-200 bg-green-50 p-5 dark:border-green-500/30 dark:bg-green-500/10">
            <p class="text-xs font-medium text-green-500 mb-1">Selesai</p>
            <p class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $stats['selesai'] }}</p>
            <p class="text-xs text-green-400 mt-1">Keluhan</p>
        </div>
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 dark:border-red-500/30 dark:bg-red-500/10">
            <p class="text-xs font-medium text-red-500 mb-1">Ditolak</p>
            <p class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $stats['ditolak'] }}</p>
            <p class="text-xs text-red-400 mt-1">Keluhan</p>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="GET" action="{{ route('admin.keluhan.index') }}" class="flex flex-col gap-3 sm:flex-row">

            {{-- Search --}}
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari judul atau nama warga..."
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />

            {{-- Filter Status --}}
            <select
                name="status"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full sm:w-44 appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai"  {{ request('status') == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak"  {{ request('status') == 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
            </select>

            {{-- Filter Kategori --}}
            <select
                name="kategori"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full sm:w-44 appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >
                <option value="">Semua Kategori</option>
                <option value="infrastruktur" {{ request('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                <option value="keamanan"      {{ request('kategori') == 'keamanan'      ? 'selected' : '' }}>Keamanan</option>
                <option value="kebersihan"    {{ request('kategori') == 'kebersihan'    ? 'selected' : '' }}>Kebersihan</option>
                <option value="sosial"        {{ request('kategori') == 'sosial'        ? 'selected' : '' }}>Sosial</option>
                <option value="lainnya"       {{ request('kategori') == 'lainnya'       ? 'selected' : '' }}>Lainnya</option>
            </select>

            <button type="submit"
                class="h-11 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600 shrink-0">
                Filter
            </button>

            @if(request('search') || request('status') || request('kategori'))
            <a href="{{ route('admin.keluhan.index') }}"
                class="flex items-center justify-center h-11 rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 shrink-0">
                Reset
            </a>
            @endif

        </form>
    </div>

    {{-- TABEL --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Daftar Keluhan
                <span class="ml-2 text-sm font-normal text-gray-400">({{ $keluhanList->total() }} keluhan)</span>
            </h3>
        </div>

        @if($keluhanList->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Warga</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Judul</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Kategori</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Status</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Tanggal</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($keluhanList as $keluhan)
                    <tr>
                        <td class="py-3 font-medium text-gray-800 dark:text-white">
                            {{ $keluhan->warga->nama_lengkap ?? '-' }}
                            <p class="text-xs text-gray-400 font-normal">{{ $keluhan->warga->kartuKeluarga->no_kk ?? '-' }}</p>
                        </td>
                        <td class="py-3 text-gray-600 dark:text-gray-400 max-w-[200px]">
                            <p class="truncate">{{ $keluhan->judul }}</p>
                        </td>
                        <td class="py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $keluhan->badge_kategori }}">
                                {{ $keluhan->label_kategori }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $keluhan->badge_status }}">
                                {{ $keluhan->label_status }}
                            </span>
                        </td>
                        <td class="py-3 text-gray-400 text-xs">
                            {{ $keluhan->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3">
                            <a href="{{ route('admin.keluhan.show', $keluhan->id) }}"
                                class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $keluhanList->links() }}
        </div>

        @else
            <p class="text-sm text-gray-400 text-center py-6">Belum ada keluhan.</p>
        @endif
    </div>

</div>
@endsection