@section('title', 'Daftar Periode Kelulusan')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Daftar Periode Kelulusan</li>
@endsection

<x-layouts.admin-layout>
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                <span class="material-icons-round font25 mt-2 text-white opacity-10">event</span>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Daftar Periode Kelulusan</p>
                <h4 class="mb-0">{{ $periods->total() }} Periode</h4>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <div class="px-3 pt-3">
                    <a href="{{ route('admin.graduation-periods.create') }}" class="btn bg-gradient-warning">
                        <span class="material-icons-round text-sm">add</span>&nbsp;&nbsp;Tambah Periode
                    </a>
                </div>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tahun Ajaran</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Semester</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Pengumuman</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periods as $period)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $period->tahun_ajaran }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $period->semester }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">
                                    {{ $period->tanggal_pengumuman->format('d F Y') }} 
                                    {{ $period->jam_pengumuman ? \Carbon\Carbon::parse($period->jam_pengumuman)->format('H:i') : '00:00' }} WIB
                                </p>
                            </td>
                            <td>
                                <span class="badge badge-sm bg-gradient-{{ $period->is_active ? 'success' : 'secondary' }}">
                                    {{ $period->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <a  href="{{ route('admin.graduation-periods.show', $period) }}"
                                    class="btn btn-sm bg-success text-white font-weight-bold text-xs"
                                    data-bs-toggle="tooltip" data-bs-title="Detail periode" data-bs-placement="left">
                                    <span class="material-icons-round opacity-10 text-sm">visibility</span>
                                </a>
                                <a  href="{{ route('admin.graduation-periods.edit', $period) }}"
                                    class="btn btn-sm bg-info text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-bs-title="Edit periode" data-bs-placement="top">
                                    <span class="material-icons-round opacity-10 text-sm">edit</span>
                                </a>
                                <a  href="javascript:void(0)"
                                    class="btn btn-sm bg-danger text-white font-weight-bold text-xs" onclick="confirmDelete({{ $period->id }})"
                                    data-bs-toggle="tooltip" data-bs-title="Hapus periode" data-bs-placement="right">
                                    <span class="material-icons-round opacity-10 text-sm">delete</span>
                                </a>
                                <form action="{{ route('admin.graduation-periods.destroy', $period) }}" method="POST" id="delete-form-{{$period->id}}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data periode kelulusan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-3 pt-4">
                    {{ $periods->links() }}
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
            html: `Periode Kelulusan akan dihapus permanen!<br>beserta seluruh data
                   <strong>Siswa, Kelas dan Nilai dan seluruh datanya</strong>`,
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
