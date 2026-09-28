<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boardings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();   // ["boarding/images/a.jpg", ...]
            $table->json('videos')->nullable();   // [{"type":"file","src":"boarding/videos/a.mp4"}, {"type":"link","src":"https://youtu.be/..."}]
            $table->string('fees_title')->nullable();   // e.g. "Fees structure 2024-2025"
            $table->string('fees_qr')->nullable();      // QR code image path
            $table->string('qr_caption')->nullable();   // e.g. "Al Azhar Central School Mala"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boardings');
    }
};