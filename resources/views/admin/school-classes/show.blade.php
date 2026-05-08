@section('title', 'Detail Kelas')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.school-classes.index') }}">Daftar Kelas</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Kelas</li>
@endsection

<x-layouts.admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Detail Kelas</h6>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Nama Kelas</h6>
                                <h6 class="mb-0">{{ $class->nama_kelas }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Jurusan</h6>
                                <h6 class="mb-0">{{ $class->jurusan }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Tingkat</h6>
                                <h6 class="mb-0">{{ $class->tingkat }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Wali Kelas</h6>
                                <h6 class="mb-0">{{ $class->wali_kelas }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Periode Kelulusan</h6>
                                <h6 class="mb-0">{{ $class->graduationPeriod->tahun_ajaran }} - {{ $class->graduationPeriod->semester }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Jumlah Siswa</h6>
                                <h6 class="mb-0">{{ $class->students->count() }} Siswa</h6>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Daftar Siswa</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIS</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Rata-rata</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($class->students as $student)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $student->nis }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $student->nama }}</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-{{ $student->status === 'LULUS' ? 'success' : 'danger' }}">{{ $student->status }}</span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ number_format($student->nilai_rata_rata, 2) }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.students.show', $student) }}" class="text-secondary font-weight-bold text-xs">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada siswa di kelas ini</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('admin.school-classes.edit', $class) }}" class="btn bg-gradient-success">Edit</a>
                            <form action="{{ route('admin.school-classes.destroy', $class) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn bg-gradient-danger btn-delete">Hapus</button>
                            </form>
                            <a href="{{ route('admin.school-classes.index') }}" class="btn bg-gradient-secondary">Kembali</a>
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
                text: "Data kelas akan dihapus secara permanen!",
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
