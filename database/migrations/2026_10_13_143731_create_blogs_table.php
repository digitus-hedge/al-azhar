<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * File: database/migrations/2026_10_13_000300_create_blogs_table.php
 *
 * Run:
 *   php artisan make:migration create_blogs_table   (generate the file)
 *   php artisan migrate                              (then apply it)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');          // TinyMCE HTML
            $table->timestamp('published_at')->nullable();
            $table->string('image')->nullable();      // storage path
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('published_at');
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};