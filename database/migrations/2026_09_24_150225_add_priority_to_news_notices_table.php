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
        Schema::table('news_notices', function (Blueprint $table) {
            $table->string('priority', 20)->default('normal')->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('news_notices', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
};
