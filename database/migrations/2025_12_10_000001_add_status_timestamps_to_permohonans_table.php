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
            $table->dateTime('verified_at')->nullable()->after('updated_at');
            $table->dateTime('sample_received_at')->nullable()->after('verified_at');
            $table->dateTime('testing_started_at')->nullable()->after('sample_received_at');
            $table->dateTime('testing_ended_at')->nullable()->after('testing_started_at');
            $table->dateTime('report_started_at')->nullable()->after('testing_ended_at');
            $table->dateTime('completed_at')->nullable()->after('report_started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn([
                'verified_at',
                'sample_received_at',
                'testing_started_at',
                'testing_ended_at',
                'report_started_at',
                'completed_at',
            ]);
        });
    }
};
