<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// class DatabaseSeeder extends Seeder
// {
//     /**
//      * Seed the application's database.
//      */
//     public function run(): void
//     {
//         // User::factory(10)->create();

//         User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'test@example.com',
//         ]);
//     }
// }
use App\Models\Curriculum;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Curriculum::insert([
            ['name' => 'Khoa học Máy tính', 'description' => 'Chương trình đào tạo ngành CNTT'],
            ['name' => 'Kinh tế', 'description' => 'Chương trình đào tạo ngành Kinh tế'],
            ['name' => 'Quản trị Kinh doanh', 'description' => 'Chương trình đào tạo ngành Quản trị'],
        ]);
    }
}
