<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;

class StudentController extends Controller
{
    // Hiển thị danh sách sinh viên
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    // Hiển thị form tạo mới sinh viên
    public function create()
    {
        return view('students.create');
    }

    // Lưu thông tin sinh viên mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:50',
            'dob'   => 'nullable|date',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Sinh viên được tạo thành công.');
    }

    // Hiển thị chi tiết một sinh viên
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    // Hiển thị form chỉnh sửa sinh viên
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    // Cập nhật thông tin sinh viên
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:50',
            'dob'   => 'nullable|date',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Sinh viên được cập nhật thành công.');
    }

    // Xóa sinh viên khỏi cơ sở dữ liệu
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Sinh viên được xóa thành công.');
    }

    public function importForm()
    {
        return view('students.import');
    }

    /**
     * Xử lý nhập danh sách sinh viên từ file Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return redirect()->route('students.index')
                         ->with('success', 'Danh sách sinh viên đã được nhập thành công.');
    }
}
