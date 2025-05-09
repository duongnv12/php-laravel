<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CoursesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Sử dụng updateOrCreate để tránh trùng lặp theo 'code'
        $course = Course::updateOrCreate(
            ['code' => $row['code']],
            [
                'name'        => $row['name'] ?? null,
                'description' => $row['description'] ?? null,
                'credit'      => is_numeric($row['credit']) ? (float)$row['credit'] : 0,
            ]
        );

        // Nếu file có chứa danh sách các mã môn tiên quyết (ví dụ: "CS101,CS102"),
        // bạn sẽ cần tách chuỗi đó và thiết lập mối liên hệ bằng cách sử dụng phương thức prerequisites()
        if (!empty($row['prerequisites'])) {
            $prereqCodes = array_map('trim', explode(',', $row['prerequisites']));
            $prereqIds = Course::whereIn('code', $prereqCodes)->pluck('id')->toArray();
            // Cập nhật mối quan hệ: có thể dùng sync() hoặc attach() tùy theo nghiệp vụ
            $course->prerequisites()->sync($prereqIds);
        }

        return $course;
    }
    
}
