<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    use HasFactory;

    // Định nghĩa các trường có thể được gán hàng loạt (mass assignable)
    protected $fillable = [
        'tax_payer_id',
        'full_name',
        'date_of_birth',
        'relationship',
        'identification_number',
    ];

    /**
     * Định nghĩa mối quan hệ Một-Một ngược lại với TaxPayer.
     * Một Dependent thuộc về một TaxPayer.
     */
    public function taxPayer()
    {
        return $this->belongsTo(TaxPayer::class);
    }
}