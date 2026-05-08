<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $graduationPeriod = \App\Models\GraduationPeriod::first();

        $classes = [
            ['nama_kelas' => 'XII IPA 1', 'jurusan' => 'IPA', 'tingkat' => '12', 'wali_kelas' => 'Drs. Ahmad'],
            ['nama_kelas' => 'XII IPA 2', 'jurusan' => 'IPA', 'tingkat' => '12', 'wali_kelas' => 'Dra. Siti'],
            ['nama_kelas' => 'XII IPS 1', 'jurusan' => 'IPS', 'tingkat' => '12', 'wali_kelas' => 'Drs. Budi'],
            ['nama_kelas' => 'XII IPS 2', 'jurusan' => 'IPS', 'tingkat' => '12', 'wali_kelas' => 'Dra. Rina'],
        ];

        foreach ($classes as $class) {
            \App\Models\SchoolClass::create([
                'nama_kelas' => $class['nama_kelas'],
                'jurusan' => $class['jurusan'],
                'tingkat' => $class['tingkat'],
                'wali_kelas' => $class['wali_kelas'],
                'graduation_period_id' => $graduationPeriod->id
            ]);
        }
    }
}
