<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    public static function generateToken($length = 30)
    {
        $timestamp = str_split(\Carbon\Carbon::now()->timestamp);

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $data = '';

        for ($i = 0; $i < $length; $i++) {
            if ($i % 3 == 0 && $i <= 30) {
                $n = ($i / 3) / 1;
                $data .= $timestamp[$n];
            } else {
                $data .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            }
        }

        return $data;
    }
}
