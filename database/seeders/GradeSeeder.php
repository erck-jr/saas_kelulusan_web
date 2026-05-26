<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $mataPelajaran = [
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Matematika',
            'Fisika',
            'Biologi',
            'Kimia',
            'Sejarah',
            'PKN',
            'Agama'
        ];

        $students = \App\Models\Student::all();

        foreach ($students as $student) {
            foreach ($mataPelajaran as $mapel) {
                $nilaiSekolah = $faker->randomFloat(2, 60, 100);
                $nilaiUjian = $faker->randomFloat(2, 60, 100);
                $nilaiAkhir = ($nilaiSekolah + $nilaiUjian) / 2;

                \App\Models\Grade::create([
                    'school_id' => 1,
                    'student_id' => $student->id,
                    'mata_pelajaran' => $mapel,
                    'nilai_akhir' => $nilaiAkhir,
                    'nilai_ujian' => $nilaiUjian,
                    'nilai_sekolah' => $nilaiSekolah,
                    'catatan' => $faker->optional()->sentence()
                ]);
            }
        }
    }
}
