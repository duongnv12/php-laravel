<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Hiển thị danh sách các khóa học
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    // Hiển thị form tạo mới khóa học
    public function create()
    {
        return view('courses.create');
    }

    // Lưu khóa học vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Khóa học được tạo thành công.');
    }

    // Hiển thị chi tiết khóa học
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    // Hiển thị form chỉnh sửa khóa học
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Cập nhật thông tin khóa học
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Khóa học được cập nhật thành công.');
    }

    // Xóa khóa học khỏi cơ sở dữ liệu
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Khóa học được xóa thành công.');
    }
}
