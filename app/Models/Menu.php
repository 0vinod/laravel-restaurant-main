<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price_options', 'image', 'category_id'];

    protected $casts = [
        'price_options' => 'json',
    ];

    public function category()
    { 
        return $this->belongsTo(Category::class);
    }
}
