<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Curriculum;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'credits' => 'required|integer',
            'instructor' => 'required',
            'curriculum_id' => 'required|exists:curriculums,id',
        ]);
    
        Course::create($request->all());
        return redirect()->route('courses.index')->with('success', 'Môn học đã được thêm!');
    }
    
    public function update(Request $request, Course $course)
    {
        $course->update($request->all());
        return response()->json($course, 200);
    }
    
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(null, 204);
    }

    public function create()
    {
        $curriculums = Curriculum::all();
        return view('courses.create', compact('curriculums'));
    }
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }
}
