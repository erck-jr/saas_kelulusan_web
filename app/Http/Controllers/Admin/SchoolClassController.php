<?php

namespace App\Http\Controllers\Admin;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\GraduationPeriod;
use App\Http\Controllers\Controller;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::whereHas('graduationPeriod', function ($query) {
                        $query->where('is_active', 1);
                    })->latest()->paginate(10);
        return view('admin.school-classes.index', compact('classes'));
    }

    public function create()
    {
        $periods = GraduationPeriod::all();
        return view('admin.school-classes.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required',
            'jurusan' => 'nullable',
            'tingkat' => 'required',
            'wali_kelas' => 'nullable',
            'graduation_period_id' => 'required|exists:graduation_periods,id'
        ]);

        SchoolClass::create($validated);
        return redirect()->route('admin.school-classes.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $class = SchoolClass::with(['students', 'graduationPeriod'])->findOrFail($id);
        return view('admin.school-classes.show', compact('class'));
    }

    public function edit(string $id)
    {
        $class = SchoolClass::findOrFail($id);
        $periods = GraduationPeriod::all();
        return view('admin.school-classes.edit', compact('class', 'periods'));
    }

    public function update(Request $request, string $id)
    {
        $class = SchoolClass::findOrFail($id);

        $validated = $request->validate([
            'nama_kelas' => 'required',
            'jurusan' => 'nullable',
            'tingkat' => 'required',
            'wali_kelas' => 'nullable',
            'graduation_period_id' => 'required|exists:graduation_periods,id'
        ]);

        $class->update($validated);
        return redirect()->route('admin.school-classes.index')->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $class = SchoolClass::findOrFail($id);
        $class->delete();
        return redirect()->route('admin.school-classes.index')->with('success', 'Kelas berhasil dihapus');
    }
}
