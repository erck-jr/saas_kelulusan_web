<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        $prefix = '';
        if(Auth::check()){
            $prefix = 'admin.';
        }
        return view($prefix.'announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        $announcement = Announcement::create($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function show(Announcement $announcement)
    {
        $route = 'announcements.show';
        $prefix = '';
        if(Auth::check()){
            $prefix = 'admin.';
        }
        return view($prefix.$route, compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function publish(Announcement $announcement)
    {
        $announcement->update([
            'is_published' => true,
            'published_at' => now()
        ]);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dipublikasikan.');
    }

    /**
     * Public-facing announcement list (tenant-scoped via BelongsToTenant trait).
     */
    public function publicIndex()
    {
        $announcements = Announcement::where('is_published', true)
            ->latest()
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    /**
     * Public-facing announcement detail (tenant-scoped via BelongsToTenant trait).
     */
    public function publicShow(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }
}
