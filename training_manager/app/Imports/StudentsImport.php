<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Student::updateOrCreate(
            // Điều kiện xác định duy nhất để tránh trùng lặp, ví dụ email là duy nhất
            ['email' => $row['email']],
            [
                'name'  => $row['name'] ?? null,
                'phone' => $row['phone'] ?? null,
                // Ép kiểu sang float để tránh lỗi khi xử lý giá trị số của dob
                'dob'   => isset($row['dob']) && is_numeric($row['dob'])
                           ? Date::excelToDateTimeObject((float)$row['dob'])
                           : null,
            ]
        );
    }
}
