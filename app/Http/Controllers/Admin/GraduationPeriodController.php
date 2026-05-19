<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\GraduationPeriod;
use App\Http\Controllers\Controller;

class GraduationPeriodController extends Controller
{
    public function index()
    {
        $periods = GraduationPeriod::latest()->paginate(10);
        return view('admin.graduation-periods.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.graduation-periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required',
            'semester' => 'required',
            'tanggal_pengumuman' => 'required|date',
            'jam_pengumuman' => 'required',
            'keterangan' => 'nullable|string'
        ]);

        $validated['is_active'] = false;
        if ($request->has('is_active')) {
            $validated['is_active'] = true;
            GraduationPeriod::where('is_active', true)->update(['is_active' => false]);
        }

        GraduationPeriod::create($validated);
        return redirect()->route('admin.graduation-periods.index')->with('success', 'Periode kelulusan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $period = GraduationPeriod::with(['students', 'schoolClasses'])->findOrFail($id);
        return view('admin.graduation-periods.show', compact('period'));
    }

    public function edit(string $id)
    {
        $period = GraduationPeriod::findOrFail($id);
        return view('admin.graduation-periods.edit', compact('period'));
    }

    public function update(Request $request, string $id)
    {
        $period = GraduationPeriod::findOrFail($id);

        $validated = $request->validate([
            'tahun_ajaran' => 'required',
            'semester' => 'required',
            'tanggal_pengumuman' => 'required|date',
            'jam_pengumuman' => 'required',
            'keterangan' => 'nullable|string'
        ]);

        $validated['is_active'] = false;

        if ($request->has('is_active')) {
            $validated['is_active'] = true;
            GraduationPeriod::where('is_active', true)
                ->where('id', '!=', $id)
                ->update(['is_active' => false]);
        }

        $period->update($validated);
        return redirect()->route('admin.graduation-periods.index')->with('success', 'Periode kelulusan berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $period = GraduationPeriod::findOrFail($id);
        $period->delete();
        return redirect()->route('admin.graduation-periods.index')->with('success', 'Periode kelulusan berhasil dihapus');
    }
}
