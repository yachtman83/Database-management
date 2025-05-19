<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = ['name', 'weight', 'material', 'product_type_id'];


    // Связь Many-to-One с ProductType
    public function productType()
    {
        return $this->belongsTo(Product_type::class);
    }
}
