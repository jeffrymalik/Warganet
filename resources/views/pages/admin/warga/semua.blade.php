@extends('layouts.main')

@section('content')
<div x-data="{ pageName: `Semua Data Warga` }">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Warga</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalWarga }}</h3>
        </div>
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum Ada Akun</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $belumAkun }}</h3>
        </div>
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Sudah Ada Akun</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $sudahAkun }}</h3>
        </div>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mt-3">

    {{-- Header --}}
    <div class="flex flex-col gap-2 px-4 pt-4 pb-4 sm:px-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Daftar Seluruh Warga</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Total {{ $wargas->total() }} data warga</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Filter --}}
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                >
                    <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z" fill="" stroke="" stroke-width="1.5"/>
                        <path d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z" fill="" stroke="" stroke-width="1.5"/>
                    </svg>
                    Filter
                    @if(request()->filled('jenis_kelamin'))
                        <span class="flex h-2 w-2 rounded-full bg-brand-500"></span>
                    @endif
                </button>

                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-64 rounded-xl border border-gray-200 bg-white p-4 shadow-lg z-50 dark:border-gray-700 dark:bg-gray-800"
                >
                    <form method="GET" action="{{ route('admin.warga.semua') }}">
                        @if(request()->filled('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Jenis Kelamin</p>
                        <div class="flex flex-col gap-2">
                            @foreach(['laki_laki' => 'Laki-laki', 'perempuan' => 'Perempuan'] as $val => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="{{ $val }}"
                                        {{ request('jenis_kelamin') === $val ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-brand-600 dark:border-gray-600">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex gap-2 mt-5">
                            <button type="submit" class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 text-center hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-white/[0.05]">Terapkan</button>
                            <a href="{{ route('admin.warga.semua') }}" class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 text-center hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-white/[0.05]">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tambah Data --}}
            <button
                onclick="window.location.href='{{ route('admin.warga.warga.create') }}'"
                class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
            >
                Tambah Data
            </button>
        </div>
    </div>

    {{-- Search --}}
    <div class="px-4 pb-4 sm:px-6">
        <form method="GET" action="{{ route('admin.warga.semua') }}">
            @if(request()->filled('jenis_kelamin'))
                <input type="hidden" name="jenis_kelamin" value="{{ request('jenis_kelamin') }}">
            @endif
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari NIK atau nama warga..."
                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-9 pr-4 text-sm text-gray-700 placeholder-gray-400 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-500"
                >
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="w-full overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-y border-gray-100 dark:border-gray-800">
                    <th class="px-4 py-3 sm:px-6"><p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">NIK</p></th>
                    <th class="px-4 py-3 sm:px-6"><p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama</p></th>
                    <th class="px-4 py-3 sm:px-6"><p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jenis Kelamin</p></th>
                    <th class="px-4 py-3 sm:px-6"><p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Agama</p></th>
                    <th class="px-4 py-3 sm:px-6"><p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p></th>
                    <th class="px-4 py-3 sm:px-6"><p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($wargas as $w)
                <tr>
                    <td class="px-4 py-3 sm:px-6">
                        <p class="font-mono text-gray-700 text-theme-sm dark:text-white/90">{{ $w->nik }}</p>
                    </td>
                    <td class="px-4 py-3 sm:px-6">
                        <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $w->nama_lengkap }}</p>
                        <p class="text-xs text-gray-400">{{ $w->label_status_kk }}</p>
                    </td>
                    <td class="px-4 py-3 sm:px-6">
                        <p class="text-gray-500 text-theme-sm dark:text-white/90">{{ $w->label_jenis_kelamin }}</p>
                    </td>
                    <td class="px-4 py-3 sm:px-6">
                        <p class="text-gray-500 text-theme-sm dark:text-white/90">{{ ucfirst($w->agama) }}</p>
                    </td>
                    <td class="px-4 py-3 sm:px-6">
                        <span class="rounded-full px-2.5 py-0.5 text-theme-xs font-medium {{ $w->badge_status_warga }}">
                            {{ $w->label_status_warga }}
                        </span>
                    </td>
                    <td class="px-4 py-3 sm:px-6">
                        <div x-data="{ open: false }" class="relative">
                            <button
                                @click="open = !open"
                                class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-white/[0.05] dark:hover:text-gray-200"
                            >
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M9 9.75C9.41421 9.75 9.75 9.41421 9.75 9C9.75 8.58579 9.41421 8.25 9 8.25C8.58579 8.25 8.25 8.58579 8.25 9C8.25 9.41421 8.58579 9.75 9 9.75Z" fill="currentColor"/>
                                    <path d="M9 4.75C9.41421 4.75 9.75 4.41421 9.75 4C9.75 3.58579 9.41421 3.25 9 3.25C8.58579 3.25 8.25 3.58579 8.25 4C8.25 4.41421 8.58579 9.75 9 4.75Z" fill="currentColor"/>
                                    <path d="M9 14.75C9.41421 14.75 9.75 14.4142 9.75 14C9.75 13.5858 9.41421 13.25 9 13.25C8.58579 13.25 8.25 13.5858 8.25 14C8.25 14.4142 8.58579 14.75 9 14.75Z" fill="currentColor"/>
                                </svg>
                            </button>

                            <div
                                x-show="open"
                                @click.outside="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-1 w-40 rounded-xl border border-gray-200 bg-white shadow-lg z-50 py-1 dark:border-gray-700 dark:bg-gray-800"
                            >
                                {{-- Detail --}}
                                <button
                                    onclick="bukaDetail({{ $w->id }}); "
                                    class="flex w-full items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/[0.05]"
                                >
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                        <path d="M7.5 1C3.91 1 1 3.91 1 7.5S3.91 14 7.5 14 14 11.09 14 7.5 11.09 1 7.5 1zm0 11C4.47 12 2 9.53 2 6.5S4.47 1 7.5 1 13 3.47 13 6.5 10.53 12 7.5 12z" fill="currentColor"/>
                                        <path d="M7 5h1v5H7zM7 3h1v1H7z" fill="currentColor"/>
                                    </svg>
                                    Detail
                                </button>

                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin.warga.warga.edit', $w->id) }}"
                                    class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/[0.05]"
                                >
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                        <path d="M11.854 1.146a.5.5 0 0 0-.707 0L2.5 9.793V12.5h2.707l8.647-8.646a.5.5 0 0 0 0-.708l-2-2zM3.5 11.5v-1.293l7-7 1.293 1.293-7 7H3.5z" fill="currentColor"/>
                                    </svg>
                                    Edit
                                </a>

                                <div class="my-1 border-t border-gray-100 dark:border-gray-700"></div>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('admin.warga.warga.destroy', $w->id) }}" onsubmit="return confirm('Yakin ingin menghapus data warga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="flex w-full items-center gap-2.5 px-4 py-2.5 text-sm text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10"
                                    >
                                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                            <path d="M5.5 1h4v1h-4V1zM2 3h11v1H2V3zm2 1h7l-.5 9h-6L4 4zm2 2v5h1V6H6zm2 0v5h1V6H8z" fill="currentColor"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" class="text-gray-300 dark:text-gray-600">
                                <rect x="6" y="8" width="28" height="26" rx="3" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M13 16h14M13 21h10M13 26h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada data warga</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                @if(request()->filled('search') || request()->filled('jenis_kelamin'))
                                    Data tidak ditemukan dengan filter tersebut.
                                @else
                                    Belum ada warga yang terdaftar.
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($wargas->hasPages())
    <div class="flex items-center justify-between px-4 py-4 border-t border-gray-200 dark:border-gray-800">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Menampilkan {{ $wargas->firstItem() }} - {{ $wargas->lastItem() }} dari {{ $wargas->total() }} data
        </p>
        <div class="flex items-center gap-1">
            @if ($wargas->onFirstPage())
                <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed dark:bg-gray-800">Prev</span>
            @else
                <a href="{{ $wargas->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800">Prev</a>
            @endif

            @for ($i = 1; $i <= $wargas->lastPage(); $i++)
                <a href="{{ $wargas->url($i) }}" class="px-3 py-2 text-sm rounded-lg border {{ $wargas->currentPage() == $i ? 'bg-brand-500 text-white border-brand-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800' }}">
                    {{ $i }}
                </a>
            @endfor

            @if ($wargas->hasMorePages())
                <a href="{{ $wargas->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800">Next</a>
            @else
                <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed dark:bg-gray-800">Next</span>
            @endif
        </div>
    </div>
    @endif

</div>

{{-- MODAL DETAIL WARGA --}}
<div style="border: 1px solif black" id="modal-detail" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog">
    <div id="modal-backdrop" onclick="tutupDetail()" class="absolute inset-0 bg-black/60"></div>

    <div class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-xl flex flex-col max-h-[90vh]">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 shrink-0">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white">Detail Warga</h3>
            <button
                onclick="tutupDetail()"
                class="flex items-center justify-center w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-white/10"
            >
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div id="modal-content" class="px-6 py-2 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800 min-h-0 flex-1"></div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 shrink-0">
            <button
                onclick="tutupDetail()"
                class="w-full rounded-lg border border-gray-300 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.05]"
            >
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const wargaList = {!! json_encode($wargas->map(function($w) {
        return [
            'id'            => $w->id,
            'nik'           => $w->nik,
            'nama_lengkap'  => $w->nama_lengkap,
            'tempat_lahir'  => $w->tempat_lahir,
            'tanggal_lahir' => optional($w->tanggal_lahir)->format('d M Y'),
            'umur'          => $w->umur,
            'jenis_kelamin' => $w->label_jenis_kelamin,
            'agama'         => ucfirst($w->agama),
            'pekerjaan'     => $w->pekerjaan ?? '-',
            'no_telepon'    => $w->no_telepon ?? '-',
            'pendapatan'    => $w->pendapatan_format,
            'status_warga'  => $w->label_status_warga,
            'status_kk'     => $w->label_status_kk,
            'no_kk'         => optional($w->kartuKeluarga)->no_kk ?? '-',
            'email'         => optional($w->user)->email ?? null,
        ];
    })) !!};

    function bukaDetail(id) {
        const w = wargaList.find(x => x.id === id);
        if (!w) return;

        const rows = [
            ['NIK',             w.nik],
            ['No. KK',          w.no_kk],
            ['Nama Lengkap',    w.nama_lengkap],
            ['Status dalam KK', w.status_kk],
            ['Tempat Lahir',    w.tempat_lahir],
            ['Tanggal Lahir',   w.tanggal_lahir],
            ['Umur',            w.umur + ' tahun'],
            ['Jenis Kelamin',   w.jenis_kelamin],
            ['Agama',           w.agama],
            ['Pekerjaan',       w.pekerjaan],
            ['No. Telepon',     w.no_telepon],
            ['Pendapatan',      w.pendapatan],
            ['Status Warga',    w.status_warga],
            ['Akun / Email',    w.email ?? 'Belum punya akun'],
        ];

        const html = rows.map(([label, value]) => `
            <div class="flex items-start justify-between gap-4 py-3">
                <span class="text-xs text-gray-400 dark:text-gray-500 w-32 shrink-0 pt-0.5">${label}</span>
                <span class="text-sm font-medium text-gray-800 dark:text-white text-right break-words max-w-[60%]">${value}</span>
            </div>
        `).join('');

        document.getElementById('modal-content').innerHTML = html;
        document.getElementById('modal-detail').classList.remove('hidden');
        document.getElementById('modal-detail').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupDetail() {
        document.getElementById('modal-detail').classList.add('hidden');
        document.getElementById('modal-detail').classList.remove('flex');
        document.body.style.overflow = '';
    }
</script>
@endsection