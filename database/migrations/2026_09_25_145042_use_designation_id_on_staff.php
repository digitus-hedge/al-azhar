<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Staff: replace the free-text `designation` column with
 * `designation_id` → management_designations.id (type = 'staff').
 * Every existing typed designation becomes (or reuses) a Staff designation row.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. New id column
        if (! Schema::hasColumn('staff', 'designation_id')) {
            Schema::table('staff', function (Blueprint $table) {
                $table->unsignedBigInteger('designation_id')->nullable()->after('name');
            });
        }

        // 2. Convert existing text designations → Staff designation rows
        if (Schema::hasColumn('staff', 'designation')) {
            DB::table('staff')
                ->whereNotNull('designation')->where('designation', '!=', '')
                ->distinct()->pluck('designation')
                ->each(function ($text) {
                    $name = trim(preg_replace('/\s+/', ' ', $text));

                    $id = DB::table('management_designations')
                            ->where('name', $name)->where('type', 'staff')->whereNull('deleted_at')
                            ->value('id')
                        ?? DB::table('management_designations')->insertGetId([
                            'name'       => $name,
                            'type'       => 'staff',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                    DB::table('staff')->where('designation', $text)->update(['designation_id' => $id]);
                });

            // 3. Remove the old text column
            Schema::table('staff', function (Blueprint $table) {
                $table->dropColumn('designation');
            });
        }

        // 4. Link to the designations table
        Schema::table('staff', function (Blueprint $table) {
            $table->foreign('designation_id')
                  ->references('id')->on('management_designations')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropForeign(['designation_id']);
            $table->string('designation')->nullable()->after('name');
        });

        DB::table('staff as s')
            ->join('management_designations as d', 'd.id', '=', 's.designation_id')
            ->update(['s.designation' => DB::raw('d.name')]);

        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn('designation_id');
        });
    }
};