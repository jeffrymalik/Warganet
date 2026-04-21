<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iuran_tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iuran_id')->constrained('iuran_warga')->onDelete('cascade');
            $table->foreignId('kk_id')->constrained('kartu_keluarga')->onDelete('cascade');
            $table->string('order_id')->unique()->nullable();
            $table->string('snap_token')->nullable();
            $table->enum('status', ['belum_bayar', 'menunggu', 'lunas'])->default('belum_bayar');
            $table->string('metode_bayar')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iuran_tagihan');
    }
};