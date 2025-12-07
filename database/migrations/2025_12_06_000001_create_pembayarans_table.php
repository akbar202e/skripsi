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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->nullable(); // e.g., 'VA', 'VC', 'OV'
            $table->string('payment_method_name')->nullable(); // e.g., 'BCA Virtual Account'
            $table->string('merchant_order_id')->unique(); // Order ID dari merchant (unik)
            $table->string('duitku_reference')->nullable(); // Reference dari Duitku
            $table->string('va_number')->nullable(); // Virtual account number
            $table->text('payment_url')->nullable(); // URL untuk payment page
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->string('result_code')->nullable(); // Response code dari Duitku (00 = success, 01 = failed)
            $table->timestamp('paid_at')->nullable(); // Waktu pembayaran berhasil
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('permohonan_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
