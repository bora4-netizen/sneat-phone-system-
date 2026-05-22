<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelType extends Model
{
    use HasFactory;

    protected $table = 'model_types';

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'model_type_id', 'id');
    }

}
