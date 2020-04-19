<?php

namespace App\Punpang;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'products';

  protected $connection = 'punpang';

  public $timestamps = false;

  public function prices()
  {
    return $this->hasMany(Price::class,'id_product','id')->orderBy('price_normal','ASC');
  }

  public function pics()
  {
    return $this->hasMany(Pic::class,'id_product','id');
  }
}
