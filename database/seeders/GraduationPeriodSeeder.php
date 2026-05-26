<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GraduationPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\GraduationPeriod::create([
            'school_id' => 1,
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Genap',
            'tanggal_pengumuman' => '2025-05-15',
            'is_active' => true,
            'keterangan' => 'Periode Kelulusan Tahun 2025'
        ]);
    }
}
