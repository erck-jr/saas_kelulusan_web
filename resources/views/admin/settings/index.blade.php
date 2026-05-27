@section('title', 'Pengaturan Aplikasi')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Pengaturan Aplikasi</li>
@endsection

@php
    $groupNames = [
        'general' => 'Umum',
        'school' => 'Profil Sekolah',
        'academic' => 'Akademik & Nilai',
        'announcement' => 'Pengumuman',
        'sertifikat' => 'Sertifikat',
        'appearance' => 'Desain Tampilan'
    ];
@endphp

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white tracking-wide">Pengaturan Aplikasi</h2>
                <p class="text-xs text-slate-400 mt-1">Sesuaikan konfigurasi aplikasi tanpa mengubah proses bisnis.</p>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-sm font-semibold text-white">Kelompok Pengaturan</h3>
                                <p class="text-xs text-slate-400">Pilih grup pengaturan untuk menampilkan opsi yang sesuai.</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach($groups as $index => $group)
                                <button type="button" class="group rounded-2xl border border-white/10 bg-slate-900/70 px-4 py-3 text-left transition hover:border-indigo-500/30 {{ $index === 0 ? 'ring-2 ring-indigo-500/40 bg-indigo-500/10 border-indigo-500/20' : '' }}" onclick="document.getElementById('tab-{{ $group }}').scrollIntoView({ behavior: 'smooth', block: 'start' })">
                                    <p class="text-xs uppercase tracking-wide text-slate-400 group-hover:text-white">{{ $groupNames[$group] ?? ucfirst($group) }}</p>
                                    <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $groupNames[$group] ?? ucfirst($group) }}</p>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-8">
                        @foreach($groups as $index => $group)
                            <div id="tab-{{ $group }}" class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                                <h3 class="text-sm font-semibold text-white mb-4">{{ $groupNames[$group] ?? ucfirst($group) }}</h3>
                                
                                @if($group === 'appearance')
                                    <div class="grid gap-6 lg:grid-cols-12">
                                        <!-- Form Fields Column -->
                                        <div class="space-y-6 lg:col-span-7">
                                            @foreach($settings[$group] as $setting)
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $setting->label }}</label>
                                                    
                                                    @if(in_array($setting->key, ['theme_primary_color', 'theme_accent_color']))
                                                        <div class="flex gap-3">
                                                            <input type="color" id="picker-{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="h-11 w-14 rounded-xl border border-white/10 bg-slate-950/50 cursor-pointer p-1" oninput="document.getElementById('input-{{ $setting->key }}').value = this.value; window.updateMockup();" />
                                                            <input type="text" id="input-{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="flex-1 rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" oninput="document.getElementById('picker-{{ $setting->key }}').value = this.value; window.updateMockup();" />
                                                        </div>
                                                    @elseif($setting->key === 'theme_bg_mode')
                                                        <select name="{{ $setting->key }}" id="select-{{ $setting->key }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" onchange="window.updateMockup();">
                                                            <option value="dark" {{ old($setting->key, $setting->value) === 'dark' ? 'selected' : '' }}>Gelap Premium (Dark Mode)</option>
                                                            <option value="light" {{ old($setting->key, $setting->value) === 'light' ? 'selected' : '' }}>Terang Bersih (Light Mode)</option>
                                                        </select>
                                                    @elseif($setting->key === 'theme_font_family')
                                                        <select name="{{ $setting->key }}" id="select-{{ $setting->key }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" onchange="window.updateMockup();">
                                                            @foreach(['Plus Jakarta Sans', 'Inter', 'Roboto', 'Outfit', 'Poppins', 'Montserrat', 'Open Sans', 'Playfair Display', 'Lora', 'Merriweather'] as $font)
                                                                <option value="{{ $font }}" {{ old($setting->key, $setting->value) === $font ? 'selected' : '' }}>{{ $font }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($setting->type === 'image')
                                                        <div class="rounded-2xl border border-white/10 bg-slate-900/50 p-4">
                                                            @if($setting->value)
                                                                <img id="preview-image-{{ $setting->key }}" src="{{ Storage::url($setting->value) }}" alt="{{ $setting->label }}" class="h-24 w-full object-contain rounded-xl mb-3" />
                                                            @endif
                                                            <input type="file" name="{{ $setting->key }}" accept="image/*" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" onchange="window.previewHeroBg(this);" />
                                                        </div>
                                                    @endif

                                                    @if($setting->description)
                                                        <p class="text-xs text-slate-500">{{ $setting->description }}</p>
                                                    @endif
                                                    @error($setting->key)
                                                        <p class="text-xs text-rose-400">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Live Mockup Column -->
                                        <div class="lg:col-span-5 flex flex-col justify-start">
                                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Pratinjau Live Tampilan Halaman Siswa</label>
                                            <div id="mockup-container" data-bg="{{ settings('theme_hero_bg') ? Storage::url(settings('theme_hero_bg')) : '' }}" class="rounded-3xl border border-white/10 shadow-2xl p-6 transition-all duration-500 aspect-[9/14] flex flex-col justify-between relative overflow-hidden" style="max-height: 480px;">
                                                <!-- Decorative Blurs -->
                                                <div id="mockup-blur-1" class="absolute top-[-20%] left-[-20%] w-[80%] h-[80%] rounded-full opacity-20 blur-[60px] pointer-events-none transition-colors duration-500"></div>
                                                <div id="mockup-blur-2" class="absolute bottom-[-20%] right-[-20%] w-[80%] h-[80%] rounded-full opacity-20 blur-[60px] pointer-events-none transition-colors duration-500"></div>

                                                <div class="z-10 flex flex-col items-center text-center mt-6">
                                                    <!-- Logo Mockup -->
                                                    <div id="mockup-logo-container" class="w-16 h-16 rounded-xl flex items-center justify-center shadow-lg mb-3 bg-white p-1 overflow-hidden">
                                                        @if(settings('school_logo'))
                                                            <img src="{{ Storage::url(settings('school_logo')) }}" alt="Logo" class="w-full h-full object-contain" />
                                                        @else
                                                            <div id="mockup-logo-fallback" class="w-full h-full rounded-lg flex items-center justify-center text-white">
                                                                <span class="material-icons-round text-2xl">school</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- School Info -->
                                                    <h1 id="mockup-title" class="font-bold text-sm tracking-wide transition-all duration-300">Pengumuman Kelulusan</h1>
                                                    <h2 id="mockup-school-name" class="font-bold text-xs mt-0.5 transition-all duration-300">{{ settings('school_name') }}</h2>
                                                    <p class="text-[10px] opacity-60 mt-0.5">Tahun Ajaran 2025/2026</p>
                                                </div>

                                                <!-- Input Field Mockup -->
                                                <div class="z-10 my-4 space-y-3">
                                                    <div class="space-y-1 text-left">
                                                        <span class="text-[9px] font-bold uppercase tracking-wider opacity-60">Nomor Induk Siswa Nasional (NISN)</span>
                                                        <div id="mockup-input" class="w-full rounded-xl border border-white/10 px-3 py-2 text-xs opacity-60 bg-slate-900/40">1234567890</div>
                                                    </div>
                                                    <button type="button" id="mockup-button" class="w-full py-2.5 rounded-xl text-white text-xs font-semibold transition-all duration-500 shadow-md">
                                                        Cek Kelulusan
                                                    </button>
                                                </div>

                                                <!-- Footer Mockup -->
                                                <div class="z-10 text-[9px] opacity-40 text-center mb-2">
                                                    Sistem Informasi Kelulusan © 2026
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="grid gap-6 lg:grid-cols-2">
                                        @foreach($settings[$group] as $setting)
                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $setting->label }}</label>
                                                @if(in_array($setting->type, ['text','number']))
                                                    <input type="{{ $setting->type }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                                                @elseif($setting->type === 'image' || $setting->type === 'template')
                                                    <div class="rounded-2xl border border-white/10 bg-slate-900/50 p-4">
                                                        @if($setting->value)
                                                            <img src="{{ Storage::url($setting->value) }}" alt="{{ $setting->label }}" class="h-24 w-full object-contain rounded-xl mb-3" />
                                                        @endif
                                                        <input type="file" name="{{ $setting->key }}" accept="image/*" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                                                        @if($setting->type === 'template' && $setting->value)
                                                            <a href="{{ route('admin.settings.certificate-preview') }}" target="_blank" class="inline-flex items-center gap-2 mt-3 rounded-xl bg-indigo-500/10 px-3 py-2 text-xs font-semibold text-indigo-300 border border-indigo-500/20 hover:bg-indigo-500/15 transition">Cek Hasil Sertifikat</a>
                                                        @endif
                                                    </div>
                                                @endif
                                                @if($setting->description)
                                                    <p class="text-xs text-slate-500">{{ $setting->description }}</p>
                                                @endif
                                                @error($setting->key)
                                                    <p class="text-xs text-rose-400">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="flex flex-wrap gap-3 justify-end">
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-xs font-semibold transition shadow-md">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('custom_js')
<script>
    window.updateMockup = function() {
        try {
            const primaryInput = document.getElementById('input-theme_primary_color');
            const accentInput = document.getElementById('input-theme_accent_color');
            const bgModeSelect = document.getElementById('select-theme_bg_mode');
            const fontSelect = document.getElementById('select-theme_font_family');
            
            if (!primaryInput || !accentInput || !bgModeSelect || !fontSelect) return;

            const primary = primaryInput.value;
            const accent = accentInput.value;
            const bgMode = bgModeSelect.value;
            const font = fontSelect.value;
            
            const container = document.getElementById('mockup-container');
            const blur1 = document.getElementById('mockup-blur-1');
            const blur2 = document.getElementById('mockup-blur-2');
            const button = document.getElementById('mockup-button');
            const title = document.getElementById('mockup-title');
            const schoolName = document.getElementById('mockup-school-name');
            const logoFallback = document.getElementById('mockup-logo-fallback');
            const mockupInput = document.getElementById('mockup-input');
            
            if (container) {
                container.style.fontFamily = font;
            }
            
            // Tentukan overlay background berdasarkan mode gelap/terang
            const isLight = bgMode === 'light';
            const overlayColor = isLight ? 'rgba(248, 250, 252, 0.9)' : 'rgba(11, 15, 25, 0.92)';
            
            if (container && title && schoolName && mockupInput) {
                if (isLight) {
                    container.style.backgroundColor = '#F8FAFC';
                    container.style.color = '#1E293B';
                    container.style.borderColor = 'rgba(0, 0, 0, 0.08)';
                    title.style.color = '#0F172A';
                    schoolName.style.color = '#334155';
                    mockupInput.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';
                    mockupInput.style.color = '#1E293B';
                    mockupInput.style.borderColor = 'rgba(0, 0, 0, 0.08)';
                } else {
                    container.style.backgroundColor = '#0B0F19';
                    container.style.color = '#F1F5F9';
                    container.style.borderColor = 'rgba(255, 255, 255, 0.06)';
                    title.style.color = '#FFFFFF';
                    schoolName.style.color = '#CBD5E1';
                    mockupInput.style.backgroundColor = 'rgba(15, 23, 42, 0.45)';
                    mockupInput.style.color = '#F1F5F9';
                    mockupInput.style.borderColor = 'rgba(255, 255, 255, 0.06)';
                }
                
                // Pasang background image jika ada data-bg
                const heroBgUrl = container.getAttribute('data-bg');
                if (heroBgUrl) {
                    container.style.backgroundImage = `linear-gradient(to bottom, ${overlayColor}, ${overlayColor}), url('${heroBgUrl}')`;
                    container.style.backgroundSize = 'cover';
                    container.style.backgroundPosition = 'center';
                } else {
                    container.style.backgroundImage = '';
                }
            }
            
            if (blur1) blur1.style.backgroundColor = primary;
            if (blur2) blur2.style.backgroundColor = accent;
            
            if (button) {
                button.style.background = `linear-gradient(135deg, ${primary}, ${accent})`;
                button.style.boxShadow = `0 4px 14px 0 ${primary}33`;
            }
            
            if (logoFallback) {
                logoFallback.style.background = `linear-gradient(135deg, ${primary}, ${accent})`;
            }
        } catch (error) {
            console.error('Error updating mockup:', error);
        }
    }

    window.previewHeroBg = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('mockup-container');
                if (container) {
                    container.setAttribute('data-bg', e.target.result);
                    window.updateMockup();
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function initMockup() {
        if (document.getElementById('input-theme_primary_color')) {
            // Load custom fonts dynamically untuk pratinjau dropdown list
            const fonts = ['Plus Jakarta Sans', 'Inter', 'Roboto', 'Outfit', 'Poppins', 'Montserrat', 'Open Sans', 'Playfair Display', 'Lora', 'Merriweather'];
            fonts.forEach(font => {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = `https://fonts.googleapis.com/css2?family=${font.replace(/ /g, '+')}:wght@400;600;700&display=swap`;
                document.head.appendChild(link);
            });
            
            // Set initial mockup dari seting saat ini
            window.updateMockup();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMockup);
    } else {
        initMockup();
    }
</script>
@endpush
</x-layouts.admin-layout>
