<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\Program;
use Illuminate\Http\Request;

class CohortController extends Controller
{
    // Hiển thị danh sách niên khóa
    public function index()
    {
        $cohorts = Cohort::with('programs')->get();
        return view('cohorts.index', compact('cohorts'));
    }

    // Hiển thị form tạo mới niên khóa
    public function create()
    {
        // Lấy danh sách chương trình để lựa chọn dùng chung cho niên khóa (vì một chương trình có thể dùng cho nhiều khóa)
        $programs = Program::all();
        return view('cohorts.create', compact('programs'));
    }

    // Lưu lại niên khóa
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'start_year'   => 'nullable|integer',
            'end_year'     => 'nullable|integer',
            'program_ids'  => 'nullable|array',
            'program_ids.*'=> 'exists:programs,id'
        ]);

        $cohort = Cohort::create([
            'name'       => $validatedData['name'],
            'start_year' => $validatedData['start_year'] ?? null,
            'end_year'   => $validatedData['end_year'] ?? null,
        ]);

        if (isset($validatedData['program_ids'])) {
            $cohort->programs()->sync($validatedData['program_ids']);
        }

        return redirect()->route('cohorts.index')->with('success', 'Niên khóa đã được tạo thành công!');
    }

    // Hiển thị chi tiết niên khóa
    public function show(Cohort $cohort)
    {
        $cohort->load('programs');
        return view('cohorts.show', compact('cohort'));
    }

    // Hiển thị form chỉnh sửa niên khóa
    public function edit(Cohort $cohort)
    {
        $programs = Program::all();
        return view('cohorts.edit', compact('cohort', 'programs'));
    }

    // Cập nhật niên khóa
    public function update(Request $request, Cohort $cohort)
    {
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'start_year'   => 'nullable|integer',
            'end_year'     => 'nullable|integer',
            'program_ids'  => 'nullable|array',
            'program_ids.*'=> 'exists:programs,id'
        ]);
        
        $cohort->update([
            'name'       => $validatedData['name'],
            'start_year' => $validatedData['start_year'] ?? null,
            'end_year'   => $validatedData['end_year'] ?? null,
        ]);
        
        if (isset($validatedData['program_ids'])) {
            $cohort->programs()->sync($validatedData['program_ids']);
        }
        
        return redirect()->route('cohorts.index')->with('success', 'Niên khóa đã được cập nhật!');
    }

    // Xóa niên khóa
    public function destroy(Cohort $cohort)
    {
        $cohort->delete();
        return redirect()->route('cohorts.index')->with('success', 'Niên khóa đã được xóa!');
    }
}
