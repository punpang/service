<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class UploadImgCustomer extends Model
{
  protected $table = 'a_upload_image_customer';

  protected $connection = 'order';

  // public $timestamps = false;

  public function order()
  {
    return $this->belongsTo(Aorder::class,'id_order','id');
  }

}
