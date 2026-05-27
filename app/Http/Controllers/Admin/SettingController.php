<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Setting;
use App\Services\CertificationGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();

        $groups = $settings->pluck('group')->unique()->values();

        $groupedSettings = $settings->groupBy('group');

        return view('admin.settings.index', [
            'settings' => $groupedSettings,
            'groups' => $groups
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'theme_primary_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'theme_accent_color'  => ['nullable', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'theme_bg_mode'       => ['nullable', 'in:dark,light'],
            'theme_font_family'   => ['nullable', 'string', 'max:100'],
            'theme_hero_bg'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        foreach ($request->except('_token', '_method') as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if (!$setting) continue;
           
            if ($setting->type === 'image' || $setting->type === 'template') {
                if ($request->hasFile($key)) {
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    // simpan file di folder "settings" di disk public
                    $value = $request->file($key)->store('settings', 'public');
                } else {
                    // Tetap pertahankan file yang lama jika tidak mengunggah file baru
                    continue;
                }
            }

            $setting->update([
                'value' => $value,
                'updated_at' => now()
            ]);
        }

        if (app()->bound('current_school')) {
            Cache::forget('app_settings_' . app('current_school')->id);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function previewCertificate()
    {
        try {
            $certificateService = app(\App\Services\CertificateService::class);
            $gambar = $certificateService->generate('NAMA SISWA DUMMY', '1234567890', 'LULUS');

            ob_start();
            imagejpeg($gambar);
            $content = ob_get_clean();
            imagedestroy($gambar);

            return response($content)->header('Content-Type', 'image/jpeg');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function regenerateCertificates(Request $request, School $school)
    {
        // Try to flush certificate-related cache using tags when supported.
        try {
            $store = Cache::getStore();
            if ($store instanceof TaggableStore) {
                Cache::tags(['certificates'])->flush();
            } else {
                // Fallback: forget individual certificate cache keys for this school
                if ($school && $school->relationLoaded('students')) {
                    $students = $school->students;
                } else {
                    $students = $school->students()->get();
                }

                foreach ($students as $student) {
                    $cacheKey = "school_{$school->id}_student_{$student->nis}_cert_path";
                    Cache::forget($cacheKey);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Unable to flush certificate cache tags: ' . $e->getMessage());
        }
        try {
            Log::info("Regenerating certificates for school ID: {$school->id}");

            $service = new CertificationGeneratorService();
            $service->generateCertificates($school);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Sertifikat berhasil diregenerasi.']);
            }

            return redirect()->back()->with('success', 'Sertifikat berhasil diregenerasi.');
        } catch (\Exception $e) {
            Log::error("Error regenerating certificates for school ID: {$school->id}: " . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat meregenerasi sertifikat.'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat meregenerasi sertifikat.');
        }
    }


}
