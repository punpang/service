<?php

namespace App\Shabunoonee;

use Illuminate\Database\Eloquent\Model;

class CookingType extends Model
{
    protected $table = "cooking_types";
    protected $hidden = ["created_at", "updated_at"];
}
