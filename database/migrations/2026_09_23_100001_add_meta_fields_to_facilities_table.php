<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Brings an already-existing `facilities` table up to date
 * (adds SEO fields). Safe to run on a fresh table too — it only
 * adds columns that are missing.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            if (! Schema::hasColumn('facilities', 'meta_title')) {
                $table->string('meta_title', 191)->nullable()->after('contact_phone');
            }
            if (! Schema::hasColumn('facilities', 'meta_description')) {
                $table->string('meta_description', 500)->nullable()->after('meta_title');
            }
        });
    }

    public function down(): void
    {
        // Columns are part of the create migration on fresh installs,
        // so nothing is removed here.
    }
};
