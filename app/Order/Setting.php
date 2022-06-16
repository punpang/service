<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "settings";
    protected $guarded = [];

    public static function attribute_name($name)
    {
        $setting = self::first();
        return $setting->$name;
    }
}
