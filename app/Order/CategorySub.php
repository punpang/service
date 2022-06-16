<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class CategorySub extends Model
{
    protected $table = "category_subs";
    protected $connection = "order";
    protected $hidden = ["created_at", "updated_at"];
}
