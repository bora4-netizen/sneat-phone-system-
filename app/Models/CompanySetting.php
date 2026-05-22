<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'detail',
      'logo',
      'interest',
      'phone',
      'address',
      'default_loan_note',
      'default_invoice_note',
  ];

    public function getImageLogoAttribute()
    {
      if($this->logo && $this->logo != null && $this->logo != ''){
        return asset('/images/company/'.$this->logo);
      }
      return asset('/assets/img/logo.png');
    }
}
