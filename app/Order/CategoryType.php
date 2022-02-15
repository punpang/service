<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    protected $table = "category_types";
    protected $connection = "order";
    protected $hidden = ["created_at", "updated_at"];
}
