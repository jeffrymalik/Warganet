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
            $query->where('no_kk', 'like', "%{$search}%")
                  ->orWhere('no_rumah', 'like', "%{$search}%")
                  ->orWhereHas('kepalaKeluarga', function ($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                  });
        }

        if ($request->filled('status_hunian')) {
            $query->where('status_hunian', $request->status_hunian);
        }

        $kartus = $query->latest()->paginate(10)->withQueryString();

        return view('pages.admin.warga.index', compact('kartus'));
    }

    // ─────────────────────────────────────────────────────
    // CREATE — Form tambah warga baru (KK + Kepala Keluarga)
    // ─────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.warga.create');
    }

    // ─────────────────────────────────────────────────────
    // STORE — Simpan KK + Kepala Keluarga + Akun User
    // ─────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'no_kk'                 => 'required|string|size:16|unique:kartu_keluarga,no_kk',
            'no_rumah'              => 'required|string|max:10',
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
        $kartuKeluarga->load(['kepalaKeluarga.user', 'anggota.user']);

        return view('admin.warga.show', compact('kartuKeluarga'));
    }

    // ─────────────────────────────────────────────────────
    // EDIT — Form edit data kepala keluarga
    // ─────────────────────────────────────────────────────
    public function edit(Warga $warga)
    {
        $warga->load(['kartuKeluarga', 'user']);

        return view('admin.warga.edit', compact('warga'));
    }

    // ─────────────────────────────────────────────────────
    // UPDATE — Update data kepala keluarga
    // ─────────────────────────────────────────────────────
    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'no_kk'                 => 'required|string|size:16|unique:kartu_keluarga,no_kk,' . $warga->kartuKeluarga->id,
            'no_rumah'              => 'required|string|max:10',
            'blok'                  => 'nullable|string|max:10',
            'status_hunian'         => 'required|in:pemilik,kontrak,kost',
            'tanggal_mulai_tinggal' => 'required|date',
            'nik'                   => 'required|string|size:16|unique:warga,nik,' . $warga->id,
            'nama_lengkap'          => 'required|string|max:100',
            'tempat_lahir'          => 'required|string|max:50',
            'tanggal_lahir'         => 'required|date|before:today',
            'jenis_kelamin'         => 'required|in:laki_laki,perempuan',
            'agama'                 => 'required|in:islam,kristen,katolik,hindu,buddha,konghucu',
            'pekerjaan'             => 'nullable|string|max:50',
            'no_telepon'            => 'nullable|string|max:15',
            'pendapatan'            => 'required|integer|min:0',
            'status_warga'          => 'required|in:aktif,tidak_aktif,pindah,meninggal',
            'email'                 => 'required|email|unique:users,email,' . $warga->user_id,
            'password'              => ['nullable', 'confirmed', Password::min(8)],
        ]);

        DB::transaction(function () use ($request, $warga) {
            if ($warga->is_kepala_keluarga) {
                $warga->kartuKeluarga->update([
                    'no_kk'                 => $request->no_kk,
                    'no_rumah'              => $request->no_rumah,
                    'blok'                  => $request->blok,
                    'status_hunian'         => $request->status_hunian,
                    'tanggal_mulai_tinggal' => $request->tanggal_mulai_tinggal,
                ]);
            }

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

            if ($warga->user) {
                $userData = [
                    'name'  => $request->nama_lengkap,
                    'email' => $request->email,
                ];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $warga->user->update($userData);
            }
        });

        return redirect()->route('admin.warga.show', $warga->kartuKeluarga)
                         ->with('success', 'Data warga berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────
    // CREATE ANGGOTA — Form tambah anggota ke KK yang ada
    // ─────────────────────────────────────────────────────
    public function createAnggota(KartuKeluarga $kartuKeluarga)
    {
        return view('admin.warga.create-anggota', compact('kartuKeluarga'));
    }

    // ─────────────────────────────────────────────────────
    // STORE ANGGOTA — Simpan anggota baru
    // Akun login OPSIONAL via checkbox "buat_akun" (Opsi B)
    // ─────────────────────────────────────────────────────
    public function storeAnggota(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $buatAkun = $request->boolean('buat_akun');

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
        ];

        // Tambah validasi akun hanya jika checkbox dicentang
        if ($buatAkun) {
            $rules['email']    = 'required|email|unique:users,email';
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        $request->validate($rules, [
            'nik.size'             => 'NIK harus 16 digit.',
            'nik.unique'           => 'NIK sudah terdaftar.',
            'email.unique'         => 'Email sudah digunakan.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
        ]);

        DB::transaction(function () use ($request, $kartuKeluarga, $buatAkun) {
            $userId = null;

            if ($buatAkun) {
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
                'status_warga'       => 'aktif',
            ]);
        });

        return redirect()->route('admin.warga.show', $kartuKeluarga)
                         ->with('success', 'Anggota keluarga berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────────────────
    // EDIT ANGGOTA — Form edit anggota keluarga
    // ─────────────────────────────────────────────────────
    public function editAnggota(Warga $warga)
    {
        $warga->load(['kartuKeluarga', 'user']);

        return view('admin.warga.edit-anggota', compact('warga'));
    }

    // ─────────────────────────────────────────────────────
    // UPDATE ANGGOTA — Update data anggota
    // Bisa buatkan akun baru, update, atau hapus akun (Opsi B)
    // ─────────────────────────────────────────────────────
    public function updateAnggota(Request $request, Warga $warga)
    {
        $buatAkun       = $request->boolean('buat_akun');
        $hapusAkun      = $request->boolean('hapus_akun');
        $sudahPunyaAkun = $warga->user_id !== null;

        $rules = [
            'nik'             => 'required|string|size:16|unique:warga,nik,' . $warga->id,
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
        ];

        // Sudah punya akun & tidak dihapus → validasi update email/password
        if ($sudahPunyaAkun && !$hapusAkun) {
            $rules['email']    = 'required|email|unique:users,email,' . $warga->user_id;
            $rules['password'] = ['nullable', 'confirmed', Password::min(8)];
        }

        // Belum punya akun & mau dibuatkan → validasi akun baru
        if (!$sudahPunyaAkun && $buatAkun) {
            $rules['email']    = 'required|email|unique:users,email';
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $warga, $buatAkun, $hapusAkun, $sudahPunyaAkun) {
            $warga->update([
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
                if ($hapusAkun) {
                    // Hapus akun, warga tetap ada (user_id jadi null)
                    $warga->user->delete();
                    $warga->update(['user_id' => null]);
                } else {
                    // Update akun yang ada
                    $userData = [
                        'name'  => $request->nama_lengkap,
                        'email' => $request->email,
                    ];
                    if ($request->filled('password')) {
                        $userData['password'] = Hash::make($request->password);
                    }
                    $warga->user->update($userData);
                }
            }

            // Belum punya akun → buatkan jika dicentang
            if (!$sudahPunyaAkun && $buatAkun) {
                $user = User::create([
                    'name'     => $request->nama_lengkap,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'warga',
                ]);
                $warga->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('admin.warga.show', $warga->kartuKeluarga)
                         ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────
    // UPDATE STATUS — Cepat update status warga
    // ─────────────────────────────────────────────────────
    public function updateStatus(Request $request, Warga $warga)
    {
        $request->validate([
            'status_warga' => 'required|in:aktif,tidak_aktif,pindah,meninggal',
        ]);

        $warga->update(['status_warga' => $request->status_warga]);

        return back()->with('success', 'Status warga berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────
    // DESTROY — Soft delete warga
    // ─────────────────────────────────────────────────────
    public function destroy(Warga $warga)
    {
        DB::transaction(function () use ($warga) {
            if ($warga->user) {
                $warga->user->update(['role' => 'nonaktif']);
            }
            $warga->delete();
        });

        return back()->with('success', 'Data warga berhasil dihapus.');
    }

    // ─────────────────────────────────────────────────────
    // LAPORAN EKONOMI
    // ─────────────────────────────────────────────────────
    public function laporanEkonomi(Request $request)
    {
        $kategori = $request->get('kategori', 'semua');

        $query = Warga::with('kartuKeluarga')->aktif();

        if ($kategori !== 'semua') {
            $query->kategoriEkonomi($kategori);
        }

        $wargas = $query->orderBy('pendapatan')->paginate(15)->withQueryString();

        $ringkasan = [
            'tidak_mampu'  => Warga::aktif()->kategoriEkonomi('tidak_mampu')->count(),
            'kurang_mampu' => Warga::aktif()->kategoriEkonomi('kurang_mampu')->count(),
            'mampu'        => Warga::aktif()->kategoriEkonomi('mampu')->count(),
            'sangat_mampu' => Warga::aktif()->kategoriEkonomi('sangat_mampu')->count(),
        ];

        return view('admin.warga.laporan-ekonomi', compact('wargas', 'ringkasan', 'kategori'));
    }
}