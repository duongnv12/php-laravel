<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ActivityLog;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách tất cả người dùng.
     */
    public function index()
    {
        // Lấy tất cả người dùng, sắp xếp theo ID giảm dần hoặc tên
        $users = User::orderBy('id', 'asc')->paginate(10); // Phân trang 10 người dùng mỗi trang
        return view('admin.users.index', compact('users'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin người dùng.
     */
    public function edit(User $user)
    {
        // Định nghĩa các vai trò có sẵn
        $roles = ['user', 'admin'];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Cập nhật thông tin người dùng.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Đảm bảo email duy nhất trừ email hiện tại của user
            ],
            'role' => ['required', 'string', Rule::in(['user', 'admin'])], // Chỉ cho phép 'user' hoặc 'admin'
        ]);

        $user->update($validatedData);

                // Ghi log hành động Cập nhật người dùng
        ActivityLog::logActivity(
            'updated',
            $user,
            $user->getOriginal(), // Dữ liệu cũ
            $validatedData // Dữ liệu mới
        );
        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật thành công!');
    }

    /**
     * Đặt lại mật khẩu cho người dùng cụ thể.
     */
    // public function resetPassword(Request $request, User $user)
    // {
    //     $request->validate([
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ], [
    //         'password.required' => 'Mật khẩu không được để trống.',
    //         'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
    //         'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
    //     ]);

    //     $user->password = Hash::make($request->password);
    //     $user->save();

    //     return redirect()->route('admin.users.edit', $user)->with('success', 'Mật khẩu người dùng đã được đặt lại thành công.');
    // }

    /**
     * Xóa người dùng khỏi hệ thống.
     */
    public function destroy(User $user)
    {
        // Ngăn không cho Admin tự xóa tài khoản của chính mình
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa tài khoản quản trị của mình.');
        }

        $user->delete();
        // Ghi log hành động Xóa người dùng
        ActivityLog::logActivity(
            'deleted',
            $user,
            $user->toArray() // Dữ liệu cũ
        );

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công.');
    }
}