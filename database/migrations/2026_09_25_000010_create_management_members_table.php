<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * School Management: profiles of the school committee, trustees
 * and institutional leadership.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('designation', 150);                 // e.g. Chairman, Secretary, Principal
            $table->string('type', 30)->default('committee');   // committee | trustee | leadership
            $table->string('photo')->nullable();                // storage path on the public disk
            $table->text('bio')->nullable();                    // short biography (plain text)
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_members');
    }
};
