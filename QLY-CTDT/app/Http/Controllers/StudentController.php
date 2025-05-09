<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create() {
        return view('students.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'class' => 'required|string|max:255',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Sinh viên đã được thêm!');
    }

    public function edit($id) {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id) {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Thông tin sinh viên đã được cập nhật!');
    }

    public function destroy($id) {
        Student::destroy($id);
        return redirect()->route('students.index')->with('success', 'Sinh viên đã bị xóa!');
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $students = Student::where('name', 'LIKE', "%{$query}%")->get();
        
        return response()->json($students);
    }
}
