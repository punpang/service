<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;

class WaitressQueueOrder extends Model
{

    public static function countWaitressForChannel($channel)
    {
        return WaitressQueueOrder::where("waitress_channal", $channel->id)->where("status_done", 0)->count();
    }

    public static function Waitress($queue_id, $channel_id)
    {
        $Waitress = new WaitressQueueOrder;
        $Waitress->queue_id = $queue_id;
        $Waitress->waitress_channal = $channel_id;
        $Waitress->save();

        return $Waitress;
    }

    public function tableOrderDetails()
    {
        return $this->hasMany(TableOrderDetail::class, "table_order_id", "queue_id");
    }

    public function tableOrderDetail()
    {
        return $this->belongsTo(TableOrderDetail::class, "queue_id", "table_order_id");
    }

    public function sumQuantity()
    {
        return $this->tableOrderDetails()->sum("quantity");
    }
}
