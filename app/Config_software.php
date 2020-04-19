<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config_software extends Model
{
  protected $table = 'config_software';

  protected $connection = 'store';

  public $timestamps = false;

  public function scopeScore($query)
  {
    return $query = $this->select('score')->first();
  }
}
