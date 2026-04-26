<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('sample_code')->unique()->nullable()->after('user_id');
            $table->string('bukti_penerimaan_sampel')->nullable()->after('laporan_hasil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn('sample_code');
            $table->dropColumn('bukti_penerimaan_sampel');
        });
    }
};
