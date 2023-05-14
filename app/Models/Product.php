<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['productname', 'productcode', 'price', 'stock'];
    public function cart_detail()
    {
        return $this->hasMany('App\Models\CartDetail', 'product_id', 'id');
    }
}
