<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    // Hiển thị danh sách tiến độ
    public function index()
    {
        $progresses = Progress::all();
        return view('progresses.index', compact('progresses'));
    }

    // Hiển thị form thêm mới tiến độ
    public function create()
    {
        // Lấy danh sách sinh viên và khóa học để hiển thị trong form select
        $students = Student::all();
        $courses = Course::all();
        return view('progresses.create', compact('students', 'courses'));
    }

    // Lưu tiến độ mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'score'      => 'nullable|numeric',
            'status'     => 'required|string|max:255',
        ]);

        Progress::create($validated);

        return redirect()->route('progresses.index')
                         ->with('success', 'Tiến độ được tạo thành công!');
    }

    // Hiển thị chi tiết tiến độ
    public function show(Progress $progress)
    {
        return view('progresses.show', compact('progress'));
    }

    // Hiển thị form chỉnh sửa tiến độ
    public function edit(Progress $progress)
    {
        $students = Student::all();
        $courses = Course::all();
        return view('progresses.edit', compact('progress', 'students', 'courses'));
    }

    // Cập nhật thông tin tiến độ
    public function update(Request $request, Progress $progress)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'score'      => 'nullable|numeric',
            'status'     => 'required|string|max:255',
        ]);

        $progress->update($validated);

        return redirect()->route('progresses.index')
                         ->with('success', 'Tiến độ đã được cập nhật thành công!');
    }

    // Xóa tiến độ khỏi cơ sở dữ liệu
    public function destroy(Progress $progress)
    {
        $progress->delete();

        return redirect()->route('progresses.index')
                         ->with('success', 'Tiến độ đã được xóa thành công!');
    }
}
