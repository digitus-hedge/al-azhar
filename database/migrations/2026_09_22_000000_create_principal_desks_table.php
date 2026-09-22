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
        Schema::create('principal_desks', function (Blueprint $table) {
            $table->id();
            $table->string('heading');                 // e.g. "Principal's Desk"
            $table->string('name')->nullable();         // Principal's name
            $table->string('photo')->nullable();        // stored path (storage/app/public/...)
            $table->string('avatar_initial', 2)->nullable(); // fallback letter, e.g. "P"
            $table->text('excerpt');                    // short preview text shown on the card
            $table->longText('message');                // full message shown on "Read More"
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('principal_desks');
    }
};
