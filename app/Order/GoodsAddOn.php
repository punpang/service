<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class GoodsAddOn extends Model
{
    protected $table = "goods_add_ons";
    protected $primaryKey = "id";

    protected $guarded = ["id"];

    protected $hidden = ['created_at', 'updated_at'];

}
