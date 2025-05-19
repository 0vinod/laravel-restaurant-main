<?php

namespace App\Models;

use App\Http\Trait\WithRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, WithRestaurant;

    protected $fillable = ['name', 'description', 'price_options', 'image', 'category_id','restaurant_id','menu_type_id','display_on','preparation_time'];

    protected $casts = [
        'price_options' => 'json',
    ];

    public function category()
    { 
        return $this->belongsTo(Category::class);
    }

    public function menuType(){
        return $this->belongsTo(MenuType::class,'menu_type_id');
    }
}
