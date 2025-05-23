<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * Hiển thị danh sách lịch hẹn của bệnh nhân hoặc bác sĩ.
     */
    public function index()
    {
        if (Auth::user()->role === 'patient') {
            $appointments = Auth::user()->appointments()->with('doctor.user', 'schedule')->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc')->get();
        } elseif (Auth::user()->role === 'doctor') {
            $appointments = Auth::user()->doctor->appointments()->with('patient', 'schedule')->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc')->get();
        } else { // Admin
            $appointments = Appointment::with('patient', 'doctor.user', 'schedule')->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc')->get();
        }
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     * Hiển thị form đặt lịch hẹn mới.
     * (Chúng ta sẽ đơn giản hóa bằng cách chọn bác sĩ và ngày, sau đó hiển thị các khung giờ trống)
     */
    public function create()
    {
        $doctors = Doctor::with('user', 'specialty')->get(); // Lấy tất cả bác sĩ
        return view('appointments.create', compact('doctors'));
    }

    /**
     * Lấy các khung giờ có sẵn cho một bác sĩ và ngày cụ thể (AJAX request).
     */
    public function getAvailableSchedules(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $availableSchedules = Schedule::where('doctor_id', $request->doctor_id)
                                    ->where('date', $request->date)
                                    ->where('status', 'available')
                                    ->orderBy('start_time')
                                    ->get();

        return response()->json($availableSchedules);
    }

    /**
     * Store a newly created resource in storage.
     * Lưu lịch hẹn mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'reason' => 'nullable|string|max:1000',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        // Đảm bảo khung giờ này thuộc về bác sĩ đã chọn và còn trống
        if ($schedule->doctor->id !== (int)$request->doctor_id || $schedule->status !== 'available') {
            return back()->withInput()->withErrors(['message' => 'Khung giờ bạn chọn không hợp lệ hoặc đã được đặt.']);
        }

        // Tạo lịch hẹn
        Appointment::create([
            'patient_id' => Auth::id(), // Lấy ID của người dùng đang đăng nhập (bệnh nhân)
            'doctor_id' => $request->doctor_id,
            'schedule_id' => $request->schedule_id,
            'appointment_date' => $schedule->date,
            'appointment_time' => $schedule->start_time, // Lấy thời gian bắt đầu của khung giờ
            'reason' => $request->reason,
            'status' => 'pending', // Trạng thái ban đầu là chờ xác nhận
        ]);

        // Cập nhật trạng thái của khung giờ thành 'booked'
        $schedule->update(['status' => 'booked']);

        return redirect()->route('appointments.index')->with('success', 'Lịch hẹn của bạn đã được đặt thành công và đang chờ xác nhận!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Kiểm tra quyền: bệnh nhân chỉ được xem lịch của mình, bác sĩ xem lịch của mình, admin xem tất cả
        if (Auth::user()->role === 'patient' && $appointment->patient_id !== Auth::id()) {
            abort(403);
        }
        if (Auth::user()->role === 'doctor' && $appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     * Thường thì lịch hẹn đã đặt không nên chỉnh sửa nhiều, chỉ có thể hủy hoặc cập nhật trạng thái.
     * Chúng ta sẽ chỉ cho phép cập nhật trạng thái ở đây.
     */
    public function edit(Appointment $appointment)
    {
        // Chỉ bác sĩ hoặc admin mới có thể chỉnh sửa (cập nhật trạng thái)
        if (Auth::user()->role === 'patient') {
            abort(403);
        }
        if (Auth::user()->role === 'doctor' && $appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     * Cập nhật trạng thái của lịch hẹn.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Chỉ bác sĩ hoặc admin mới có thể cập nhật trạng thái
        if (Auth::user()->role === 'patient') {
            abort(403);
        }
        if (Auth::user()->role === 'doctor' && $appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        // Nếu trạng thái thay đổi từ 'booked' sang 'cancelled' hoặc 'completed',
        // cần xem xét việc cập nhật trạng thái của Schedule (tùy vào logic nghiệp vụ).
        // Ví dụ: nếu hủy, có thể trả lại trạng thái 'available' cho schedule (tùy vào yêu cầu)
        if ($appointment->status === 'booked' && $request->status === 'cancelled') {
             // Logic: nếu hủy lịch hẹn đã được xác nhận, có thể mở lại khung giờ
             // Hoặc giữ nguyên 'booked' để lịch sử
             // Tạm thời, ta không thay đổi trạng thái schedule khi hủy từ appointment
             // Vì schedule_id là unique, nó ngăn việc đặt lại khung giờ này.
        }

        $appointment->update([
            'status' => $request->status,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Trạng thái lịch hẹn đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     * Cho phép hủy lịch hẹn (bệnh nhân hoặc bác sĩ/admin).
     */
    public function destroy(Appointment $appointment)
    {
        // Bệnh nhân chỉ được hủy lịch của mình, bác sĩ/admin hủy lịch của mình/người khác
        if (Auth::user()->role === 'patient' && $appointment->patient_id !== Auth::id()) {
            abort(403);
        }
        if (Auth::user()->role === 'doctor' && $appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        // Khi hủy lịch hẹn, chúng ta cần cập nhật lại trạng thái của khung giờ làm việc thành 'available'
        $schedule = $appointment->schedule;
        if ($schedule) {
            $schedule->update(['status' => 'available']);
        }

        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Lịch hẹn đã được hủy thành công!');
    }
}