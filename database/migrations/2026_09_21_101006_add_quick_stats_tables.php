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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();

            // Array of stat items, e.g.
            // [
            //   ["value" => "25+", "label" => "Years", "description" => "of Excellence"],
            //   ["value" => "3200+", "label" => "Students", "description" => "Enrolled"],
            //   ...
            // ]
            $table->json('items')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};