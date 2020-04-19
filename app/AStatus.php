<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AStatus extends Model
{
  protected $table = 'a_status';

  protected $connection = 'order';

  public $timestamps = false;
}
