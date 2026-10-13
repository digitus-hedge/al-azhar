<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * File: database/migrations/2026_10_13_000400_create_curriculums_table.php
 *
 * Run:
 *   php artisan make:migration create_curriculums_table
 *   php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');       // TinyMCE HTML
            $table->string('image')->nullable();   // storage path
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
};