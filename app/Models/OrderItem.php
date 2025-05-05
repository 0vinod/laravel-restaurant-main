<?php

namespace App\Models;

use App\Http\Trait\WithRestaurant;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use WithRestaurant;
    
    protected $fillable = [
        'order_id',
        'menu_name',
        'quantity',
        'subtotal',
        'restaurant_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
