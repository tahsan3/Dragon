<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_thumbnail'];

    function rel_to_order_product_details(){
        return $this->hasMany(Order_product_details::class,'product_id', 'id');
    }
}
