<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin', // Using username
            'password' => bcrypt('admin'), // Use bcrypt for password hashing
        ]);

        $this->call([
            DataBerasSeeder::class
        ]);
        $this->call([
            DataUjiSeeder::class
        ]);
    }
}
