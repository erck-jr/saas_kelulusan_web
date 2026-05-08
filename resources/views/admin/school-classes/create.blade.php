@section('title', 'Tambah Kelas')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.school-classes.index') }}">Daftar Kelas</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Kelas</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <span class="material-icons-round font25 mt-2 text-white opacity-10">add_home</span>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Tambah Kelas Baru</p>
                <h4 class="mb-0">Form Input Data</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.school-classes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas') }}">
                            @error('nama_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" value="{{ old('jurusan') }}">
                            @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Tingkat</label>
                            <input type="text" name="tingkat" class="form-control @error('tingkat') is-invalid @enderror" value="{{ old('tingkat') }}">
                            @error('tingkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Wali Kelas</label>
                            <input type="text" name="wali_kelas" class="form-control @error('wali_kelas') is-invalid @enderror" value="{{ old('wali_kelas') }}">
                            @error('wali_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
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
                    <div class="col-md-12">
                        <button type="submit" class="btn bg-gradient-success">Simpan</button>
                        <a href="{{ route('admin.school-classes.index') }}" class="btn bg-gradient-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin-layout>
