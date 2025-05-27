<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxBracket extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_income',
        'max_income',
        'tax_rate',
        'deduction_amount',
    ];

    protected $casts = [
        'min_income' => 'decimal:2',
        'max_income' => 'decimal:2',
        'tax_rate' => 'decimal:4', // Tỷ lệ thuế có thể cần độ chính xác cao hơn
        'deduction_amount' => 'decimal:2',
    ];
}