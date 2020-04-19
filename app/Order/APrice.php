<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class APrice extends Model
{
  protected $table = 'a_price';

  protected $connection = 'order';

  public $timestamps = false;

  public function scopeDataUsePluck()
  {
    return $query = $this->orderBy('count','ASC')->pluck('m4','id');
  }
}
