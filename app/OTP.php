<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = "o_t_p_s";
    protected $fillable = [
        'ref1',
        'ref2',
        'phoneNumber',
        'status',
        'limit'
    ];

    public static function findLastCreated(){}
}
