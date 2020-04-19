<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM4 extends Model
{
  protected $table = 'a_m4';

  protected $connection = 'order';

  public $timestamps = false;

  public function scopeDataUsePluck()
  {
    return $query = $this->orderBy('count','ASC')->pluck('m4','id');
  }

  public static function FindData($m)
  {
    return AM4::where('id',$m)->select('id','m4')->first();
  }
}
