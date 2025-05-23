<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Nếu bạn không muốn user factory

        // Chạy các seeder của bạn theo thứ tự phụ thuộc
        $this->call([
            SpecialtySeeder::class,
            DoctorSeeder::class, // DoctorSeeder tạo cả user admin và patient
            ScheduleSeeder::class,
            AppointmentSeeder::class,
        ]);
    }
}