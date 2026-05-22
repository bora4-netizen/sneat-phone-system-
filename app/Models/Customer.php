<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_NORMAL = 1;
    const STATUS_LOAN = 2;

    protected $fillable = 
    [
      'id_card_number',
      'name',
      'latin_name',
      'profile',
      'customer_type',
      'gender',
      'nationality',
      'family_status',
      'dob',
      'phone',
      'mobile',
      'facebook',
      'house_number',
      'street_number',
      'group_number',
      'village',
      'district',
      'commune',
      'province',
      'housing_ownership_type',
      'employee_id',
    ];

    public function loan()
    {
        return $this->hasOne(Loan::class);
    }

    public function users()
    {
      return $this->hasMany(User::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function guarantor()
    {
        return $this->hasOne(CustomerGuarantor::class);
    }

    public function job()
    {
        return $this->hasOne(CustomerJob::class);
    }

    public function scopeLoanable($query)
    {
        return $query->where('customer_type', self::STATUS_LOAN);
    }

    public function getProfileImageAttribute()
    {
      if($this->profile && $this->profile != null && $this->profile != ''){
        return asset('/images/profile/'.$this->profile);
      }
      return asset('/assets/img/blank-profile.png');
    }
    public function loanPayments()
    {
        return $this->hasManyThrough(LoanPayment::class, Loan::class);
    }
}
