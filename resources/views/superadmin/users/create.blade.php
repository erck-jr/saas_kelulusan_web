@section('title', 'Tambah Pengguna')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('superadmin.global.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('superadmin.global.users.index') }}">Data Pengguna</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Tambah Pengguna</li>
@endsection

<x-layouts.superadmin-layout>
    <div class="space-y-6">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Tambah Pengguna Baru</h2>
                    <p class="text-xs text-slate-400 mt-1">Lengkapi data pengguna untuk mengakses sistem.</p>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form action="{{ route('superadmin.global.users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama Sekolah</label>
                            <input type="text" name="school_name" value="{{ old('school_name') }}" required autofocus class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" placeholder="Contoh: SMA Negeri 1 Jakarta" />
                            @error('school_name')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama Admin (PIC)</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('name')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('email')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Password</label>
                            <input type="password" name="password" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('password')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                        </div>
                    </div>



                    <div class="flex flex-wrap gap-3 justify-end">
                        <a href="{{ route('superadmin.global.users.index') }}" class="inline-flex justify-center items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-300 bg-slate-800/50 hover:bg-slate-800 border border-white/5 hover:border-white/10 transition-all">Batal</a>
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-xs font-semibold transition shadow-md">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.superadmin-layout>
