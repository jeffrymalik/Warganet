<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipl_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('ipl_tagihan')->onDelete('cascade');
            $table->string('order_id')->unique();
            $table->string('snap_token')->nullable();
            $table->bigInteger('jumlah');
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->string('metode_bayar')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ipl_pembayaran');
    }
};