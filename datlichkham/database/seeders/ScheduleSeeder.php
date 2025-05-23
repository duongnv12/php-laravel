<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Thêm dòng này

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schedule::truncate(); // Xóa dữ liệu cũ

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Tạm bật lại để truy vấn Doctor

        $doctors = Doctor::all();
        if ($doctors->isEmpty()) {
            $this->command->info('Vui lòng chạy DoctorSeeder trước để có dữ liệu bác sĩ.');
            return;
        }

        // Tắt lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $dates = [
            Carbon::today(),
            Carbon::today()->addDay(),
            Carbon::today()->addDays(2),
        ];

        foreach ($doctors as $doctor) {
            foreach ($dates as $date) {
                // Thêm các khung giờ làm việc mẫu cho mỗi bác sĩ
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'date' => $date->toDateString(),
                    'start_time' => '08:00:00',
                    'end_time' => '09:00:00',
                    'status' => 'available',
                ]);
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'date' => $date->toDateString(),
                    'start_time' => '09:00:00',
                    'end_time' => '10:00:00',
                    'status' => 'available',
                ]);
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'date' => $date->toDateString(),
                    'start_time' => '14:00:00',
                    'end_time' => '15:00:00',
                    'status' => 'available',
                ]);
            }
        }

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}