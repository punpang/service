<?php

namespace App\ShaBuNooNee;

use App\ShabuNooNee\WaitressQueueOrder;
use Illuminate\Database\Eloquent\Model;

class WaitressChannel extends Model
{
    protected $table = "waitress_channels";

    public function waitressQueued()
    {
        return $this->hasMany(WaitressQueueOrder::class, 'waitress_channal', "id")->where("status_done", 0);
    }
}
