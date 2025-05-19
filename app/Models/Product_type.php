<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_type extends Model
{
    protected $fillable =['name'];

    public function workshops()
    {
        return $this->belongsToMany(Workshop::class, 'workshop_product_type');
    }

    // Связь One-to-Many с Details
    public function details()
    {
        return $this->hasMany(Detail::class);
    }
    
}
