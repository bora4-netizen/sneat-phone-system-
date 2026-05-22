<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $table = 'networks';

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'network_id', 'id');
    }
}
