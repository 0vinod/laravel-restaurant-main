<?php

namespace App\Http\Trait;

use Illuminate\Support\Facades\Auth;

trait WithRestaurant
{
    public static function bootWithRestaurant()
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->restaurant_id)) {
                $model->restaurant_id = Auth::user()->id;
            }
        });
    }
}
