<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{
    public function index() {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    public function create() {
        return view('programs.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_credits' => 'required|integer|min:1',
        ]);

        Program::create($request->all());
        return redirect()->route('programs.index')->with('success', 'Chương trình đào tạo đã được thêm!');
    }

    public function edit($id) {
        $program = Program::findOrFail($id);
        return view('programs.edit', compact('program'));
    }

    public function update(Request $request, $id) {
        $program = Program::findOrFail($id);
        $program->update($request->all());
        return redirect()->route('programs.index')->with('success', 'Chương trình đào tạo đã được cập nhật!');
    }

    public function destroy($id) {
        Program::destroy($id);
        return redirect()->route('programs.index')->with('success', 'Chương trình đào tạo đã bị xóa!');
    }
}

