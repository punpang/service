<?php

namespace App\ShabuNooNee;

use App\Events\WaitressQueueOrderProcessing;
use App\ShabuNoonee\CookingDetail;
use App\Shabunoonee\CookingType;
use App\ShaBuNooNee\WaitressChannel;
use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class WaitressQueueOrder extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'dining_table_id',
        'queue_id',
        "user_id",
        "waitress_channal",
        "format_id",
        "status_done",
        "status_use"
    ];

    protected $hidden = ["created_at", "updated_at"];

    public static function countWaitressForChannel($channel)
    {
        return WaitressQueueOrder::where("waitress_channal", $channel->id)->where("status_done", 0)->count();
    }

    public static function countWaitressForChannelAll()
    {
        WaitressChannel::where('status', 1)->update(["count" => 0]);

        $countChannel = WaitressQueueOrder::where("status_done", 0)->get();
        $groupBys = $countChannel->groupBy("waitress_channal");

        foreach ($groupBys as $key => $value) {
            $WaitressChannel = WaitressChannel::where("id", $key)
                ->where("status", 1)->first();
            $WaitressChannel->count = $value->count();
            $WaitressChannel->save();
        }
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

    public static function waitressCreate($dining_table_id, $queue_id, $format_id = 1, $broadcast = "alert")
    {
        //หาช่องเสิร์ฟที่คิวงานน้อยที่สุด และ อัปเดทล่าสุด
        $channel = WaitressChannel::findQueue();
        // สร้างคิวงานเสิร์ฟ
        $Waitress = self::Waitress($dining_table_id, $queue_id, $channel->id, $format_id);

        // นับจำนวนงานเสิร์ฟของแต่ละช่องเสิร์ฟ // อัปเดทจำนวนงานเสิร์ฟแต่ละช่อง
        // $channel->count = WaitressQueueOrder::countWaitressForChannel($channel);
        // $channel->save();

        // อัปเดทจำนวนคิวงานทุกช่องเสิร์ฟ
        self::countWaitressForChannelAll();

        // pusher ไปยัง เสิร์ฟ
        broadcast(new WaitressQueueOrderProcessing($broadcast));

        return $Waitress;
    }

    public static function checkInsert($queue_id, $format_id = 1)
    {
        return WaitressQueueOrder::where("queue_id", $queue_id)
            //->where("id", $kitchen->id)
            ->where("format_id", $format_id)
            ->first();
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
