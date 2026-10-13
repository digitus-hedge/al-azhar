<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostel_applications', function (Blueprint $table) {
            $table->id();

            // Student details
            $table->string('student_name');
            $table->unsignedTinyInteger('age');
            $table->foreignId('class_id')->nullable()
                  ->constrained('classes')->nullOnDelete();
            $table->string('class_name_snapshot')->nullable(); // keep readable name even if class row changes/deletes
            $table->enum('gender', ['male', 'female', 'other']);

            // Parent / Guardian details
            $table->string('parent_name');
            $table->string('parent_phone', 20);
            $table->string('parent_email')->nullable();

            // Optional extra details
            $table->text('address')->nullable();

            // Admin workflow
            $table->enum('status', ['pending', 'contacted', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostel_applications');
    }
};