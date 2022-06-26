<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class AM4 extends Model
{
    protected $table = "a_m4";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = false;
    protected $appends = [];

    protected $guarded = [];

    public function getNameAttribute()
    {
        return $this->m4;
    }
}
