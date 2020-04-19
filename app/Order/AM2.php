<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM2 extends Model
{
  protected $table = 'a_m2';

  protected $connection = 'order';

  public $timestamps = false;

  public function scopeAll()
  {
    return $query = $this->get();
    //    return $query = $this->orderBy('count','ASC')->get();

  }

  public static function FindData($m)
  {
    return AM2::where('id',$m)->select('id','m2')->first();
  }
}
