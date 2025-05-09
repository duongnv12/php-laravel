<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Đảm bảo model User đã được cấu hình đúng
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Kiểm tra xem không có admin nào với email 'admin@example.com' chưa.
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name'     => 'Admin',
                'email'    => 'admin@example.com',
                // Sử dụng Hash::make() để mã hóa mật khẩu
                'password' => Hash::make('password'), // Thay 'password' bằng mật khẩu mong muốn
                // Nếu bạn có cột phụ thuộc xác định vai trò, ví dụ cột is_admin:
                'is_admin' => true,
            ]);
        }
    }
}
