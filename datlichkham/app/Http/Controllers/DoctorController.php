<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User; // Cần import Model User
use App\Models\Specialty; // Cần import Model Specialty
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Để mã hóa mật khẩu

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with('user', 'specialty')->get(); // Lấy tất cả bác sĩ, eager load user và specialty
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialties = Specialty::all(); // Lấy tất cả chuyên khoa để chọn
        return view('doctors.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'specialty_id' => 'nullable|exists:specialties,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // Tạo người dùng mới (tài khoản cho bác sĩ)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
            'role' => 'doctor', // Gán vai trò là 'doctor'
        ]);

        // Tạo thông tin bác sĩ
        Doctor::create([
            'user_id' => $user->id,
            'specialty_id' => $request->specialty_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Bác sĩ đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $specialties = Specialty::all();
        return view('doctors.edit', compact('doctor', 'specialties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $doctor->user->id, // Unique ngoại trừ chính nó
            'password' => 'nullable|string|min:8|confirmed', // Mật khẩu có thể null nếu không muốn đổi
            'specialty_id' => 'nullable|exists:specialties,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // Cập nhật thông tin người dùng
        $doctor->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Nếu có mật khẩu mới, cập nhật mật khẩu
        if ($request->filled('password')) {
            $doctor->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Cập nhật thông tin bác sĩ
        $doctor->update([
            'specialty_id' => $request->specialty_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Thông tin bác sĩ đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete(); // Xóa tài khoản người dùng liên quan (sẽ xóa bác sĩ và các lịch liên quan do cascade)
        // Hoặc $doctor->delete(); nếu bạn chỉ muốn xóa thông tin bác sĩ mà không xóa tài khoản người dùng
        return redirect()->route('doctors.index')->with('success', 'Bác sĩ đã được xóa thành công!');
    }
}