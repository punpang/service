<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class CategoryPrice extends Model
{
    protected $table = "category_prices";
    protected $connection = "order";
    protected $hidden = ["created_at", "updated_at"];
}
