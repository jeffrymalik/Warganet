<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileControlller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = null;
        $kartuKeluarga = null;

        if ($user->role === 'warga') {
            $warga = $user->warga()->with('kartuKeluarga')->first();
            $kartuKeluarga = $warga?->kartuKeluarga;
        }

        return view('auth.profile', compact('user', 'warga', 'kartuKeluarga'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password']              = 'min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        $request->validate($rules);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path;
        }

        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($user->role === 'warga' && $request->filled('no_hp')) {
            $user->warga()->update(['no_telepon' => $request->no_hp]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function keluarga()
    {
        $user = Auth::user();

        if ($user->role !== 'warga') {
            abort(403);
        }

        $warga = $user->warga()->with('kartuKeluarga')->first();
        $kartuKeluarga = $warga?->kartuKeluarga;
        $anggota = $kartuKeluarga?->anggota()->orderBy('is_kepala_keluarga', 'desc')->get() ?? collect();

        return view('pages.warga.keluarga', compact('warga', 'kartuKeluarga', 'anggota'));
    }
}