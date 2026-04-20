<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->cascadeOnDelete();
            $table->enum('jenis_surat', [
                'pengantar_ktp',
                'domisili',
                'pengantar_kk',
                'sktm',
                'skck',
            ]);
            $table->text('keperluan');
            $table->enum('status', [
                'menunggu',
                'diproses',
                'selesai',
                'ditolak',
            ])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->string('file_surat')->nullable();

            // ── Pengantar KTP ──────────────────────────────
            $table->enum('ktp_keperluan', ['buat_baru', 'hilang', 'rusak'])->nullable();

            // ── Domisili ───────────────────────────────────
            $table->string('domisili_lama_tinggal')->nullable();

            // ── Pengantar KK ───────────────────────────────
            $table->enum('kk_keperluan', ['baru', 'tambah_anggota', 'pindah'])->nullable();

            // ── SKTM ───────────────────────────────────────
            $table->integer('sktm_penghasilan')->nullable();
            $table->integer('sktm_jumlah_tanggungan')->nullable();

            // ── SKCK ───────────────────────────────────────
            $table->string('skck_keperluan')->nullable();

            $table->timestamps();
        });

        Schema::create('permohonan_surat_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_surat_id')
                  ->constrained('permohonan_surat')
                  ->cascadeOnDelete();
            $table->string('nama_dokumen');
            $table->string('file');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_surat_dokumen');
        Schema::dropIfExists('permohonan_surat');
    }
};