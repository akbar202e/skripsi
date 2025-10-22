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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 100);
            $table->text('isi');
            $table->string('status')->default('menunggu verifikasi'); //terverifikasi, selesai, dibatalkan
            $table->foreignID('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignID('worker_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
