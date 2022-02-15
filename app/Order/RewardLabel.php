<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Linenotify;

class RewardLabel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        "reward_customer_id",
        "status_open",
        "redeem_code",
        "status_use_redeem_code",
    ];

    protected $table = "reward_labels";
    protected $hidden = ["created_at", "redeem_code"];

    public function reward()
    {
        return $this->belongsTo(Reward::class, "reward_id", "id");
    }

    public function group()
    {
        return $this->belongsTo(RewardGroup::class, "reward_group_id", "id");
    }

    // นับจำนวนรางวัลคงเหลือ ตามกลุ่ม และแจ้งผ่าน line
    public static function rewardCountByGroup($group = 1)
    {
        $reward_count = self::whereRewardGroupId($group)
            ->whereRewardCustomerId(0)->count();
        $message_line = "จำนวนรางวัลคงเหลือ " . $reward_count . " รางวัล";
        Linenotify::send($message_line);
    }

    // ลงทะเบียนสิทธิ์ตามลำดับ
    public static function rewardRegister($nors, $customer_id)
    {
        $reward_labels = self::whereRewardGroupId(1)
            ->whereRewardCustomerId(0)->take($nors)
            ->update(["reward_customer_id" => $customer_id]);

        return $reward_labels;
    }

    public function getUpdatedAtAttribute($date)
    {
        // return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->diffForHumans();
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->addYears(543)->format('d-m-Y H:i:s');
    }
}
