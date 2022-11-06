<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class CategoryMoneyService extends Model
{
    protected $table = "category_money_services";
    protected $connection = "order";
    protected $primaryKey = "id";
    protected $appends = [];
    protected $hidden = ['created_at', 'updated_at'];

    //protected $filable = ["code", "price", "m1", "m2", "m3", "m4"];
    protected $guarded = [];
}
