@section('title', 'Detail Siswa')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.students.index') }}">Daftar Siswa</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Siswa</li>
@endsection

<x-layouts.admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Detail Siswa</h6>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">NIS</h6>
                                <h6 class="mb-0">{{ $student->nis }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Nama Lengkap</h6>
                                <h6 class="mb-0">{{ $student->nama }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Kelas</h6>
                                <h6 class="mb-0">{{ $student->schoolClass->nama_kelas }} - {{ $student->schoolClass->jurusan }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Status</h6>
                                <span class="badge badge-sm bg-gradient-{{ $student->status === 'LULUS' ? 'success' : 'danger' }}">{{ $student->status }}</span>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Nilai Rata-rata</h6>
                                <h6 class="mb-0">{{ number_format($student->nilai_rata_rata, 2) }}</h6>
                            </div>
                            <div class="list-group-item mt-3">
                                <h6 class="mb-0 text-sm text-secondary">Periode Kelulusan</h6>
                                <h6 class="mb-0">{{ $student->graduationPeriod->tahun_ajaran }} - {{ $student->graduationPeriod->semester }}</h6>
                            </div>
                        </div>
                    </div>

                    @if($student->catatan)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="list-group-item">
                                <h6 class="mb-0 text-sm text-secondary">Catatan</h6>
                                <p class="text-sm mb-0">{{ $student->catatan }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Daftar Nilai</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mata Pelajaran</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Ujian</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Sekolah</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($student->grades as $grade)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $grade->mata_pelajaran }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ number_format($grade->nilai_ujian, 2) }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ number_format($grade->nilai_sekolah, 2) }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ number_format($grade->nilai_akhir, 2) }}</p>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada nilai</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('admin.students.edit', $student) }}" class="btn bg-gradient-info">Edit</a>
                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn bg-gradient-danger btn-delete">Hapus</button>
                            </form>
                            <a href="{{ route('admin.students.index') }}" class="btn bg-gradient-secondary">Kembali</a>
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
                text: "Data siswa akan dihapus secara permanen!",
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
