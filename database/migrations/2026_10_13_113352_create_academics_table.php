<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academics', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // Preschool, LKG and UKG, ...
            $table->string('subtitle')->nullable(); // e.g. "Classes I – V"
            $table->longText('description');        // TinyMCE HTML
            $table->string('icon')->nullable();     // bi-house etc.
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academics');
    }
};