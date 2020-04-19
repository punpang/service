<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_coupon_detail extends Model
{
  protected $table = 'tb_coupon_detail';

  protected $connection = 'store';

  public $timestamps = false;
}
