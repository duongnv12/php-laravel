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


    // Nếu có mối quan hệ với bảng enrollments:
    // Mối quan hệ 1-n với bảng enrollments
    // Một sinh viên có thể có nhiều đăng ký môn học
    // Một sinh viên có thể đăng ký nhiều môn học
    // Một môn học có thể có nhiều sinh viên đăng ký
    // Một sinh viên có thể có nhiều môn học
    // Một môn học có thể có nhiều sinh viên
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Nếu có mối quan hệ với bảng courses thông qua bảng enrollments:
    public function courses()
    {
        // Qua bảng enrollments, lấy các môn học mà sinh viên đã đăng ký
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('status', 'grade')
                    ->withTimestamps();
    }

    // Nếu có mối quan hệ với tiến độ học tập:
    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }
}
