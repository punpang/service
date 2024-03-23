<?php

namespace App\Order;

// use App\Linenotify;
// use Illuminate\Support\Str;
// use App\Order\FacebookReply;
use Illuminate\Database\Eloquent\Model;

class StoreDayOff extends Model
{
    protected $table = "store_day_offs";
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ["start_date_th", "end_date_th"];

    public static function reply_th($store_day_off)
    {
        $day_off = $store_day_off->start_date_th . " - " . $store_day_off->end_date_th;
        if ($store_day_off->start_date == $store_day_off->end_date) {
            $day_off = $store_day_off->start_date_th;
        }
        // return FacebookReply::replace_value(27, [$day_off, $store_day_off->get_date_th]);
        // $message = FacebookReply::find(27);
        // return Str::replaceArray("!?!", [$day_off, $store_day_off->get_date_th], $message->text_th);

        if ($store_day_off->start_time == "00:00:00"  && $store_day_off->end_time == "23:30:00") {
            $message = "ร้านหยุดให้บริการหน้าร้าน $day_off

ลูกค้าสามารถสั่งซื้อสินค้าสำหรับวันที่ $store_day_off->get_date_th เป็นต้นไปได้ตามปกติค่ะ

โดยสามารถสั่งซื้อผ่านช่องทางเพจได้เลยค่ะ

รบกวนรอสักครู่ค่ะ";
        } else {
            $end_time = $store_day_off->end_time != "23:30:00" ?
                "ช่วงเวลา $store_day_off->start_time - $store_day_off->end_time น.
หน้าร้านหยุดให้บริการชั่วคราว" :
                "ร้านหยุดให้บริการหน้าร้านตั้งแต่ $store_day_off->start_time น. เป็นต้นไปค่ะ";

            $message = "วันนี้ ( $day_off )
$end_time

ลูกค้าสามารถสั่งซื้อสินค้าสำหรับวันนี้ ( $day_off ) และรับสินค้านอกช่วงเวลาดังกล่าวได้ตามปกติค่ะ

โดยสามารถสั่งซื้อผ่านช่องทางเพจได้เลยค่ะ

รบกวนรอสักครู่ค่ะ";
        }

        return $message;

        //         return "ร้านหยุดให้บริการหน้าร้าน $day_off

        // ลูกค้าสามารถสั่งซื้อสินค้าสำหรับวันที่ $store_day_off->get_date_th เป็นต้นไปได้ตามปกติค่ะ

        // โดยสามารถสั่งซื้อผ่านช่องทางเพจได้เหมือนเดิมค่ะ

        // รบกวนรอสักครู่ค่ะ";
    }

    public function getStartDateThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->start_date)
            ->addYears(543)
            ->format('d/m/Y');
    }

    public function getEndDateThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->end_date)
            ->addYears(543)
            ->format('d/m/Y');
    }

    public function getGetDateThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $this->end_date)
            ->addYears(543)
            ->addDays(1)
            ->format('d/m/Y');
    }

    public function getBeforeEndTimeAttribute()
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->end_time)
            ->addMinutes(30)
            ->format('H:i:s');
    }
}
