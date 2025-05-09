<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Cho phép chèn hàng loạt
    protected $fillable = ['name', 'email', 'phone', 'dob'];

    // Ép kiểu trường ngày (sẽ tự động chuyển đổi thành instance của Carbon)
    protected $casts = [
        'dob' => 'date',
    ];

    // Nếu sinh viên tham gia khóa học theo mối quan hệ many-to-many:
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }

    // Nếu có mối quan hệ với tiến độ học tập:
    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }
}
