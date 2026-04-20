@extends('layouts.main')

@section('title', 'Edit Data Warga')

@section('content')

<div x-data="{ pageName: `Edit Data Kartu Keluarga`}">
    @include('../../../partials/breadcrumb')
</div>

<div class="mt-6 space-y-6">

    {{-- ERROR --}}
    @if ($errors->any())
    <div class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15 mb-3">
        <div class="flex items-start gap-3">
            <div class="-mt-0.5 text-error-500">
                ❗
            </div>
            <div>
                <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                    Terjadi Kesalahan:
                </h4>
                <ul class="text-sm text-gray-500 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.warga.update', ['kartuKeluarga' => $warga->kartuKeluarga->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Data Kartu Keluarga
            </h3>

            {{-- No KK --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    No KK
                </label>
                <input
                    type="text"
                    name="no_kk"
                    value="{{ old('no_kk', $kartuKeluarga->no_kk ?? '') }}"
                    placeholder="No KK"
                    inputmode="numeric"
                    maxlength="16"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- Alamat --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Alamat
                </label>
                <input
                    type="text"
                    name="alamat"
                    value="{{ old('alamat', $kartuKeluarga->alamat ?? '') }}"
                    placeholder="Alamat"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- No Rumah --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    No Rumah
                </label>
                <input
                    type="text"
                    name="no_rumah"
                    value="{{ old('no_rumah', $kartuKeluarga->no_rumah ?? '') }}"
                    placeholder="No Rumah"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- Blok --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Blok
                </label>
                <input
                    type="text"
                    name="blok"
                    value="{{ old('blok', $kartuKeluarga->blok ?? '') }}"
                    placeholder="Blok"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- Status Hunian --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Status Hunian
                </label>

                <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                    <select
                        name="status_hunian"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        @change="isOptionSelected = true"
                    >
                        <option value="">Pilih</option>
                        <option value="pemilik" {{ old('status_hunian', $kartuKeluarga->status_hunian ?? '')=='pemilik'?'selected':'' }}>Pemilik</option>
                        <option value="kontrak" {{ old('status_hunian', $kartuKeluarga->status_hunian ?? '')=='kontrak'?'selected':'' }}>Kontrak</option>
                        <option value="kost" {{ old('status_hunian', $kartuKeluarga->status_hunian ?? '')=='kost'?'selected':'' }}>Kost</option>
                    </select>
                </div>
            </div>

            {{-- Tanggal Mulai Tinggal --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Tanggal Mulai Tinggal
                </label>

                <div class="relative">
                    <input
                        type="date"
                        name="tanggal_mulai_tinggal"
                        value="{{ old('tanggal_mulai_tinggal', optional($kartuKeluarga->tanggal_mulai_tinggal)->format('Y-m-d')) }}"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        onclick="this.showPicker()"
                    />
                </div>
            </div>

        </div>
                {{-- BOX 2 — KEPALA KELUARGA --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">
            
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Data Kepala Keluarga
            </h3>

            {{-- Ganti Kepala Keluarga (hanya muncul kalau ada anggota lain) --}}
            @if($anggotaLain->count() > 0)
            <div class="mb-5 rounded-xl border border-warning-300 bg-warning-50 p-4 dark:border-warning-500/30 dark:bg-warning-500/10">
                <p class="text-sm text-warning-700 dark:text-warning-400 mb-3 font-medium">
                    ⚠️ Ganti Kepala Keluarga
                </p>
                <select
                    name="kepala_keluarga_id"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >
                    <option value="">-- Tetap ({{ $warga->nama_lengkap }}) --</option>
                    @foreach($anggotaLain as $anggota)
                        <option value="{{ $anggota->id }}">{{ $anggota->nama_lengkap }} — {{ $anggota->nik }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-warning-600 dark:text-warning-400 mt-2">
                    Jika diganti, data di bawah akan mengikuti kepala keluarga yang baru.
                </p>
            </div>
            @endif

            {{-- NIK --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">NIK</label>
                <input

                    type="text"
                    name="nik"
                    value="{{ old('nik', $warga->nik ?? '') }}"
                    placeholder="NIK"
                    inputmode="numeric"
                    maxlength="16"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- Nama Lengkap --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Lengkap</label>
                <input
                    type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap', $warga->nama_lengkap ?? '') }}"
                    placeholder="Nama Lengkap"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- Tempat & Tanggal Lahir --}}
            <div class="mt-5 grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tempat Lahir</label>
                    <input
                        type="text"
                        name="tempat_lahir"
                        value="{{ old('tempat_lahir', $warga->tempat_lahir ?? '') }}"
                        placeholder="Tempat Lahir"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Lahir</label>
                    <input
    
                        type="date"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', optional($warga->tanggal_lahir)->format('Y-m-d')) }}"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        onclick="this.showPicker()"
                    />
                </div>
            </div>

            {{-- Jenis Kelamin --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis Kelamin</label>
                <select

                    name="jenis_kelamin"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    <option value="">Pilih</option>
                    <option value="laki_laki" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'laki_laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Agama --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Agama</label>
                <select

                    name="agama"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                >
                    <option value="">Pilih</option>
                    <option value="islam"     {{ old('agama', $warga->agama ?? '') == 'islam'     ? 'selected' : '' }}>Islam</option>
                    <option value="kristen"   {{ old('agama', $warga->agama ?? '') == 'kristen'   ? 'selected' : '' }}>Kristen</option>
                    <option value="katolik"   {{ old('agama', $warga->agama ?? '') == 'katolik'   ? 'selected' : '' }}>Katolik</option>
                    <option value="hindu"     {{ old('agama', $warga->agama ?? '') == 'hindu'     ? 'selected' : '' }}>Hindu</option>
                    <option value="buddha"    {{ old('agama', $warga->agama ?? '') == 'buddha'    ? 'selected' : '' }}>Buddha</option>
                    <option value="konghucu"  {{ old('agama', $warga->agama ?? '') == 'konghucu'  ? 'selected' : '' }}>Konghucu</option>
                </select>
            </div>

            {{-- Pekerjaan --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pekerjaan</label>
                <input
                    type="text"
                    name="pekerjaan"
                    value="{{ old('pekerjaan', $warga->pekerjaan ?? '') }}"
                    placeholder="Pekerjaan"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- No Telepon --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No Telepon</label>
                <input
                    type="text"
                    name="no_telepon"
                    value="{{ old('no_telepon', $warga->no_telepon ?? '') }}"
                    placeholder="No Telepon"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- Pendapatan --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pendapatan</label>
                <input

                    type="number"
                    name="pendapatan"
                    value="{{ old('pendapatan', $warga->pendapatan ?? '') }}"
                    placeholder="Pendapatan"
                    min="0"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            {{-- Status Warga --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status Warga</label>
                <select

                    name="status_warga"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                >
                    <option value="">Pilih</option>
                    <option value="aktif"       {{ old('status_warga', $warga->status_warga ?? '') == 'aktif'       ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status_warga', $warga->status_warga ?? '') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="pindah"      {{ old('status_warga', $warga->status_warga ?? '') == 'pindah'      ? 'selected' : '' }}>Pindah</option>
                    <option value="meninggal"   {{ old('status_warga', $warga->status_warga ?? '') == 'meninggal'   ? 'selected' : '' }}>Meninggal</option>
                </select>
            </div>

        </div>

                {{-- BOX 3 — AKUN --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">

            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Akun
            </h3>

            <div id="box-akun-content">
                @if($warga->user_id)
                    {{-- Sudah punya akun — edit saja --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $warga->user->email ?? '') }}"
                            placeholder="Email"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:shadow-focus-ring dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-0 focus:outline-hi:border-gray:bg-gra:placeholder:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 :border-gray-800 :bg-white/[0.03] :placeholder:text-white/15"
                        />
                    </div>

                    <div class="mt-5">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Password <span class="text-gray-400 font-normal"></span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Password baru"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                    </div>

                    <div class="mt-5">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Konfirmasi Password</label>
                        <input
        
                            type="password"
                            name="password_confirmation"
                            placeholder="Konfirmasi Password"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                    </div>

                @else
                    {{-- Belum punya akun — minta buat --}}
                    <div class="rounded-xl border border-warning-300 bg-warning-50 p-4 dark:border-warning-500/30 dark:bg-warning-500/10 mb-5">
                        <p class="text-sm font-medium text-warning-700 dark:text-warning-400">
                            ⚠️ Warga ini belum memiliki akun. Silakan buatkan akun dengan mengisi data di bawah ini.
                        </p>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                    </div>

                    <div class="mt-5">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Password</label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Password"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                    </div>

                    <div class="mt-5">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Konfirmasi Password"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                    </div>
                @endif
            </div>

        </div>

        {{-- TOMBOL SUBMIT --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.warga.index') }}"
                class="flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.05]"
            >
                Batal
            </a>
            <button
                type="submit"
                class="flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
            >
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const anggotaData = {!! json_encode($anggotaJson) !!};

    const kepalaAsli = {
        id:            null,
        nik:           "{{ $warga->nik }}",
        nama_lengkap:  "{{ $warga->nama_lengkap }}",
        tempat_lahir:  "{{ $warga->tempat_lahir }}",
        tanggal_lahir: "{{ optional($warga->tanggal_lahir)->format('Y-m-d') }}",
        jenis_kelamin: "{{ $warga->jenis_kelamin }}",
        agama:         "{{ $warga->agama }}",
        pekerjaan:     "{{ $warga->pekerjaan ?? '' }}",
        no_telepon:    "{{ $warga->no_telepon ?? '' }}",
        pendapatan:    "{{ $warga->pendapatan }}",
        status_warga:  "{{ $warga->status_warga }}",
        email:         "{{ optional($warga->user)->email ?? '' }}",
        punya_akun:    {{ $warga->user_id ? 'true' : 'false' }},
    };

    function isiForm(data) {
        document.querySelector('[name=nik]').value           = data.nik;
        document.querySelector('[name=nama_lengkap]').value  = data.nama_lengkap;
        document.querySelector('[name=tempat_lahir]').value  = data.tempat_lahir;
        document.querySelector('[name=tanggal_lahir]').value = data.tanggal_lahir;
        document.querySelector('[name=jenis_kelamin]').value = data.jenis_kelamin;
        document.querySelector('[name=agama]').value         = data.agama;
        document.querySelector('[name=pekerjaan]').value     = data.pekerjaan;
        document.querySelector('[name=no_telepon]').value    = data.no_telepon;
        document.querySelector('[name=pendapatan]').value    = data.pendapatan;
        document.querySelector('[name=status_warga]').value  = data.status_warga;

        // Update box akun dinamis
        updateBoxAkun(data.email, data.punya_akun);
    }

    function updateBoxAkun(email, punyaAkun) {
        const boxAkun = document.getElementById('box-akun-content');

        if (punyaAkun) {
            boxAkun.innerHTML = `
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                    <input type="email" name="email" value="${email}" placeholder="Email"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                </div>
                <div class="mt-5">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Password <span class="text-gray-400 font-normal"></span>
                    </label>
                    <input type="password" name="password" placeholder="Password baru"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                </div>
                <div class="mt-5">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                </div>
            `;
        } else {
            boxAkun.innerHTML = `
                <div class="rounded-xl border border-warning-300 bg-warning-50 p-4 dark:border-warning-500/30 dark:bg-warning-500/10 mb-5">
                    <p class="text-sm font-medium text-warning-700 dark:text-warning-400">
                        ⚠️ Warga ini belum memiliki akun. Silakan buatkan akun dengan mengisi data di bawah ini.
                    </p>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                    <input type="email" name="email" value="" placeholder="Email"
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
            `;
        }
    }

    // Dropdown ganti kepala keluarga — cek dulu apakah ada elemennya
    const dropdownKepala = document.querySelector('[name=kepala_keluarga_id]');
    if (dropdownKepala) {
        dropdownKepala.addEventListener('change', function () {
            const selectedId = parseInt(this.value);

            if (!selectedId) {
                isiForm(kepalaAsli);
                return;
            }

            const anggota = anggotaData.find(a => a.id === selectedId);
            if (anggota) isiForm(anggota);
        });
    }

</script>

@endsection