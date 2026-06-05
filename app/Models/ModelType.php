<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ import នៅទីនេះ

class ModelType extends Model
{
    use SoftDeletes; // ✅ use នៅទីនេះ

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'model_type_id');
    }
}   