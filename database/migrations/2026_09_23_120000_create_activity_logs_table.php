<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Audit trail: WHO did WHAT to WHICH record, and WHEN.
 * Rows are never edited or deleted from the admin panel.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // WHO — user_id can become NULL if the user is deleted later,
            // so name / email / role are stored as a snapshot too.
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name', 150)->nullable();
            $table->string('user_email', 191)->nullable();
            $table->string('user_role', 30)->nullable();

            // WHAT — created | updated | deleted | restored | login | logout
            $table->string('action', 20);

            // WHICH — module name + the exact record
            $table->string('module', 60);                       // "Facilities", "News & Notices"
            $table->string('subject_type', 191)->nullable();    // App\Models\Facility
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('subject_label', 255)->nullable();   // record title at that moment

            // DETAILS (properties) — changed fields: {"title": {"old": "A", "new": "B"}}
            $table->json('properties')->nullable();
            $table->string('description', 500)->nullable();

            // CONTEXT
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('url', 1000)->nullable();

            // WHEN
            $table->timestamp('created_at')->useCurrent()->index();

            $table->index(['module', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['action', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
