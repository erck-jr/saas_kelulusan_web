@section('title', 'Daftar Kelas')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Kelas</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <span class="material-icons-round font25 mt-2 text-white opacity-10">school</span>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Daftar Kelas</p>
                <h4 class="mb-0">{{ $classes->total() }} Kelas</h4>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <div class="px-3 pt-3">
                    <a href="{{ route('admin.school-classes.create') }}" class="btn bg-gradient-success">
                        <span class="material-icons-round text-sm">add</span>&nbsp;&nbsp;Tambah Kelas
                    </a>
                </div>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Kelas</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jurusan</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tingkat</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Wali Kelas</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Periode</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
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
                                <p class="text-xs font-weight-bold mb-0">{{ $class->tingkat }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $class->wali_kelas }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $class->graduationPeriod->tahun_ajaran }} - {{ $class->graduationPeriod->semester }}</p>
                            </td>
                            <td class="align-middle">
                                <a  href="{{ route('admin.school-classes.show', $class) }}"
                                    class="btn btn-sm bg-success text-white font-weight-bold text-xs"
                                    data-bs-toggle="tooltip" data-bs-title="Detail kelas" data-bs-placement="left">
                                    <span class="material-icons-round opacity-10 text-sm">visibility</span>
                                </a>
                                <a  href="{{ route('admin.school-classes.edit', $class) }}"
                                    class="btn btn-sm bg-info text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-bs-title="Edit kelas" data-bs-placement="top">
                                    <span class="material-icons-round opacity-10 text-sm">edit</span>
                                </a>
                                <a  href="javascript:void(0)"
                                    class="btn btn-sm bg-danger text-white font-weight-bold text-xs" onclick="confirmDelete({{ $class->id }})"
                                    data-bs-toggle="tooltip" data-bs-title="Hapus Kelas" data-bs-placement="right">
                                    <span class="material-icons-round opacity-10 text-sm">delete</span>
                                </a>
                                <form action="{{ route('admin.school-classes.destroy', $class) }}" method="POST" id="delete-form-{{$class->id}}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <span class="badge badge-md bg-gradient-warning">---Tidak Ada Kelas pada periode aktif saat ini---</span>
                                <br>
                                <a href="{{ route('admin.graduation-periods.index') }}" class="btn bg-gradient-warning text-white mt-2"> Ganti Periode</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-3 pt-4">
                    {{ $classes->links() }}
                </div>
            </div>
        </div>
    </div>

@section('custom_js')
<script>
    // Fungsi untuk konfirmasi hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Kelas akan dihapus permanen!",
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
