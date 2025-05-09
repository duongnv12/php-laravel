<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cohort extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_year', 'end_year'];

    // Định nghĩa mối quan hệ many-to-many với Program
    public function programs()
    {
        return $this->belongsToMany(\App\Models\Program::class, 'cohort_program');
    }
}
