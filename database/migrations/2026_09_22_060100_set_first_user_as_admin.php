<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Data migration: your existing "Admin" login (the very first row in
 * `users`, id = 1) predates the `role` column, so it got the default
 * ('staff') like everyone else. This promotes that one account to
 * 'admin' so you don't get locked out of admin-only sections after
 * migrating. Any other pre-existing users stay 'staff' — set those
 * manually (via phpMyAdmin, or by re-saving their Staff record with the
 * Login Access "Role" set to Admin) if any of them should also be admins.
 */
return new class extends Migration
{
    public function up(): void
    {
        $firstUserId = DB::table('users')->min('id');

        if ($firstUserId) {
            DB::table('users')->where('id', $firstUserId)->update(['role' => 'admin']);
        }
    }

    public function down(): void
    {
        // Intentionally no-op — reverting this would demote your admin
        // account, which is never what you want on a rollback.
    }
};
