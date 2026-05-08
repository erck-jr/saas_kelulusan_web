<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->get();

        $groups = $settings->pluck('group')->unique()->values();

        $groupedSettings = $settings->groupBy('group');

        return view('admin.settings.index', [
            'settings' => $groupedSettings,
            'groups' => $groups
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            $setting = DB::table('settings')->where('key', $key)->first();

           if (!$setting) continue;
           
           if (($setting->type === 'image' || $setting->type === 'template') && $request->hasFile($key)) {
                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
                // simpan file di folder "settings" di disk public
                $value = $request->file($key)->store('settings', 'public');
            }

            DB::table('settings')->where('key', $key)->update([
                'value' => $value,
                'updated_at' => now()
            ]);
        }

        Cache::forget('settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');

        Cache::forget('settings');

        return redirect()
            ->route('admin.settings.index')
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
}
