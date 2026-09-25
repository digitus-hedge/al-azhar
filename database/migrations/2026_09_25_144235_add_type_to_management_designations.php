<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('management_designations', function (Blueprint $table) {
            // management | staff  (existing rows become "management")
            $table->string('type', 20)->default('management')->after('name');
            $table->index(['type', 'name']);
        });
    }

    public function down(): void
    {
        Schema::table('management_designations', function (Blueprint $table) {
            $table->dropIndex(['type', 'name']);
            $table->dropColumn('type');
        });
    }
};