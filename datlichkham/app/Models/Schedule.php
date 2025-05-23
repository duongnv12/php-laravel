<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    // Định nghĩa mối quan hệ: Một lịch làm việc thuộc về một bác sĩ
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Định nghĩa mối quan hệ: Một lịch làm việc có thể có một cuộc hẹn
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}