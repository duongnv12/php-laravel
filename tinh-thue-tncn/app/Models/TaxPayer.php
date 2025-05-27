<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TaxPayer extends Model
{
    use HasFactory;

    // Định nghĩa các trường có thể được gán hàng loạt (mass assignable)
    protected $fillable = [
        'full_name',
        'tax_code',
        'identification_number',
        'total_income',
        'social_insurance_contribution',
    ];

    /**
     * Định nghĩa mối quan hệ Một-Nhiều với Dependent.
     * Một TaxPayer có nhiều Dependents.
     */
    public function dependents()
    {
        return $this->hasMany(Dependent::class);
    }
}