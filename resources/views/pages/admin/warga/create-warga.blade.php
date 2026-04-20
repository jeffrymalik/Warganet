@extends('layouts.main')

@section('title', 'Tambah Data Warga')

@section('content')

<div x-data="{ pageName: `Tambah Data Warga` }">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">

    @if ($errors->any())
    <div class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15">
        <div class="flex items-start gap-3">
            <div class="-mt-0.5 text-error-500">❗</div>
            <div>
                <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">Terjadi Kesalahan:</h4>
                <ul class="text-sm text-gray-500 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.warga.warga.store') }}" method="POST">
        @csrf

        {{-- BOX 1 — PILIH KARTU KELUARGA --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Kartu Keluarga</h3>
            <p class="text-sm text-gray-400 mb-4">Pilih kartu keluarga tempat warga ini akan didaftarkan.</p>

            <div x-data="{ selected: '{{ old('kartu_keluarga_id') }}' }">
                {{-- Search + Dropdown --}}
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No. KK</label>
                <select
                    name="kartu_keluarga_id"
                    x-model="selected"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >
                    <option value="">-- Pilih No. KK --</option>
                    @foreach($kkList as $kk)
                        <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                            {{ $kk->no_kk }} — {{ $kk->kepalaKeluarga?->nama_lengkap ?? 'Tanpa Kepala KK' }}
                        </option>
                    @endforeach
                </select>

                {{-- Info KK setelah dipilih --}}
                <template x-if="selected">
                    @foreach($kkList as $kk)
                    <div x-show="selected == '{{ $kk->id }}'" class="mt-4 grid grid-cols-2 gap-4 rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-white/[0.02]">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">No. KK</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kk->no_kk }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Kepala Keluarga</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kk->kepalaKeluarga?->nama_lengkap ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Alamat</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kk->alamat ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">No. Rumah</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $kk->no_rumah ?? '-' }}</p>
                        </div>
                    </div>
                    @endforeach
                </template>
            </div>
        </div>

        {{-- BOX 2 — DATA WARGA --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Data Warga</h3>

            {{-- NIK --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" placeholder="NIK" inputmode="numeric" maxlength="16"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>

            {{-- Nama --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>

            {{-- Tempat & Tanggal Lahir --}}
            <div class="mt-5 grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" onclick="this.showPicker()"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"/>
                </div>
            </div>

            {{-- Jenis Kelamin --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">Pilih</option>
                    <option value="laki_laki"  {{ old('jenis_kelamin') == 'laki_laki'  ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan"  {{ old('jenis_kelamin') == 'perempuan'  ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Agama --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Agama</label>
                <select name="agama" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">Pilih</option>
                    <option value="islam"    {{ old('agama') == 'islam'    ? 'selected' : '' }}>Islam</option>
                    <option value="kristen"  {{ old('agama') == 'kristen'  ? 'selected' : '' }}>Kristen</option>
                    <option value="katolik"  {{ old('agama') == 'katolik'  ? 'selected' : '' }}>Katolik</option>
                    <option value="hindu"    {{ old('agama') == 'hindu'    ? 'selected' : '' }}>Hindu</option>
                    <option value="buddha"   {{ old('agama') == 'buddha'   ? 'selected' : '' }}>Buddha</option>
                    <option value="konghucu" {{ old('agama') == 'konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
            </div>

            {{-- Status dalam KK --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status dalam KK</label>
                <select name="status_dalam_kk" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">Pilih</option>
                    <option value="istri"   {{ old('status_dalam_kk') == 'istri'   ? 'selected' : '' }}>Istri</option>
                    <option value="anak"    {{ old('status_dalam_kk') == 'anak'    ? 'selected' : '' }}>Anak</option>
                    <option value="lainnya" {{ old('status_dalam_kk') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            {{-- Pekerjaan --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>

            {{-- No Telepon --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" placeholder="No Telepon"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>

            {{-- Pendapatan --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pendapatan</label>
                <input type="number" name="pendapatan" value="{{ old('pendapatan') }}" placeholder="Pendapatan" min="0"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>

            {{-- Status Warga --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status Warga</label>
                <select name="status_warga" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">Pilih</option>
                    <option value="aktif"       {{ old('status_warga') == 'aktif'       ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status_warga') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="pindah"      {{ old('status_warga') == 'pindah'      ? 'selected' : '' }}>Pindah</option>
                    <option value="meninggal"   {{ old('status_warga') == 'meninggal'   ? 'selected' : '' }}>Meninggal</option>
                </select>
            </div>
        </div>

        {{-- BOX 3 — AKUN (OPSIONAL) --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Akun</h3>
            <p class="text-sm text-gray-400 mb-4">(Opsional — kosongkan jika belum ingin dibuatkan akun)</p>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Password</label>
                <input type="password" name="password" placeholder="Password"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"/>
            </div>
        </div>

        {{-- TOMBOL --}}
        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('admin.warga.semua') }}"
                class="flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.05]">
                Batal
            </a>
            <button type="submit"
                class="flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection