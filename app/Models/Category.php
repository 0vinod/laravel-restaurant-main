<?php

namespace App\Models;

use App\Http\Trait\WithRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, WithRestaurant;

    protected $fillable = ['name','menu_type_id','restaurant_id'];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
