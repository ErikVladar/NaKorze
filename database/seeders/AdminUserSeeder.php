<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update an admin user. Password will be hashed by the model cast.
        $user = User::updateOrCreate(
            ['email' => env("ADMIN_EMAIL", "info@example.com")],
            [
                'name' => env("ADMIN_USER", "admin"),
                'password' => env("ADMIN_PASSWORD", "password"),
                'role' => 'admin',
            ]
        );
    }
}
