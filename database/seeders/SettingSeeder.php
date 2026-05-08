<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'Sistem Informasi Kelulusan',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Aplikasi',
                'description' => 'Nama aplikasi yang akan ditampilkan di title dan header'
            ],
            [
                'key' => 'school_name',
                'value' => 'SMA Negeri 1',
                'type' => 'text',
                'group' => 'school',
                'label' => 'Nama Sekolah',
                'description' => 'Nama lengkap sekolah'
            ],
            [
                'key' => 'school_address',
                'value' => 'Jl. Pendidikan No. 1',
                'type' => 'text',
                'group' => 'school',
                'label' => 'Alamat Sekolah',
                'description' => 'Alamat lengkap sekolah'
            ],
            [
                'key' => 'school_email',
                'value' => 'info@sman1.sch.id',
                'type' => 'text',
                'group' => 'school',
                'label' => 'Email Sekolah',
                'description' => 'Alamat email resmi sekolah'
            ],
            [
                'key' => 'school_phone',
                'value' => '(021) 1234567',
                'type' => 'text',
                'group' => 'school',
                'label' => 'Telepon Sekolah',
                'description' => 'Nomor telepon sekolah'
            ],
            [
                'key' => 'kepala_sekolah',
                'value' => 'Dr. Kepala Sekolah, M.Pd.',
                'type' => 'text',
                'group' => 'school',
                'label' => 'Nama Kepala Sekolah',
                'description' => 'Nama lengkap dan gelar Kepala Sekolah'
            ],
            [
                'key' => 'nip_kepala_sekolah',
                'value' => '196001011985031001',
                'type' => 'text',
                'group' => 'school',
                'label' => 'NIP Kepala Sekolah',
                'description' => 'Nomor Induk Pegawai Kepala Sekolah'
            ],
            [
                'key' => 'school_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'school',
                'label' => 'Logo Sekolah',
                'description' => 'Logo resmi sekolah (format: PNG, maksimal 2MB)'
            ],
            [
                'key' => 'minimum_graduation_score',
                'value' => '75',
                'type' => 'number',
                'group' => 'academic',
                'label' => 'Nilai Minimum Kelulusan',
                'description' => 'Nilai minimum yang harus dicapai untuk dinyatakan lulus'
            ],
            [
                'key' => 'announcement_header',
                'value' => 'PENGUMUMAN KELULUSAN',
                'type' => 'text',
                'group' => 'announcement',
                'label' => 'Header Pengumuman',
                'description' => 'Teks yang akan ditampilkan di bagian atas halaman pengumuman'
            ],
            [
                'key' => 'announcement_footer',
                'value' => 'Selamat kepada siswa/i yang dinyatakan LULUS. Tetap semangat bagi yang belum berhasil.',
                'type' => 'text',
                'group' => 'announcement',
                'label' => 'Footer Pengumuman',
                'description' => 'Teks yang akan ditampilkan di bagian bawah halaman pengumuman'
            ]
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => $setting['type'],
                'group' => $setting['group'],
                'label' => $setting['label'],
                'description' => $setting['description'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
