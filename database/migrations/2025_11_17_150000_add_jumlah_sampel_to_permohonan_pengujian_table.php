<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_pengujian', function (Blueprint $table) {
            $table->integer('jumlah_sampel')->default(1)->after('jenis_pengujian_id');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_pengujian', function (Blueprint $table) {
            $table->dropColumn('jumlah_sampel');
        });
    }
};
