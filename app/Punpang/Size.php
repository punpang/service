<?php

namespace App\Punpang;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
  protected $table = 'size';

  protected $connection = 'punpang';

  public $timestamps = false;
}
