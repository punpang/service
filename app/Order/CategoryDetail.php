<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class CategoryDetail extends Model
{
    protected $table = "category_details";

    protected $connection = "order";

    protected $hidden = ['created_at', 'updated_at'];
}
