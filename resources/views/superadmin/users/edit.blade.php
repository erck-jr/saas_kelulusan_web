@section('title', 'Edit Sekolah & Pengguna')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('superadmin.global.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('superadmin.global.users.index') }}">Data Pengguna</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Edit Pengguna</li>
@endsection

<x-layouts.superadmin-layout>
    <div class="space-y-6">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Edit Data Sekolah & Admin</h2>
                    <p class="text-xs text-slate-400 mt-1">Perbarui profil sekolah dan akun administrator utamanya.</p>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route('superadmin.global.users.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama Sekolah</label>
                            <input type="text" name="school_name" value="{{ old('school_name', $user->school ? $user->school->name : '') }}" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('school_name')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama Admin (PIC)</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('name')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('email')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 justify-end pt-4 border-t border-white/5">
                        <a href="{{ route('superadmin.global.users.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Batal</a>
                        <button type="button" onclick="confirmResetPassword()" class="px-4 py-2.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-500 hover:bg-amber-500/20 text-xs font-semibold transition shadow-md flex items-center gap-2">
                            <span class="material-icons-round text-sm">lock_reset</span> Reset Password
                        </button>
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-xs font-semibold transition shadow-md flex items-center gap-2">
                            <span class="material-icons-round text-sm">save</span> Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Hidden Reset Password Form -->
                <form id="reset-password-form" action="{{ route('superadmin.global.users.reset-password', $user) }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmResetPassword() {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Password pengguna ini akan diubah paksa menjadi "password123".',
                icon: 'warning',
                showCancelButton: true,
                background: '#0F1322',
                color: '#f1f5f9',
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Reset Password',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reset-password-form').submit();
                }
            });
        }
    </script>
    @endpush
</x-layouts.superadmin-layout>
