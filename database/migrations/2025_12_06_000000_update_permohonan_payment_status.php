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
            // Tambah kolom boolean untuk tracking pembayaran dan sampel
            $table->boolean('is_paid')->default(false)->after('status');
            $table->boolean('is_sample_ready')->default(false)->after('is_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['is_paid', 'is_sample_ready']);
        });
    }
};
