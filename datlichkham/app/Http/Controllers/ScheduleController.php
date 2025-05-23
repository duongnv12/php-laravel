<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Để lấy thông tin người dùng đăng nhập

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     * Hiển thị lịch làm việc của bác sĩ hiện tại hoặc tất cả lịch nếu là admin.
     */
    public function index()
    {
        if (Auth::user()->role === 'doctor') {
            $schedules = Auth::user()->doctor->schedules()->orderBy('date')->orderBy('start_time')->get();
        } else { // Admin có thể xem tất cả hoặc chọn bác sĩ để xem
            $schedules = Schedule::with('doctor.user')->orderBy('date')->orderBy('start_time')->get();
        }
        return view('schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     * Hiển thị form để tạo lịch làm việc mới.
     */
    public function create()
    {
        // Nếu là bác sĩ, chỉ có thể tạo lịch cho chính mình.
        // Nếu là admin, có thể chọn bác sĩ.
        $doctors = (Auth::user()->role === 'doctor') ? collect([Auth::user()->doctor]) : Doctor::with('user')->get();
        return view('schedules.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     * Lưu lịch làm việc mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Đảm bảo bác sĩ chỉ có thể tạo lịch cho chính mình
        if (Auth::user()->role === 'doctor' && $request->doctor_id !== Auth::user()->doctor->id) {
            return back()->withErrors(['message' => 'Bạn không có quyền tạo lịch cho bác sĩ khác.']);
        }

        // Kiểm tra xem khung giờ đã tồn tại chưa
        $existingSchedule = Schedule::where('doctor_id', $request->doctor_id)
                                    ->where('date', $request->date)
                                    ->where('start_time', $request->start_time)
                                    ->where('end_time', $request->end_time)
                                    ->first();

        if ($existingSchedule) {
            return back()->withInput()->withErrors(['message' => 'Khung giờ này đã tồn tại cho bác sĩ vào ngày này.']);
        }

        Schedule::create([
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'available', // Mặc định là 'available'
        ]);

        return redirect()->route('schedules.index')->with('success', 'Lịch làm việc đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        // Kiểm tra quyền: bác sĩ chỉ được xem lịch của mình
        if (Auth::user()->role === 'doctor' && $schedule->doctor_id !== Auth::user()->doctor->id) {
            abort(403); // Lỗi 403: Forbidden
        }
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        // Kiểm tra quyền: bác sĩ chỉ được sửa lịch của mình
        if (Auth::user()->role === 'doctor' && $schedule->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }
        $doctors = (Auth::user()->role === 'doctor') ? collect([Auth::user()->doctor]) : Doctor::with('user')->get();
        return view('schedules.edit', compact('schedule', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        // Kiểm tra quyền: bác sĩ chỉ được sửa lịch của mình
        if (Auth::user()->role === 'doctor' && $schedule->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:available,booked,unavailable',
        ]);

        // Kiểm tra xem khung giờ đã tồn tại chưa (trừ chính nó)
        $existingSchedule = Schedule::where('doctor_id', $schedule->doctor_id)
                                    ->where('date', $request->date)
                                    ->where('start_time', $request->start_time)
                                    ->where('end_time', $request->end_time)
                                    ->where('id', '!=', $schedule->id)
                                    ->first();

        if ($existingSchedule) {
            return back()->withInput()->withErrors(['message' => 'Khung giờ này đã tồn tại cho bác sĩ vào ngày này.']);
        }

        $schedule->update([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Lịch làm việc đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        // Kiểm tra quyền: bác sĩ chỉ được xóa lịch của mình
        if (Auth::user()->role === 'doctor' && $schedule->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        if ($schedule->status === 'booked') {
            return back()->withErrors(['message' => 'Không thể xóa lịch đã được đặt.']);
        }

        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Lịch làm việc đã được xóa thành công!');
    }
}