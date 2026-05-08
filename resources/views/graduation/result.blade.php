@section('title','Hasil Kelulusan')
<x-guest-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Hasil Pengumuman Kelulusan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Data Siswa:</h6>
                                <p>
                                    <strong>NIS:</strong> {{ $student->nis }}<br>
                                    <strong>Nama:</strong> {{ $student->nama }}<br>
                                    <strong>Kelas:</strong> {{ $student->schoolClass->nama_kelas }}
                                </p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h3 class="mt-4 {{ $student->status === 'LULUS' ? 'text-success' : 'text-danger' }}">
                                    {{ $student->status }}
                                </h3>
                            </div>
                        </div>

                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mata Pelajaran</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($student->grades as $grade)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $grade->mata_pelajaran }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($grade->nilai_akhir, 2) }}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm text-end">Rata-rata:</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm font-weight-bold">{{ number_format($student->nilai_rata_rata, 2) }}</h6>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($student->catatan)
                            <div class="alert alert-info text-white mt-4">
                                <strong>Catatan:</strong><br>
                                {{ $student->catatan }}
                            </div>
                        @endif

                        <!-- Preview Sertifikat -->
                        <div class="text-center mt-4">
                            <img src="{{ asset($sertifikatPath) }}"
                                alt="Sertifikat Kelulusan"
                                class="img-fluid rounded shadow"
                                style="max-width: 400px; cursor: zoom-in;"
                                data-bs-toggle="modal"
                                data-bs-target="#previewModal">
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ asset($sertifikatPath) }}"
                            class="btn bg-gradient-warning text-white"
                            download="sertifikat-{{ $student->nis }}.jpg"
                            title="Download sertifikat kelulusan">
                            <span class="material-icons-round me-1" style="vertical-align: middle;">download</span>
                            Download Sertifikat
                            </a>
                             <!-- Tombol Share WA -->
                            <a href="https://wa.me/?text={{ urlencode('Halo, ini sertifikat kelulusan atas nama ' . $student->nama . ' (NIS: ' . $student->nis . ').
                                Silakan download di sini: ' . asset($sertifikatPath)) }}"
                                target="_blank"
                                class="btn bg-success text-white">
                                    <span class="material-icons-round me-1">share</span>
                                    Bagikan via WhatsApp
                            </a>
                            <a href="{{ route('home') }}" class="btn bg-gradient-dark">
                            <span class="material-icons-round me-1" style="vertical-align: middle;">home</span>
                            Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
