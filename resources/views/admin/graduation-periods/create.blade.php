@section('title', 'Tambah Periode Kelulusan')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.graduation-periods.index') }}">Daftar Periode Kelulusan</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Periode</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                <span class="material-icons-round font25 mt-2 text-white opacity-10">event_available</span>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Tambah Periode Kelulusan</p>
                <h4 class="mb-0">Form Input Data</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.graduation-periods.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" value="{{ old('tahun_ajaran') }}">
                            @error('tahun_ajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-4">
                            <label for="semester" class="ms-0">Semester</label>
                            <select class="form-control @error('semester') is-invalid @enderror" name="semester" id="semester">
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-4">
                            <label class="ms-0">Tanggal Pengumuman</label>
                            <input type="date" name="tanggal_pengumuman" class="form-control @error('tanggal_pengumuman') is-invalid @enderror" value="{{ old('tanggal_pengumuman') }}">
                            @error('tanggal_pengumuman')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktifkan Periode Ini</label>
                            @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline mb-4">
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="4" name="keterangan" placeholder="Keterangan (opsional)">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn bg-gradient-warning">Simpan</button>
                        <a href="{{ route('admin.graduation-periods.index') }}" class="btn bg-gradient-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin-layout>
