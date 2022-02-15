<?php

namespace App\Momday;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $fillable = ['name', 'phone_number'];

    protected $table = "customers";

    protected $hidden = ['created_at', 'updated_at'];

    public function getPhoneNumberAttribute($data)
    {
        return "XXX-XXXX-" . substr($data, -4);
    }
}
