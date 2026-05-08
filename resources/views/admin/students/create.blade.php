@section('title', 'Tambah Siswa')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.students.index') }}">Daftar Siswa</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Siswa</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <span class="material-icons-round font25 mt-2 text-white opacity-10">person_add</span>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Tambah Siswa Baru</p>
                <h4 class="mb-0">Form Input Data</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}">
                            @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
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
                                <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
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
                                <option value="{{ $period->id }}" {{ old('graduation_period_id') == $period->id ? 'selected' : '' }}>
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
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nilai Rata-Rata</label>
                            <input type="numeric" name="nilai_rata_rata" class="form-control @error('nilai_rata_rata') is-invalid @enderror" value="{{ old('nilai_rata_rata') }}">
                            @error('nilai_rata_rata')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 my-4">
                        <div class="form-check form-switch">
                            <label for="status" class="form-label font-weight-bold badge bg-danger text-sm p-1 text-white" id="status-label">
                            TIDAK LULUS</label>
                            <input type="checkbox" class="form-check-input" name="status" id="status-check"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline mb-4">
                            <textarea class="form-control @error('catatan') is-invalid @enderror" rows="4" name="catatan" placeholder="Catatan (opsional)">{{ old('catatan') }}</textarea>
                            @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn bg-gradient-info">Simpan</button>
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
