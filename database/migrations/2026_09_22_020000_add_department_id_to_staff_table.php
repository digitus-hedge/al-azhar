<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds a proper department_id foreign key to the staff table, so the
     * "Department" field can be a dropdown backed by the departments table
     * instead of a free-text field.
     *
     * The old `department` string column is left in place (nullable is not
     * changed) so nothing breaks if other code still reads it; once you've
     * backfilled department_id for existing rows and confirmed nothing else
     * references `department`, you can drop it in a follow-up migration:
     *
     *   Schema::table('staff', fn (Blueprint $table) => $table->dropColumn('department'));
     */
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->foreignId('department_id')
                ->nullable()
                ->after('designation')
                ->constrained('departments')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
        });
    }
};
