@section('title','Beranda')
<x-guest-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Pengumuman Kelulusan</h4>
                            @if($activePeriod)
                                <p class="text-white text-center mb-0">Tahun Ajaran {{ $activePeriod->tahun_ajaran }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $isOpened = false;
                            $pengumumanDateTime = null;
                            if ($activePeriod) {
                                $pengumumanDateTime = \Carbon\Carbon::parse($activePeriod->tanggal_pengumuman->format('Y-m-d') . ' ' . ($activePeriod->jam_pengumuman ?? '00:00:00'));
                                $isOpened = now()->gte($pengumumanDateTime);
                            }
                        @endphp
                        @if($activePeriod && $isOpened)
                            <form role="form" class="text-start" method="POST" action="{{ route('graduation.check') }}">
                                @csrf
                                <div class="header">
                                    <label class="form-label">Masukan NISN Siswa </label>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Nomor Induk Siswa Nasional (NISN)</label>
                                    <input type="text" name="nis" class="form-control" required>
                                </div>

                                @error('nis')
                                    <div class="text-danger text-xs">{{ $message }}</div>
                                @enderror



                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Cek Kelulusan</button>
                                </div>
                            </form>
                        @elseif($activePeriod)
                            <div class="alert alert-info text-white">
                                <p class="text-center mb-0">
                                    Pengumuman kelulusan akan dibuka pada:<br>
                                    <strong>{{ $pengumumanDateTime->translatedFormat('d F Y, H:i') }} WIB</strong>
                                </p>
                            </div>
                        @else
                            <div class="alert alert-warning text-white">
                                <p class="text-center mb-0">
                                    Tidak ada periode kelulusan yang aktif saat ini.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
