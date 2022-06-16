<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

}
