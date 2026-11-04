<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_popups', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150)->nullable();      // used as the image alt text
            $table->string('image')->nullable();           // path on the "public" disk
            $table->string('link', 500)->nullable();       // empty = admission page
            $table->boolean('is_active')->default(false);
            $table->date('starts_on')->nullable();         // optional: show from
            $table->date('ends_on')->nullable();           // optional: show until
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_popups');
    }
};
