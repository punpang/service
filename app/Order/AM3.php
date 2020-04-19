<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM3 extends Model
{
  protected $table = 'a_m3';

  protected $connection = 'order';

  public $timestamps = false;

  public function scopeAll()
  {
    return $query = $this->get();
    //    return $query = $this->orderBy('count','ASC')->get();
  }

  public static function FindData($m)
  {
    return AM3::where('id',$m)->select('id','m3')->first();
  }
}
