<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileControlller extends Controller
{
    /** Tampilkan halaman profil */
    public function show()
    {
        $user = Auth::user()->load('warga.kartuKeluarga');
        return view('auth.profile', compact('user'));
    }

    /** Tampilkan form edit profil */
    public function edit()
    {
        $user = Auth::user()->load('warga.kartuKeluarga');
        return view('auth.profile_edit', compact('user'));
    }

    /**
     * Upload / ganti foto profil.
     * Foto lama dihapus dari storage sebelum menyimpan yang baru.
     */
    public function updateFoto(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ], [
            'avatar.required' => 'Pilih foto terlebih dahulu.',
            'avatar.image'    => 'File harus berupa gambar.',
            'avatar.mimes'    => 'Format foto harus PNG, JPG, JPEG, atau WEBP.',
            'avatar.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Simpan foto baru di storage/app/public/avatars/{user_id}/
        $path = $request->file('avatar')->store(
            'avatars/' . $user->id,
            'public'
        );

        $user->update(['avatar' => $path]);

        return redirect()->route('profile.edit')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Hapus foto profil, kembalikan ke tampilan inisial.
     */
    public function hapusFoto()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return redirect()->route('profile.edit')
            ->with('success', 'Foto profil berhasil dihapus.');
    }

    /** Update Data Akun (name & email) */
    public function updateAkun(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        if ($user->email !== $validated['email']) {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Data akun berhasil diperbarui.');
    }

    /** Update Password */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.confirmed'                => 'Konfirmasi password tidak cocok.',
            'password.min'                      => 'Password minimal 8 karakter.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password berhasil diperbarui.');
    }

    /** Update Data Pribadi Warga */
    public function updateWarga(Request $request)
    {
        $user  = Auth::user();
        $warga = $user->warga;

        if (! $warga) {
            return redirect()->route('profile.edit')
                ->with('error', 'Data warga tidak ditemukan.');
        }

        $validated = $request->validate([
            'nik'           => ['nullable', 'digits:16', 'unique:warga,nik,' . $warga->id],
            'nama_lengkap'  => ['required', 'string', 'max:255'],
            'tempat_lahir'  => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date', 'before:today'],
            'jenis_kelamin' => ['nullable', 'in:laki_laki,perempuan'],
            'agama'         => ['nullable', 'in:islam,kristen,katolik,hindu,budha,konghucu,lainnya'],
            'pekerjaan'     => ['nullable', 'string', 'max:100'],
            'no_telepon'    => ['nullable', 'string', 'max:20'],
            'pendapatan'    => ['nullable', 'integer', 'min:0'],
        ], [
            'nik.digits'            => 'NIK harus 16 digit angka.',
            'nik.unique'            => 'NIK ini sudah digunakan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'tanggal_lahir.before'  => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_kelamin.in'      => 'Pilihan jenis kelamin tidak valid.',
            'agama.in'              => 'Pilihan agama tidak valid.',
            'pendapatan.min'        => 'Pendapatan tidak boleh negatif.',
        ]);

        $warga->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Data pribadi berhasil diperbarui.');
    }
}