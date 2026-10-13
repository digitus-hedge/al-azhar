<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * File: database/migrations/2026_10_13_000200_create_career_enquiries_table.php
 *
 * Matches the existing career_enquiries table schema shown in phpMyAdmin:
 *   id, name, email, phone, nationality, career_id, apply_for, cv, message, timestamps
 *
 * Run: php artisan migrate
 *
 * NOTE: If the table already exists in your DB, SKIP running this file
 * (or use `Schema::hasTable` guard already included below).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('career_enquiries')) {
            return; // table already exists — nothing to do
        }

        Schema::create('career_enquiries', function (Blueprint $table) {
            $table->id();                                      // bigint unsigned auto_increment

            $table->string('name', 191);                       // required
            $table->string('email', 191);                      // required
            $table->string('phone', 30);                       // required

            $table->string('nationality', 191)->nullable();    // optional

            // Link to careers table (nullable so general enquiries also work)
            $table->foreignId('career_id')
                  ->nullable()
                  ->constrained('careers')
                  ->nullOnDelete();

            $table->string('apply_for', 191);                  // required — position title text

            $table->string('cv', 191)->nullable();             // uploaded CV file path
            $table->text('message')->nullable();               // optional cover letter / note

            $table->timestamps();                              // created_at, updated_at

            // Helpful indexes for the admin listing / filters
            $table->index('career_id');
            $table->index('created_at');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_enquiries');
    }
};