<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::create([
            'school_id' => 1,
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // Create petugas user
        \App\Models\User::create([
            'school_id' => 1,
            'name' => 'Petugas',
            'email' => 'petugas@example.com',
            'password' => bcrypt('password'),
            'role' => 'petugas'
        ]);
    }
}
