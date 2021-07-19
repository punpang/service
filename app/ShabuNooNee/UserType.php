<?php

namespace App\ShabuNoonee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "user_types";
    protected $fillable = [
        'name'
    ];

    protected $hidden = ["created_at" , "updated_at"];
}
