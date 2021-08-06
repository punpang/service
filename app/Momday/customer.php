<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $fillable = ['name', 'phone_number'];

    protected $table = "customers";
}
