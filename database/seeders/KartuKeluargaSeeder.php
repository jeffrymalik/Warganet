<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KartuKeluarga;

class KartuKeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    for ($i = 0; $i < 10; $i++) {
        KartuKeluarga::create([
            'no_kk' => fake()->unique()->numerify('################'),
            'no_rumah' => rand(1, 100),
            'blok' => chr(rand(65, 70)),
            'status_hunian' => fake()->randomElement(['pemilik','kontrak','kost']),
            'tanggal_mulai_tinggal' => now(),
        ]);
    }
}
}
