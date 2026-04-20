@extends('layouts.main')

@section('title', 'Detail Kartu Keluarga')

@section('content')

<div x-data="{ pageName: `Detail Kartu Keluarga`}">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="rounded-xl border border-success-500 bg-success-50 p-4 dark:border-success-500/30 dark:bg-success-500/15">
        <p class="text-sm font-medium text-success-700 dark:text-success-400">✅ {{ session('success') }}</p>
    </div>
    @endif

    {{-- BOX 1 — DATA KARTU KELUARGA --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Data Kartu Keluarga</h3>
            <a
                href="{{ route('admin.warga.edit', $kartuKeluarga->id) }}"
                class="flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.05]"
            >
                ✏️ Edit
            </a>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">No KK</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kartuKeluarga->no_kk }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">No Rumah</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kartuKeluarga->alamat_lengkap }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Alamat</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kartuKeluarga->alamat }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Status Hunian</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kartuKeluarga->label_status_hunian }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Tanggal Mulai Tinggal</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ optional($kartuKeluarga->tanggal_mulai_tinggal)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Total Pendapatan KK</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kartuKeluarga->total_pendapatan_format }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Kategori Ekonomi KK</p>
                <span class="inline-flex items-center justify-center gap-1 rounded-full bg-success-50 px-2.5 py-0.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500 {{ $kartuKeluarga->badge_ekonomi }}">
                    {{ $kartuKeluarga->kategori_ekonomi }}
                </span>
            </div>
        </div>
    </div>

    {{-- BOX 2 — DATA KEPALA KELUARGA --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Kepala Keluarga</h3>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">NIK</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kepala->nik }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Nama Lengkap</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kepala->nama_lengkap }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Tempat, Tanggal Lahir</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">
                    {{ $kepala->tempat_lahir }}, {{ optional($kepala->tanggal_lahir)->format('d M Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Umur</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kepala->umur }} tahun</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Jenis Kelamin</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kepala->label_jenis_kelamin }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Agama</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white capitalize">{{ $kepala->agama }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Pekerjaan</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kepala->pekerjaan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">No Telepon</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kepala->no_telepon ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Pendapatan</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kepala->pendapatan_format }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Status Warga</p>
                <span class="inline-flex items-center justify-center gap-1 rounded-full bg-success-50 px-2.5 py-0.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500 {{ $kepala->badge_status_warga }}">
                    {{ $kepala->label_status_warga }}
                </span>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Akun</p>
                @if($kepala->user_id)
                    <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kepala->user->email }}</p>
                @else
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-700">Belum punya akun</span>
                @endif
            </div>
        </div>
    </div>

    {{-- BOX 3 — ANGGOTA KELUARGA --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Anggota Keluarga
                <span class="ml-2 text-sm font-normal text-gray-400">({{ $anggota->count() }} orang)</span>
            </h3>
            
            <a    href="{{ route('admin.warga.anggota.create', $kartuKeluarga->id) }}"
                class="flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600"
            >
                + Tambah Anggota
            </a>
        </div>

        @if($anggota->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">NIK</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Nama</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Jenis Kelamin</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Agama</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Status</th>
                        <th class="pb-3 text-left text-xs font-medium text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($anggota as $a)
                    <tr>
                        <td class="py-3 text-gray-600 dark:text-gray-400">{{ $a->nik }}</td>
                        <td class="py-3 font-medium text-gray-800 dark:text-white">{{ $a->nama_lengkap }}</td>
                        <td class="py-3 text-gray-600 dark:text-gray-400">{{ $a->label_jenis_kelamin }}</td>
                        <td class="py-3 text-gray-600 dark:text-gray-400 capitalize">{{ $a->agama }}</td>
                        <td class="py-3 text-gray-600 dark:text-gray-400 capitalize">{{ $a->status_warga }}</td>
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                {{-- Detail --}}
                                <button
                                    type="button"
                                    onclick="bukaDetail({{ $a->id }})"
                                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.05]"
                                >
                                    Detail
                                </button>
                                {{-- Edit --}}
                                
                                <a    href="{{ route('admin.warga.anggota.edit', $a->id) }}"
                                    class="rounded-lg border border-brand-300 px-3 py-1.5 text-xs font-medium text-brand-600 hover:bg-brand-50 dark:border-brand-700 dark:text-brand-400"
                                >
                                    Edit
                                </a>
                                {{-- Hapus --}}
                                <form action="{{ route('admin.warga.anggota.destroy', $a->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-lg border border-red-300 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 dark:border-red-700 dark:text-red-400">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-sm text-gray-400 text-center py-6">Belum ada anggota keluarga.</p>
        @endif
    </div>

    {{-- TOMBOL KEMBALI --}}
    <div class="flex justify-start">
        
        <a    href="{{ route('admin.warga.index') }}"
            class="flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-blue-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.05]"
        >
            ← Kembali
        </a>
    </div>

</div>

    {{-- POPUP DETAIL ANGGOTA --}}
    <div id="modal-detail" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog">
    
        {{-- Backdrop --}}
        <div id="modal-backdrop" onclick="tutupDetail()" class="absolute inset-0 bg-black/60"></div>

        {{-- Modal Box --}}
        <div class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-xl flex flex-col max-h-[90vh]">
            
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 shrink-0">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Detail Anggota</h3>
                <button 
                    onclick="tutupDetail()" 
                    class="flex items-center justify-center w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-white/10"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Content — ini yang scroll --}}
            <div id="modal-content" class="px-6 py-2 overflow-y-scroll divide-y divide-gray-100 dark:divide-gray-800 min-h-0 flex-1"">
                {{-- diisi JS --}}
            </div>

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
    const anggotaList = {!! json_encode($anggota->map(function($a) {
        return [
            'id'             => $a->id,
            'nik'            => $a->nik,
            'nama_lengkap'   => $a->nama_lengkap,
            'tempat_lahir'   => $a->tempat_lahir,
            'tanggal_lahir'  => optional($a->tanggal_lahir)->format('d M Y'),
            'umur'           => $a->umur,
            'jenis_kelamin'  => $a->label_jenis_kelamin,
            'agama'          => ucfirst($a->agama),
            'pekerjaan'      => $a->pekerjaan ?? '-',
            'no_telepon'     => $a->no_telepon ?? '-',
            'pendapatan'     => $a->pendapatan_format,
            'status_warga'   => $a->label_status_warga,
            'status_kk'      => $a->label_status_kk,
            'email'          => optional($a->user)->email ?? null,
        ];
    })) !!};

    function bukaDetail(id) {
        const a = anggotaList.find(x => x.id === id);
        if (!a) return;

        const rows = [
            ['NIK',             a.nik],
            ['Nama Lengkap',    a.nama_lengkap],
            ['Tempat Lahir',    a.tempat_lahir],
            ['Tanggal Lahir',   a.tanggal_lahir],
            ['Umur',            a.umur + ' tahun'],
            ['Jenis Kelamin',   a.jenis_kelamin],
            ['Agama',           a.agama],
            ['Pekerjaan',       a.pekerjaan],
            ['No Telepon',      a.no_telepon],
            ['Pendapatan',      a.pendapatan],
            ['Status Warga',    a.status_warga],
            ['Status dalam KK', a.status_kk],
            ['Akun / Email',    a.email ?? 'Belum punya akun'],
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

        // Cegah scroll body ketika modal terbuka
        document.body.style.overflow = 'hidden';
    }

    function tutupDetail() {
        document.getElementById('modal-detail').classList.add('hidden');
        document.getElementById('modal-detail').classList.remove('flex');

        // Kembalikan scroll body
        document.body.style.overflow = '';
    }

    // Tutup modal kalau klik backdrop
    document.getElementById('modal-detail').addEventListener('click', function(e) {
        if (e.target === this) tutupDetail();
    });
    
</script>
@endsection