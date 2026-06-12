<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Or BelongsToMany depending on your DB design

class Network extends Model
{
    // Define the products relationship
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
