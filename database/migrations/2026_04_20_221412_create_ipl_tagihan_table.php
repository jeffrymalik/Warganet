<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipl_tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kk_id')->constrained('kartu_keluarga')->onDelete('cascade');
            $table->tinyInteger('bulan'); // 1-12
            $table->year('tahun');
            $table->bigInteger('nominal');
            $table->enum('status', ['belum_bayar', 'menunggu', 'lunas'])->default('belum_bayar');
            $table->date('due_date')->nullable();
            $table->timestamps();

            // Satu KK hanya punya 1 tagihan per bulan per tahun
            $table->unique(['kk_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ipl_tagihan');
    }
};