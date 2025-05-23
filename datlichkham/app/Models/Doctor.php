<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_id',
        'phone',
        'address',
        'bio',
    ];

    // Định nghĩa mối quan hệ: Một bác sĩ thuộc về một người dùng (tài khoản)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Định nghĩa mối quan hệ: Một bác sĩ thuộc về một chuyên khoa
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    // Định nghĩa mối quan hệ: Một bác sĩ có nhiều lịch làm việc
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Định nghĩa mối quan hệ: Một bác sĩ có nhiều cuộc hẹn
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}