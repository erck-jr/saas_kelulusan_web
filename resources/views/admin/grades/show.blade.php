@section('title', 'Detail Nilai')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.grades.index') }}">Data Nilai</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Nilai</li>
@endsection

<x-layouts.admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-danger shadow-danger border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Detail Nilai</h6>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Siswa</h6>
                                <h6 class="mb-0">{{ $grade->student->nama }}</h6>
                                <p class="text-xs text-secondary mb-0">NIS: {{ $grade->student->nis }}</p>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Kelas</h6>
                                <h6 class="mb-0">{{ $grade->student->schoolClass->nama_kelas }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Mata Pelajaran</h6>
                                <h6 class="mb-0">{{ $grade->mata_pelajaran }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Nilai Ujian</h6>
                                <h6 class="mb-0">{{ number_format($grade->nilai_ujian, 2) }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Nilai Sekolah</h6>
                                <h6 class="mb-0">{{ number_format($grade->nilai_sekolah, 2) }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Nilai Akhir</h6>
                                <h6 class="mb-0">{{ number_format($grade->nilai_akhir, 2) }}</h6>
                            </div>
                        </div>
                    </div>

                    @if($grade->catatan)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Catatan</h6>
                                <p class="text-sm mb-0">{{ $grade->catatan }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('admin.grades.edit', $grade) }}" class="btn bg-gradient-danger">Edit</a>
                            <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn bg-gradient-danger btn-delete">Hapus</button>
                            </form>
                            <a href="{{ route('admin.grades.index') }}" class="btn bg-gradient-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // SweetAlert Delete Confirmation
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data nilai akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    </script>
    @endpush
</x-layouts.admin-layout>
