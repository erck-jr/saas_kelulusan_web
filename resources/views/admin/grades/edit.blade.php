@section('title', 'Edit Nilai')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.grades.index') }}">Data Nilai</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Nilai</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                <span class="material-icons-round font25 mt-2 text-white opacity-10">edit</span>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Edit Data Nilai</p>
                <h4 class="mb-0">{{ $grade->student->nama }}</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.grades.update', $grade) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-4">
                            <label for="student_id" class="ms-0">Siswa</label>
                            <select class="form-control @error('student_id') is-invalid @enderror" name="student_id" id="student_id">
                                <option value="">Pilih Siswa</option>
                                @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id', $grade->student_id) == $student->id ? 'selected' : '' }}>
                                    {{ $student->nis }} - {{ $student->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" class="form-control @error('mata_pelajaran') is-invalid @enderror" value="{{ old('mata_pelajaran', $grade->mata_pelajaran) }}">
                            @error('mata_pelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nilai Ujian</label>
                            <input type="number" step="0.01" name="nilai_ujian" class="form-control @error('nilai_ujian') is-invalid @enderror" value="{{ old('nilai_ujian', $grade->nilai_ujian) }}">
                            @error('nilai_ujian')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nilai Sekolah</label>
                            <input type="number" step="0.01" name="nilai_sekolah" class="form-control @error('nilai_sekolah') is-invalid @enderror" value="{{ old('nilai_sekolah', $grade->nilai_sekolah) }}">
                            @error('nilai_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nilai Akhir</label>
                            <input type="number" step="0.01" name="nilai_akhir" class="form-control @error('nilai_akhir') is-invalid @enderror" value="{{ old('nilai_akhir', $grade->nilai_akhir) }}">
                            @error('nilai_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline mb-4">
                            <textarea class="form-control @error('catatan') is-invalid @enderror" rows="4" name="catatan" placeholder="Catatan (opsional)">{{ old('catatan', $grade->catatan) }}</textarea>
                            @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn bg-gradient-danger">Update</button>
                        <a href="{{ route('admin.grades.index') }}" class="btn bg-gradient-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin-layout>
