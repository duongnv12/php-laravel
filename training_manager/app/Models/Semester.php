<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [
        'name', 'start_date', 'end_date'
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}

