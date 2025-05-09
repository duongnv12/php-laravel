<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index()
    {
        $progresses = Progress::with(['student', 'course'])->get();
        return view('progresses.index', compact('progresses'));
    }

    public function create()
    {
        $students = Student::all();
        $courses  = Course::all();
        return view('progresses.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'score'      => 'nullable|numeric',
            'status'     => 'nullable|string|max:255' // có thể để null vì observer sẽ cập nhật
        ]);

        // Tạo mới tiến độ; ngay sau khi lưu, observer sẽ tự động xử lý trạng thái.
        Progress::create($validated);

        return redirect()->route('progresses.index')
                         ->with('success', 'Tiến độ được tạo thành công!');
    }

    public function show(Progress $progress)
    {
        return view('progresses.show', compact('progress'));
    }

    public function edit(Progress $progress)
    {
        $students = Student::all();
        $courses  = Course::all();
        return view('progresses.edit', compact('progress', 'students', 'courses'));
    }

    public function update(Request $request, Progress $progress)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'score'      => 'nullable|numeric',
            'status'     => 'nullable|string|max:255'
        ]);

        $progress->update($validated);

        return redirect()->route('progresses.index')
                         ->with('success', 'Tiến độ đã được cập nhật thành công!');
    }

    public function destroy(Progress $progress)
    {
        $progress->delete();
        return redirect()->route('progresses.index')
                         ->with('success', 'Tiến độ đã được xóa thành công!');
    }
}
