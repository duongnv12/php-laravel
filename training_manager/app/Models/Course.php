<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Cho phép chèn hàng loạt
    protected $fillable = ['title', 'description', 'start_date', 'end_date'];

    // Ép kiểu ngày tháng cho các trường
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    // Nếu khóa học có mối quan hệ nhiều - nhiều với Student:
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id');
    }
}
