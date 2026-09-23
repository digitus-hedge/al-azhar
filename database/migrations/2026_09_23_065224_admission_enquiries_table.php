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
        Schema::create('admission_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('student_name', 150);
            $table->string('parent_name', 150);
            $table->string('parent_phone', 20);            // mobile / WhatsApp
            $table->string('parent_email', 191)->nullable();
            $table->string('grade', 50);                   // grade seeking admission into
            $table->boolean('needs_hostel')->default(false);
            $table->text('message')->nullable();

            // Admin side
            $table->enum('status', ['new', 'contacted', 'admitted', 'in_process'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamp('contacted_at')->nullable();

            // Tracking
            $table->string('ip_address', 45)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_enquiries');
    }
};
