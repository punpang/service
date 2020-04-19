<?php

namespace App\Store;

use Illuminate\Database\Eloquent\Model;

class Tb_bill_sale_detail extends Model
{
  protected $table = 'tb_bill_sale_detail';

  protected $primaryKey = 'bill_sale_detail_id';

  protected $connection = 'store';

  public $timestamps = false;
}
