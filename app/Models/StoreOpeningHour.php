<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreOpeningHour extends Model
{
  protected $guarded = [];


  public function store()
  {
    return $this->belongsTo(Store::class);
  }
}
