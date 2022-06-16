<?php

namespace App\Order;

use App\URL;
use Illuminate\Database\Eloquent\Model;

class ShotlinkV2 extends Model
{
    protected $table = "shotlink_v2_s";
    protected $guarded = [];
    // protected $primaryKey = "shot_link";

    public function getRedirectAttribute()
    {
        return URL::base() . "/r/" . $this->shot_link;
    }

    // public function setExpirationDateAttribute($date)
    // {
    //     return  $this->attribute["expiration_date"] = "2000-01-01 00:00:00";
    // }

    public static function store($full_link, $expiration_date = 30, $number_of_access_rights = 99)
    {
        $shotlink = ShotlinkV2::firstOrCreate(
            [
                "full_link" => URL::base() . $full_link
            ],
            [
                "shot_link" => bin2hex(openssl_random_pseudo_bytes(5)),
                "expiration_date" => now()->addDays($expiration_date),
                "number_of_access_rights" => $number_of_access_rights
            ]
        );

        return $shotlink->redirect;
    }
}
