<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelType extends Model
{
        use SoftDeletes;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'model_type_id');
    }

}