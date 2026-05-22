<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerJob extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'customer_id',
        'name',
        'latin_name',
        'phone',
        'email',
        'house_number',
        'street_number',
        'group_number',
        'village',
        'commune',
        'district',
        'province',
        'email',
        'salary',
        'salary_date',
        'other_income',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
