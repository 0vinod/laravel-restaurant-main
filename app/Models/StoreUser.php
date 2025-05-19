<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreUser extends Model
{
    protected $guarded = [];
    protected $hidden = ['password'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
