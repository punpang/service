<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Helper extends Model
{
    public static function generateToken($length = 30)
    {
        return Str::random(60);

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

    public static function randomNumber($length = 30)
    {
        $timestamp = str_split(\Carbon\Carbon::now()->timestamp);

        $chars = '0123456789';
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

    public static function backBoolean($boolean)
    {
        if ($boolean == true or $boolean == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function messageUseTime($created_at, $updated_at)
    {
        $useTime = \Carbon\Carbon::parse($updated_at)->diff($created_at);
        if ($useTime->h > 0) {
            $messageUseTime = "ใช้เวลาไป " .  $useTime->h . " ชั่วโมง " . $useTime->i . " นาที " . $useTime->s . " วินาที ";
        } else if ($useTime->i > 0) {
            $messageUseTime = "ใช้เวลาไป " .  $useTime->i . " นาที " . $useTime->s . " วินาที ";
        } else {
            $messageUseTime = "ใช้เวลาไป " . $useTime->s . " วินาที ";
        }

        return $messageUseTime;
    }
}
