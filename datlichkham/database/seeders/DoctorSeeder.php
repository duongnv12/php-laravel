<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Thêm dòng này

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Xóa dữ liệu cũ (đảm bảo xóa Doctor trước User nếu onDelete không phải cascade hoặc có lỗi)
        Doctor::truncate();
        User::where('role', 'doctor')->delete(); // Chỉ xóa user là bác sĩ

        // Bật lại kiểm tra khóa ngoại trước khi lấy specialtyIds nếu có thể,
        // hoặc đảm bảo SpecialtySeeder đã chạy thành công trước đó.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Tạm bật lại để truy vấn Specialty

        $specialtyIds = Specialty::pluck('id')->toArray(); // Lấy tất cả ID của chuyên khoa

        if (empty($specialtyIds)) {
            $this->command->info('Vui lòng chạy SpecialtySeeder trước để có dữ liệu chuyên khoa.');
            return;
        }

        // Tắt lại kiểm tra khóa ngoại để tránh xung đột khi tạo/xóa
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Tạo một tài khoản Admin mẫu
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // ... (phần code tạo bác sĩ vẫn giữ nguyên)
        $doctorsData = [
            [
                'name' => 'Bác sĩ Nguyễn Văn A',
                'email' => 'bacsi.a@example.com',
                'phone' => '0912345678',
                'address' => '123 Đường ABC, Quận 1',
                'bio' => 'Bác sĩ chuyên khoa Tim mạch với 10 năm kinh nghiệm.',
                'specialty_name' => 'Tim mạch', // Tên chuyên khoa để tìm ID
            ],
            [
                'name' => 'Bác sĩ Trần Thị B',
                'email' => 'bacsi.b@example.com',
                'phone' => '0987654321',
                'address' => '456 Đường XYZ, Quận 2',
                'bio' => 'Bác sĩ Nhi khoa tận tâm và yêu trẻ.',
                'specialty_name' => 'Nhi khoa',
            ],
            [
                'name' => 'Bác sĩ Lê Văn C',
                'email' => 'bacsi.c@example.com',
                'phone' => '0901122334',
                'address' => '789 Đường KLM, Quận 3',
                'bio' => 'Chuyên gia Da liễu, điều trị các vấn đề về da liễu thẩm mỹ.',
                'specialty_name' => 'Da liễu',
            ],
            [
                'name' => 'Bác sĩ Phạm Thị D',
                'email' => 'bacsi.d@example.com',
                'phone' => '0905566778',
                'address' => '321 Đường NOP, Quận 4',
                'bio' => 'Bác sĩ Nội tiết, chuyên sâu về bệnh tiểu đường và tuyến giáp.',
                'specialty_name' => 'Nội tiết',
            ],
        ];

        foreach ($doctorsData as $data) {
            $specialty = Specialty::where('name', $data['specialty_name'])->first();

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'), // Mật khẩu mặc định
                    'role' => 'doctor',
                    'email_verified_at' => now(),
                ]
            );

            Doctor::updateOrCreate(
                ['user_id' => $user->id], // Tìm theo user_id để update hoặc create
                [
                    'specialty_id' => $specialty ? $specialty->id : null,
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'bio' => $data['bio'],
                ]
            );
        }

        // Tạo một tài khoản Patient mẫu
        User::updateOrCreate(
            ['email' => 'patient@example.com'],
            [
                'name' => 'Patient User',
                'password' => Hash::make('password'),
                'role' => 'patient',
                'email_verified_at' => now(),
            ]
        );

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}