<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $graduationPeriod = \App\Models\GraduationPeriod::first();
        $classes = \App\Models\SchoolClass::all();

        foreach ($classes as $class) {
            // Create 20 students per class
            for ($i = 1; $i <= 20; $i++) {
                \App\Models\Student::create([
                    'nis' => '2025' . str_pad($class->id, 2, '0', STR_PAD_LEFT) . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $faker->name(),
                    'school_class_id' => $class->id,
                    'graduation_period_id' => $graduationPeriod->id,
                    'status' => $faker->randomElement(['LULUS', 'TIDAK LULUS']),
                    'nilai_rata_rata' => $faker->randomFloat(2, 60, 100),
                    'catatan' => $faker->optional()->sentence()
                ]);
            }
        }
    }
}
