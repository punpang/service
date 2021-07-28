<?php

namespace App\ShabuNoonee;

use App\ShabuNooNee\DiningTable;
use App\ShabuNooNee\Product;
use App\ShabuNooNee\WaitressQueueOrder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class CookingDetail extends Model
{
    protected $table = "cooking_details";

    protected $fillable = ['status_step', "status_use"];

    //protected $hidden = ["created_at", "updated_at"];

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
        // return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->addYears(543)->format('d-m-Y H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
        // return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->addYears(543)->format('d-m-Y H:i:s');
    }

    public function brothDetails()
    {
        return $this->hasMany(CookingBroth::class, 'cooking_detail_id', 'id');
    }

    public function typeCooking()
    {
        return $this->belongsTo(CookingType::class, "cooking_type_id", "id");
    }

    public function tableDining()
    {
        return $this->belongsTo(DiningTable::class, "dining_table_id", "id");
    }
    public static function setStatusStep($id, $status_step)
    {
        // dd($id, $status_step);
        $data = self::find($id);
        $data->status_step = $status_step;
        $data->save();
    }

    public function statusStepDetailCooking()
    {
        return $this->belongsTo(CookingDetailStatusStep::class, "status_step", "id");
    }

    public function waitressUser()
    {
        return $this->belongsTo(WaitressQueueOrder::class, "id", "queue_id")
            ->where("format_id", 2)
            ->select("id", "format_id", "queue_id", "user_id", "status_done", "user_id");
    }

    public function orderQueueWaitress()
    {
        return $this->belongsTo(WaitressQueueOrder::class, "id", "queue_id");
    }
}
