<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admission_enquiries', function (Blueprint $table) {
            $table->string('gender', 20)->nullable()->after('student_name');
            $table->string('state', 100)->nullable()->after('parent_email');
            $table->string('district', 100)->nullable()->after('state');
            $table->string('city', 100)->nullable()->after('district');
            $table->boolean('needs_transport')->default(false)->after('needs_hostel');
        });
    }

    public function down(): void
    {
        Schema::table('admission_enquiries', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'state',
                'district',
                'city',
                'needs_transport',
            ]);
        });
    }
};