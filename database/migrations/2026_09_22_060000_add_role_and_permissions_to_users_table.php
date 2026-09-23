<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 'admin'  -> full access, bypasses the module permission checks.
            // 'staff'  -> restricted; access is limited to whatever is in `permissions`.
            $table->string('role', 20)->default('staff')->after('email');

            // A JSON array of module keys this user (if role = staff) may access,
            // e.g. ["news-notices","events","gallery"]. Ignored for admins.
            $table->json('permissions')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'permissions']);
        });
    }
};
