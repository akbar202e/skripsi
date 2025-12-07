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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method')->unique(); // e.g., 'VA', 'VC', 'OV'
            $table->string('payment_name'); // e.g., 'BCA Virtual Account'
            $table->text('payment_image')->nullable(); // URL image dari Duitku
            $table->decimal('total_fee', 12, 2)->default(0); // Fee dari Duitku
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
