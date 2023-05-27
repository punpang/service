<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class RegisterWongnaiPosBill extends Model
{
    protected $table = "register_wongnai_pos_bills";
    protected $guarded = [];

    public function facebook()
    {
        return $this->belongsTo(Facebook::class);
    }
}
