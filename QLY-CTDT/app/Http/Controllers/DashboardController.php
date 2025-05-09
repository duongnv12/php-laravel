<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index() {
        $classes = Student::select('class')->distinct()->pluck('class');
        $studentCounts = Student::selectRaw('class, COUNT(*) as total')
            ->groupBy('class')
            ->pluck('total');
    
        return view('welcome', compact('classes', 'studentCounts'));
    }
    
}
