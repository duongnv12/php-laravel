<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialty;
use Illuminate\Support\Facades\DB; // Thêm dòng này

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Specialty::truncate(); // Bây giờ có thể truncate

        $specialties = [
            ['name' => 'Tim mạch', 'description' => 'Chuyên khoa về bệnh tim và hệ tuần hoàn.'],
            ['name' => 'Nhi khoa', 'description' => 'Chuyên khoa về sức khỏe của trẻ em.'],
            ['name' => 'Da liễu', 'description' => 'Chuyên khoa về da, tóc, móng và các bệnh liên quan.'],
            ['name' => 'Nội tiết', 'description' => 'Chuyên khoa về các rối loạn nội tiết và chuyển hóa.'],
            ['name' => 'Răng Hàm Mặt', 'description' => 'Chuyên khoa về răng, hàm, mặt và các bệnh liên quan.'],
            ['name' => 'Cơ Xương Khớp', 'description' => 'Chuyên khoa về các bệnh lý xương, khớp, cơ.'],
            ['name' => 'Tiêu hóa', 'description' => 'Chuyên khoa về hệ tiêu hóa và các bệnh liên quan.'],
        ];

        foreach ($specialties as $specialty) {
            Specialty::create($specialty);
        }

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}