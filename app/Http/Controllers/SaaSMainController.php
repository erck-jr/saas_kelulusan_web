<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SaaSMainController extends Controller
{
    /**
     * Show SaaS landing page.
     */
    public function index()
    {
        $schools = School::where('is_active', true)->get();
        return view('saas.landing', compact('schools'));
    }

    /**
     * Register a new school (tenant) on the platform.
     */
    public function register(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_slug' => 'required|string|alpha_dash|max:50|unique:schools,slug',
            'admin_name'  => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create School (Tenant)
            $school = School::create([
                'name' => $request->school_name,
                'slug' => Str::slug($request->school_slug),
                'is_active' => true,
            ]);

            // 2. Create Admin User bound to this School
            User::create([
                'school_id' => $school->id,
                'name'      => $request->admin_name,
                'email'     => $request->admin_email,
                'password'  => Hash::make($request->admin_password),
                'role'      => 'admin',
            ]);

            // 3. Seed default settings for the new school
            $defaultSettings = [
                [
                    'key' => 'app_name',
                    'value' => 'Sistem Informasi Kelulusan - ' . $school->name,
                    'type' => 'text',
                    'group' => 'general',
                    'label' => 'Nama Aplikasi',
                    'description' => 'Nama aplikasi yang akan ditampilkan di title dan header'
                ],
                [
                    'key' => 'school_name',
                    'value' => $school->name,
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
                    'value' => $request->admin_email,
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
                ],
                [
                    'key' => 'template-sertifikat',
                    'value' => null,
                    'type' => 'template',
                    'group' => 'sertifikat',
                    'label' => 'Template Sertifikat',
                    'description' => 'Template sertifikat kelulusan (format JPG).'
                ],
                [
                    'key' => 'theme_primary_color',
                    'value' => '#6366f1',
                    'type' => 'text',
                    'group' => 'appearance',
                    'label' => 'Warna Utama (Primary Color)',
                    'description' => 'Warna utama sekolah (format Hex, contoh: #6366f1) yang digunakan untuk gradasi ornamen dan elemen visual.'
                ],
                [
                    'key' => 'theme_accent_color',
                    'value' => '#8b5cf6',
                    'type' => 'text',
                    'group' => 'appearance',
                    'label' => 'Warna Aksen (Accent Color)',
                    'description' => 'Warna aksen tombol, hover, dan ornamen penting (format Hex, contoh: #8b5cf6).'
                ],
                [
                    'key' => 'theme_bg_mode',
                    'value' => 'dark',
                    'type' => 'text',
                    'group' => 'appearance',
                    'label' => 'Mode Latar Belakang (Background Mode)',
                    'description' => 'Pilihan mode tampilan untuk halaman publik siswa: dark (gelap) atau light (terang).'
                ],
                [
                    'key' => 'theme_font_family',
                    'value' => 'Outfit',
                    'type' => 'text',
                    'group' => 'appearance',
                    'label' => 'Jenis Huruf (Font Family)',
                    'description' => 'Pilihan font Google Fonts online untuk halaman publik kelulusan siswa.'
                ],
                [
                    'key' => 'theme_hero_bg',
                    'value' => null,
                    'type' => 'image',
                    'group' => 'appearance',
                    'label' => 'Gambar Latar Belakang (Background Hero)',
                    'description' => 'Gambar latar kustom untuk halaman depan publik siswa (format: JPG/PNG, maks 2MB).'
                ]
            ];

            foreach ($defaultSettings as $setting) {
                Setting::create([
                    'school_id' => $school->id,
                    'key' => $setting['key'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group' => $setting['group'],
                    'label' => $setting['label'],
                    'description' => $setting['description'],
                ]);
            }

            DB::commit();

            return redirect()->route('school.home', ['school_slug' => $school->slug])
                ->with('success', 'Registrasi sekolah berhasil! Silakan login di dashboard admin sekolah Anda.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }

    /**
     * Show superadmin central dashboard.
     */
    public function globalDashboard()
    {
        $schools = School::withCount('students')->paginate(10);
        $appDomain = parse_url(config('app.url'), PHP_URL_HOST);
        $protocol = parse_url(config('app.url'), PHP_URL_SCHEME) ?? 'http';

        return view('superadmin.dashboard', compact('schools', 'appDomain', 'protocol'));
    }
}
