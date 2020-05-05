<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class SilpUnVerifyReasoning extends Model
{
    protected $table = "silp_un_verify_reasonings";
    protected $connection = "order";
    public $hidden = ['created_at','updated_at'];

    public function scopeUseOnly()
    {
        return $query = $this->whereStatus(1);
    }
}
