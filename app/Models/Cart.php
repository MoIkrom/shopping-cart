<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function cart_detail()
    {
        return $this->hasMany('App\Models\CartDetail', 'cart_id', 'id');
    }
}
