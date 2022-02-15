<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;

class RewardCustomer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        "name",
        "phone",
        "uuid"
    ];
    protected $table = "reward_customers";
    protected $hidden = ["created_at", "updated_at"];

    public function labels()
    {
        return $this->hasMany(RewardLabel::class, "reward_customer_id", "id")
            // ->orderByAsc("status_use_redeem_code")
            // ->orderBy("status_open", "asc")
            ->orderByDesc("id");
    }

    // ค้นหาสมาชิก สร้างใหม่ และเปลี่ยนชื่อลูกค้าทุกครั้ง
    public static function CustomerAddEdit($customer_name, $customer_phone)
    {
        $findCustomer = RewardCustomer::wherePhone($customer_phone)->first();
        if ($findCustomer === null) {
            $findCustomer = new RewardCustomer;
            $findCustomer->name = $customer_name;
            $findCustomer->phone = $customer_phone;
            $findCustomer->uuid = Str::uuid();
            $findCustomer->save();
        } else {
            $findCustomer->name = $customer_name;
            $findCustomer->uuid = Str::uuid();
            $findCustomer->save();
        }
        return $findCustomer;
    }

    // public function getPhoneAttribute($data)
    // {
    //     return "XXX-XXXX-" . substr($data, -4);
    // }

    // ตรวจสอบ สมาชิกถูกต้องหรือไม่
    public static function checkByIdUuid($customer_id, $customer_uuid)
    {
        $customer = RewardCustomer::whereId($customer_id)
            ->whereUuid($customer_uuid)->first();

        return $customer;
    }
}
