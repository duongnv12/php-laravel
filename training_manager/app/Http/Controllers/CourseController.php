<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CoursesImport;

class CourseController extends Controller
{
    // Hiển thị danh sách môn học
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function import()
    {
        return view('courses.import');
    }

    // Phương thức xử lý file import qua POST
    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CoursesImport, $request->file('file'));

        return redirect()->route('courses.index')->with('success', 'Import Môn học thành công!');
    }


    // Hiển thị form tạo mới môn học
    public function create()
    {
        // Lấy tất cả các môn học để chọn “môn tiên quyết”
        $courses = Course::all();
        return view('courses.create', compact('courses'));
    }

    // Lưu thông tin môn học vào CSDL
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code'          => 'required|unique:courses,code',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'credit'        => 'required|numeric',
            'prerequisites' => 'nullable|array',
            'prerequisites.*' => 'exists:courses,id'
        ]);

        $course = Course::create([
            'code'        => $validatedData['code'],
            'name'        => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'credit'      => $validatedData['credit'],
        ]);

        // Nếu có môn tiên quyết, thiết lập mối quan hệ (sử dụng sync để tránh trùng lặp)
        if (isset($validatedData['prerequisites'])) {
            $course->prerequisites()->sync($validatedData['prerequisites']);
        }

        return redirect()->route('courses.index')->with('success', 'Môn học đã được tạo thành công!');
    }

    // Hiển thị thông tin chi tiết của một môn học
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    // Hiển thị form chỉnh sửa thông tin môn học
    public function edit(Course $course)
    {
        // Truy vấn lấy tất cả các môn học ngoại trừ môn học đang được chỉnh sửa (để tránh chọn làm môn tiên quyết cho chính nó)
        $courses = Course::where('id', '<>', $course->id)->get();

        return view('courses.edit', compact('course', 'courses'));
    }

    // Cập nhật môn học
    public function update(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'code'          => 'required|unique:courses,code,' . $course->id,
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'credit'        => 'required|numeric',
            'prerequisites' => 'nullable|array',
            'prerequisites.*' => 'exists:courses,id'
        ]);

        $course->update([
            'code'        => $validatedData['code'],
            'name'        => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'credit'      => $validatedData['credit'],
        ]);

        if (isset($validatedData['prerequisites'])) {
            $course->prerequisites()->sync($validatedData['prerequisites']);
        }

        return redirect()->route('courses.index')->with('success', 'Môn học đã được cập nhật!');
    }

    // Xóa môn học
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Môn học đã được xóa!');
    }
}
