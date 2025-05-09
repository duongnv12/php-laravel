<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Program;
use App\Models\Cohort;

class DashboardController extends Controller
{
    public function index()
    {
        // Tính toán dữ liệu thống kê
        $totalEnrollments = Enrollment::count();
        $completedEnrollments = Enrollment::where('status', 'completed')->count();
        $completionRate = $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100, 2) : 0;
        $totalStudents   = Student::count();
        $totalPrograms   = Program::count();
        $totalCohorts    = Cohort::count();

        // Truyền tất cả các biến này sang view
        return view('dashboard.index', compact(
            'totalEnrollments',
            'completedEnrollments',
            'completionRate',
            'totalStudents',
            'totalPrograms',
            'totalCohorts'
        ));

    }
}
