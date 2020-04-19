<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM1 extends Model
{
  protected $table = 'a_m1';

  protected $connection = 'order';

  public $timestamps = false;

  public function scopeDataUsePluck()
  {
    return $query = $this->orderBy('count','ASC')->pluck('m1','id');
  }

  public static function FindData($m1)
  {
    return AM1::where('id',$m1)->select('id','m1')->first();
  }
}
