<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Course;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // Hiển thị danh sách chương trình đào tạo
    public function index()
    {
        $programs = Program::with('courses')->get();
        return view('programs.index', compact('programs'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        // Lấy danh mục môn học để lựa chọn (chương trình sẽ có danh sách môn học)
        $courses = Course::all();
        return view('programs.create', compact('courses'));
    }

    // Lưu lại chương trình đào tạo
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'course_ids'   => 'nullable|array',
            'course_ids.*' => 'exists:courses,id'
        ]);

        $program = Program::create([
            'name'        => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
        ]);

        // Nếu có môn học được chọn thì liên kết qua bảng pivot
        if (isset($validatedData['course_ids'])) {
            $program->courses()->sync($validatedData['course_ids']);
        }

        return redirect()->route('programs.index')->with('success', 'Chương trình đào tạo đã được tạo thành công!');
    }

    // Hiển thị chi tiết chương trình đào tạo
    public function show(Program $program)
    {
        $program->load('courses');
        return view('programs.show', compact('program'));
    }

    // Hiển thị form chỉnh sửa chương trình
    public function edit(Program $program)
    {
        $courses = Course::all();
        return view('programs.edit', compact('program', 'courses'));
    }

    // Cập nhật chương trình đào tạo
    public function update(Request $request, Program $program)
    {
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'course_ids'   => 'nullable|array',
            'course_ids.*' => 'exists:courses,id'
        ]);

        $program->update([
            'name'        => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
        ]);

        if (isset($validatedData['course_ids'])) {
            $program->courses()->sync($validatedData['course_ids']);
        }

        return redirect()->route('programs.index')->with('success', 'Chương trình đào tạo đã được cập nhật!');
    }

    // Xóa chương trình đào tạo
    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Chương trình đào tạo đã được xóa!');
    }
}
