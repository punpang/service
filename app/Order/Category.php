<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $connection = "order";
}
