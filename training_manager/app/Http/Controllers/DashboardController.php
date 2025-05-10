<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Program;
use App\Models\Cohort;
use App\Models\Semester;

class DashboardController extends Controller
{
    public function index()
    {
        // Dữ liệu tổng quát
        $totalEnrollments = Enrollment::count();
        $completedEnrollments = Enrollment::where('status', 'completed')->count();
        $completionRate = $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100, 2) : 0;
        $totalStudents = Student::count();
        $totalPrograms = Program::count();
        $totalCohorts = Cohort::count();

        // Ví dụ: Lấy dữ liệu cho từng kỳ học
        $semesters = Semester::withCount([
            'enrollments',
            'enrollments as completed_enrollments_count' => function ($query) {
                $query->where('status', 'completed');
            }
        ])->get();

        return view('dashboard.index', compact(
            'totalEnrollments',
            'completedEnrollments',
            'completionRate',
            'totalStudents',
            'totalPrograms',
            'totalCohorts',
            'semesters'
        ));
    }
}
