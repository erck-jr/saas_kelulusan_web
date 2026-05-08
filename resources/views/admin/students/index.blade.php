@section('title', 'Daftar Siswa')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Siswa</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <span class="material-icons-round font25 mt-2 text-white opacity-10">people</span>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Daftar Siswa</p>
                <h4 class="mb-0">{{ $students->total() }} Siswa</h4>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <div class="px-3 pt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('admin.students.create') }}" class="btn bg-gradient-info">
                                <i class="material-icons-round text-sm">add</i>&nbsp;&nbsp;Tambah Siswa
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#importModal">
                                <span class="material-icons-round text-sm">upload</span>&nbsp;&nbsp;Import Siswa
                            </button>
                        </div>
                    </div>
                </div>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIS</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kelas</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Rata-rata</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
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
                                <p class="text-xs font-weight-bold mb-0">{{ $student->schoolClass->nama_kelas }}</p>
                            </td>
                            <td>
                                <span class="badge badge-sm bg-gradient-{{ $student->status === 'LULUS' ? 'success' : 'danger' }}">{{ $student->status }}</span>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ number_format($student->nilai_rata_rata, 2) }}</p>
                            </td>
                            <td class="align-middle">
                                <a  href="{{ route('admin.students.show', $student) }}"
                                    class="btn btn-sm bg-success text-white font-weight-bold text-xs"
                                    data-bs-toggle="tooltip" data-bs-title="Detail Siswa" data-bs-placement="left">
                                    <span class="material-icons-round opacity-10 text-sm">visibility</span>
                                </a>
                                <a  href="{{ route('admin.students.edit', $student) }}"
                                    class="btn btn-sm bg-info text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-bs-title="Edit Siswa" data-bs-placement="top">
                                    <span class="material-icons-round opacity-10 text-sm">edit</span>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-sm bg-danger text-white font-weight-bold text-xs" onclick="confirmDelete({{ $student->id }})"
                                        data-bs-toggle="tooltip" data-bs-title="Hapus Siswa" data-bs-placement="right">
                                        <span class="material-icons-round opacity-10 text-sm">delete</span>
                                    </a>
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" id="delete-form-{{$student->id}}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                            <td colspan="6" class="text-center">
                                <span class="badge badge-md bg-gradient-warning">---Tidak Ada Siswa pada periode aktif saat ini---</span>
                                <br>
                                <a href="{{ route('admin.graduation-periods.index') }}" class="btn bg-gradient-warning text-white mt-2"> Ganti Periode</a>
                            </td>
                        @endforelse
                    </tbody>
                </table>
                <nav aria-label="Student pagination">
                    {{ $students->links('pagination::bootstrap-5') }}
                </nav>
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
            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info text-white">
                        <i class="material-icons-round">info</i>
                        Silakan unduh template berikut dan isi sesuai format yang ditentukan.
                    </div>

                    <a href="{{ route('admin.students.template') }}" class="btn bg-gradient-info btn-block mb-3">
                        <span class="material-icons-round text-sm">download</span>&nbsp;&nbsp;Unduh Template Excel
                    </a>

                    <div class="card bg-gradient-warning mb-3">
                            <div class="card-header bg-transparant p-3 pt-2">
                                <h6 class="mb-0">Perhatian !!</h6>
                            </div>
                            <div class="card-body p-3 pt-0">
                                <span class="text-white">Pastikan Sudah menghapus semua baris petunjuk pada template excel sebelum import</span>
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
@if (session('error'))
        <script>
            $(document).ready(function() {
                $('#importModal').modal('hide'); // For Bootstrap modals
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan!',
                    text: `{{ session('error') }}`,
                    showCancelButton: false, // Hide the cancel button
                    confirmButtonText: 'OK' // Text for the confirm button
                });
            });
        </script>
 @endif
<script>
    // Fungsi untuk konfirmasi hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Siswa akan dihapus permanen!",
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
