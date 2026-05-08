<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertificateSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists = DB::table('settings')->where('key', 'template-sertifikat')->exists();
        
        if (!$exists) {
            DB::table('settings')->insert([
                'key' => 'template-sertifikat',
                'value' => null,
                'type' => 'template',
                'group' => 'sertifikat',
                'label' => 'Template Sertifikat',
                'description' => 'Template sertifikat kelulusan (format JPG).',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
