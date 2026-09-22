<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds an optional class_id foreign key to the staff table, so a
     * staff member (e.g. a class teacher) can be linked to one of the
     * classes created in the Classes module. Nullable because not every
     * staff member (admin, sports, etc.) is tied to a specific class.
     */
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->foreignId('class_id')
                ->nullable()
                ->after('department_id')
                ->constrained('classes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropConstrainedForeignId('class_id');
        });
    }
};
