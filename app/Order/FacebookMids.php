<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class FacebookMids extends Model
{
    protected $table = "facebook_mids";
    // protected $hidden = ["created_at", "updated_at"];
    protected $guarded = [];

    public static function check($mid)
    {
        $fbmid = FacebookMids::where("mid", $mid)->get();

        if ($fbmid->count() > 1) {
            return true;
        }

        FacebookMids::create([
            "mid" => $mid
        ]);
        return false;
    }
}
