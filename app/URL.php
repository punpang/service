<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class URL extends Model
{
    public static function base()
    {
        return request()->getSchemeAndHttpHost();
    }

    public static function base_to_link($path)
    {
        return Url::base() . "/$path";
    }

    public static function punpang()
    {
        if (request()->getHttpHost() === 'punpang.store') {
            return URL::base() . '/order/';
        } else {
            return URL::base() . '/punpang/order/';
        }
    }
}
