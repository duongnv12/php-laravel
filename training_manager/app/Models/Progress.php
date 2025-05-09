<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    // Đặt tên bảng đúng theo migration (bảng được tạo ra là 'progresses')
    protected $table = 'progresses';

    protected $fillable = ['student_id', 'course_id', 'score', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
