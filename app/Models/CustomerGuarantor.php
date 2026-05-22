<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGuarantor extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'customer_id',
        'id_card_number',
        'name',
        'latin_name',
        'gender',
        'customer_relation_type',
        'nationality',
        'family_status',
        'dob',
        'house_number',
        'street_number',
        'group_number',
        'village',
        'district',
        'commune',
        'province',
        'housing_ownership_type',
        'phone',
        'mobile',
        'facebook',

    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
