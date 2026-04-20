<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluhan_pesan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluhan_id')->constrained('keluhan')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('pesan');
            $table->timestamps();
        });

        // Hapus kolom admin_catatan dari tabel keluhan
        Schema::table('keluhan', function (Blueprint $table) {
            $table->dropColumn('admin_catatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluhan_pesan');

        Schema::table('keluhan', function (Blueprint $table) {
            $table->text('admin_catatan')->nullable();
        });
    }
};