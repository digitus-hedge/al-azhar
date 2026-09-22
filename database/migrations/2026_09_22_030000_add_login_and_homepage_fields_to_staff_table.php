<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->boolean('show_on_home')->default(false)->after('is_head_of_staff');

            $table->boolean('has_login')->default(false)->after('show_on_home');
            $table->foreignId('user_id')->nullable()->after('has_login')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['has_login', 'show_on_home']);
        });
    }
};
