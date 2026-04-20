<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Warga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class WargaController extends Controller
{
    // ─────────────────────────────────────────────────────
    // INDEX — Daftar semua KK beserta anggotanya
    // ─────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = KartuKeluarga::with([
            'kepalaKeluarga.user',
            'anggota',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                ->orWhere('no_rumah', 'like', "%{$search}%")
                ->orWhereHas('kepalaKeluarga', function ($q2) use ($search) {
                    $q2->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status_hunian')) {
            $query->where('status_hunian', $request->status_hunian);
        }

        $kartus = $query->latest()->paginate(10)->withQueryString();

        // 🔥 Statistik
        $totalWarga = Warga::count();

        $akunTerdaftar = Warga::whereHas('user')->count();

        $belumAdaAkun = Warga::doesntHave('user')->count();

        return view('pages.admin.warga.index', compact(
            'kartus',
            'totalWarga',
            'akunTerdaftar',
            'belumAdaAkun'
        ));
    }

    public function warga(Request $request)
    {
        $query = Warga::with('user');

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%")
                ->orWhere('no_telepon', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q2) use ($search) {
                    $q2->where('email', 'like', "%{$search}%");
                });
            });
        }

        $wargas = $query->latest()->paginate(10)->withQueryString();

        // 🔥 Statistik (yang kamu butuhin)
        $totalWarga = Warga::count();
        $sudahPunyaAkun = Warga::whereNotNull('user_id')->count();
        $belumPunyaAkun = Warga::whereNull('user_id')->count();

        return view('pages.admin.warga.warga', compact(
            'wargas',
            'totalWarga',
            'sudahPunyaAkun',
            'belumPunyaAkun'
        ));
    }

    // ─────────────────────────────────────────────────────
    // CREATE — Form tambah warga baru (KK + Kepala Keluarga)
    // ─────────────────────────────────────────────────────
    public function create()
    {
        return view('pages.admin.warga.create');
    }

    // ─────────────────────────────────────────────────────
    // STORE — Simpan KK + Kepala Keluarga + Akun User
    // ─────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'no_kk'                 => 'required|string|size:16|unique:kartu_keluarga,no_kk',
            'no_rumah'              => 'required|string|max:10',
            'alamat'              => 'required|string|min:10',
            'blok'                  => 'nullable|string|max:10',
            'status_hunian'         => 'required|in:pemilik,kontrak,kost',
            'tanggal_mulai_tinggal' => 'required|date',
            'nik'                   => 'required|string|size:16|unique:warga,nik',
            'nama_lengkap'          => 'required|string|max:100',
            'tempat_lahir'          => 'required|string|max:50',
            'tanggal_lahir'         => 'required|date|before:today',
            'jenis_kelamin'         => 'required|in:laki_laki,perempuan',
            'agama'                 => 'required|in:islam,kristen,katolik,hindu,buddha,konghucu',
            'pekerjaan'             => 'nullable|string|max:50',
            'no_telepon'            => 'nullable|string|max:15',
            'pendapatan'            => 'required|integer|min:0',
            'email'                 => 'required|email|unique:users,email',
            'password'              => ['required', 'confirmed', Password::min(8)],
        ], [
            'no_kk.size'           => 'No. KK harus 16 digit.',
            'no_kk.unique'         => 'No. KK sudah terdaftar.',
            'nik.size'             => 'NIK harus 16 digit.',
            'nik.unique'           => 'NIK sudah terdaftar.',
            'email.unique'         => 'Email sudah digunakan.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'warga',
            ]);

            $kk = KartuKeluarga::create([
                'no_kk'                 => $request->no_kk,
                'alamat'                => $request->alamat,
                'no_rumah'              => $request->no_rumah,
                'blok'                  => $request->blok,
                'status_hunian'         => $request->status_hunian,
                'tanggal_mulai_tinggal' => $request->tanggal_mulai_tinggal,
            ]);

            Warga::create([
                'user_id'            => $user->id,
                'kartu_keluarga_id'  => $kk->id,
                'nik'                => $request->nik,
                'nama_lengkap'       => $request->nama_lengkap,
                'tempat_lahir'       => $request->tempat_lahir,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'jenis_kelamin'      => $request->jenis_kelamin,
                'agama'              => $request->agama,
                'pekerjaan'          => $request->pekerjaan,
                'no_telepon'         => $request->no_telepon,
                'pendapatan'         => $request->pendapatan,
                'is_kepala_keluarga' => true,
                'status_dalam_kk'    => 'kepala_keluarga',
                'status_warga'       => 'aktif',
            ]);
        });

        return redirect()->route('admin.warga.index')
                         ->with('success', 'Data warga berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────────────────
    // SHOW — Detail satu KK beserta semua anggotanya
    // ─────────────────────────────────────────────────────
    public function show(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load(['kepalaKeluarga.user', 'anggota.user', 'wargas']);
        $kepala  = $kartuKeluarga->kepalaKeluarga;
        $anggota = $kartuKeluarga->anggota;

        return view('pages.admin.warga.show', compact('kartuKeluarga', 'kepala', 'anggota'));
    }

    // ─────────────────────────────────────────────────────
    // EDIT — Form edit data kepala keluarga
    // ─────────────────────────────────────────────────────
    public function edit(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load(['kepalaKeluarga.user', 'anggota.user']);
        $warga = $kartuKeluarga->kepalaKeluarga;
        $anggotaLain = $kartuKeluarga->anggota;

        $anggotaJson = $anggotaLain->map(function($a) {
            return [
                'id'            => $a->id,
                'nik'           => $a->nik,
                'nama_lengkap'  => $a->nama_lengkap,
                'tempat_lahir'  => $a->tempat_lahir,
                'tanggal_lahir' => optional($a->tanggal_lahir)->format('Y-m-d'),
                'jenis_kelamin' => $a->jenis_kelamin,
                'agama'         => $a->agama,
                'pekerjaan'     => $a->pekerjaan ?? '',
                'no_telepon'    => $a->no_telepon ?? '',
                'pendapatan'    => $a->pendapatan,
                'status_warga'  => $a->status_warga,
                'email'         => optional($a->user)->email ?? '',
                'punya_akun'    => $a->user_id !== null,
            ];
        })->values();

        return view('pages.admin.warga.edit', compact('warga', 'kartuKeluarga', 'anggotaLain', 'anggotaJson'));
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load(['kepalaKeluarga.user', 'anggota']);
        $warga = $kartuKeluarga->kepalaKeluarga;

        // ── Tentukan target warga & user_id untuk validasi ────────
        $anggotaBaru = $request->filled('kepala_keluarga_id')
            ? Warga::with('user')->find($request->kepala_keluarga_id)
            : null;

        $targetWargaId = $anggotaBaru ? $anggotaBaru->id : $warga->id;
        $targetUserId  = $anggotaBaru ? ($anggotaBaru->user_id ?? 'NULL') : ($warga->user_id ?? 'NULL');
        $targetPunyaAkun = $anggotaBaru ? $anggotaBaru->user_id !== null : $warga->user_id !== null;

        $request->validate([
            'no_kk'                 => 'required|string|size:16|unique:kartu_keluarga,no_kk,' . $kartuKeluarga->id,
            'no_rumah'              => 'required|string|max:10',
            'alamat'                => 'required|string|min:15',
            'blok'                  => 'nullable|string|max:10',
            'status_hunian'         => 'required|in:pemilik,kontrak,kost',
            'tanggal_mulai_tinggal' => 'required|date',
            'nik'                   => 'required|string|size:16|unique:warga,nik,' . $targetWargaId,
            'nama_lengkap'          => 'required|string|max:100',
            'tempat_lahir'          => 'required|string|max:50',
            'tanggal_lahir'         => 'required|date|before:today',
            'jenis_kelamin'         => 'required|in:laki_laki,perempuan',
            'agama'                 => 'required|in:islam,kristen,katolik,hindu,buddha,konghucu',
            'pekerjaan'             => 'nullable|string|max:50',
            'no_telepon'            => 'nullable|string|max:15',
            'pendapatan'            => 'required|integer|min:0',
            'status_warga'          => 'required|in:aktif,tidak_aktif,pindah,meninggal',
            'kepala_keluarga_id'    => 'nullable|exists:warga,id',
            'email'                 => 'required|email|unique:users,email,' . $targetUserId,
            'password'              => $targetPunyaAkun
                ? ['nullable', 'confirmed', Password::min(8)]
                : ['required', 'confirmed', Password::min(8)],
        ]);

        DB::transaction(function () use ($request, $kartuKeluarga, &$warga, $anggotaBaru) {

            // ── 1. Update Data KK ──────────────────────────────────────
            $kartuKeluarga->update([
                'no_kk'                 => $request->no_kk,
                'alamat'                => $request->alamat,
                'no_rumah'              => $request->no_rumah,
                'blok'                  => $request->blok,
                'status_hunian'         => $request->status_hunian,
                'tanggal_mulai_tinggal' => $request->tanggal_mulai_tinggal,
            ]);

            // ── 2. Ganti Kepala Keluarga (jika dipilih) ────────────────

            if ($anggotaBaru && $anggotaBaru->kartu_keluarga_id === $kartuKeluarga->id) {
                // Turunkan kepala lama jadi anggota biasa
                $warga->update([
                    'is_kepala_keluarga' => false,
                    'status_dalam_kk'    => 'lainnya', // ✅ update status KK kepala lama
                ]);

                // Naikkan anggota baru jadi kepala keluarga
                $anggotaBaru->update([
                    'is_kepala_keluarga' => true,
                    'status_dalam_kk'    => 'kepala_keluarga', // ✅ update status KK anggota baru
                ]);

                $warga = $anggotaBaru;
                $warga->refresh();
                $warga->load('user');
            }

            // ── 3. Update Data Kepala Keluarga ─────────────────────────
            $warga->update([
                'nik'           => $request->nik,
                'nama_lengkap'  => $request->nama_lengkap,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama'         => $request->agama,
                'pekerjaan'     => $request->pekerjaan,
                'no_telepon'    => $request->no_telepon,
                'pendapatan'    => $request->pendapatan,
                'status_warga'  => $request->status_warga,
            ]);

            // ── 4. Update / Buat Akun ──────────────────────────────────
            $warga->refresh();
            $warga->load('user');

            if ($warga->user_id !== null) {
                // Sudah punya akun — update
                $userData = [
                    'name'  => $request->nama_lengkap,
                    'email' => $request->email,
                ];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $warga->user->update($userData);
            } else {
                // Belum punya akun — buat baru
                $user = User::create([
                    'name'     => $request->nama_lengkap,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'warga',
                ]);
                $warga->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('admin.warga.index', $kartuKeluarga)
                        ->with('success', 'Data berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────
    // CREATE ANGGOTA — Form tambah anggota ke KK yang ada
    // ─────────────────────────────────────────────────────
    public function createAnggota(KartuKeluarga $kartuKeluarga)
    {
        return view('pages.admin.warga.create-anggota', compact('kartuKeluarga'));
    }

    // ─────────────────────────────────────────────────────
    // STORE ANGGOTA — Simpan anggota baru
    // Akun login OPSIONAL via checkbox "buat_akun" (Opsi B)
    // ─────────────────────────────────────────────────────
    public function storeAnggota(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $rules = [
            'nik'             => 'required|string|size:16|unique:warga,nik',
            'nama_lengkap'    => 'required|string|max:100',
            'tempat_lahir'    => 'required|string|max:50',
            'tanggal_lahir'   => 'required|date|before:today',
            'jenis_kelamin'   => 'required|in:laki_laki,perempuan',
            'agama'           => 'required|in:islam,kristen,katolik,hindu,buddha,konghucu',
            'pekerjaan'       => 'nullable|string|max:50',
            'no_telepon'      => 'nullable|string|max:15',
            'pendapatan'      => 'required|integer|min:0',
            'status_dalam_kk' => 'required|in:istri,anak,lainnya',
            'status_warga'    => 'required|in:aktif,tidak_aktif,pindah,meninggal',

            // ✅ Email & password opsional — hanya wajib kalau email diisi
            'email'    => 'nullable|email|unique:users,email',
            'password' => $request->filled('email')
                ? ['required', 'confirmed', Password::min(8)]
                : ['nullable'],
        ];

        $request->validate($rules, [
            'nik.size'             => 'NIK harus 16 digit.',
            'nik.unique'           => 'NIK sudah terdaftar.',
            'email.unique'         => 'Email sudah digunakan.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
        ]);

        DB::transaction(function () use ($request, $kartuKeluarga) {
            $userId = null;

            // ✅ Buat akun hanya kalau email diisi
            if ($request->filled('email')) {
                $user   = User::create([
                    'name'     => $request->nama_lengkap,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'warga',
                ]);
                $userId = $user->id;
            }

            Warga::create([
                'user_id'            => $userId,
                'kartu_keluarga_id'  => $kartuKeluarga->id,
                'nik'                => $request->nik,
                'nama_lengkap'       => $request->nama_lengkap,
                'tempat_lahir'       => $request->tempat_lahir,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'jenis_kelamin'      => $request->jenis_kelamin,
                'agama'              => $request->agama,
                'pekerjaan'          => $request->pekerjaan,
                'no_telepon'         => $request->no_telepon,
                'pendapatan'         => $request->pendapatan,
                'is_kepala_keluarga' => false,
                'status_dalam_kk'    => $request->status_dalam_kk,
                'status_warga'       => $request->status_warga,
            ]);
        });

        return redirect()->route('admin.warga.show', $kartuKeluarga)
                        ->with('success', 'Anggota keluarga berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────────────────
    // EDIT ANGGOTA — Form edit anggota keluarga
    // ─────────────────────────────────────────────────────
    public function editAnggota(Warga $anggota)
    {
        $anggota->load(['kartuKeluarga', 'user']);
        return view('pages.admin.warga.edit-anggota', compact('anggota')); // ✅ harus edit-anggota
    }

    // ─────────────────────────────────────────────────────
    // UPDATE ANGGOTA — Update data anggota
    // Bisa buatkan akun baru, update, atau hapus akun (Opsi B)
    // ─────────────────────────────────────────────────────
    public function updateAnggota(Request $request, Warga $anggota)
    {
        $sudahPunyaAkun = $anggota->user_id !== null;
        $kartuKeluargaId = $anggota->kartu_keluarga_id;

        $rules = [
            'nik'             => 'required|string|size:16|unique:warga,nik,' . $anggota->id,
            'nama_lengkap'    => 'required|string|max:100',
            'tempat_lahir'    => 'required|string|max:50',
            'tanggal_lahir'   => 'required|date|before:today',
            'jenis_kelamin'   => 'required|in:laki_laki,perempuan',
            'agama'           => 'required|in:islam,kristen,katolik,hindu,buddha,konghucu',
            'pekerjaan'       => 'nullable|string|max:50',
            'no_telepon'      => 'nullable|string|max:15',
            'pendapatan'      => 'required|integer|min:0',
            'status_dalam_kk' => 'required|in:istri,anak,lainnya',
            'status_warga'    => 'required|in:aktif,tidak_aktif,pindah,meninggal',
            'email'           => $sudahPunyaAkun
                ? 'required|email|unique:users,email,' . $anggota->user_id
                : 'nullable|email|unique:users,email',
            'password'        => $sudahPunyaAkun
                ? ['nullable', 'confirmed', Password::min(8)]
                : ($request->filled('email')
                    ? ['required', 'confirmed', Password::min(8)]
                    : ['nullable']),
        ];

        $request->validate($rules);

        DB::transaction(function () use ($request, $anggota, $sudahPunyaAkun) {
            $anggota->update([
                'nik'             => $request->nik,
                'nama_lengkap'    => $request->nama_lengkap,
                'tempat_lahir'    => $request->tempat_lahir,
                'tanggal_lahir'   => $request->tanggal_lahir,
                'jenis_kelamin'   => $request->jenis_kelamin,
                'agama'           => $request->agama,
                'pekerjaan'       => $request->pekerjaan,
                'no_telepon'      => $request->no_telepon,
                'pendapatan'      => $request->pendapatan,
                'status_dalam_kk' => $request->status_dalam_kk,
                'status_warga'    => $request->status_warga,
            ]);

            if ($sudahPunyaAkun) {
                $userData = [
                    'name'  => $request->nama_lengkap,
                    'email' => $request->email,
                ];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $anggota->user->update($userData);
            } elseif ($request->filled('email')) {
                $user = User::create([
                    'name'     => $request->nama_lengkap,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'warga',
                ]);
                $anggota->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('admin.warga.show', $kartuKeluargaId)
                        ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroyAnggota(Warga $anggota)
    {
        $kartuKeluargaId = $anggota->kartu_keluarga_id; // ✅ simpan dulu

        DB::transaction(function () use ($anggota) {
            if ($anggota->user_id) {
                $anggota->user->delete();
            }
            $anggota->delete();
        });

        return redirect()->route('admin.warga.show', $kartuKeluargaId)
                        ->with('success', 'Anggota berhasil dihapus.');
    }

    // ─────────────────────────────────────────────────────
    // DESTROY — Soft delete warga
    // ─────────────────────────────────────────────────────
    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load(['wargas.user']);

        DB::transaction(function () use ($kartuKeluarga) {
            // Hapus semua akun user milik anggota KK ini
            foreach ($kartuKeluarga->wargas as $warga) {
                if ($warga->user_id) {
                    $warga->user->delete();
                }
            }

            // Soft delete semua warga dalam KK
            $kartuKeluarga->wargas()->delete();

            // Soft delete KK
            $kartuKeluarga->delete();
        });

        return redirect()->route('admin.warga.index')
                        ->with('success', 'Kartu Keluarga dan seluruh anggota berhasil dihapus.');
    }

    // ─────────────────────────────────────────────────────
    // LAPORAN EKONOMI
    // ─────────────────────────────────────────────────────
    
    public function semua()
    {
        $wargas = Warga::with(['user', 'kartuKeluarga'])
            ->when(request('search'), function ($q) {
                $q->where('nik', 'like', '%' . request('search') . '%')
                ->orWhere('nama_lengkap', 'like', '%' . request('search') . '%');
            })
            ->when(request('jenis_kelamin'), function ($q) {
                $q->where('jenis_kelamin', request('jenis_kelamin'));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalWarga  = Warga::count();
        $belumAkun   = Warga::whereNull('user_id')->count();
        $sudahAkun   = Warga::whereNotNull('user_id')->count();

        return view('pages.admin.warga.semua', compact(
            'wargas', 'totalWarga', 'belumAkun', 'sudahAkun'
        ));
    }
            
    public function kategoriEkonomi(Request $request)
    {
        $query = KartuKeluarga::with(['kepalaKeluarga', 'wargas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                ->orWhereHas('kepalaKeluarga', function ($q2) use ($search) {
                    $q2->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
            });
        }

        $kartus = $query->latest()->get();

        // Filter kategori setelah load (karena kategori dihitung dari collection)
        if ($request->filled('kategori')) {
            $kartus = $kartus->filter(function ($kk) use ($request) {
                return match ($request->kategori) {
                    'tidak_mampu'  => $kk->total_pendapatan < 1_000_000,
                    'kurang_mampu' => $kk->total_pendapatan >= 1_000_000 && $kk->total_pendapatan <= 3_000_000,
                    'mampu'        => $kk->total_pendapatan > 3_000_000 && $kk->total_pendapatan <= 7_000_000,
                    'sangat_mampu' => $kk->total_pendapatan > 7_000_000,
                    default        => true,
                };
            });
        }

        // Statistik
        $allKartus = KartuKeluarga::with('wargas')->get();
        $stats = [
            'tidak_mampu'  => $allKartus->filter(fn($kk) => $kk->total_pendapatan < 1_000_000)->count(),
            'kurang_mampu' => $allKartus->filter(fn($kk) => $kk->total_pendapatan >= 1_000_000 && $kk->total_pendapatan <= 3_000_000)->count(),
            'mampu'        => $allKartus->filter(fn($kk) => $kk->total_pendapatan > 3_000_000 && $kk->total_pendapatan <= 7_000_000)->count(),
            'sangat_mampu' => $allKartus->filter(fn($kk) => $kk->total_pendapatan > 7_000_000)->count(),
        ];

        return view('pages.admin.warga.kategori-ekonomi', compact('kartus', 'stats'));
    }
        // ─────────────────────────────────────────────────────
    // CREATE WARGA — Form tambah warga (pilih KK dari dropdown)
    // ─────────────────────────────────────────────────────
    public function createWarga()
    {
        $kkList = KartuKeluarga::with('kepalaKeluarga')
            ->orderBy('no_kk')
            ->get();

        return view('pages.admin.warga.create-warga', compact('kkList'));
    }

    // ─────────────────────────────────────────────────────
    // STORE WARGA — Simpan warga baru ke KK yang dipilih
    // ─────────────────────────────────────────────────────
    public function storeWarga(Request $request)
    {
        $request->validate([
            'kartu_keluarga_id' => 'required|exists:kartu_keluarga,id',
            'nik'               => 'required|string|size:16|unique:warga,nik',
            'nama_lengkap'      => 'required|string|max:100',
            'tempat_lahir'      => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date|before:today',
            'jenis_kelamin'     => 'required|in:laki_laki,perempuan',
            'agama'             => 'required|in:islam,kristen,katolik,hindu,buddha,konghucu',
            'status_dalam_kk'   => 'required|in:istri,anak,lainnya',
            'pekerjaan'         => 'nullable|string|max:50',
            'no_telepon'        => 'nullable|string|max:15',
            'pendapatan'        => 'required|integer|min:0',
            'status_warga'      => 'required|in:aktif,tidak_aktif,pindah,meninggal',
            'email'             => 'nullable|email|unique:users,email',
            'password'          => $request->filled('email')
                ? ['required', 'confirmed', Password::min(8)]
                : ['nullable'],
        ], [
            'nik.size'             => 'NIK harus 16 digit.',
            'nik.unique'           => 'NIK sudah terdaftar.',
            'email.unique'         => 'Email sudah digunakan.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
        ]);

        DB::transaction(function () use ($request) {
            $userId = null;

            if ($request->filled('email')) {
                $user   = User::create([
                    'name'     => $request->nama_lengkap,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'warga',
                ]);
                $userId = $user->id;
            }

            Warga::create([
                'user_id'            => $userId,
                'kartu_keluarga_id'  => $request->kartu_keluarga_id,
                'nik'                => $request->nik,
                'nama_lengkap'       => $request->nama_lengkap,
                'tempat_lahir'       => $request->tempat_lahir,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'jenis_kelamin'      => $request->jenis_kelamin,
                'agama'              => $request->agama,
                'pekerjaan'          => $request->pekerjaan,
                'no_telepon'         => $request->no_telepon,
                'pendapatan'         => $request->pendapatan,
                'is_kepala_keluarga' => false,
                'status_dalam_kk'    => $request->status_dalam_kk,
                'status_warga'       => $request->status_warga,
            ]);
        });

        return redirect()->route('admin.warga.semua')
                        ->with('success', 'Data warga berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────────────────
    // EDIT WARGA — Form edit warga dari halaman semua
    // ─────────────────────────────────────────────────────
    public function editWarga(Warga $warga)
    {
        $warga->load(['kartuKeluarga', 'user']);
        $kkList = KartuKeluarga::with('kepalaKeluarga')
            ->orderBy('no_kk')
            ->get();

        return view('pages.admin.warga.edit-warga', compact('warga', 'kkList'));
    }

    public function updateWarga(Request $request, Warga $warga)
    {
        $sudahPunyaAkun = $warga->user_id !== null;
        $isKepala = $warga->is_kepala_keluarga;

        $request->validate([
            // Kalau kepala keluarga, kartu_keluarga_id tidak boleh diubah
            'kartu_keluarga_id' => $isKepala
                ? 'prohibited'
                : 'required|exists:kartu_keluarga,id',
            // ...sisa validasi sama
            'nik'               => 'required|string|size:16|unique:warga,nik,' . $warga->id,
            'nama_lengkap'      => 'required|string|max:100',
            'tempat_lahir'      => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date|before:today',
            'jenis_kelamin'     => 'required|in:laki_laki,perempuan',
            'agama'             => 'required|in:islam,kristen,katolik,hindu,buddha,konghucu',
            'status_dalam_kk'   => $isKepala ? 'prohibited' : 'required|in:istri,anak,lainnya',
            'pekerjaan'         => 'nullable|string|max:50',
            'no_telepon'        => 'nullable|string|max:15',
            'pendapatan'        => 'required|integer|min:0',
            'status_warga'      => 'required|in:aktif,tidak_aktif,pindah,meninggal',
            'email'             => $sudahPunyaAkun
                ? 'required|email|unique:users,email,' . $warga->user_id
                : 'nullable|email|unique:users,email',
            'password'          => $sudahPunyaAkun
                ? ['nullable', 'confirmed', Password::min(8)]
                : ($request->filled('email')
                    ? ['required', 'confirmed', Password::min(8)]
                    : ['nullable']),
        ]);

        DB::transaction(function () use ($request, $warga, $sudahPunyaAkun, $isKepala) {
            $warga->update([
                // Kalau kepala keluarga, tetap pakai KK lama
                'kartu_keluarga_id' => $isKepala ? $warga->kartu_keluarga_id : $request->kartu_keluarga_id,
                'nik'               => $request->nik,
                'nama_lengkap'      => $request->nama_lengkap,
                'tempat_lahir'      => $request->tempat_lahir,
                'tanggal_lahir'     => $request->tanggal_lahir,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'agama'             => $request->agama,
                'pekerjaan'         => $request->pekerjaan,
                'no_telepon'        => $request->no_telepon,
                'pendapatan'        => $request->pendapatan,
                // Kalau kepala keluarga, status_dalam_kk tetap kepala_keluarga
                'status_dalam_kk'   => $isKepala ? 'kepala_keluarga' : $request->status_dalam_kk,
                'status_warga'      => $request->status_warga,
            ]);

            if ($sudahPunyaAkun) {
                $userData = ['name' => $request->nama_lengkap, 'email' => $request->email];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $warga->user->update($userData);
            } elseif ($request->filled('email')) {
                $user = User::create([
                    'name'     => $request->nama_lengkap,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'warga',
                ]);
                $warga->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('admin.warga.semua')
                        ->with('success', 'Data warga berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────
    // DESTROY WARGA — Hapus warga dari halaman semua
    // ─────────────────────────────────────────────────────
    public function destroyWarga(Warga $warga)
    {
        DB::transaction(function () use ($warga) {
            if ($warga->user_id) {
                $warga->user->delete();
            }
            $warga->delete();
        });

        return redirect()->route('admin.warga.semua')
                        ->with('success', 'Data warga berhasil dihapus.');
    }
}