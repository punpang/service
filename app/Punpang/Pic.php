<?php

namespace App\Punpang;

use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
  protected $table = 'pics';

  protected $connection = 'punpang';

  public $timestamps = false;
}
