@extends('layouts.main')

@section('title', 'Tambah Data Warga')

@section('content')

<!-- Breadcrumb Start -->
<div x-data="{ pageName: `Tambah Data Warga`}">
    @include('../../../partials/breadcrumb')
</div>

<!-- Content Start -->
<div class="mt-6 space-y-6">

    <!-- Error -->
        @if ($errors->any())
        <div
            class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15 mb-3"
        >
            <div class="flex items-start gap-3">
                
                <!-- Icon -->
                <div class="-mt-0.5 text-error-500">
                    <svg
                        class="fill-current"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M20.3499 12.0004C20.3499 16.612 16.6115 20.3504 11.9999 20.3504C7.38832 20.3504 3.6499 16.612 3.6499 12.0004C3.6499 7.38881 7.38833 3.65039 11.9999 3.65039C16.6115 3.65039 20.3499 7.38881 20.3499 12.0004ZM11.9999 22.1504C17.6056 22.1504 22.1499 17.6061 22.1499 12.0004C22.1499 6.3947 17.6056 1.85039 11.9999 1.85039C6.39421 1.85039 1.8499 6.3947 1.8499 12.0004C1.8499 17.6061 6.39421 22.1504 11.9999 22.1504ZM13.0008 16.4753C13.0008 15.923 12.5531 15.4753 12.0008 15.4753C11.4475 15.4753 10.9998 15.923 10.9998 16.4753C10.9998 17.0276 11.4475 17.4753 11.9998 17.4753C12.5531 17.4753 13.0008 17.0276 13.0008 16.4753ZM11.9998 6.62898C12.414 6.62898 12.7498 6.96476 12.7498 7.37898V13.0555C12.7498 13.4697 12.414 13.8055 11.9998 13.8055C11.5856 13.8055 11.2498 13.4697 11.2498 13.0555V7.37898C11.2498 6.96476 11.5856 6.62898 11.9998 6.62898Z"
                            fill="#F04438"
                        />
                    </svg>
                </div>

                <!-- Content -->
                <div>
                    <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                        Terjadi Kesalahan:
                    </h4>

                    <ul class="text-sm text-gray-500 dark:text-gray-400 list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    @endif

    <form action="{{ route('admin.warga.store') }}" method="POST">
        @csrf

                    <!-- CARD: KARTU KELUARGA -->
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
                    value="{{ old('no_kk') }}"
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
                    value="{{ old('alamat') }}"
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
                    value="{{ old('no_rumah') }}"
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
                    value="{{ old('blok') }}"
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
                        <option value="pemilik" {{ old('status_hunian')=='pemilik' ? 'selected' : '' }}>Pemilik</option>
                        <option value="kontrak" {{ old('status_hunian')=='kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="kost" {{ old('status_hunian')=='kost' ? 'selected' : '' }}>Kost</option>
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
                        value="{{ old('tanggal_mulai_tinggal') }}"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        onclick="this.showPicker()"
                    />
                </div>
            </div>

        </div>

        <!-- CARD: WARGA -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Data Kepala Keluarga
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NIK --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        NIK
                    </label>
                    <input 
                        type="text" 
                        name="nik" 
                        maxlength="16"
                        inputmode="numeric"
                        value="{{ old('nik') }}" 
                        placeholder="Masukkan NIK"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        name="nama_lengkap" 
                        value="{{ old('nama_lengkap') }}" 
                        placeholder="Nama Lengkap"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                {{-- Tempat Lahir --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tempat Lahir
                    </label>
                    <input 
                        type="text" 
                        name="tempat_lahir" 
                        value="{{ old('tempat_lahir') }}" 
                        placeholder="Kota Kelahiran"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tanggal Lahir
                    </label>
                    <div class="relative">
                        <input 
                            type="date" 
                            name="tanggal_lahir" 
                            value="{{ old('tanggal_lahir') }}" 
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            onclick="this.showPicker()"
                        >
                        <span class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                        <svg
                            class="fill-current"
                            width="20"
                            height="20"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                                fill=""
                            />
                        </svg>
                    </span>
                    </div>
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Jenis Kelamin
                    </label>
                    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                        <select 
                            name="jenis_kelamin" 
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                            @change="isOptionSelected = true"
                        >
                            <option value="">Pilih</option>

                            <option value="laki_laki"
                                {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'laki_laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="perempuan"
                                {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Agama --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Agama
                    </label>
                    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                        <select 
                            name="agama" 
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            @change="isOptionSelected = true"
                        >
                            <option value="">Pilih</option>

                            <option value="islam"
                                {{ old('agama', $warga->agama ?? '') == 'islam' ? 'selected' : '' }}>
                                Islam
                            </option>

                            <option value="kristen"
                                {{ old('agama', $warga->agama ?? '') == 'kristen' ? 'selected' : '' }}>
                                Kristen
                            </option>

                            <option value="katolik"
                                {{ old('agama', $warga->agama ?? '') == 'katolik' ? 'selected' : '' }}>
                                Katolik
                            </option>

                            <option value="hindu"
                                {{ old('agama', $warga->agama ?? '') == 'hindu' ? 'selected' : '' }}>
                                Hindu
                            </option>

                            <option value="buddha"
                                {{ old('agama', $warga->agama ?? '') == 'buddha' ? 'selected' : '' }}>
                                Buddha
                            </option>

                            <option value="konghucu"
                                {{ old('agama', $warga->agama ?? '') == 'konghucu' ? 'selected' : '' }}>
                                Konghucu
                            </option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Pekerjaan --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Pekerjaan
                    </label>
                    <input 
                        type="text" 
                        name="pekerjaan" 
                        value="{{ old('pekerjaan') }}" 
                        placeholder="Contoh: Karyawan Swasta"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                {{-- No Telepon --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        No Telepon
                    </label>
                    <input 
                        type="text" 
                        name="no_telepon" 
                        value="{{ old('no_telepon') }}" 
                        placeholder="0812..."
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                {{-- Pendapatan --}}
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Pendapatan
                    </label>
                    <input 
                        type="number" 
                        name="pendapatan" 
                        value="{{ old('pendapatan') }}" 
                        placeholder="Rp. 0"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] mt-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Data Akun
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Email --}}
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="contoh@email.com"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Password
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="••••••••"
                        value="{{old('password')}}"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Konfirmasi Password
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        value=""
                        value="{{old('password_confirmation')}}"
                        placeholder="••••••••"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

            </div>
        </div>

        <!-- ACTION -->
        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('admin.warga.index') }}"
               class="px-4 py-2 text-sm font-medium bg-gray-200 rounded-lg dark:bg-gray-700 dark:text-white">
                Batal
            </a>

            <button type="submit"
                class="px-5 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">
                Simpan Data
            </button>
        </div>
    </form>

</div>
@endsection