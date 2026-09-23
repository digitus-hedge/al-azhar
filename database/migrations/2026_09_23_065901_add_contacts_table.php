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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('email', 191);
            $table->string('phone', 20)->nullable();
            $table->string('subject', 191)->nullable();
            $table->text('message');

            // Admin side
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->text('admin_notes')->nullable();

            // Tracking
            $table->string('ip_address', 45)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_read', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
