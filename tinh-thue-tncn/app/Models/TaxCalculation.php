<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_income',
        'social_insurance_contribution',
        'number_of_dependents',
        'charitable_contributions',
        'retirement_fund_contributions',
        'personal_deduction_amount', // Đảm bảo có
        'dependent_deduction_amount', // Đảm bảo có
        'calculated_retirement_fund_deduction', // Đảm bảo có
        'total_deductions',
        'taxable_income',
        'final_tax_amount',
    ];

    /**
     * Get the user that owns the tax calculation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}