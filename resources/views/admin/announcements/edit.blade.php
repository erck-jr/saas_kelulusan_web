@section('title', 'Edit Pengumuman')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.announcements.index') }}">Pengumuman</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Pengumuman</li>
@endsection

<x-layouts.admin-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Edit Pengumuman</h6>
                    </div>
                </div>
                <div class="card-body px-3 pb-2">
                    <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group input-group-outline my-3 is-filled">
                                    <label class="form-label">Judul Pengumuman</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           name="title" value="{{ old('title', $announcement->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline my-3 is-filled">
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                              name="content" rows="10" required>{{ old('content', $announcement->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3">Pengaturan Publikasi</h6>

                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="is_published"
                                                   id="is_published" value="1"
                                                   {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_published">
                                                Publikasikan sekarang
                                            </label>
                                        </div>

                                        <div class="input-group input-group-outline my-3 is-filled">
                                            <label class="form-label">Tanggal Publikasi</label>
                                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                                   name="published_at" value="{{ old('published_at', $announcement->published_at ? $announcement->published_at->format('Y-m-d\TH:i') : '') }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-light me-2">
                                                Batal
                                            </a>
                                            <button type="submit" class="btn bg-gradient-primary">
                                                Perbarui Pengumuman
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin-layout>
