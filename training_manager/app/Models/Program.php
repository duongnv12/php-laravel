<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;
    
    protected $fillable = ['cohort_id', 'name', 'description'];

    // Chương trình của một niên khóa
    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    // Chương trình có nhiều môn học (qua bảng pivot)
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_program')->withPivot('order')->withTimestamps();
    }
}
