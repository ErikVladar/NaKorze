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
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => 'ZvkV1R4NduKVjpzL',
                'role' => 'admin',
            ]
        );

        // Output the password to console during seeding
        $this->command->info("Admin user created/updated.");
        $this->command->info("Email: admin@example.com");
        $this->command->info("Password: ZvkV1R4NduKVjpzL");
        $this->command->warn('Save this password in a secure location!');
    }
}
