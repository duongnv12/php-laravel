<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;

class EnrollmentController extends Controller
{
    // Hiển thị danh sách đăng ký (có thể dành riêng cho admin hoặc từng sinh viên riêng)
    public function index()
    {
        // Ví dụ: lấy tất cả đăng ký, kèm thông tin sinh viên và môn học
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return view('enrollments.index', compact('enrollments'));
    }

    // Hiển thị form đăng ký cho sinh viên (chọn các môn học)
    public function create()
    {
        // Lấy danh sách tất cả môn học để sinh viên đăng ký
        $courses = Course::all();
        
        // Giả sử bạn lấy thông tin sinh viên từ session (hoặc auth)
        $student = auth()->user();
        
        return view('enrollments.create', compact('courses', 'student'));
    }

    // Lưu đăng ký
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = auth()->user(); // Giả sử đã đăng nhập và auth::user() trả về sinh viên

        Enrollment::create([
            'student_id' => $student->id,
            'course_id'  => $request->course_id,
            'status'     => 'registered'
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Đăng ký học thành công!');
    }

    // Các phương thức khác: show, edit, update, destroy (nếu cần)
    // Bạn có thể hiển thị chi tiết đăng ký, cập nhật kết quả học tập, …
        /**
     * Hiển thị form chỉnh sửa tiến độ học tập cho một đăng ký.
     */
    public function edit(Enrollment $enrollment)
    {
        return view('enrollments.edit', compact('enrollment'));
    }

    /**
     * Xử lý cập nhật thông tin tiến độ học tập của đăng ký.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $data = $request->validate([
            'status' => 'required|in:registered,completed,failed',
            'grade'  => 'nullable|numeric|min:0|max:10',
        ]);

        $enrollment->update($data);

        return redirect()->route('enrollments.index')->with('success', 'Cập nhật tiến độ học tập thành công!');
    }
}
