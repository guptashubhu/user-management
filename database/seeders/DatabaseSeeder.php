<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Contact;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Create Admin
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        // Create Normal User
        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'user@yopmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'user'
        ]);

        Contact::factory()->count(10)->create();
    }
}
