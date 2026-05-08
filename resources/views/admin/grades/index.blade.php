@section('title', 'Data Nilai')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Nilai</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                <span class="material-icons-round font25 mt-2 text-white opacity-10">grade</span>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Data Nilai Siswa</p>
                <h4 class="mb-0">{{ $grades->total() }} Nilai</h4>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <div class="px-3 pt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('admin.grades.create') }}" class="btn bg-gradient-danger">
                                <span class="material-icons-round text-sm">add</span>&nbsp;&nbsp;Tambah Nilai
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#importModal">
                                <span class="material-icons-round text-sm">upload</span>&nbsp;&nbsp;Import
                            </button>
                        </div>
                    </div>
                </div>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Siswa</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mata Pelajaran</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Ujian</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Sekolah</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Akhir</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $grade)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $grade->student->nama }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $grade->student->nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $grade->mata_pelajaran }}</p>
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
                            <td class="align-middle">
                                <a  href="{{ route('admin.grades.show', $grade) }}"
                                    class="btn btn-sm bg-success text-white font-weight-bold text-xs"
                                    data-bs-toggle="tooltip" data-bs-title="Detail Nilai" data-bs-placement="left">
                                    <span class="material-icons-round opacity-10 text-sm">visibility</span>
                                </a>
                                <a  href="{{ route('admin.grades.edit', $grade) }}"
                                    class="btn btn-sm bg-info text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-bs-title="Edit nilai" data-bs-placement="top">
                                    <span class="material-icons-round opacity-10 text-sm">edit</span>
                                </a>
                                <a  href="javascript:void(0)"
                                    class="btn btn-sm bg-danger text-white font-weight-bold text-xs" onclick="confirmDelete({{ $grade->id }})"
                                    data-bs-toggle="tooltip" data-bs-title="Hapus nilai" data-bs-placement="right">
                                    <span class="material-icons-round opacity-10 text-sm">delete</span>
                                </a>
                                <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" id="delete-form-{{$grade->id}}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <span class="badge badge-md bg-gradient-warning">---Tidak Ada siswa dengan nilai pada periode aktif saat ini---</span>
                                <br>
                                <a href="{{ route('admin.graduation-periods.index') }}" class="btn bg-gradient-warning text-white mt-2"> Ganti Periode</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-3 pt-4">
                    {{ $grades->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="importModalLabel">Import Data Nilai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.grades.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info text-white">
                            <i class="material-icons-round">info</i>
                            Silakan unduh template berikut dan isi sesuai format yang ditentukan.
                        </div>

                        <a href="{{ route('admin.grades.template') }}" class="btn bg-gradient-info btn-block mb-3">
                            <span class="material-icons-round text-sm">download</span>&nbsp;&nbsp;Unduh Template Excel
                        </a>

                        <div class="card mb-3">
                            <div class="card-header p-3 pt-2">
                                <h6 class="mb-0">Format Data</h6>
                            </div>
                            <div class="card-body p-3 pt-0">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Kolom</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm">
                                            <tr>
                                                <td>NISN</td>
                                                <td>NISN siswa (wajib)</td>
                                            </tr>
                                            <tr>
                                                <td>Mata Pelajaran</td>
                                                <td>Nama mata pelajaran (wajib)</td>
                                            </tr>
                                            <tr>
                                                <td>Nilai Ujian</td>
                                                <td>Nilai ujian (0-100)</td>
                                            </tr>
                                            <tr>
                                                <td>Nilai Sekolah</td>
                                                <td>Nilai sekolah (0-100)</td>
                                            </tr>
                                            <tr>
                                                <td>Nilai Akhir</td>
                                                <td>Nilai akhir (0-100, wajib)</td>
                                            </tr>
                                            <tr>
                                                <td>Catatan</td>
                                                <td>Catatan tambahan (opsional)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        </div>
                        <small class="text-muted">Format file: XLSX, XLS, atau CSV</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('custom_js')
<script>
    // Fungsi untuk konfirmasi hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Nilai akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
</x-layouts.admin-layout>
