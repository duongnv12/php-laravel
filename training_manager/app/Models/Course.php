<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'name', 'description', 'credit'];

    // Quan hệ tự tham chiếu: các môn tiên quyết của môn học này
    public function prerequisites()
    {
        return $this->belongsToMany(
            self::class,
            'course_prerequisite',
            'course_id',          // Khóa chính tại bảng pivot
            'prerequisite_id'     // Môn học tiên quyết
        );
    }

    // Ngược lại: danh sách các môn mà hiện tại là môn tiên quyết
    public function subsequentCourses()
    {
        return $this->belongsToMany(
            self::class,
            'course_prerequisite',
            'prerequisite_id',
            'course_id'
        );
    }

    // Quan hệ với chương trình đào tạo (chung nhiều - many-to-many)
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'course_program');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withPivot('status', 'grade')
            ->withTimestamps();
    }

}
