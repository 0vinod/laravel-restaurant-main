<?php

namespace App\Models;

use App\Http\Trait\WithRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantWorkingHour extends Model
{
    use HasFactory, WithRestaurant;

    protected $fillable = ['working_hours','restaurant_id'];
}
