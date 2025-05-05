<?php

namespace App\Models;

use App\Http\Trait\WithRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableBooking extends Model
{
    use HasFactory, WithRestaurant;

    protected $fillable = [
        'name', 'email', 'phone', 'date', 'time', 'persons','restaurant_id'
    ];
}
