@section('title', 'Superadmin Dashboard')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('superadmin.global.dashboard') }}">Dashboard</a></li>
@endsection

<x-layouts.superadmin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                    <span class="material-icons-round text-2xl">domain</span>
                </div>
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Daftar Sekolah Terdaftar</h2>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Total terdata: <span class="text-indigo-400 font-bold">{{ $schools->total() }}</span> Sekolah</p>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3.5 px-6">Nama Sekolah</th>
                            <th class="py-3.5 px-6">Subdomain (Slug)</th>
                            <th class="py-3.5 px-6">Jumlah Siswa</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($schools as $school)
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="py-4 px-6 font-medium text-slate-200">{{ $school->name }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ $school->slug }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ $school->students_count }} Siswa</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold tracking-wide {{ $school->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                        {{ $school->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ $protocol }}://{{ $school->slug }}.{{ $appDomain }}/admin" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 px-3 py-1.5 text-xs font-semibold text-white transition shadow-md hover:from-indigo-600 hover:to-violet-700" title="Kelola Sekolah Ini">
                                            <span class="material-icons-round text-sm">open_in_new</span>
                                            <span>Kelola Sekolah</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-sm text-slate-500">Belum ada sekolah terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($schools->hasPages())
                <div class="p-4 border-t border-white/5 bg-slate-900/20 custom-pagination">
                    {{ $schools->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.superadmin-layout>
