<?php

namespace App\Punpang;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
  protected $table = 'price';

  protected $connection = 'punpang';

  public $timestamps = false;

  public function Size()
  {
    return $this->hasOne(Size::class,'id','size');
  }
}
