<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'school_id' => null,
            'name' => 'Super Administrator',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);
    }
}
