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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action'); // 'create', 'update', 'delete', 'login', 'logout', 'failed_login', 'payment'
            $table->string('model')->nullable(); // Model class name (e.g., 'App\Models\Permohonan')
            $table->unsignedBigInteger('model_id')->nullable(); // Model instance ID
            $table->json('old_values')->nullable(); // Previous values (for update)
            $table->json('new_values')->nullable(); // New values (for create/update)
            $table->ipAddress('ip_address'); // Client IP address
            $table->text('user_agent'); // Client user agent
            $table->timestamp('created_at');

            // Foreign key
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Indexes untuk performa query
            $table->index(['user_id', 'created_at']);
            $table->index(['action', 'created_at']);
            $table->index(['model', 'model_id']);
            $table->index(['ip_address', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
