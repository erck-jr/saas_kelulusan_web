@section('title', 'Pengaturan Aplikasi')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pengaturan Aplikasi</li>
@endsection

<x-layouts.admin-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Pengaturan Sistem</h6>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                @foreach($groups as $index => $group)
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 {{ $index === 0 ? 'active' : '' }}"
                                           data-bs-toggle="tab"
                                           href="#{{ $group }}"
                                           role="tab"
                                           aria-controls="{{ $group }}"
                                           aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                            {{ ucfirst($group) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="tab-content mt-4">
                            @foreach($groups as $index => $group)
                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                     id="{{ $group }}"
                                     role="tabpanel"
                                     aria-labelledby="{{ $group }}-tab">
                                    <div class="row">
                                        @foreach($settings[$group] as $setting)
                                            <div class="col-md-6 mb-4">
                                                @if($setting->type === 'text' || $setting->type === 'number')
                                                <div class="input-group input-group-outline {{ old($setting->key, $setting->value) ? 'is-filled' : '' }}">
                                                @else
                                                <div class="input-group input-group-static {{ old($setting->key, $setting->value) ? 'is-filled' : '' }} mb-4">
                                                @endif
                                                    @if($setting->type === 'text')
                                                        <label class="form-label">{{ $setting->label }}</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               name="{{ $setting->key }}"
                                                               value="{{ old($setting->key, $setting->value) }}">
                                                    @elseif($setting->type === 'number')
                                                        <label class="form-label">{{ $setting->label }}</label>
                                                        <input type="number"
                                                               class="form-control"
                                                               name="{{ $setting->key }}"
                                                               value="{{ old($setting->key, $setting->value) }}">
                                                    @elseif($setting->type === 'image')
                                                        <label>{{ $setting->label }}</label>
                                                        <div class="row w-100 mt-2">
                                                            <div class="col-md-6 pt-auto">
                                                                @if($setting->value)
                                                                    <img src="{{ Storage::url($setting->value) }}"
                                                                        alt="{{ $setting->label }}"
                                                                        class="img-fluid mb-2"
                                                                        style="max-height: 100px">
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="file"
                                                                    class="form-control"
                                                                    name="{{ $setting->key }}"
                                                                    accept="image/*">
                                                            </div>
                                                        </div>
                                                    @elseif($setting->type === 'template')
                                                        <label>{{ $setting->label }}</label>
                                                        <div class="row w-100 mt-2">
                                                            <div class="col-md-6 pt-auto">
                                                                @if($setting->value)
                                                                    <img src="{{ Storage::url($setting->value) }}"
                                                                        alt="{{ $setting->label }}"
                                                                        class="img-fluid mb-2"
                                                                        style="max-height: 100px">
                                                                    <div class="mt-2">
                                                                        <a href="{{ route('admin.settings.certificate-preview') }}" target="_blank" class="btn btn-sm btn-info">Cek Hasil Sertifikat</a>
                                                                    </div>
                                                                @else
                                                                    <span class="text-xs text-danger">Template belum diunggah</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="file"
                                                                    class="form-control"
                                                                    name="{{ $setting->key }}"
                                                                    accept="image/*">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($setting->description)
                                                    <div class="form-text text-muted">
                                                        {{ $setting->description }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn bg-gradient-primary">
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.admin-layout>
