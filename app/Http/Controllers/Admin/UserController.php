<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        // Tampilkan user yang role-nya admin (karena sekarang kita pakai admin saja per tenant)
        $users = User::with('school')->where('id', '!=', auth()->id())->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();

        try {
            // 1. Buat Sekolah
            // Generate slug otomatis dari nama sekolah (dengan random suffix untuk jaga keunikan jika nama sama)
            $slug = Str::slug($validated['school_name']);
            if (School::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . Str::random(4);
            }

            $school = School::create([
                'name' => $validated['school_name'],
                'slug' => $slug,
                'is_active' => true,
            ]);

            // 2. Buat Admin User terikat dengan Sekolah
            $user = User::create([
                'school_id' => $school->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'admin' // Role paksa admin
            ]);

            // 3. Seed default settings
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
                    'value' => $validated['email'],
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

            return redirect()
                ->route('superadmin.global.users.index')
                ->with('success', 'Sekolah dan Admin berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        return view('superadmin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        DB::beginTransaction();
        try {
            // Update User
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                // Role tetap dipertahankan sebagai default (admin), tidak bisa diedit
            ]);

            // Update School Name
            if ($user->school) {
                $user->school->update([
                    'name' => $validated['school_name']
                ]);
            }

            DB::commit();
            return redirect()
                ->route('superadmin.global.users.index')
                ->with('success', 'Data Sekolah dan Pengguna berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function resetPassword(User $user)
    {
        $user->update([
            'password' => Hash::make('password123')
        ]);

        return redirect()
            ->route('superadmin.global.users.edit', $user)
            ->with('success', 'Password berhasil direset ke: password123');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('superadmin.global.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Jika user adalah tenant admin dan memiliki school_id, 
        // hapus School-nya. Karena tabel kita pakai onDelete('cascade'),
        // maka menghapus School otomatis menghapus User, Settings, Students, dll.
        if ($user->school) {
            $user->school->delete();
        } else {
            // Jika untuk alasan tertentu user tidak punya school (misal akun lepas), hapus user-nya saja.
            $user->delete();
        }

        return redirect()
            ->route('superadmin.global.users.index')
            ->with('success', 'Sekolah beserta seluruh data yang terkait berhasil dibumihanguskan.');
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        
        // Nonaktifkan juga status sekolahnya jika dibutuhkan
        if ($user->school) {
            $user->school->is_active = ($user->status === 'active');
            $user->school->save();
        }

        return response()->json([
            'success' => true,
            'status' => $user->status,
            'message' => 'Status akun dan sekolah berhasil diubah menjadi ' . $user->status . '.'
        ]);
    }
}
