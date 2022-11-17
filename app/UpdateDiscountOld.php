<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateDiscountOld extends Model
{
    protected $table = "a_customer";
    protected $connection = "update_table";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [];
    protected $guarded = [];
}
