@section('title', 'Edit Siswa')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.students.index') }}">Daftar Siswa</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Siswa</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons-round opacity-10">edit</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Edit Data Siswa</p>
                <h4 class="mb-0">{{ $student->nama }}</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $student->nis) }}">
                            @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $student->nama) }}">
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-4">
                            <label for="school_class_id" class="ms-0">Kelas</label>
                            <select class="form-control @error('school_class_id') is-invalid @enderror" name="school_class_id" id="school_class_id">
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('school_class_id', $student->school_class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->nama_kelas }} - {{ $class->jurusan }}
                                </option>
                                @endforeach
                            </select>
                            @error('school_class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-4">
                            <label for="graduation_period_id" class="ms-0">Periode Kelulusan</label>
                            <select class="form-control @error('graduation_period_id') is-invalid @enderror" name="graduation_period_id" id="graduation_period_id">
                                <option value="">Pilih Periode</option>
                                @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ old('graduation_period_id', $student->graduation_period_id) == $period->id ? 'selected' : '' }}>
                                    {{ $period->tahun_ajaran }} - {{ $period->semester }}
                                </option>
                                @endforeach
                            </select>
                            @error('graduation_period_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 my-4">
                        <div class="form-check form-switch">
                            <label for="status" class="form-label font-weight-bold badge {{ $student->status === 'LULUS' ? 'bg-success' : 'bg-danger'}} text-sm p-1 text-white" id="status-label">
                            {{ $student->status }}</label>
                            <input type="checkbox" class="form-check-input" name="status" id="status-check" {{ $student->status === 'LULUS' ? 'checked' : ''}} />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline mb-4">
                            <label class="form-label">Nilai Rata-rata</label>
                            <input type="number" step="0.01" name="nilai_rata_rata" class="form-control @error('nilai_rata_rata') is-invalid @enderror" value="{{ old('nilai_rata_rata', $student->nilai_rata_rata) }}">
                            @error('nilai_rata_rata')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline mb-4">
                            <textarea class="form-control @error('catatan') is-invalid @enderror" rows="4" name="catatan" placeholder="Catatan (opsional)">{{ old('catatan', $student->catatan) }}</textarea>
                            @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn bg-gradient-info">Update</button>
                        <a href="{{ route('admin.students.index') }}" class="btn bg-gradient-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@section('custom_js')
<script>
    $('#status-check').on('change', function() {

        // Check if the checkbox is currently checked
        if ($(this).is(':checked')) {
            $('#status-label').text("LULUS");
            $('#status-label').removeClass('bg-danger').addClass('bg-success');
        } else {
            $('#status-label').text("TIDAK LULUS");
            $('#status-label').removeClass('bg-success').addClass('bg-danger');
        }
  });
</script>
@endsection
</x-layouts.admin-layout>
