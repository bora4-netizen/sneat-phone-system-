<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productsAvailable()
    {
      return self::products()->where('products.status', Product::STATUS_ID_AVAILABLE);
    }
    public function series()
    {
        return $this->hasMany(Series::class);
    }
}
