<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu_verifikasi',
                'perlu_perbaikan',
                'menunggu_pembayaran_sampel',
                'sedang_diuji',
                'menyusun_laporan',
                'selesai'
            ])->default('menunggu_verifikasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('status')->default('menunggu_verifikasi')->change();
        });
    }
};
