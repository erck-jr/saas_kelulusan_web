<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelulusan App - Platform Pengumuman Kelulusan Sekolah Modern</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-display {
            font-family: 'Outfit', sans-serif;
        }
        .glass {
            background: rgba(15, 23, 25, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="bg-[#0B0F19] text-slate-100 min-h-screen overflow-x-hidden relative flex flex-col justify-between">
    
    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-indigo-900/15 blur-[120px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-purple-900/15 blur-[120px] pointer-events-none -z-10"></div>

    <header class="w-full px-4 sm:px-6 py-5 max-w-7xl mx-auto flex items-center justify-between border-b border-white/5 relative z-10">
        <a href="/" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
            </div>
            <span class="font-display font-bold text-xl tracking-wide bg-gradient-to-r from-white via-indigo-200 to-violet-300 bg-clip-text text-transparent">Kelulusan-App</span>
        </a>
        
        <div>
            <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:opacity-90 shadow-lg text-xs sm:text-sm font-semibold tracking-wide transition-opacity">Login Admin</a>
        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 py-8 lg:py-16 grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center relative z-10 w-full">
        
        <div class="lg:col-span-7 flex flex-col justify-center space-y-6 lg:space-y-8 text-center lg:text-left">
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider self-center lg:self-start">
                <span>Portal Kelulusan Sekolah</span>
            </div>
            
            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-extrabold tracking-tight leading-tight sm:leading-[1.1] text-white">
                Kelola Pengumuman Kelulusan Sekolah dalam <span class="bg-gradient-to-r from-indigo-400 via-violet-400 to-fuchsia-400 bg-clip-text text-transparent">Satu Platform.</span>
            </h1>
            
            <p class="text-slate-400 text-base sm:text-lg leading-relaxed max-w-xl mx-auto lg:mx-0">
                Ubah cara sekolah mengumumkan hasil kelulusan. Dengan teknologi multi-tenant yang aman, sistem anti-crash saat trafik tinggi, dan hitung mundur pengumuman real-time.
            </p>

            <div class="grid grid-cols-3 gap-4 sm:gap-6 pt-6 max-w-md mx-auto lg:mx-0 border-t border-white/5">
                <div>
                    <h3 class="font-display font-bold text-xl sm:text-2xl text-white">100%</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1">Data Terisolasi</p>
                </div>
                <div>
                    <h3 class="font-display font-bold text-xl sm:text-2xl text-indigo-400">0 ms</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1">Delay Unduh SKL</p>
                </div>
                <div>
                    <h3 class="font-display font-bold text-xl sm:text-2xl text-violet-400">Mudah</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1">Kelola Tenant</p>
                </div>
            </div>
        </div>

        <div id="register" class="lg:col-span-5 w-full max-w-md mx-auto lg:max-w-none">
            <div class="glass p-6 sm:p-8 rounded-2xl sm:rounded-3xl shadow-2xl relative overflow-hidden">
                <h2 class="font-display font-bold text-xl sm:text-2xl text-white">Daftarkan Sekolah Baru</h2>
                <p class="text-xs text-slate-400 mt-1 mb-6">Siapkan portal kelulusan sekolah Anda dalam beberapa langkah mudah.</p>

                @if(session('success'))
                    <div class="p-4 mb-4 text-xs rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="p-4 mb-4 text-xs rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="p-4 mb-4 text-xs rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('saas.register') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label border for="school_name" class="text-xs font-semibold text-slate-300">Nama Sekolah</label>
                        <input type="text" name="school_name" id="school_name" required value="{{ old('school_name') }}"
                            placeholder="Contoh: SMA Negeri 1 Jakarta"
                            class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>

                    <div class="space-y-1.5">
                        <label border for="school_slug" class="text-xs font-semibold text-slate-300">Subdomain / Slug URL</label>
                        <input type="text" name="school_slug" id="school_slug" required value="{{ old('school_slug') }}"
                            placeholder="Contoh: sman1jkt"
                            class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-colors">
                        <span class="text-[10px] text-slate-500 block mt-0.5">Format: domain.com/{slug}</span>
                    </div>

                    <div class="pt-4 border-t border-white/5 space-y-4">
                        <div class="space-y-1.5">
                            <label for="admin_name" class="text-xs font-semibold text-slate-300">Nama Lengkap Administrator</label>
                            <input type="text" name="admin_name" id="admin_name" required value="{{ old('admin_name') }}"
                                placeholder="Nama Lengkap"
                                class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-colors">
                        </div>

                        <div class="space-y-1.5">
                            <label border for="admin_email" class="text-xs font-semibold text-slate-300">Email Admin</label>
                            <input type="email" name="admin_email" id="admin_email" required value="{{ old('admin_email') }}"
                                placeholder="admin@sekolah.sch.id"
                                class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-colors">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label border for="admin_password" class="text-xs font-semibold text-slate-300">Password</label>
                                <input type="password" name="admin_password" id="admin_password" required
                                    placeholder="••••••••"
                                    class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-colors">
                            </div>

                            <div class="space-y-1.5">
                                <label border for="admin_password_confirmation" class="text-xs font-semibold text-slate-300">Konfirmasi</label>
                                <input type="password" name="admin_password_confirmation" id="admin_password_confirmation" required
                                    placeholder="••••••••"
                                    class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all transform active:scale-[0.98] text-sm tracking-wide cursor-pointer">
                        Buat Portal Sekarang
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer class="w-full px-4 sm:px-6 py-6 border-t border-white/5 relative z-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            Kelulusan-App © Copyright {{ date('Y') }} Web-Kelulusan by :
                <a href="https://instagram.com/el_miro23" class="link-dark text-sm" target="_blank">
                    <x-instagram-logo class="text-white"></x-instagram-logo>
                    EL-MIRO23
                </a>
        </div>
    </footer>

</body>
</html>