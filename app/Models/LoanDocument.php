<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDocument extends Model
{
    use HasFactory;

    protected $fillable = [
      'loan_id',
      'customer_id_card',
      'customer_family_book',
      'customer_birth_certificate',
      'customer_other',
      'guarantor_id_card',
      'guarantor_family_book',
      'guarantor_birth_certificate',
      'guarantor_other',
  ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
