<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class CategorySubRelationship extends Model
{
    protected $table = "category_sub_relationships";
    protected $connection = "order";
    protected $hidden = ["created_at", "updated_at"];
}
