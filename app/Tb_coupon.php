<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_coupon extends Model
{
  protected $table = 'tb_coupon';

  protected $connection = 'store';

  public $timestamps = false;

  public function scopeCoupon($query)
  {
    return $query = $this->where([
      ['ecoupon','1'],
      ['status','use']])->select('id','name','type','value','status')->orderBy('value','ASC');
  }

}
