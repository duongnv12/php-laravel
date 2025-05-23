<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'schedule_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
    ];

    // Định nghĩa mối quan hệ: Một cuộc hẹn thuộc về một bệnh nhân (người dùng)
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id'); // Rõ ràng liên kết patient_id với User
    }

    // Định nghĩa mối quan hệ: Một cuộc hẹn thuộc về một bác sĩ
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Định nghĩa mối quan hệ: Một cuộc hẹn thuộc về một lịch làm việc
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}