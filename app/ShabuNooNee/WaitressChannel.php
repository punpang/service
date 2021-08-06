<?php

namespace App\ShaBuNooNee;

use App\ShabuNooNee\WaitressQueueOrder;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class WaitressChannel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'title',
        'status',
    ];

    protected $table = "waitress_channels";

    public function waitressQueued()
    {
        return $this->hasMany(WaitressQueueOrder::class, 'waitress_channal', "id")->where("status_done", 0);
    }

    public static function findQueue()
    {
        return  WaitressChannel::whereStatus(1)
            ->orderBy('count', "asc")
            ->orderBy("updated_at", "desc")
            ->first();
    }

    public static function QueueFree()
    {
        return  WaitressChannel::orderBy('count', "asc")
            ->orderBy("updated_at", "desc")
            ->first();
    }

    public static function selectTitle()
    {
        return self::select("id", "title");
    }
}
