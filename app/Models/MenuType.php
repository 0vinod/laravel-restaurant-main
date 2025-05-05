<?php

namespace App\Models;

use App\Http\Trait\WithRestaurant;
use Illuminate\Database\Eloquent\Model;

class MenuType extends Model
{
    use WithRestaurant;

    protected $fillable = ['name', 'description', 'image', 'restaurant_id'];
}
