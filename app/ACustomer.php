<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ACustomer extends Model
{
  protected $table = 'a_customer';

  protected $connection = 'order';

  public $timestamps = false;
}
