<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressTracking extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'progress', 'warning'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
