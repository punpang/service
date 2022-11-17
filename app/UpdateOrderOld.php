<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateOrderOld extends Model
{
    protected $table = "a_order";
    protected $connection = "update_table";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [];
    protected $guarded = [];
}
