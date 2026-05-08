@section('title', 'Detail Periode Kelulusan')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.graduation-periods.index') }}">Daftar Periode Kelulusan</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Periode</li>
@endsection

<x-layouts.admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-warning shadow-warning border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Detail Periode Kelulusan</h6>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Tahun Ajaran</h6>
                                <h6 class="mb-0">{{ $period->tahun_ajaran }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Semester</h6>
                                <h6 class="mb-0">{{ $period->semester }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Tanggal Pengumuman</h6>
                                <h6 class="mb-0">{{ $period->tanggal_pengumuman->format('d F Y') }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Status</h6>
                                <span class="badge badge-sm bg-gradient-{{ $period->is_active ? 'success' : 'secondary' }}">
                                    {{ $period->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Jumlah Kelas</h6>
                                <h6 class="mb-0">{{ $period->schoolClasses->count() }} Kelas</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Jumlah Siswa</h6>
                                <h6 class="mb-0">{{ $period->students->count() }} Siswa</h6>
                            </div>
                        </div>
                    </div>

                    @if($period->keterangan)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Keterangan</h6>
                                <p class="text-sm mb-0">{{ $period->keterangan }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Daftar Kelas</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Kelas</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jurusan</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Wali Kelas</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Siswa</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($period->schoolClasses as $class)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $class->nama_kelas }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $class->jurusan }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $class->wali_kelas }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $class->students->count() }} Siswa</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.school-classes.show', $class) }}" class="text-secondary font-weight-bold text-xs">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada kelas untuk periode ini</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('admin.graduation-periods.edit', $period) }}" class="btn bg-gradient-warning">Edit</a>
                            <form action="{{ route('admin.graduation-periods.destroy', $period) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn bg-gradient-danger btn-delete">Hapus</button>
                            </form>
                            <a href="{{ route('admin.graduation-periods.index') }}" class="btn bg-gradient-secondary">Kembali</a>
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
                text: "Data periode kelulusan akan dihapus secara permanen!",
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
