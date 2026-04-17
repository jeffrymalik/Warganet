@extends('layouts.main')

@section('content')
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Manajemen Data Warga`}">
        @include('../../../partials/breadcrumb')
    </div>

    <!-- Content Start -->
    <div class="mt-6 space-y-6">

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Total KK -->
            <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-white/[0.03] shadow p-5">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total KK</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                    {{ $kartus->total() }}
                </h3>
            </div>

            <!-- Akun Terdaftar -->
            <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-white/[0.03] shadow p-5">
                <p class="text-sm text-gray-500 dark:text-gray-400">Akun Terdaftar</p>
                <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                    -
                </h3>
            </div>

            <!-- Total Warga -->
            <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-white/[0.03] shadow p-5">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Warga</p>
                <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                    -
                </h3>
            </div>

            <!-- Belum Ada Akun -->
            <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-white/[0.03] shadow p-5">
                <p class="text-sm text-gray-500 dark:text-gray-400">Belum Ada Akun</p>
                <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">
                    -
                </h3>
            </div>
        </div>

        <!-- Card -->
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-white/[0.03] shadow">

            <!-- Header -->
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Daftar Kartu Keluarga
                </h2>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.warga.index') }}"
                        class="flex flex-col sm:flex-row gap-2">

                        <!-- Search -->
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari No KK / NIK / Nama..."
                            value="{{ request('search') }}"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm
                                   bg-white dark:bg-gray-800
                                   text-gray-800 dark:text-gray-100
                                   placeholder-gray-400 dark:placeholder-gray-500
                                   focus:ring-2 focus:ring-primary focus:outline-none">

                        <!-- Filter Status Hunian -->
                        <select
                            name="status_hunian"
                            onchange="this.form.submit()"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm
                                   bg-white dark:bg-gray-800
                                   text-gray-800 dark:text-gray-100
                                   focus:ring-2 focus:ring-primary focus:outline-none">
                            <option value="">Semua Status</option>
                            <option value="pemilik"    {{ request('status_hunian') == 'pemilik'    ? 'selected' : '' }}>Pemilik</option>
                            <option value="kontrak"    {{ request('status_hunian') == 'kontrak'    ? 'selected' : '' }}>Kontrak</option>
                            <option value="kost"       {{ request('status_hunian') == 'kost'       ? 'selected' : '' }}>Kost</option>
                        </select>

                        <!-- Tombol Cari -->
                        <button
                            type="submit"
                            class="bg-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-opacity-90 transition">
                            Cari
                        </button>
                    </form>

                    <!-- Tombol Tambah -->
                    <a href="{{ route('admin.warga.create') }}"
                        class="inline-flex items-center gap-1.5 bg-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-opacity-90 transition whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Warga
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                @if($kartus->isEmpty())
                    <!-- Empty State -->
                    <div class="p-10 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada data ditemukan</p>
                    </div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-800/60">
                            <tr>
                                <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold">No KK</th>
                                <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold">No Rumah</th>
                                <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold">Kepala Keluarga</th>
                                <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold">NIK</th>
                                <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold">Status Hunian</th>
                                <th class="p-3 text-center text-gray-600 dark:text-gray-300 font-semibold">Anggota</th>
                                <th class="p-3 text-center text-gray-600 dark:text-gray-300 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($kartus as $kk)
                                <tr class="bg-white dark:bg-transparent">

                                    <!-- No KK -->
                                    <td class="p-3 font-medium text-gray-800 dark:text-gray-100">
                                        {{ $kk->no_kk }}
                                    </td>

                                    <!-- No Rumah -->
                                    <td class="p-3 text-gray-700 dark:text-gray-300">
                                        {{ $kk->no_rumah ?? '-' }}
                                    </td>

                                    <!-- Kepala Keluarga -->
                                    <td class="p-3 text-gray-700 dark:text-gray-300">
                                        {{ $kk->kepalaKeluarga->nama_lengkap ?? '-' }}
                                    </td>

                                    <!-- NIK -->
                                    <td class="p-3 text-gray-500 dark:text-gray-400">
                                        {{ $kk->kepalaKeluarga->nik ?? '-' }}
                                    </td>

                                    <!-- Status Hunian -->
                                    <td class="p-3">
                                        @php
                                            $status = $kk->status_hunian;
                                            $badgeClass = match($status) {
                                                'pemilik' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
                                                'kontrak' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400',
                                                'kost'    => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                                                default   => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>

                                    <!-- Jumlah Anggota -->
                                    <td class="p-3 text-center text-gray-700 dark:text-gray-300">
                                        {{ $kk->anggota->count() }}
                                    </td>

                                    <!-- Aksi -->
                                    <td class="p-3 text-center">
                                        <div x-data="{ open: false }" class="relative inline-block text-left">

                                            <!-- Tombol titik tiga -->
                                            <button
                                                @click="open = !open"
                                                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 text-gray-600 dark:text-gray-300"
                                                    viewBox="0 0 24 24" fill="currentColor">
                                                    <circle cx="12" cy="5"  r="1.5"/>
                                                    <circle cx="12" cy="12" r="1.5"/>
                                                    <circle cx="12" cy="19" r="1.5"/>
                                                </svg>
                                            </button>

                                            <!-- Dropdown Menu -->
                                            <div
                                                x-show="open"
                                                @click.outside="open = false"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute right-0 mt-2 w-40
                                                       bg-white dark:bg-gray-800
                                                       border border-gray-200 dark:border-gray-700
                                                       rounded-xl shadow-lg z-50">

                                                <!-- Detail -->
                                                <a href="{{ route('admin.warga.show', $kk->id) }}"
                                                    class="flex items-center gap-2 px-4 py-2 text-sm
                                                           text-gray-700 dark:text-gray-200
                                                           hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-xl transition">
                                                    👁️ <span>Detail</span>
                                                </a>

                                                <!-- Edit -->
                                                <a href="{{ route('admin.warga.edit', $kk->id) }}"
                                                    class="flex items-center gap-2 px-4 py-2 text-sm
                                                           text-gray-700 dark:text-gray-200
                                                           hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                    ✏️ <span>Edit</span>
                                                </a>

                                                <!-- Hapus -->
                                                <form action="{{ route('admin.warga.destroy', $kk->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                        class="w-full flex items-center gap-2 px-4 py-2 text-sm
                                                               text-red-600 dark:text-red-400
                                                               hover:bg-gray-100 dark:hover:bg-gray-700 rounded-b-xl transition">
                                                        🗑️ <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $kartus->links() }}
            </div>
        </div>

    </div>
@endsection