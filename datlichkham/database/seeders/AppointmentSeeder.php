<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB; // Thêm dòng này

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Appointment::truncate(); // Xóa dữ liệu cũ

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Tạm bật lại để truy vấn User và Schedule

        $patient = User::where('role', 'patient')->first();
        if (!$patient) {
            $this->command->info('Vui lòng chạy DoctorSeeder (có tạo patient user) trước để có dữ liệu bệnh nhân.');
            return;
        }

        // Lấy một số khung giờ có sẵn
        $availableSchedules = Schedule::where('status', 'available')->limit(3)->get();

        if ($availableSchedules->isEmpty()) {
            $this->command->info('Không có khung giờ nào có sẵn để tạo lịch hẹn. Vui lòng kiểm tra ScheduleSeeder.');
            return;
        }

        // Tắt lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($availableSchedules as $schedule) {
            // Đảm bảo khung giờ chưa được đặt
            if ($schedule->status === 'available') {
                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $schedule->doctor_id,
                    'schedule_id' => $schedule->id,
                    'appointment_date' => $schedule->date,
                    'appointment_time' => $schedule->start_time,
                    'reason' => 'Khám định kỳ',
                    'status' => 'pending', // Mặc định là chờ xác nhận
                ]);

                // Cập nhật trạng thái của khung giờ thành đã đặt
                $schedule->update(['status' => 'booked']);
            }
        }

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}