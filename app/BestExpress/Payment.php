<?php

namespace App\BestExpress;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $table = 'payments';

  protected $connection = 'best';
}
