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
        $this->call([
            AdminUserSeeder::class, // Hanya Superadmin
            
            // Dummy Data (Komentari untuk Production/Hosting)
            // SchoolSeeder::class,
            // SettingSeeder::class,
            // CertificateSettingSeeder::class,
            // UserSeeder::class, // Admin dan Petugas Dummy
            // GraduationPeriodSeeder::class,
            // SchoolClassSeeder::class,
            // StudentSeeder::class,
            // GradeSeeder::class,
        ]);
    }
}
