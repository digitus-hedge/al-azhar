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
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('video_url', 500)->nullable()->after('media');
            $table->string('video_provider', 20)->nullable()->after('video_url'); // youtube | vimeo
            $table->string('video_id', 50)->nullable()->after('video_provider');

            // media must be optional now (link-only items have no file)
            $table->string('media')->nullable()->change();
            // allow 'image', 'video', 'youtube', 'vimeo'
            $table->string('media_type', 20)->default('image')->change();
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'video_provider', 'video_id']);
        });
    }
};
