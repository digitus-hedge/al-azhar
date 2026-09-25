<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Master > Management Designations (Chairman, Secretary, Trustee, Principal, ...) */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_designations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->index();
            $table->timestamps();
            $table->softDeletes(); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_designations');
    }
};
