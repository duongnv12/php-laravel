<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Thêm 'role' vào fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Định nghĩa mối quan hệ: Một người dùng có thể là một bác sĩ
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    // Định nghĩa mối quan hệ: Một người dùng có nhiều lịch hẹn (là bệnh nhân)
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id'); // Rõ ràng liên kết patient_id
    }
}