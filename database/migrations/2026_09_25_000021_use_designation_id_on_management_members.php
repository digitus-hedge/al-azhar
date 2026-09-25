<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * School Management: replace the free-text `designation` column with
 * `designation_id` → management_designations.id.
 * Existing profiles are converted: each typed designation becomes (or reuses) a designation row.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('management_members', function (Blueprint $table) {
            $table->unsignedBigInteger('designation_id')->nullable()->after('name');
        });

        // Convert existing text values to designation rows
        if (Schema::hasColumn('management_members', 'designation')) {
            DB::table('management_members')
                ->whereNotNull('designation')->where('designation', '!=', '')
                ->distinct()->pluck('designation')
                ->each(function ($name) {
                    $name = trim(preg_replace('/\s+/', ' ', $name));

                    $id = DB::table('management_designations')->where('name', $name)->whereNull('deleted_at')->value('id')
                        ?? DB::table('management_designations')->insertGetId([
                            'name' => $name, 'created_at' => now(), 'updated_at' => now(),
                        ]);

                    DB::table('management_members')->where('designation', $name)->update(['designation_id' => $id]);
                });

            Schema::table('management_members', function (Blueprint $table) {
                $table->dropColumn('designation');
            });
        }

        Schema::table('management_members', function (Blueprint $table) {
            $table->foreign('designation_id')->references('id')->on('management_designations')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('management_members', function (Blueprint $table) {
            $table->dropForeign(['designation_id']);
            $table->string('designation', 150)->nullable()->after('name');
        });

        DB::table('management_members as m')
            ->join('management_designations as d', 'd.id', '=', 'm.designation_id')
            ->update(['m.designation' => DB::raw('d.name')]);

        Schema::table('management_members', function (Blueprint $table) {
            $table->dropColumn('designation_id');
        });
    }
};
