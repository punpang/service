<?php

namespace App\ShabuNoonee;

use Illuminate\Database\Eloquent\Model;

class CookingDetailStatusStep extends Model
{
    protected $table = "cooking_detail_status_steps";
    protected $hidden = ["created_at", "updated_at"];
}
