<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class CategorySubDetail extends Model
{
    protected $table = "category_sub_details";
    protected $connection = "order";
    protected $hidden = ["created_at", "updated_at"];
}
