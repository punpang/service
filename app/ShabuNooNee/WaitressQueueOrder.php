<?php

namespace App\ShabuNooNee;

use App\Events\WaitressQueueOrderProcessing;
use App\ShabuNoonee\CookingDetail;
use App\Shabunoonee\CookingType;
use App\ShaBuNooNee\WaitressChannel;
use App\User;
use Illuminate\Database\Eloquent\Model;

class WaitressQueueOrder extends Model
{
    protected $hidden = ["created_at", "updated_at"];

    public static function countWaitressForChannel($channel)
    {
        return WaitressQueueOrder::where("waitress_channal", $channel->id)->where("status_done", 0)->count();
    }

    public static function Waitress($dining_table_id, $queue_id, $channel_id, $format_id = 1)
    {
        $Waitress = new WaitressQueueOrder;
        $Waitress->dining_table_id = $dining_table_id;
        $Waitress->queue_id = $queue_id;
        $Waitress->waitress_channal = $channel_id;
        $Waitress->format_id = $format_id;
        $Waitress->save();

        return $Waitress;
    }

    public static function waitressCreate($dining_table_id, $queue_id, $format_id = 1, $msgBroadcast = "alert")
    {
        //หาช่องเสิร์ฟที่คิวงานน้อยที่สุด และ อัปเดทล่าสุด
        $channel = WaitressChannel::findQueue();
        // สร้างคิวงานเสิร์ฟ
        self::Waitress($dining_table_id, $queue_id, $channel->id, $format_id);

        // นับจำนวนงานเสิร์ฟของแต่ละช่องเสิร์ฟ // อัปเดทจำนวนงานเสิร์ฟแต่ละช่อง
        $channel->count = WaitressQueueOrder::countWaitressForChannel($channel);
        $channel->save();

        // pusher ไปยัง เสิร์ฟ
        broadcast(new WaitressQueueOrderProcessing($msgBroadcast));
    }

    public  function waitressChannal()
    {
        return $this->belongsTo(WaitressChannel::class, "waitress_channal", "id");
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

    public function tableOrder()
    {
        return $this->belongsTo(TableOrder::class, "queue_id", "id");
    }

    public function tableDining()
    {
        return $this->belongsTo(DiningTable::class, "dining_table_id", "id");
    }

    public function tableDiningSelectUserId()
    {
        return $this->tableDining()->select("id", "user_id");
    }

    public function channelWaitress()
    {
        return $this->belongsTo(WaitressChannel::class, "waitress_channal", "id");
    }

    public function channelWaitressSelectTitle()
    {
        return $this->channelWaitress()->select("id", "title");
    }

    public function detailCooking()
    {
        return $this->belongsTo(CookingDetail::class, "queue_id", "id")->whereIn("status_step", [1, 2])->where("status_use", 1);
    }

    public function detailCookingForWaitress()
    {
        return $this->belongsTo(CookingDetail::class, "queue_id", "id")
            ->whereIn("status_step", [1, 2])
            ->where("status_use", 1);
    }

    public function idUser()
    {
        return $this->belongsTo(User::class, "user_id", "id")->select("id", "name");
    }
}
