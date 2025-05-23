<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     * Hiển thị danh sách tất cả chuyên khoa.
     */
    public function index()
    {
        $specialties = Specialty::all(); // Lấy tất cả các chuyên khoa từ cơ sở dữ liệu
        return view('specialties.index', compact('specialties')); // Trả về view 'specialties.index' với dữ liệu chuyên khoa
    }

    /**
     * Show the form for creating a new resource.
     * Hiển thị form để tạo chuyên khoa mới.
     */
    public function create()
    {
        return view('specialties.create'); // Trả về view 'specialties.create'
    }

    /**
     * Store a newly created resource in storage.
     * Lưu chuyên khoa mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255|unique:specialties,name',
            'description' => 'nullable|string',
        ]);

        // Tạo chuyên khoa mới
        Specialty::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('specialties.index')->with('success', 'Chuyên khoa đã được thêm thành công!'); // Chuyển hướng về trang danh sách với thông báo thành công
    }

    /**
     * Display the specified resource.
     * Hiển thị thông tin chi tiết của một chuyên khoa cụ thể.
     */
    public function show(Specialty $specialty)
    {
        return view('specialties.show', compact('specialty')); // Trả về view 'specialties.show' với dữ liệu chuyên khoa
    }

    /**
     * Show the form for editing the specified resource.
     * Hiển thị form để chỉnh sửa chuyên khoa.
     */
    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty')); // Trả về view 'specialties.edit' với dữ liệu chuyên khoa
    }

    /**
     * Update the specified resource in storage.
     * Cập nhật thông tin chuyên khoa trong cơ sở dữ liệu.
     */
    public function update(Request $request, Specialty $specialty)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255|unique:specialties,name,' . $specialty->id, // unique ngoại trừ chính nó
            'description' => 'nullable|string',
        ]);

        // Cập nhật chuyên khoa
        $specialty->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('specialties.index')->with('success', 'Chuyên khoa đã được cập nhật thành công!'); // Chuyển hướng về trang danh sách với thông báo thành công
    }

    /**
     * Remove the specified resource from storage.
     * Xóa chuyên khoa khỏi cơ sở dữ liệu.
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete(); // Xóa chuyên khoa

        return redirect()->route('specialties.index')->with('success', 'Chuyên khoa đã được xóa thành công!'); // Chuyển hướng về trang danh sách với thông báo thành công
    }
}