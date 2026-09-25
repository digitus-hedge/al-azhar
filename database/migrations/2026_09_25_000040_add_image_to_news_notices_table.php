<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** News & Notices: optional cover image (shown on the website card / detail page). */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_notices', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description'); // storage path on the public disk
        });
    }

    public function down(): void
    {
        Schema::table('news_notices', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
