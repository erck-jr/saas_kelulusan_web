<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalGraduated = Student::where('status', 'LULUS')->count();
        $totalFailed = Student::where('status', 'TIDAK LULUS')->count();
        $totalClasses = SchoolClass::count();
        $totalAnnouncements = Announcement::count();

        // Get recent announcements
        $recentAnnouncements = Announcement::latest()
            ->take(5)
            ->get();

        // Get class statistics
        $classStatistics = SchoolClass::withCount([
            'students as total_students',
            'students as graduated_count' => function ($query) {
                $query->where('status', 'LULUS');
            }
        ])->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalGraduated',
            'totalFailed',
            'totalClasses',
            'totalAnnouncements',
            'recentAnnouncements',
            'classStatistics'
        ));
    }
}
