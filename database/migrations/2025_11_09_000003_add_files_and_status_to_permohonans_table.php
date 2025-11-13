<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First update all existing records to the new default status
        DB::table('permohonans')->update(['status' => 'permohonan_masuk']);

        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('surat_permohonan')->nullable();
            $table->string('laporan_hasil')->nullable();
            $table->dropColumn('status');
        });

        Schema::table('permohonans', function (Blueprint $table) {
            $table->enum('status', [
                'permohonan_masuk',
                'verifikasi_berkas',
                'perlu_perbaikan',
                'terverifikasi',
                'menunggu_sampel_dan_pembayaran',
                'proses_administrasi',
                'pengujian',
                'selesai'
            ])->default('permohonan_masuk');
            $table->decimal('total_biaya', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['surat_permohonan', 'laporan_hasil', 'total_biaya']);
        });

        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('status')->default('menunggu verifikasi');
        });
    }
};