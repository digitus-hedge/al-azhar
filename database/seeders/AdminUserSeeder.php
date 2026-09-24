<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // If user id 1 exists, update it; otherwise create a new one with id 1.
        $user = User::find(1) ?? new User();

        $user->forceFill([
            'id'          => 1,
            'name'        => 'Admin',
            'email'       => 'admin@example.com',
            'role'        => 'admin',
            'password'    => Hash::make('password123'),
            'permissions' => [],
        ])->save();

        $this->command->info(
            $user->wasRecentlyCreated ? 'Admin user created.' : 'Admin user (id 1) updated.'
        );
    }
}