<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            AdminSeeder::class,
        ]);

        // Create an admin
        $admin = Admin::create([
            'name' => 'Admin Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign role
        $admin->assignRole('super-admin');
    }
}
