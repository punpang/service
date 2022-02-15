<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = "user_types";
    protected $connection = "order";

    protected $fillable = [
        'name'
    ];

    protected $hidden = ["created_at", "updated_at"];
}
