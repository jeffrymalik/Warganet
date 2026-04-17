<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluarga')->cascadeOnDelete();
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki_laki', 'perempuan']);
            $table->enum('agama', ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu']);
            $table->string('pekerjaan')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->unsignedBigInteger('pendapatan')->default(0)->nullable();
            $table->boolean('is_kepala_keluarga')->default(false);
            $table->enum('status_dalam_kk', ['kepala_keluarga', 'istri', 'anak', 'lainnya'])->default('lainnya');
            $table->enum('status_warga', ['aktif', 'tidak_aktif', 'pindah', 'meninggal'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};