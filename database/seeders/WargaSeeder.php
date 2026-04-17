<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warga;
use App\Models\User;
use App\Models\KartuKeluarga;
use Illuminate\Support\Facades\Hash;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua KK
        $kks = KartuKeluarga::all();

        foreach ($kks as $kk) {

            // ======================
            // KEPALA KELUARGA
            // ======================
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'warga',
            ]);

            $kepala = Warga::create([
                'user_id' => $user->id,
                'kartu_keluarga_id' => $kk->id,
                'nik' => fake()->unique()->numerify('################'),
                'nama_lengkap' => $user->name,
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date(),
                'jenis_kelamin' => 'laki_laki',
                'agama' => fake()->randomElement(['islam','kristen','katolik','hindu','buddha']),
                'pekerjaan' => fake()->jobTitle(),
                'no_telepon' => fake()->phoneNumber(),
                'pendapatan' => rand(1000000, 10000000),
                'is_kepala_keluarga' => true,
                'status_dalam_kk' => 'kepala_keluarga',
                'status_warga' => 'aktif',
            ]);

            // ======================
            // ANGGOTA KELUARGA
            // ======================
            $jumlahAnggota = rand(1, 4);

            for ($i = 0; $i < $jumlahAnggota; $i++) {
                Warga::create([
                    'user_id' => null,
                    'kartu_keluarga_id' => $kk->id,
                    'nik' => fake()->unique()->numerify('################'),
                    'nama_lengkap' => fake()->name(),
                    'tempat_lahir' => fake()->city(),
                    'tanggal_lahir' => fake()->date(),
                    'jenis_kelamin' => fake()->randomElement(['laki_laki', 'perempuan']),
                    'agama' => fake()->randomElement(['islam','kristen','katolik','hindu','buddha']),
                    'pekerjaan' => fake()->jobTitle(),
                    'no_telepon' => fake()->phoneNumber(),
                    'pendapatan' => rand(0, 5000000),
                    'is_kepala_keluarga' => false,
                    'status_dalam_kk' => fake()->randomElement(['istri','anak']),
                    'status_warga' => 'aktif',
                ]);
            }
        }
    }
}