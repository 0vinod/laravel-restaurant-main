<?php

namespace App\Models;

use App\Http\Trait\WithRestaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Store extends Model
{

  protected $guarded = [];

  public function storeOpeningHours()
  {
      return $this->hasMany(StoreOpeningHour::class);
  }

  public function storeTables()
  {
      return $this->hasMany(StoreTable::class);
  }

  public function storeUsers()
  {
      return $this->hasMany(StoreUser::class);
  }

}
