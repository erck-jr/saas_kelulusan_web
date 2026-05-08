<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\GraduationPeriod;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class StudentController extends Controller
{
    public function template()
    {
        $classes_ids = SchoolClass::whereHas('graduationPeriod', function ($query) {
                            $query->where('is_active', 1);
                        })->pluck('nama_kelas','id');
        $gp_id = GraduationPeriod::where('is_active', true)->first();

        if ($classes_ids->count() == 0) {
            return redirect()->route('admin.students.index')
                    ->with('error', "Belum ada kelas pada periode aktif ini, tambahkan kelas terlebih dahulu");
        }

        $headers = [
            'NIS',
            'Nama Lengkap',
            'ID Kelas',
            'ID Periode Kelulusan',
            'Nilai Rata-Rata',
            'Status',
            'Catatan (Optional)'
        ];

        // Create a new temp file
        $filename = 'template_siswa_' . date('Ymd') . '.xlsx';
        $path = storage_path('app/public/' . $filename);

        // Create Excel file with headers
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        foreach ($headers as $idx => $header) {
            $col = chr(65 + $idx);
            $sheet->setCellValue("{$col}1", $header);
            $sheet->getStyle("{$col}1")->getFont()->setBold(true);
        }

        // Example data (urutan sesuai header!)
        $sheet->fromArray([
            ['2023001', 'Siswa Contoh 1', $classes_ids->keys()->first(), $gp_id->id, '82.5', 'LULUS', 'Prestasi baik'],
            ['2023002', 'Siswa Contoh 2', $classes_ids->keys()->first(), $gp_id->id, '65.0', 'TIDAK LULUS', 'Perlu perbaikan'],
        ], null, 'A2');

        // Auto size columns (A–G)
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // === Dropdown untuk ID Kelas (C2:C500) ===
        $kelasValidation = new DataValidation();
        $kelasValidation->setType(DataValidation::TYPE_LIST);
        $kelasValidation->setErrorStyle(DataValidation::STYLE_STOP);
        $kelasValidation->setAllowBlank(false);
        $kelasValidation->setShowDropDown(true);
        $kelasValidation->setFormula1('"' . implode(',', $classes_ids->keys()->toArray()) . '"');
        $sheet->setDataValidation("C2:C500", $kelasValidation);

        // === Dropdown untuk ID graduation periode (D2:D500) ===
        $gpValidation = new DataValidation();
        $gpValidation->setType(DataValidation::TYPE_LIST);
        $gpValidation->setErrorStyle(DataValidation::STYLE_STOP);
        $gpValidation->setAllowBlank(false);
        $gpValidation->setShowDropDown(true);
        $gpValidation->setFormula1('"' .$gp_id->id. '"');
        $sheet->setDataValidation("D2:D500", $gpValidation);

        // === Dropdown untuk Status (F2:F500) ===
        $statusValidation = new DataValidation();
        $statusValidation->setType(DataValidation::TYPE_LIST);
        $statusValidation->setErrorStyle(DataValidation::STYLE_STOP);
        $statusValidation->setAllowBlank(false);
        $statusValidation->setShowDropDown(true);
        $statusValidation->setFormula1('"LULUS,TIDAK LULUS"');
        $sheet->setDataValidation("F2:F500", $statusValidation);

        // Add notes/instructions
        $row = $sheet->getHighestRow() + 2;
        $sheet->setCellValue("A{$row}", 'Hapus Semua Data Petunjuk ini ketika akan diupload'); $row++;
        $sheet->setCellValue("A{$row}", 'PETUNJUK:'); $row++;
        $sheet->setCellValue("A{$row}", '- ID Periode Kelulusan: '.$gp_id->tahun_ajaran.' (id: '.$gp_id->id.')'); $row++;
        $sheet->setCellValue("A{$row}", '- ID Kelas: Lihat daftar kelas berikut'); $row++;

        foreach ($classes_ids as $id => $value) {
            $sheet->setCellValue("A{$row}", "Kelas {$value} - id: {$id}");
            $row++;
        }

        $sheet->setCellValue("A{$row}", '- NIS harus unik dan tidak boleh duplikat'); $row++;
        $sheet->setCellValue("A{$row}", '- Nilai Rata-rata dalam format angka desimal (misal: 82.5)'); $row++;
        $sheet->setCellValue("A{$row}", '- Status hanya bisa dipilih: LULUS atau TIDAK LULUS');

        // Save file
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }

    public function index()
    {
        $students = Student::whereHas('graduationPeriod', function ($query) {
                        $query->where('is_active', 1);
                    })
                    ->latest()->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $periods = GraduationPeriod::all();
        return view('admin.students.create', compact('classes', 'periods'));
    }

    public function store(Request $request)
        {
            $validated = $request->validate([
                'nis' => 'required|unique:students',
                'nama' => 'required',
                'school_class_id' => 'required|exists:school_classes,id',
                'graduation_period_id' => 'required|exists:graduation_periods,id',
                'nilai_rata_rata' => 'nullable|numeric',
                'catatan' => 'nullable|string'
            ]);
            if($request->has('status')){
                $validated['status'] = 'LULUS';
            }else{
                $validated['status'] = 'TIDAK LULUS';
            }

            Student::create($validated);
            return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil ditambahkan');
        }

        public function show(string $id)
        {
            $student = Student::with(['schoolClass', 'graduationPeriod', 'grades'])->findOrFail($id);
            return view('admin.students.show', compact('student'));
        }

        public function edit(string $id)
        {
            $student = Student::findOrFail($id);
            $classes = SchoolClass::all();
            $periods = GraduationPeriod::all();
            return view('admin.students.edit', compact('student', 'classes', 'periods'));
        }

        public function update(Request $request, string $id)
        {
            $student = Student::findOrFail($id);

            $validated = $request->validate([
                'nis' => 'required|unique:students,nis,' . $id,
                'nama' => 'required',
                'school_class_id' => 'required|exists:school_classes,id',
                'graduation_period_id' => 'required|exists:graduation_periods,id',
                'nilai_rata_rata' => 'nullable|numeric',
                'catatan' => 'nullable|string'
            ]);
            if($request->has('status')){
                $validated['status'] = 'LULUS';
            }else{
                $validated['status'] = 'TIDAK LULUS';
            }

            $student->update($validated);
            return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diupdate');
        }

        public function destroy(string $id)
        {
            $student = Student::findOrFail($id);
            $student->delete();
            return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus');
        }

    public function import(Request $request)
    {
        // Validasi file upload
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.students.index')
                ->with('error', 'File tidak valid. Pastikan file berformat .xlsx atau .xls dan maksimal 2MB');
        }

        try {
            $file = $request->file('file');
            $path = $file->getRealPath();

            // Load spreadsheet
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Remove header row
            array_shift($data);

            // Filter empty rows
            $data = array_filter($data, function($row) {
                return !empty(array_filter($row));
            });

            if (empty($data)) {
                return redirect()->route('admin.students.index')
                    ->with('error', 'File tidak memiliki data untuk diimport');
            }

            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            $nisList = []; // untuk validasi duplikat dalam file

            DB::beginTransaction();

            foreach ($data as $index => $row) {
                $rowNumber = $index + 2; // +2 karena index dimulai dari 0 dan header di row 1

                // Mapping data sesuai template
                $rowData = [
                    'nis' => trim($row[0] ?? ''),
                    'nama' => trim($row[1] ?? ''),
                    'school_class_id' => trim($row[2] ?? ''),
                    'graduation_period_id' => trim($row[3] ?? ''),
                    'nilai_rata_rata' => !empty(trim($row[4] ?? '')) ? floatval(trim($row[4])) : null,
                    'status' => strtoupper(trim($row[5] ?? '')),
                    'catatan' => trim($row[6] ?? '') ?: null
                ];

                // Cek duplikat NIS dalam file
                if (in_array($rowData['nis'], $nisList)) {
                    $errorCount++;
                    $errors[] = "Baris {$rowNumber}: NIS duplikat dalam file";
                    continue;
                }
                $nisList[] = $rowData['nis'];

                // Validasi data sesuai model Student
                $rowValidator = Validator::make($rowData, [
                    'nis' => 'required|unique:students',
                    'nama' => 'required',
                    'school_class_id' => 'required|exists:school_classes,id',
                    'graduation_period_id' => 'required|exists:graduation_periods,id',
                    'nilai_rata_rata' => 'nullable|numeric',
                    'status' => 'required|in:LULUS,TIDAK LULUS',
                    'catatan' => 'nullable|string'
                ]);

                if ($rowValidator->fails()) {
                    $errorCount++;
                    $errorMessages = [];
                    foreach ($rowValidator->errors()->toArray() as $field => $messages) {
                        $errorMessages[] = implode(', ', $messages);
                    }
                    $errors[] = "Baris {$rowNumber}: " . implode(' | ', $errorMessages);
                    continue;
                }

                try {
                    // Create student menggunakan model Student
                    Student::create([
                        'nis' => $rowData['nis'],
                        'nama' => $rowData['nama'],
                        'school_class_id' => $rowData['school_class_id'],
                        'graduation_period_id' => $rowData['graduation_period_id'],
                        'nilai_rata_rata' => $rowData['nilai_rata_rata'],
                        'status' => $rowData['status'],
                        'catatan' => $rowData['catatan']
                    ]);

                    $successCount++;

                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = "Baris {$rowNumber}: Gagal menyimpan data - " . $e->getMessage();
                }
            }

            if ($errorCount === 0) {
                DB::commit();
                return redirect()->route('admin.students.index')
                    ->with('success', "Berhasil mengimport {$successCount} data siswa");
            } else {
                DB::rollback();
                $errorMessage = "Import gagal. {$errorCount} baris error dari total " . ($successCount + $errorCount) . " baris.\n\n";
                $errorMessage .= implode("\n", array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $errorMessage .= "\n... dan " . (count($errors) - 5) . " error lainnya";
                }

                return redirect()->route('admin.students.index')
                    ->with('error', $errorMessage);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.students.index')
                ->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }


    public function export()
    {
        // Export logic will be implemented later
        return response()->download('path/to/exported/file.xlsx');
    }
}
