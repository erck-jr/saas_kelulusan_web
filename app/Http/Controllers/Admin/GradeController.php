<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class GradeController extends Controller
{
    public function template()
    {
        // Ambil siswa dari periode aktif
        $students = Student::whereHas('graduationPeriod', function ($query) {
                            $query->where('is_active', 1);
                        })
                        ->pluck('nis','id');

        // Header kolom
        $headers = [
            'NISN',           // A
            'Mata Pelajaran', // B
            'Nilai Ujian',    // C
            'Nilai Sekolah',  // D
            'Nilai Akhir',    // E
            'Catatan'         // F
        ];

        $filename = 'template_nilai_' . date('Ymd') . '.xlsx';
        $path = storage_path('app/public/' . $filename);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // === Set header ===
        foreach ($headers as $idx => $header) {
            $col = chr(65 + $idx); // A, B, C, ...
            $sheet->setCellValue("{$col}1", $header);
            $sheet->getStyle("{$col}1")->getFont()->setBold(true);
        }

        // === Isi data NIS di kolom A ===
        $row = 2;
        foreach ($students as $nis) {
            $sheet->setCellValue("A{$row}", $nis);
            $row++;
        }

        // === Format angka untuk nilai ===
        $sheet->getStyle('C:E')->getNumberFormat()
            ->setFormatCode('0.00'); // 2 desimal

        // Auto size kolom
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // === Simpan file ===
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }

    public function index()
    {
        $grades = Grade::with('student')->whereHas('student.graduationPeriod', function ($query) {
                        $query->where('is_active', 1);
                    })
                ->latest()->paginate(10);
        return view('admin.grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::all();
        return view('admin.grades.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'mata_pelajaran' => 'required',
            'nilai_akhir' => 'required|numeric|min:0|max:100',
            'nilai_ujian' => 'nullable|numeric|min:0|max:100',
            'nilai_sekolah' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        Grade::create($validated);

        // Update nilai rata-rata siswa
        $student = Student::find($request->student_id);
        $avgGrade = $student->grades()->avg('nilai_akhir');
        $student->update(['nilai_rata_rata' => $avgGrade]);

        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $grade = Grade::with('student')->findOrFail($id);
        return view('admin.grades.show', compact('grade'));
    }

    public function edit(string $id)
    {
        $grade = Grade::findOrFail($id);
        $students = Student::all();
        return view('admin.grades.edit', compact('grade', 'students'));
    }

    public function update(Request $request, string $id)
    {
        $grade = Grade::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'mata_pelajaran' => 'required',
            'nilai_akhir' => 'required|numeric|min:0|max:100',
            'nilai_ujian' => 'nullable|numeric|min:0|max:100',
            'nilai_sekolah' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        $grade->update($validated);

        // Update nilai rata-rata siswa
        $student = Student::find($request->student_id);
        $avgGrade = $student->grades()->avg('nilai_akhir');
        $student->update(['nilai_rata_rata' => $avgGrade]);

        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $grade = Grade::findOrFail($id);
        $student_id = $grade->student_id;
        $grade->delete();

        // Update nilai rata-rata siswa
        $student = Student::find($student_id);
        $avgGrade = $student->grades()->avg('nilai_akhir');
        $student->update(['nilai_rata_rata' => $avgGrade]);

        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $errors = [];
        $grades = [];

        foreach ($rows as $index => $row) {
            if ($index == 1) continue; // skip header

            $nis            = trim($row['A']);
            $mataPelajaran  = trim($row['B']);
            $nilaiUjian     = $row['C'];
            $nilaiSekolah   = $row['D'];
            $nilaiAkhir     = $row['E'];
            $catatan        = $row['F'] ?? null;

            // skip baris kosong
            if (empty($nis) && empty($mataPelajaran)) continue;

            // validasi nis
            $student = Student::where('nis', $nis)->first();
            if (!$student) {
                $errors[] = "Baris {$index} → NIS <b>{$nis}</b> tidak ditemukan";
                continue;
            }

            $grades[] = [
                'student_id'     => $student->id,
                'mata_pelajaran' => $mataPelajaran,
                'nilai_ujian'    => $nilaiUjian,
                'nilai_sekolah'  => $nilaiSekolah,
                'nilai_akhir'    => $nilaiAkhir,
                'catatan'        => $catatan,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        // kalau ada error, batalkan semua
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        // kalau aman, simpan dalam transaction
        DB::transaction(function () use ($grades) {
            Grade::insert($grades);
        });

        return redirect()->back()->with('success', 'Import nilai berhasil disimpan.');
    }


}
