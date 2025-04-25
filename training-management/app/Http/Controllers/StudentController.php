<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Curriculum;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('curriculum')->get();
        return view('students.index', compact('students'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'student_code' => 'required|unique:students,student_code',
            'curriculum_id' => 'required|exists:curriculums,id',
        ]);
    
        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Sinh viên đã được thêm!');
    }
    
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'student_code' => 'required|unique:students,student_code,' . $student->id,
            'curriculum_id' => 'required|exists:curriculums,id',
        ]);
    
        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Sinh viên đã được cập nhật!');
    }
    
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Sinh viên đã được xóa!');
    }

    public function create()
    {
        $curriculums = Curriculum::all();
        return view('students.create', compact('curriculums'));
    }

    public function edit(Student $student)
    {
        $curriculums = Curriculum::all();
        return view('students.edit', compact('student', 'curriculums'));
    }
}
