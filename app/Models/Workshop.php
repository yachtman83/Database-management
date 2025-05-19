<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Workshop extends Model
{
    protected $fillable = [
        'title',
        'chief_name',
        'chief_surname',
        'chief_photo',
    ];

    public function productTypes(): BelongsToMany
    {
        return $this->belongsToMany(Product_type::class, 'workshop_product_type');
    }

     // Связь One-to-Many с Employee
     public function employees()
     {
         return $this->hasMany(Employee::class);
     }
}
