<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            // 'HOD' = Head of Department, 'HOS' = Head of Staff, null = not a head
            $table->string('head_type', 3)->nullable()->after('is_head_of_staff');
            $table->index(['department_id', 'head_type']);
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropIndex(['department_id', 'head_type']);
            $table->dropColumn('head_type');
        });
    }
};