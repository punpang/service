<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class LineAccessToken extends Model
{
    protected $table = "line_access_tokens";
    protected $guarded = [];
}
