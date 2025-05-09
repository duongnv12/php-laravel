<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function create() {
        return view('courses.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'instructor' => 'required|string|max:255',
        ]);

        Course::create($request->all());
        return redirect()->route('courses.index')->with('success', 'Khóa học đã được thêm!');
    }

    public function edit($id) {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id) {
        $course = Course::findOrFail($id);
        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Thông tin khóa học đã được cập nhật!');
    }

    public function destroy($id) {
        Course::destroy($id);
        return redirect()->route('courses.index')->with('success', 'Khóa học đã bị xóa!');
    }
}
