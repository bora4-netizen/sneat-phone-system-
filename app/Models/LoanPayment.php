<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'loan_id',
      'employee_id',
      'amount',
      'date',
      'payment_type',
      'payment_status',
      'note',
      'phone_profit'
  ];

    const STATUS_1 = 1; //MONTHLY
    const STATUS_2 = 2; //PAYING OFF

    const TYPE_1 = 1; //MONTHLY
    const TYPE_2 = 2; //PAYING OFF
    const TYPE_3 = 3; //PAYING OFF

    const STATUS = [
      1 => 'MONTHLY',
      2 => 'PAYING OFF'
    ];

    const TYPES = [
      1 => 'CASH',
      2 => 'BANK',
      3 => 'OTHER'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function getStatusNameAttribute(): string
    {
      return self::STATUS[$this->payment_status];
    }

    public function getTypeNameAttribute()
    {
      return self::TYPES[$this->payment_type];
    }

    public function employee()
    {
       return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function customer()
    {
      return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
